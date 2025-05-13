@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Payroll Record</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('payrolls.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pay_period_start" class="form-label">Pay Period Start</label>
                    <input type="date" name="pay_period_start" id="pay_period_start" class="form-control @error('pay_period_start') is-invalid @enderror" value="{{ old('pay_period_start') }}" required>
                    @error('pay_period_start')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pay_period_end" class="form-label">Pay Period End</label>
                    <input type="date" name="pay_period_end" id="pay_period_end" class="form-control @error('pay_period_end') is-invalid @enderror" value="{{ old('pay_period_end') }}" required>
                    @error('pay_period_end')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gross_pay" class="form-label">Gross Pay</label>
                    <input type="number" step="0.01" name="gross_pay" id="gross_pay" class="form-control @error('gross_pay') is-invalid @enderror" value="{{ old('gross_pay') }}" required>
                    @error('gross_pay')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="net_pay" class="form-label">Net Pay</label>
                    <input type="number" step="0.01" name="net_pay" id="net_pay" class="form-control @error('net_pay') is-invalid @enderror" value="{{ old('net_pay') }}" required>
                    @error('net_pay')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deductions" class="form-label">Deductions</label>
                    <input type="number" step="0.01" name="deductions" id="deductions" class="form-control @error('deductions') is-invalid @enderror" value="{{ old('deductions') }}" required>
                    @error('deductions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" id="payment_date" class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date') }}" required>
                    @error('payment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Create Payroll Record</button>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
