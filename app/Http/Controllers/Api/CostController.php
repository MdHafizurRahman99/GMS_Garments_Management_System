<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CostController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Cost::with('paymentMethod')
            ->where('user_id', $user->id);
        
        // Apply filters
        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }
        
        if ($request->has('expense_type') && $request->expense_type != 'All Types') {
            // Get standard expense types from the database
            $standardExpenseTypes = \App\Models\ExpenseType::pluck('name')->toArray();
            
            if ($request->expense_type == 'Other') {
                // If "Other" is selected, show all non-standard expense types
                $query->whereNotIn('expense_type', $standardExpenseTypes);
            } else {
                $query->where('expense_type', $request->expense_type);
            }
        }
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('expense_type', 'like', "%{$search}%")
                  ->orWhere('details', 'like', "%{$search}%");
            });
        }
        
        // Get total for the filtered data
        $total = $query->sum('amount');
        
        // Get paginated results
        $costs = $query->orderBy('date', 'desc')
                      ->paginate(10);
        
        return response()->json([
            'data' => $costs,
            'total' => $total
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'expense_type' => 'required|string',
            'other_type' => 'required_if:expense_type,Other|max:255',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'details' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $cost = new Cost();
        $cost->expense_id = Str::uuid();
        $cost->amount = $request->amount;
        $cost->expense_type = $request->expense_type == 'Other' ? $request->other_type : $request->expense_type;
        $cost->payment_method_id = $request->payment_method_id;
        $cost->details = $request->details;
        $cost->date = $request->date;
        $cost->user_id = $request->user()->id;
        $cost->save();

        return response()->json([
            'message' => 'Expense created successfully',
            'data' => $cost
        ], 201);
    }

    public function show(Cost $cost, Request $request)
    {
        // Check if the cost belongs to the authenticated user
        if ($cost->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json($cost->load('paymentMethod'));
    }

    public function update(Request $request, Cost $cost)
    {
        // Check if the cost belongs to the authenticated user
        if ($cost->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'expense_type' => 'required|string',
            'other_type' => 'required_if:expense_type,Other|max:255',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'details' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $cost->amount = $request->amount;
        $cost->expense_type = $request->expense_type == 'Other' ? $request->other_type : $request->expense_type;
        $cost->payment_method_id = $request->payment_method_id;
        $cost->details = $request->details;
        $cost->date = $request->date;
        $cost->save();

        return response()->json([
            'message' => 'Expense updated successfully',
            'data' => $cost
        ]);
    }

    public function destroy(Cost $cost, Request $request)
    {
        // Check if the cost belongs to the authenticated user
        if ($cost->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $cost->delete();

        return response()->json([
            'message' => 'Expense deleted successfully'
        ]);
    }
}

