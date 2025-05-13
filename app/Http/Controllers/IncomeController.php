<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\PaymentMethod;
use App\Models\IncomeSource;
use App\Models\IncomeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class IncomeController extends Controller
{
    public function create()
    {
        // Get data from settings tables instead of hardcoded arrays
        $incomeSources = IncomeSource::pluck('name');
        $incomeTypes = IncomeType::pluck('name');
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        // $customers = DB::table('customers')->get();
        // $orders = DB::table('orders')->get();
        $customers = Schema::hasTable('customers') ? DB::table('customers')->get() : collect();
        $orders = Schema::hasTable('orders') ? DB::table('orders')->get() : collect();
        return view('admin.income.create', compact(
            'incomeSources',
            'incomeTypes',
            'paymentMethods',
            'customers',
            'orders'
        ));
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        $validated = $request->validate([
            'incomes' => 'required|array|min:1',
            'incomes.*.amount' => 'required|numeric|min:0',
            'incomes.*.income_source' => 'required|string',
            'incomes.*.payment_method_id' => 'required|exists:payment_methods,id',
            'incomes.*.bank_name' => 'required_if:incomes.*.payment_method_type,bank',
            'incomes.*.transaction_id' => 'nullable|string',
            'incomes.*.details' => 'nullable|string',
            'incomes.*.date' => 'required|date',
            'incomes.*.customer_id' => 'nullable|exists:customers,id',
            'incomes.*.order_id' => 'nullable|exists:orders,id',
            'incomes.*.image' => 'nullable|image|max:2048',
            'incomes.*.income_type' => 'required|string',
        ]);

        foreach ($validated['incomes'] as $incomeData) {
            $income = new Income();
            $income->amount = $incomeData['amount'];
            $income->income_source = $incomeData['income_source'];
            $income->payment_method_id = $incomeData['payment_method_id'];
            $income->bank_name = $incomeData['bank_name'] ?? null;
            $income->transaction_id = $incomeData['transaction_id'] ?? null;
            $income->details = $incomeData['details'] ?? null;
            $income->date = $incomeData['date'];
            $income->user_id = $user_id;
            $income->customer_id = $incomeData['customer_id'] ?? null;
            $income->order_id = $incomeData['order_id'] ?? null;
            $income->income_type = $incomeData['income_type'];

            if (isset($incomeData['image'])) {
                $imagePath = $this->saveImage($incomeData['image']);
                $income->image_path = $imagePath;
            }

            $income->save();
        }

        return redirect()->route('transactions.index')->with('success', 'Income added successfully!');
    }

    public function index(Request $request)
    {
        $query = Income::with('paymentMethod');
        // $query = Income::with('paymentMethod', 'customer', 'order');

        $currentYear = date('Y');
        $currentMonth = date('n');

        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);

        // Apply date filter
        $query->whereYear('date', $selectedYear)
              ->whereMonth('date', $selectedMonth);

        // Apply type filter
        if ($request->has('income_type') && $request->income_type != 'All Types') {
            $query->where('income_type', $request->income_type);
        }

        if (auth()->user()->role == 'user') {
            $query->where('user_id', auth()->user()->id);
        }

        $incomes = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();

        // Get data from settings tables
        $incomeTypes = IncomeType::pluck('name');
        $incomeSources = IncomeSource::pluck('name');
        $paymentMethods = PaymentMethod::all();
        // $customers = DB::table('customers')->get();
        // $orders = DB::table('orders')->get();
        $customers = Schema::hasTable('customers') ? DB::table('customers')->get() : collect();
        $orders = Schema::hasTable('orders') ? DB::table('orders')->get() : collect();
        // Get available years for the filter
        $availableYears = Income::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $totalIncome = $query->sum('amount');

        return view('admin.income.index', compact(
            'incomes',
            'incomeTypes',
            'incomeSources',
            'paymentMethods',
            'customers',
            'orders',
            'selectedYear',
            'selectedMonth',
            'availableYears',
            'totalIncome'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        // Load relationships to ensure they're included in the JSON response
        $income->load('paymentMethod');
        // $income->load('paymentMethod', 'customer', 'order');

        return response()->json($income);
    }

    public function update(Request $request, Income $income)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'income_source' => 'required|string',
            'income_type' => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'bank_name' => 'nullable|required_if:payment_method_id,2|string',
            'transaction_id' => 'nullable|string',
            'details' => 'nullable|string',
            'date' => 'required|date',
            'customer_id' => 'nullable|exists:customers,id',
            'order_id' => 'nullable|exists:orders,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $income->fill($validated);

        if ($request->hasFile('image')) {
            if ($income->image_path) {
                unlink($income->image_path);
            }
            $imagePath = $this->saveImage($request->file('image'));
            $income->image_path = $imagePath;
        }

        $income->save();

        return redirect()->back()->with('success', 'Income updated successfully!');
    }

    public function destroy(Income $income)
    {
        if ($income->image_path) {
            unlink($income->image_path);
        }
        $income->delete();
        return redirect()->back()->with('success', 'Income deleted successfully!');
    }

    private function saveImage($img)
    {
        if ($img) {
            $imageName = rand() . '.' . $img->getClientOriginalExtension();
            $directory = 'adminAsset/income/';
            $imgUrl = $directory . $imageName;
            $img->move($directory, $imageName);
            return $imgUrl;
        }
        return null;
    }
}

