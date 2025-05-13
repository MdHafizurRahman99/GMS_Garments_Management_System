@extends('layouts.admin.master')
@section('content')
<div class="container">
    <h1 class="mb-4">Payroll Management</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('payrolls.create') }}" class="btn btn-primary">Add New Payroll Record</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Pay Period</th>
                            <th>Gross Pay</th>
                            <th>Net Pay</th>
                            <th>Deductions</th>
                            <th>Payment Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payrolls as $payroll)
                            <tr>
                                <td>{{ $payroll->employee->name }}</td>
                                <td>{{ $payroll->pay_period_start->format('M d, Y') }} - {{ $payroll->pay_period_end->format('M d, Y') }}</td>
                                <td>${{ number_format($payroll->gross_pay, 2) }}</td>
                                <td>${{ number_format($payroll->net_pay, 2) }}</td>
                                <td>${{ number_format($payroll->deductions, 2) }}</td>
                                <td>{{ $payroll->payment_date->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('payrolls.edit', $payroll) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $payrolls->links() }}
    </div>
</div>
@endsection
