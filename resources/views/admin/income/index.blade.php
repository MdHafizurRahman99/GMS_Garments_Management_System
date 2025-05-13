@extends('layouts.admin.master')
@section('title', 'Income List')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .income-positive {
            color: #198754;
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
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="mb-3 mb-md-0">Income List</h1>
        <a href="{{ route('incomes.create') }}" class="btn btn-success mb-2 mb-md-0">
            <span class="me-2">+</span> Add Income
        </a>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('incomes.index') }}" method="GET" class="filter-form mb-4">
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
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label for="income_type" class="form-label">Income Type:</label>
                <select name="income_type" id="income_type" class="form-select">
                    <option value="All Types">All Types</option>
                    @foreach($incomeTypes as $type)
                        <option value="{{ $type }}" {{ request('income_type') == $type ? 'selected' : '' }}>
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

    <!-- Income Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Source</th>
                            <th>Type</th>
                            <th>Payment Method</th>
                            <th>Details</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomes as $income)
                            <tr>
                                <td>{{ $income->date->format('Y-m-d') }}</td>
                                <td class="income-positive">${{ number_format($income->amount, 2) }}</td>
                                <td>{{ $income->income_source }}</td>
                                <td>{{ $income->income_type }}</td>
                                <td>{{ $income->paymentMethod->name }}</td>
                                <td>{{ $income->details }}</td>
                                <td>
                                    @if($income->image_path)
                                        <img src="{{ asset($income->image_path) }}"
                                             alt="Income Image"
                                             class="expense-image-preview"
                                             onclick="openImageModal('{{ asset($income->image_path) }}', '{{ $income->details }}')">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editIncome({{ $income->id }})">
                                        Edit
                                    </button>
                                    <form action="{{ route('incomes.destroy', $income) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
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
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        {{ $incomes->links() }}
    </div>
</div>

<!-- Edit Income Modal -->
<div class="modal fade" id="editIncomeModal" tabindex="-1" aria-labelledby="editIncomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editIncomeModalLabel">Edit Income</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editIncomeForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editAmount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="editAmount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="editIncomeSource" class="form-label">Income Source</label>
                        <select class="form-select" id="editIncomeSource" name="income_source" required>
                            @foreach($incomeSources as $source)
                                <option value="{{ $source }}">{{ $source }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editIncomeType" class="form-label">Income Type</label>
                        <select class="form-select" id="editIncomeType" name="income_type" required>
                            @foreach($incomeTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editPaymentMethod" class="form-label">Payment Method</label>
                        <select class="form-select" id="editPaymentMethod" name="payment_method_id" required>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editBankName" class="form-label">Bank Name</label>
                        <input type="text" class="form-control" id="editBankName" name="bank_name">
                    </div>
                    <div class="mb-3">
                        <label for="editTransactionId" class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" id="editTransactionId" name="transaction_id">
                    </div>
                    <div class="mb-3">
                        <label for="editDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="editDetails" name="details" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editDate" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCustomer" class="form-label">Customer</label>
                        <select class="form-select" id="editCustomer" name="customer_id">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editOrder" class="form-label">Order</label>
                        <select class="form-select" id="editOrder" name="order_id">
                            <option value="">Select Order</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}">{{ $order->reference }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">New Image (optional)</label>
                        <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Income</button>
                    </div>
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
                <h5 class="modal-title" id="imageModalLabel">Income Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="/placeholder.svg" id="modalImage" alt="Income Image">
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openImageModal(imageSrc, imageAlt) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
        modalImage.alt = imageAlt;
        const imageModalLabel = document.getElementById('imageModalLabel');
        imageModalLabel.textContent = imageAlt;
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }

    function editIncome(id) {
        // Fetch income data and populate the form
        fetch(`/incomes/${id}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Income data:', data); // Debug log

                // Set form action
                document.getElementById('editIncomeForm').action = `/incomes/${id}`;

                // Set basic fields
                document.getElementById('editAmount').value = data.amount;
                document.getElementById('editIncomeSource').value = data.income_source;
                document.getElementById('editIncomeType').value = data.income_type;
                document.getElementById('editPaymentMethod').value = data.payment_method_id;
                document.getElementById('editBankName').value = data.bank_name || '';
                document.getElementById('editTransactionId').value = data.transaction_id || '';
                document.getElementById('editDetails').value = data.details || '';

                // Format the date to YYYY-MM-DD for the date input
                const dateObj = new Date(data.date);
                const year = dateObj.getFullYear();
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dateObj.getDate()).padStart(2, '0');
                document.getElementById('editDate').value = `${year}-${month}-${day}`;

                // Set relationship fields
                document.getElementById('editCustomer').value = data.customer_id || '';
                document.getElementById('editOrder').value = data.order_id || '';

                // Show the modal
                const editModal = new bootstrap.Modal(document.getElementById('editIncomeModal'));
                editModal.show();
            })
            .catch(error => {
                console.error('Error fetching income data:', error);
                alert('Error loading income data. Please try again.');
            });
    }
</script>
@endsection

