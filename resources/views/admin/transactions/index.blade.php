@extends('layouts.admin.master')
@section('title', 'Transactions')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .transaction-positive {
            color: #198754;
        }
        .transaction-negative {
            color: #dc3545;
        }
        .summary-card {
            transition: transform 0.2s;
        }
        .summary-card:hover {
            transform: translateY(-5px);
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
        @media (max-width: 768px) {
            .filter-form .col-auto {
                width: 100%;
                margin-bottom: 10px;
            }
            .filter-form select, .filter-form button {
                width: 100%;
            }
            .summary-cards {
                margin-bottom: 1rem;
            }
            .summary-card {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="mb-3 mb-md-0">Transactions</h1>
        <div class="btn-group">
            <a href="{{ route('costs.create') }}" class="btn btn-dark me-2 mb-2 mb-md-0">
                <span class="me-2">+</span> Add Expense
            </a>
            <a href="{{ route('incomes.create') }}" class="btn btn-success mb-2 mb-md-0">
                <span class="me-2">+</span> Add Income
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row summary-cards mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card summary-card bg-light">
                <div class="card-body">
                    <h6 class="card-title text-muted">Cash in Hand</h6>
                    <h3 class="mb-0 {{ $cashInHand >= 0 ? 'transaction-positive' : 'transaction-negative' }}">
                        ${{ number_format($cashInHand, 2) }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card summary-card bg-light">
                <div class="card-body">
                    <h6 class="card-title text-muted">Cash in Bank</h6>
                    <h3 class="mb-0 {{ $cashInBank >= 0 ? 'transaction-positive' : 'transaction-negative' }}">
                        ${{ number_format($cashInBank, 2) }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card summary-card bg-light">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Income</h6>
                    <h3 class="mb-0 transaction-positive">${{ number_format($totalIncome, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card summary-card bg-light">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Expense</h6>
                    <h3 class="mb-0 transaction-negative">${{ number_format($totalExpense, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('transactions.index') }}" method="GET" class="filter-form mb-4">
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
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Transactions Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Details</th>
                            <th>Image</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ date('Y-m-d', strtotime($transaction->date)) }}</td>
                                <td>
                                    <span class="badge {{ $transaction->type === 'income' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->category }}</td>
                                <td class="{{ $transaction->type === 'income' ? 'transaction-positive' : 'transaction-negative' }}">
                                    ${{ number_format($transaction->amount, 2) }}
                                </td>
                                <td>{{ $transaction->details }}</td>
                                <td>
                                    @if($transaction->image_path)
                                        <img src="{{ asset($transaction->image_path) }}"
                                             alt="Transaction Image"
                                             class="expense-image-preview"
                                             onclick="openImageModal('{{ asset($transaction->image_path) }}', '{{ $transaction->details }}')">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                {{-- <td>
                                    <button class="btn btn-sm btn-primary"
                                            onclick="editTransaction('{{ $transaction->type }}', {{ $transaction->id }})"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editTransactionModal">
                                        Edit
                                    </button>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        {{ $transactions->links() }}
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Transaction Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="/placeholder.svg" id="modalImage" alt="Transaction Image">
            </div>
        </div>
    </div>
</div>

<!-- Edit Transaction Modal -->
<div class="modal fade" id="editTransactionModal" tabindex="-1" aria-labelledby="editTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTransactionModalLabel">Edit Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTransactionForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editAmount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="editAmount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <input type="text" class="form-control" id="editCategory" name="category" required>
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
                        <label for="editDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="editDetails" name="details" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editDate" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">New Image (optional)</label>
                        <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Transaction</button>
                </form>
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

    function editTransaction(type, id) {
        // Use the correct route for editing
        const url = type === 'income' ? `/incomes/${id}/edit` : `/costs/${id}/edit`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('editTransactionForm').action = type === 'income' ? `/incomes/${id}` : `/costs/${id}`;
                document.getElementById('editAmount').value = data.amount;

                // Set the correct category field based on transaction type
                if (type === 'income') {
                    document.getElementById('editCategory').value = data.income_type ? data.income_type.name : data.income_type_id;
                } else {
                    document.getElementById('editCategory').value = data.expense_type ? data.expense_type.name : data.expense_type_id;
                }

                document.getElementById('editPaymentMethod').value = data.payment_method_id;
                document.getElementById('editDetails').value = data.details || '';

                // Format the date to YYYY-MM-DD for the date input
                const dateObj = new Date(data.date);
                const year = dateObj.getFullYear();
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dateObj.getDate()).padStart(2, '0');
                document.getElementById('editDate').value = `${year}-${month}-${day}`;

                // Show the modal
                new bootstrap.Modal(document.getElementById('editTransactionModal')).show();
            })
            .catch(error => {
                console.error('Error fetching transaction data:', error);
                alert('Error loading transaction data. Please try again.');
            });
    }
</script>
@endsection

