<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Income::with('paymentMethod')
            ->where('user_id', $user->id);
        
        // Apply filters
        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('income_source', 'like', "%{$search}%")
                  ->orWhere('income_type', 'like', "%{$search}%")
                  ->orWhere('details', 'like', "%{$search}%");
            });
        }
        
        // Get total for the filtered data
        $total = $query->sum('amount');
        
        // Get paginated results
        $incomes = $query->orderBy('date', 'desc')
                        ->paginate(10);
        
        return response()->json([
            'data' => $incomes,
            'total' => $total
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'income_source' => 'required|string',
            'income_type' => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'bank_name' => 'nullable|required_if:payment_method_id,2|string',
            'transaction_id' => 'nullable|string',
            'details' => 'nullable|string',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $income = new Income();
        $income->amount = $request->amount;
        $income->income_source = $request->income_source;
        $income->income_type = $request->income_type;
        $income->payment_method_id = $request->payment_method_id;
        $income->bank_name = $request->bank_name;
        $income->transaction_id = $request->transaction_id;
        $income->details = $request->details;
        $income->date = $request->date;
        $income->user_id = $request->user()->id;
        $income->save();

        return response()->json([
            'message' => 'Income created successfully',
            'data' => $income
        ], 201);
    }

    public function show(Income $income, Request $request)
    {
        // Check if the income belongs to the authenticated user
        if ($income->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json($income->load('paymentMethod'));
    }

    public function update(Request $request, Income $income)
    {
        // Check if the income belongs to the authenticated user
        if ($income->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'income_source' => 'required|string',
            'income_type' => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'bank_name' => 'nullable|required_if:payment_method_id,2|string',
            'transaction_id' => 'nullable|string',
            'details' => 'nullable|string',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $income->amount = $request->amount;
        $income->income_source = $request->income_source;
        $income->income_type = $request->income_type;
        $income->payment_method_id = $request->payment_method_id;
        $income->bank_name = $request->bank_name;
        $income->transaction_id = $request->transaction_id;
        $income->details = $request->details;
        $income->date = $request->date;
        $income->save();

        return response()->json([
            'message' => 'Income updated successfully',
            'data' => $income
        ]);
    }

    public function destroy(Income $income, Request $request)
    {
        // Check if the income belongs to the authenticated user
        if ($income->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $income->delete();

        return response()->json([
            'message' => 'Income deleted successfully'
        ]);
    }
}

