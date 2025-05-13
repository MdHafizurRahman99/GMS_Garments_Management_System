<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\IncomeSource;
use App\Models\IncomeType;
use App\Models\ExpenseType;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        $incomeSources = IncomeSource::all();
        $incomeTypes = IncomeType::all();
        $expenseTypes = ExpenseType::all();

        return view('admin.settings.index', compact('paymentMethods', 'incomeSources', 'incomeTypes', 'expenseTypes'));
    }

    // Payment Methods
    public function storePaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,cheque',
        ]);

        PaymentMethod::create($validated);

        return redirect()->back()->with('success', 'Payment method added successfully.');
    }

    public function editPaymentMethod(PaymentMethod $paymentMethod)
    {
        return response()->json($paymentMethod);
    }

    public function updatePaymentMethod(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,cheque',
        ]);

        $paymentMethod->update($validated);

        return redirect()->back()->with('success', 'Payment method updated successfully.');
    }

    public function destroyPaymentMethod(PaymentMethod $paymentMethod)
    {
        // Check if the payment method is in use
        if ($paymentMethod->incomes()->count() > 0 || $paymentMethod->costs()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete payment method that is in use.');
        }

        $paymentMethod->delete();

        return redirect()->back()->with('success', 'Payment method deleted successfully.');
    }

    // Income Sources
    public function storeIncomeSource(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:income_sources',
        ]);

        IncomeSource::create($validated);

        return redirect()->back()->with('success', 'Income source added successfully.');
    }

    public function editIncomeSource(IncomeSource $incomeSource)
    {
        return response()->json($incomeSource);
    }

    public function updateIncomeSource(Request $request, IncomeSource $incomeSource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:income_sources,name,' . $incomeSource->id,
        ]);

        $incomeSource->update($validated);

        return redirect()->back()->with('success', 'Income source updated successfully.');
    }

    public function destroyIncomeSource(IncomeSource $incomeSource)
    {
        // Check if the income source is in use
        if ($incomeSource->incomes()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete income source that is in use.');
        }

        $incomeSource->delete();

        return redirect()->back()->with('success', 'Income source deleted successfully.');
    }

    // Income Types
    public function storeIncomeType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:income_types',
        ]);

        IncomeType::create($validated);

        return redirect()->back()->with('success', 'Income type added successfully.');
    }

    public function editIncomeType(IncomeType $incomeType)
    {
        return response()->json($incomeType);
    }

    public function updateIncomeType(Request $request, IncomeType $incomeType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:income_types,name,' . $incomeType->id,
        ]);

        $incomeType->update($validated);

        return redirect()->back()->with('success', 'Income type updated successfully.');
    }

    public function destroyIncomeType(IncomeType $incomeType)
    {
        // Check if the income type is in use
        if ($incomeType->incomes()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete income type that is in use.');
        }

        $incomeType->delete();

        return redirect()->back()->with('success', 'Income type deleted successfully.');
    }

    // Expense Types
    public function storeExpenseType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:expense_types',
        ]);

        ExpenseType::create($validated);

        return redirect()->back()->with('success', 'Expense type added successfully.');
    }

    public function editExpenseType(ExpenseType $expenseType)
    {
        return response()->json($expenseType);
    }

    public function updateExpenseType(Request $request, ExpenseType $expenseType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:expense_types,name,' . $expenseType->id,
        ]);

        $expenseType->update($validated);

        return redirect()->back()->with('success', 'Expense type updated successfully.');
    }

    public function destroyExpenseType(ExpenseType $expenseType)
    {
        // Check if the expense type is in use
        if ($expenseType->costs()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete expense type that is in use.');
        }

        $expenseType->delete();

        return redirect()->back()->with('success', 'Expense type deleted successfully.');
    }
}

