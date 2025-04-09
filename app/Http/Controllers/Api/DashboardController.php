<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Cost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $currentYear = $request->input('year', date('Y'));
        
        // Calculate total income
        $totalIncome = Income::where('user_id', $user->id)->sum('amount');
        
        // Calculate total expense
        $totalExpense = Cost::where('user_id', $user->id)->sum('amount');
        
        // Calculate cash in hand (cash payment method)
        $cashIncome = Income::whereHas('paymentMethod', function ($query) {
            $query->where('type', 'cash');
        })->where('user_id', $user->id)->sum('amount');
        
        $cashExpense = Cost::whereHas('paymentMethod', function ($query) {
            $query->where('type', 'cash');
        })->where('user_id', $user->id)->sum('amount');
        
        $cashInHand = $cashIncome - $cashExpense;
        
        // Calculate cash in bank (bank payment method)
        $bankIncome = Income::whereHas('paymentMethod', function ($query) {
            $query->where('type', 'bank');
        })->where('user_id', $user->id)->sum('amount');
        
        $bankExpense = Cost::whereHas('paymentMethod', function ($query) {
            $query->where('type', 'bank');
        })->where('user_id', $user->id)->sum('amount');
        
        $cashInBank = $bankIncome - $bankExpense;
        
        // Get monthly data for the current year
        $monthlyIncome = Income::select(
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->groupBy(DB::raw('MONTH(date)'))
            ->get()
            ->pluck('total', 'month')
            ->toArray();
            
        $monthlyExpense = Cost::select(
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->groupBy(DB::raw('MONTH(date)'))
            ->get()
            ->pluck('total', 'month')
            ->toArray();
            
        $months = [];
        $incomeData = [];
        $expenseData = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $incomeData[] = $monthlyIncome[$i] ?? 0;
            $expenseData[] = $monthlyExpense[$i] ?? 0;
        }
        
        // Get expense by category
        $standardExpenseTypes = DB::table('expense_types')->pluck('name')->toArray();
        
        $expenseByCategory = Cost::select(
                DB::raw('CASE WHEN expense_type IN ("' . implode('","', $standardExpenseTypes) . '") THEN expense_type ELSE "Other" END as name'),
                DB::raw('SUM(amount) as amount')
            )
            ->where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->groupBy(DB::raw('CASE WHEN expense_type IN ("' . implode('","', $standardExpenseTypes) . '") THEN expense_type ELSE "Other" END'))
            ->get();
        
        return response()->json([
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'cashInHand' => $cashInHand,
            'cashInBank' => $cashInBank,
            'monthlyData' => [
                'labels' => $months,
                'income' => $incomeData,
                'expense' => $expenseData
            ],
            'expenseByCategory' => $expenseByCategory
        ]);
    }
}

