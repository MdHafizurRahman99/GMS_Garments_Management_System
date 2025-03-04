<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CostController extends Controller
{
    public $image, $imageName, $directory, $imgUrl;
    private $expenseTypes = ['Rent', 'Utilities', 'Supplies', 'Machinery Repair', 'Other'];

    public function create()
    {
        $expenseTypes = $this->expenseTypes;
        return view('admin.expense.create', compact('expenseTypes'));
    }

    public function index(Request $request)
    {
        $query = Cost::query();

        $currentYear = date('Y');
        $currentMonth = date('n');

        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);

        // Apply date filter
        $query->whereYear('date', $selectedYear)
              ->whereMonth('date', $selectedMonth);

        // Apply type filter
        if ($request->has('type_filter') && $request->type_filter != 'All Types') {
            if ($request->type_filter == 'Other') {
                $query->whereNotIn('expense_type', $this->expenseTypes);
            } else {
                $query->where('expense_type', $request->type_filter);
            }
        }

        if (auth()->user()->role == 'user') {
            $query->where('user_id', auth()->user()->id);
        }

        $costs = $query->orderBy('date', 'desc')->paginate(10);
        $expenseTypes =  $this->expenseTypes;
        // $expenseTypes = array_merge(['All Types'], $this->expenseTypes, ['Other']);

        // Get total expenses by type for the chart
        $chartData = Cost::select(
                DB::raw('CASE WHEN expense_type IN ("' . implode('","', $this->expenseTypes) . '") THEN expense_type ELSE "Other" END as expense_type'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('date', $selectedYear)
            ->whereMonth('date', $selectedMonth)
            ->groupBy('expense_type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->expense_type => $item->total];
            });

        // Get yearly cost report data
        $yearlyChartData = Cost::select(
                DB::raw('CASE WHEN expense_type IN ("' . implode('","', $this->expenseTypes) . '") THEN expense_type ELSE "Other" END as expense_type'),
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('date', $selectedYear)
            ->groupBy('expense_type', DB::raw('MONTH(date)'))
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

        return view('admin.expense.index', compact('costs', 'expenseTypes', 'chartData', 'yearlyChartData', 'selectedYear', 'selectedMonth', 'availableYears'));
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
            'expenses.*.image' => 'nullable|image|max:2048',
            'expenses.*.date' => 'required|date',
        ]);

        $expense_id = Str::uuid();

        foreach ($validated['expenses'] as $expenseData) {
            $cost = new Cost();
            $cost->expense_id = $expense_id;
            $cost->amount = $expenseData['amount'];
            $cost->details = $expenseData['details'];
            $cost->expense_type = $expenseData['expense_type'] == 'Other' ? $expenseData['other_type'] : $expenseData['expense_type'];
            $cost->date = $expenseData['date'];
            $cost->user_id = $user_id;

            if (isset($expenseData['image'])) {
                // $imagePath = $expenseData['image']->store('expense_images', 'public');
                $imagePath =$this->saveImage($expenseData['image']);

                $cost->image_path = $imagePath;
            }

            $cost->save();
        }

        return redirect()->route('costs.index')->with('success', 'Costs added successfully!');
    }



    public function update(Request $request, Cost $cost)
    {
// return $request;
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'details' => 'required|string|max:255',
            'expense_type' => 'required|string',
            'other_type' => 'required_if:expense_type,Other|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        // return $validated;
        $cost->amount = $validated['amount'];
        $cost->details = $validated['details'];
        $cost->expense_type = $validated['expense_type'] == 'Other' ? $validated['other_type'] : $validated['expense_type'];

        if ($request->hasFile('image')) {

            // Delete old image if exists
            if ($cost->image_path) {
                // Storage::disk('public')->delete($cost->image_path);
                unlink($cost->image_path);
            }
            // $imagePath = $request->file('image')->store('expense_images', 'public');
            $imagePath =$this->saveImage($request->file('image'));

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
            // Storage::disk('public')->delete($cost->image_path);
            unlink($cost->image_path);

        }
        $cost->delete();
        return redirect()->back()->with('success', 'Cost deleted successfully!');
    }
}
