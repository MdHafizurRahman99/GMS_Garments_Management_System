{{-- @extends('layouts.admin.master')
@section('title')
    Dashboard(Costing History)
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .other-type-input {
            display: none;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

    <h1 class="mb-2">Expense History</h1>
    <p class="text-muted mb-4">Track and manage company expenses</p>

    <button class="btn btn-dark mb-4" data-bs-toggle="modal" data-bs-target="#addCostModal">
        <span class="me-2">+</span> Add Cost
    </button>

    <!-- Add filter form -->
    <form action="{{ route('costs.index') }}" method="GET" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="type_filter" class="col-form-label">Filter by Type:</label>
            </div>
            <div class="col-auto">
                <select name="type_filter" id="type_filter" class="form-select" onchange="this.form.submit()">
                    <option value="All" {{ request('type_filter') == 'All' ? 'selected' : '' }}>All Types</option>
                    @foreach ($expenseTypes as $type)
                        <option value="{{ $type }}" {{ request('type_filter') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($costs as $cost)
                    <tr>
                        <td>{{ $cost->date->format('Y-m-d') }}</td>
                        <td>${{ number_format($cost->amount, 2) }}</td>
                        <td>{{ $cost->details }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary"
                                    onclick="editCost({{ $cost->id }}, '{{ $cost->amount }}', '{{ $cost->details }}', '{{ $cost->expense_type }}', '{{ $cost->order_id }}')"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editCostModal">
                                Edit
                            </button>
                            <form action="{{ route('costs.destroy', $cost) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="d-flex justify-content-between align-items-center mt-4">
        {{ $costs->links() }}
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addCostModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Cost</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('costs.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expense Type</label>
                        <select name="expense_type" class="form-select" required onchange="toggleOtherType(this, 'add')">
                            @foreach ($expenseTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 other-type-input" id="addOtherType">
                        <label class="form-label">Other Type</label>
                        <input type="text" name="other_type" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order ID (Optional)</label>
                        <select name="order_id" class="form-select">
                            <option value="">None</option>
                            @foreach ($orders as $order)
                                <option value="{{ $order->id }}">{{ $order->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Details</label>
                        <textarea name="details" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark">Add Cost</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editCostModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Cost</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" name="amount" id="editAmount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expense Type</label>
                        <select name="expense_type" id="editExpenseType" class="form-select" required onchange="toggleOtherType(this, 'edit')">
                            @foreach ($expenseTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 other-type-input" id="editOtherType">
                        <label class="form-label">Other Type</label>
                        <input type="text" name="other_type" id="editOtherTypeInput" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order ID (Optional)</label>
                        <select name="order_id" id="editOrderId" class="form-select">
                            <option value="">None</option>
                            @foreach ($orders as $order)
                                <option value="{{ $order->id }}">{{ $order->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Details</label>
                        <textarea name="details" id="editDetails" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Cost</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const expenseTypes = {!! json_encode($expenseTypes) !!};

    function editCost(id, amount,details, expenseType, orderId, ) {
        document.getElementById('editForm').action = `/costs/${id}`;
        document.getElementById('editAmount').value = amount;
        if (expenseTypes.includes(expenseType)) {
            console.log('hello');

                document.getElementById('editExpenseType').value = expenseType;
                document.getElementById('editOtherTypeInput').style.display = 'none';
                document.getElementById('editOtherTypeInput').value = '';
            } else {
                document.getElementById('editExpenseType').value = 'Other';
                document.getElementById('editOtherTypeInput').style.display = 'block';
                document.getElementById('editOtherTypeInput').value = expenseType;
            }
             document.getElementById('editOrderId').value = orderId || '';
        document.getElementById('editDetails').value = details;
        toggleOtherType(document.getElementById('editExpenseType'), 'edit');
    }

    function toggleOtherType(select, prefix) {
        const otherTypeDiv = document.getElementById(prefix + 'OtherType');
        const otherTypeInput = document.getElementById(prefix + 'OtherTypeInput');
        if (select.value === 'Other') {
            otherTypeDiv.style.display = 'block';
            otherTypeInput.required = true;
        } else {
            otherTypeDiv.style.display = 'none';
            otherTypeInput.required = false;
        }
    }
</script>
@endsection --}}

@extends('layouts.admin.master')
@section('title', 'Expense History')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.css" rel="stylesheet">
    <style>
        .modal {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .other-type-input {
            display: none;
        }
        #expenseChart, #yearlyExpenseChart {
            min-height: 300px;
        }
        .expense-image-preview {
            max-width: 50px;
            max-height: 50px;
            cursor: pointer;
        }
        #imageModal .modal-body {
            text-align: center;
        }
        #imageModal .modal-body img {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .chart-container {
            position: relative;
            height: 50vh;
            width: 100%;
        }
        @media (max-width: 768px) {
            .filter-form .col-auto {
                width: 100%;
                margin-bottom: 10px;
            }
            .filter-form select, .filter-form button {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h1 class="mb-2">Expense History</h1>
        <p class="text-muted mb-4">Track and manage company expenses</p>

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <a href="{{ route('costs.create') }}" class="btn btn-dark mb-2">
                <span class="me-2">+</span> Add Cost
            </a>

            <!-- Filter Form -->
            <form action="{{ route('costs.index') }}" method="GET" class="filter-form">
                <div class="row g-3 align-items-end">
                    <div class="col-auto">
                        <label for="month" class="form-label">Month:</label>
                        <select name="month" id="month" class="form-select">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="year" class="form-label">Year:</label>
                        <select name="year" id="year" class="form-select">
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="type_filter" class="form-label">Type:</label>
                        <select name="type_filter" id="type_filter" class="form-select">
                            <option value="All Types"
                                {{ request('type_filter', 'All Types') == 'All Types' ? 'selected' : '' }}>
                                All Types
                            </option>
                            @foreach ($expenseTypes as $type)
                                <option value="{{ $type }}"
                                    {{ request('type_filter', 'All Types') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Yearly Cost Report Chart -->
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Yearly Cost Report ({{ $selectedYear }})</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="yearlyExpenseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row mt-4 mb-4">
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Total Expenses by Type
                            ({{ date('F', mktime(0, 0, 0, $selectedMonth, 1)) }} {{ $selectedYear }})</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="expenseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Expense Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th class="text-end">Total Amount</th>
                                        <th class="text-end">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalExpenses = $chartData->sum();
                                    @endphp
                                    @foreach ($chartData as $type => $amount)
                                        <tr>
                                            <td>{{ $type }}</td>
                                            <td class="text-end">${{ number_format($amount, 2) }}</td>
                                            <td class="text-end">
                                                {{ $totalExpenses > 0 ? number_format(($amount / $totalExpenses) * 100, 1) : 0 }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="fw-bold">
                                        <td>Total</td>
                                        <td class="text-end">${{ number_format($totalExpenses, 2) }}</td>
                                        <td class="text-end">100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Details</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($costs as $cost)
                                <tr>
                                    <td>{{ $cost->date->format('Y-m-d') }}</td>
                                    <td>${{ number_format($cost->amount, 2) }}</td>
                                    <td>{{ $cost->expense_type }}</td>
                                    <td>{{ $cost->details }}</td>
                                    <td>
                                        @if ($cost->image_path)
                                            <img src="{{ asset($cost->image_path) }}" alt="Expense Image"
                                                class="expense-image-preview"
                                                onclick="openImageModal('{{ asset($cost->image_path) }}', '{{ $cost->details }}')">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-primary"
                                                onclick="editCost({{ $cost->id }}, '{{ $cost->amount }}', '{{ $cost->details }}', '{{ $cost->expense_type }}','{{ $cost->order_id }}')"
                                                data-bs-toggle="modal" data-bs-target="#editCostModal">
                                                Edit
                                            </button>
                                            <form action="{{ route('costs.destroy', $cost) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            {{ $costs->links() }}
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editCostModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Cost</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" step="0.01" name="amount" id="editAmount" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Expense Type</label>
                            <select name="expense_type" id="editExpenseType" class="form-select" required
                                onchange="toggleOtherType(this, 'edit')">
                                @foreach ($expenseTypes as $type)
                                    @if ($type != 'All Types')
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 other-type-input" id="editOtherType">
                            <label class="form-label">Other Type</label>
                            <input type="text" name="other_type" id="editOtherTypeInput" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Details</label>
                            <textarea name="details" id="editDetails" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Image (optional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Cost</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Expense Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="/placeholder.svg" id="modalImage" alt="Expense Image">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart initialization
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('expenseChart').getContext('2d');
            const chartData = @json($chartData);
            const totalExpenses = @json($totalExpenses);

            if (Object.keys(chartData).length > 0) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(chartData),
                        datasets: [{
                            label: 'Total Expenses',
                            data: Object.values(chartData),
                            backgroundColor: [
                                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                                '#fd7e14', '#6f42c1', '#20c9a6', '#858796', '#5a5c69'
                            ],
                            borderColor: 'rgba(0, 0, 0, 0.1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        const value = context.parsed.y;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / totalExpenses) * 100).toFixed(1);
                                        return `${label}: $${value.toLocaleString()} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                document.getElementById('expenseChart').parentElement.innerHTML =
                    '<div class="text-center text-muted py-5">No data available for the selected period</div>';
            }
        });

        // Yearly Cost Report Chart initialization
        document.addEventListener('DOMContentLoaded', function() {
            const yearlyCtx = document.getElementById('yearlyExpenseChart').getContext('2d');
            const yearlyChartData = @json($yearlyChartData);

            if (Object.keys(yearlyChartData).length > 0) {
                const datasets = Object.entries(yearlyChartData).map(([type, data], index) => ({
                    label: type,
                    data: Array(12).fill(0).map((_, i) => data[i + 1] || 0),
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                        '#fd7e14', '#6f42c1', '#20c9a6', '#858796', '#5a5c69'
                    ][index % 10],
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1
                }));

                new Chart(yearlyCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        const value = context.parsed.y;
                                        return `${label}: $${value.toLocaleString()}`;
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                document.getElementById('yearlyExpenseChart').parentElement.innerHTML =
                    '<div class="text-center text-muted py-5">No data available for the yearly report</div>';
            }
        });

        const expenseTypes = {!! json_encode($expenseTypes) !!};

        // Remove "Other" from the array
        const filteredExpenseTypes = expenseTypes.filter(type => type !== "Other");

        function editCost(id, amount, details, expenseType) {
            document.getElementById('editForm').action = `/costs/${id}`;
            document.getElementById('editAmount').value = amount;
            if (expenseTypes.includes(expenseType)) {
                document.getElementById('editExpenseType').value = expenseType;
                document.getElementById('editOtherTypeInput').style.display = 'none';
                document.getElementById('editOtherTypeInput').value = '';
            } else {
                document.getElementById('editExpenseType').value = 'Other';
                document.getElementById('editOtherTypeInput').style.display = 'block';
                document.getElementById('editOtherTypeInput').value = expenseType;
            }
            document.getElementById('editDetails').value = details;
            toggleOtherType(document.getElementById('editExpenseType'), 'edit');
        }

        function toggleOtherType(select, prefix) {
            const otherTypeDiv = document.getElementById(prefix + 'OtherType');
            const otherTypeInput = document.getElementById(prefix + 'OtherTypeInput');
            if (select.value === 'Other') {
                otherTypeDiv.style.display = 'block';
                otherTypeInput.required = true;
            } else {
                otherTypeDiv.style.display = 'none';
                otherTypeInput.required = false;
            }
        }

        // Image Modal functionality
        function openImageModal(imageSrc, imageAlt) {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            modalImage.alt = imageAlt;
            const imageModalLabel = document.getElementById('imageModalLabel');
            imageModalLabel.textContent = imageAlt;
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }
    </script>
@endsection

