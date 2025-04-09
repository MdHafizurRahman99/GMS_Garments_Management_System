<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Income;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table(function ($query) {
            $query->select(
                'id',
                'date',
                'amount',
                'details',
                DB::raw("'expense' as type"),
                'expense_type as category',
                'image_path',
                'created_at',
                'payment_method_id'
            )
                ->from('costs')
                ->unionAll(
                    DB::table('incomes')
                        ->select(
                            'id',
                            'date',
                            'amount',
                            'details',
                            DB::raw("'income' as type"),
                            'income_type as category',
                            'image_path',
                            'created_at',
                            'payment_method_id'
                        )
                );
        }, 'transactions');

        // Apply date filter
        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                ->whereYear('date', $request->year);
        }

        // Get transactions
        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Calculate totals
        $cashInHand = $this->calculateCashInHand();
        $cashInBank = $this->calculateCashInBank();
        $totalIncome = $this->calculateTotalIncome($request);
        $totalExpense = $this->calculateTotalExpense($request);

        // Get available years for the filter
        $availableYears = DB::table(function ($query) {
            $query->select(DB::raw('YEAR(date) as year'))
                ->from('costs')
                ->union(
                    DB::table('incomes')
                        ->select(DB::raw('YEAR(date) as year'))
                );
        }, 'years')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $currentYear = date('Y');
        $currentMonth = date('n');
        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);

        $paymentMethods = PaymentMethod::all();

        return view('admin.transactions.index', compact(
            'transactions',
            'cashInHand',
            'cashInBank',
            'totalIncome',
            'totalExpense',
            'availableYears',
            'selectedYear',
            'selectedMonth',
            'paymentMethods'
        ));
    }

    private function calculateCashInHand()
    {
        $cashIncome = Income::whereHas('paymentMethod', function ($query) {
            $query->where('type', 'cash');
        })->sum('amount');

        $cashExpense = Cost::whereHas('paymentMethod', function ($query) {
            $query->where('type', 'cash');
        })->sum('amount');

        return $cashIncome - $cashExpense;
    }

    private function calculateCashInBank()
    {
        $bankIncome = Income::whereHas('paymentMethod', function ($query) {
            $query->where('type', 'bank');
        })->sum('amount');

        $bankExpense = Cost::whereHas('paymentMethod', function ($query) {
            $query->where('type', 'bank');
        })->sum('amount');

        return $bankIncome - $bankExpense;
    }

    private function calculateTotalIncome($request)
    {
        $query = Income::query();

        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                ->whereYear('date', $request->year);
        }

        return $query->sum('amount');
    }


    private function calculateTotalExpense($request)
    {
        $query = Cost::query();

        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                ->whereYear('date', $request->year);
        }

        return $query->sum('amount');
    }

    public function getTransactionDetails(Request $request)
    {
        $type = $request->type;
        $id = $request->id;

        if ($type === 'income') {
            // $transaction = Income::with('paymentMethod', 'incomeSource', 'incomeType', 'customer', 'order')
            $transaction = Income::with('paymentMethod', 'incomeSource', 'incomeType')
                ->findOrFail($id);
        } else {
            $transaction = Cost::with('paymentMethod', 'expenseType', 'customer', 'order')
                ->findOrFail($id);
        }

        return response()->json($transaction);
    }
}
