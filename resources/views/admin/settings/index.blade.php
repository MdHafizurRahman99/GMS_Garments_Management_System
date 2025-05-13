@extends('layouts.admin.master')
@section('title', 'System Settings')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .settings-card {
            margin-bottom: 2rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
        }
        .settings-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.25rem;
        }
        .btn-group-sm > .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        .settings-icon {
            font-size: 1.5rem;
            margin-right: 0.5rem;
            color: #6c757d;
        }
        .nav-pills .nav-link.active {
            background-color: #212529;
        }
        .nav-pills .nav-link {
            color: #212529;
        }
        .nav-pills .nav-link.active {
            color: #fff;
        }
        .tab-content {
            padding-top: 1.5rem;
        }
        .input-group {
            margin-bottom: 1rem;
        }
        .badge-cash {
            background-color: #28a745;
            color: white;
        }
        .badge-bank {
            background-color: #007bff;
            color: white;
        }
        .badge-cheque {
            background-color: #6c757d;
            color: white;
        }
        @media (max-width: 768px) {
            .btn-group-sm > .btn {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>System Settings</h1>
        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Transactions
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="settings-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="payment-methods-tab" data-bs-toggle="pill" data-bs-target="#payment-methods" type="button" role="tab" aria-controls="payment-methods" aria-selected="true">
                        <i class="fas fa-credit-card me-2"></i>Payment Methods
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="income-sources-tab" data-bs-toggle="pill" data-bs-target="#income-sources" type="button" role="tab" aria-controls="income-sources" aria-selected="false">
                        <i class="fas fa-money-bill-wave me-2"></i>Income Sources
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="income-types-tab" data-bs-toggle="pill" data-bs-target="#income-types" type="button" role="tab" aria-controls="income-types" aria-selected="false">
                        <i class="fas fa-tags me-2"></i>Income Types
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="expense-types-tab" data-bs-toggle="pill" data-bs-target="#expense-types" type="button" role="tab" aria-controls="expense-types" aria-selected="false">
                        <i class="fas fa-shopping-cart me-2"></i>Expense Types
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="settings-tabContent">
                <!-- Payment Methods Tab -->
                <div class="tab-pane fade show active" id="payment-methods" role="tabpanel" aria-labelledby="payment-methods-tab">
                    <div class="card settings-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Payment Methods</h5>
                            <span class="badge bg-primary">{{ count($paymentMethods) }} Methods</span>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.payment-methods.store') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="text" name="name" class="form-control" placeholder="New payment method" required>
                                    </div>
                                    <div class="col-md-5">
                                        <select name="type" class="form-select" required>
                                            <option value="" disabled selected>Select type</option>
                                            <option value="cash">Cash</option>
                                            <option value="bank">Bank</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary w-100" type="submit">
                                            <i class="fas fa-plus me-2"></i>Add
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paymentMethods as $index => $method)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $method->name }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $method->type }}">
                                                        {{ ucfirst($method->type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-sm btn-primary" onclick="editPaymentMethod({{ $method->id }})">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        {{-- <form action="{{ route('settings.payment-methods.destroy', $method) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This action cannot be undone.')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Income Sources Tab -->
                <div class="tab-pane fade" id="income-sources" role="tabpanel" aria-labelledby="income-sources-tab">
                    <div class="card settings-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Income Sources</h5>
                            <span class="badge bg-success">{{ count($incomeSources) }} Sources</span>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.income-sources.store') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" placeholder="New income source" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success w-100" type="submit">
                                            <i class="fas fa-plus me-2"></i>Add
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($incomeSources as $index => $source)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $source->name }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-sm btn-primary" onclick="editIncomeSource({{ $source->id }})">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        {{-- <form action="{{ route('settings.income-sources.destroy', $source) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This action cannot be undone.')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Income Types Tab -->
                <div class="tab-pane fade" id="income-types" role="tabpanel" aria-labelledby="income-types-tab">
                    <div class="card settings-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Income Types</h5>
                            <span class="badge bg-info">{{ count($incomeTypes) }} Types</span>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.income-types.store') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" placeholder="New income type" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-info w-100 text-white" type="submit">
                                            <i class="fas fa-plus me-2"></i>Add
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($incomeTypes as $index => $type)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $type->name }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-sm btn-primary" onclick="editIncomeType({{ $type->id }})">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        {{-- <form action="{{ route('settings.income-types.destroy', $type) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This action cannot be undone.')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expense Types Tab -->
                <div class="tab-pane fade" id="expense-types" role="tabpanel" aria-labelledby="expense-types-tab">
                    <div class="card settings-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Expense Types</h5>
                            <span class="badge bg-danger">{{ count($expenseTypes) }} Types</span>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.expense-types.store') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" placeholder="New expense type" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-danger w-100" type="submit">
                                            <i class="fas fa-plus me-2"></i>Add
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($expenseTypes as $index => $type)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $type->name }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-sm btn-primary" onclick="editExpenseType({{ $type->id }})">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        {{-- <form action="{{ route('settings.expense-types.destroy', $type) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This action cannot be undone.')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Payment Method Modal -->
<div class="modal fade" id="editPaymentMethodModal" tabindex="-1" aria-labelledby="editPaymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPaymentMethodModalLabel">Edit Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPaymentMethodForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editPaymentMethodName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editPaymentMethodName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPaymentMethodType" class="form-label">Type</label>
                        <select class="form-select" id="editPaymentMethodType" name="type" required>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Income Source Modal -->
<div class="modal fade" id="editIncomeSourceModal" tabindex="-1" aria-labelledby="editIncomeSourceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editIncomeSourceModalLabel">Edit Income Source</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editIncomeSourceForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editIncomeSourceName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editIncomeSourceName" name="name" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Income Type Modal -->
<div class="modal fade" id="editIncomeTypeModal" tabindex="-1" aria-labelledby="editIncomeTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editIncomeTypeModalLabel">Edit Income Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editIncomeTypeForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editIncomeTypeName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editIncomeTypeName" name="name" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Expense Type Modal -->
<div class="modal fade" id="editExpenseTypeModal" tabindex="-1" aria-labelledby="editExpenseTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExpenseTypeModalLabel">Edit Expense Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editExpenseTypeForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editExpenseTypeName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editExpenseTypeName" name="name" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
<script>
    function editPaymentMethod(id) {
        fetch(`/settings/payment-methods/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editPaymentMethodForm').action = `/settings/payment-methods/${id}`;
                document.getElementById('editPaymentMethodName').value = data.name;
                document.getElementById('editPaymentMethodType').value = data.type;
                new bootstrap.Modal(document.getElementById('editPaymentMethodModal')).show();
            });
    }

    function editIncomeSource(id) {
        fetch(`/settings/income-sources/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editIncomeSourceForm').action = `/settings/income-sources/${id}`;
                document.getElementById('editIncomeSourceName').value = data.name;
                new bootstrap.Modal(document.getElementById('editIncomeSourceModal')).show();
            });
    }

    function editIncomeType(id) {
        fetch(`/settings/income-types/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editIncomeTypeForm').action = `/settings/income-types/${id}`;
                document.getElementById('editIncomeTypeName').value = data.name;
                new bootstrap.Modal(document.getElementById('editIncomeTypeModal')).show();
            });
    }

    function editExpenseType(id) {
        fetch(`/settings/expense-types/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editExpenseTypeForm').action = `/settings/expense-types/${id}`;
                document.getElementById('editExpenseTypeName').value = data.name;
                new bootstrap.Modal(document.getElementById('editExpenseTypeModal')).show();
            });
    }

    // Activate tab based on hash in URL
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash) {
            const tab = document.querySelector(`[data-bs-target="${hash}"]`);
            if (tab) {
                new bootstrap.Tab(tab).show();
            }
        }
    });

    // Update URL hash when tab changes
    const tabEls = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabEls.forEach(tabEl => {
        tabEl.addEventListener('shown.bs.tab', function (event) {
            const target = event.target.getAttribute('data-bs-target');
            window.location.hash = target;
        });
    });
</script>
@endsection

