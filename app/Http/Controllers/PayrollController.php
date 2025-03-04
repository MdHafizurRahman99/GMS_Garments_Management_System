<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'user') {
            $payrolls = Payroll::with('employee')->where('employee_id', auth()->id())->orderBy('payment_date', 'desc')->paginate(10);
        }else {
            $payrolls = Payroll::with('employee')->orderBy('payment_date', 'desc')->paginate(10);
        }


        return view('admin.payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = User::all();
        return view('admin.payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after:pay_period_start',
            'gross_pay' => 'required|numeric|min:0',
            'net_pay' => 'required|numeric|min:0',
            'deductions' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        Payroll::create($validated);

        return redirect()->route('payrolls.index')->with('success', 'Payroll record created successfully.');
    }

    public function edit(Payroll $payroll)
    {
        $employees = User::all();
        return view('admin.payrolls.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after:pay_period_start',
            'gross_pay' => 'required|numeric|min:0',
            'net_pay' => 'required|numeric|min:0',
            'deductions' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        $payroll->update($validated);

        return redirect()->route('payrolls.index')->with('success', 'Payroll record updated successfully.');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('payrolls.index')->with('success', 'Payroll record deleted successfully.');
    }}
