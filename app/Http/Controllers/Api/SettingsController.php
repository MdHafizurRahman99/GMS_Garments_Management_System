<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\IncomeSource;
use App\Models\IncomeType;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    // Payment Methods
    public function getPaymentMethods()
    {
        $paymentMethods = PaymentMethod::all();
        return response()->json($paymentMethods);
    }
    
    public function storePaymentMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,cheque',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $paymentMethod = PaymentMethod::create($request->all());

        return response()->json([
            'message' => 'Payment method created successfully',
            'data' => $paymentMethod
        ], 201);
    }
    
    public function updatePaymentMethod(Request $request, PaymentMethod $paymentMethod)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,cheque',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $paymentMethod->update($request->all());

        return response()->json([
            'message' => 'Payment method updated successfully',
            'data' => $paymentMethod
        ]);
    }
    
    public function destroyPaymentMethod(PaymentMethod $paymentMethod)
    {
        // Check if the payment method is in use
        if ($paymentMethod->incomes()->count() > 0 || $paymentMethod->costs()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete payment method that is in use'
            ], 400);
        }

        $paymentMethod->delete();

        return response()->json([
            'message' => 'Payment method deleted successfully'
        ]);
    }

    // Income Sources
    public function getIncomeSources()
    {
        $incomeSources = IncomeSource::all();
        return response()->json($incomeSources);
    }
    
    public function storeIncomeSource(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:income_sources',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $incomeSource = IncomeSource::create($request->all());

        return response()->json([
            'message' => 'Income source created successfully',
            'data' => $incomeSource
        ], 201);
    }
    
    public function updateIncomeSource(Request $request, IncomeSource $incomeSource)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:income_sources,name,' . $incomeSource->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $incomeSource->update($request->all());

        return response()->json([
            'message' => 'Income source updated successfully',
            'data' => $incomeSource
        ]);
    }
    
    public function destroyIncomeSource(IncomeSource $incomeSource)
    {
        // Check if the income source is in use
        if ($incomeSource->incomes()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete income source that is in use'
            ], 400);
        }

        $incomeSource->delete();

        return response()->json([
            'message' => 'Income source deleted successfully'
        ]);
    }

    // Income Types
    public function getIncomeTypes()
    {
        $incomeTypes = IncomeType::all();
        return response()->json($incomeTypes);
    }
    
    public function storeIncomeType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:income_types',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $incomeType = IncomeType::create($request->all());

        return response()->json([
            'message' => 'Income type created successfully',
            'data' => $incomeType
        ], 201);
    }
    
    public function updateIncomeType(Request $request, IncomeType $incomeType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:income_types,name,' . $incomeType->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $incomeType->update($request->all());

        return response()->json([
            'message' => 'Income type updated successfully',
            'data' => $incomeType
        ]);
    }
    
    public function destroyIncomeType(IncomeType $incomeType)
    {
        // Check if the income type is in use
        if ($incomeType->incomes()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete income type that is in use'
            ], 400);
        }

        $incomeType->delete();

        return response()->json([
            'message' => 'Income type deleted successfully'
        ]);
    }

    // Expense Types
    public function getExpenseTypes()
    {
        $expenseTypes = ExpenseType::all();
        return response()->json($expenseTypes);
    }
    
    public function storeExpenseType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:expense_types',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $expenseType = ExpenseType::create($request->all());

        return response()->json([
            'message' => 'Expense type created successfully',
            'data' => $expenseType
        ], 201);
    }
    
    public function updateExpenseType(Request $request, ExpenseType $expenseType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:expense_types,name,' . $expenseType->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $expenseType->update($request->all());

        return response()->json([
            'message' => 'Expense type updated successfully',
            'data' => $expenseType
        ]);
    }
    
    public function destroyExpenseType(ExpenseType $expenseType)
    {
        // Check if the expense type is in use
        if ($expenseType->costs()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete expense type that is in use'
            ], 400);
        }

        $expenseType->delete();

        return response()->json([
            'message' => 'Expense type deleted successfully'
        ]);
    }
}

