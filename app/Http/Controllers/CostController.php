<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\PaymentMethod;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CostController extends Controller
{
    public $image, $imageName, $directory, $imgUrl;

    public function create()
    {
        // Get data from settings tables
        $expenseTypes = ExpenseType::pluck('name');
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        $customers = Schema::hasTable('customers') ? DB::table('customers')->get() : collect();
        $products = Schema::hasTable('products') ? DB::table('products')->get() : collect();

        return view('admin.expense.create', compact('expenseTypes', 'paymentMethods', 'customers', 'products'));
    }

    public function index(Request $request)
    {
        $query = Cost::with('paymentMethod');
        // $query = Cost::with('paymentMethod', 'customer', 'order');

        $currentYear = date('Y');
        $currentMonth = date('n');

        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);

        // Apply date filter
        $query->whereYear('date', $selectedYear)
              ->whereMonth('date', $selectedMonth);

        // Get standard expense types from the database
        $standardExpenseTypes = ExpenseType::pluck('name')->toArray();

        // Apply type filter
        if ($request->has('type_filter') && $request->type_filter != 'All Types') {
            if ($request->type_filter == 'Other') {
                // If "Other" is selected, show all non-standard expense types
                $query->whereNotIn('expense_type', $standardExpenseTypes);
            } else {
                $query->where('expense_type', $request->type_filter);
            }
        }

        if (auth()->user()->role == 'user') {
            $query->where('user_id', auth()->user()->id);
        }

        $costs = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();

        // Get data from settings tables
        $expenseTypes = ExpenseType::pluck('name');
        $paymentMethods = PaymentMethod::all();

        // Get total expenses by type for the chart
        $chartData = Cost::select(
                DB::raw('CASE WHEN expense_type IN ("' . implode('","', $standardExpenseTypes) . '") THEN expense_type ELSE "Other" END as expense_type'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('date', $selectedYear)
            ->whereMonth('date', $selectedMonth)
            ->groupBy(DB::raw('CASE WHEN expense_type IN ("' . implode('","', $standardExpenseTypes) . '") THEN expense_type ELSE "Other" END'))
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->expense_type => $item->total];
            });

        // Get yearly cost report data
        $yearlyChartData = Cost::select(
                DB::raw('CASE WHEN expense_type IN ("' . implode('","', $standardExpenseTypes) . '") THEN expense_type ELSE "Other" END as expense_type'),
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('date', $selectedYear)
            ->groupBy(
                DB::raw('CASE WHEN expense_type IN ("' . implode('","', $standardExpenseTypes) . '") THEN expense_type ELSE "Other" END'),
                DB::raw('MONTH(date)')
            )
            ->orderBy('month', 'asc')
            ->get()
            ->groupBy('expense_type')
            ->map(function ($group) {
                return $group->mapWithKeys(function ($item) {
                    return [$item->month => $item->total];
                });
            });

        // Get available years for the filter
        $availableYears = Cost::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $totalExpenses = $chartData->sum();

        // Add "Other" to the expense types list for filtering
        $expenseTypes = $expenseTypes->push('Other');

        return view('admin.expense.index', compact(
            'costs',
            'expenseTypes',
            'paymentMethods',
            'chartData',
            'yearlyChartData',
            'selectedYear',
            'selectedMonth',
            'availableYears',
            'totalExpenses'
        ));
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        $validated = $request->validate([
            'expenses' => 'required|array|min:1',
            'expenses.*.amount' => 'required|numeric|min:0',
            'expenses.*.details' => 'required|string|max:255',
            'expenses.*.expense_type' => 'required|string',
            'expenses.*.other_type' => 'required_if:expenses.*.expense_type,Other|max:255',
            'expenses.*.payment_method_id' => 'required|exists:payment_methods,id',
            'expenses.*.image' => 'nullable|image|max:2048',
            'expenses.*.date' => 'required|date',
            'expenses.*.customer_id' => 'nullable|exists:customers,id',
            'expenses.*.product_id' => 'nullable|exists:products,id',
        ]);

        $expense_id = Str::uuid();

        foreach ($validated['expenses'] as $expenseData) {
            $cost = new Cost();
            $cost->expense_id = $expense_id;
            $cost->amount = $expenseData['amount'];
            $cost->details = $expenseData['details'];
            $cost->expense_type = $expenseData['expense_type'] == 'Other' ? $expenseData['other_type'] : $expenseData['expense_type'];
            $cost->payment_method_id = $expenseData['payment_method_id'];
            $cost->date = $expenseData['date'];
            $cost->user_id = $user_id;
            $cost->customer_id = $expenseData['customer_id'] ?? null;
            $cost->product_id = $expenseData['product_id'] ?? null;

            if (isset($expenseData['image'])) {
                $imagePath = $this->saveImage($expenseData['image']);
                $cost->image_path = $imagePath;
            }

            $cost->save();
        }

        return redirect()->route('transactions.index')->with('success', 'Costs added successfully!');
    }

    public function update(Request $request, Cost $cost)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'details' => 'required|string|max:255',
            'expense_type' => 'required|string',
            'other_type' => 'required_if:expense_type,Other|max:255',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $cost->amount = $validated['amount'];
        $cost->details = $validated['details'];
        $cost->expense_type = $validated['expense_type'] == 'Other' ? $validated['other_type'] : $validated['expense_type'];
        $cost->payment_method_id = $validated['payment_method_id'];

        if ($request->hasFile('image')) {
            if ($cost->image_path) {
                unlink($cost->image_path);
            }
            $imagePath = $this->saveImage($request->file('image'));
            $cost->image_path = $imagePath;
        }

        $cost->save();

        return redirect()->back()->with('success', 'Cost updated successfully!');
    }

    private function saveImage($img)
    {
        $this->image = $img;
        if ($this->image) {
            $this->imageName = rand() . '.' . $this->image->getClientOriginalExtension();
            $this->directory = 'adminAsset/cost/';
            $this->imgUrl = $this->directory . $this->imageName;
            $this->image->move($this->directory, $this->imageName);
            return $this->imgUrl;
        } else {
            return $this->image;
        }
    }

    public function destroy(Cost $cost)
    {
        if ($cost->image_path) {
            unlink($cost->image_path);
        }
        $cost->delete();
        return redirect()->back()->with('success', 'Cost deleted successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cost $cost)
    {
        // Load relationships to ensure they're included in the JSON response
        $cost->load('paymentMethod', );
        // $cost->load('paymentMethod', 'customer', 'order');

        return response()->json($cost);
    }
}

