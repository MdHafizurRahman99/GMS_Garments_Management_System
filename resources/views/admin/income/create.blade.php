@extends('layouts.admin.master')
@section('title', 'Add Income')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .income-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        .income-grid th {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .income-grid th, .income-grid td {
            border: 1px solid #dee2e6;
            padding: 0.5rem;
        }
        .income-grid input, .income-grid select {
            width: 100%;
            padding: 0.375rem;
            border: none;
            background: transparent;
        }
        .income-grid input:focus, .income-grid select:focus {
            outline: 2px solid #0d6efd;
            border-radius: 2px;
        }
        .income-grid tr:hover {
            background-color: #f8f9fa;
        }
        .file-preview {
            max-width: 50px;
            max-height: 50px;
            margin-right: 5px;
        }
        .image-preview-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        @media (max-width: 768px) {
            .income-grid {
                font-size: 0.875rem;
            }
            .income-grid th, .income-grid td {
                padding: 0.25rem;
                min-width: 100px;
            }
            .btn-group {
                flex-direction: column;
                align-items: stretch;
            }
            .btn-group .btn {
                margin-bottom: 0.5rem;
            }
            .bank-fields {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="mb-3 mb-md-0">Add Income</h1>
        <div class="btn-group">
            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary me-2 mb-2 mb-md-0">Back to Transactions</a>
            <button type="button" class="btn btn-secondary me-2 mb-2 mb-md-0" onclick="addRow()">Add Row</button>
            <button type="submit" form="incomeForm" class="btn btn-primary">Submit Income</button>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="incomeForm" action="{{ route('incomes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="table-responsive">
            <table class="income-grid">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount ($)</th>
                        <th>Source</th>
                        <th>Type</th>
                        <th>Payment Method</th>
                        <th class="bank-fields">Bank Name</th>
                        <th class="bank-fields">Transaction ID</th>
                        <th>Customer</th>
                        <th>Order</th>
                        <th>Details</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="incomeTableBody">
                    <tr class="income-row">
                        <td>
                            <input type="date" name="incomes[0][date]" required class="form-control-plain"
                                value="{{ date('Y-m-d') }}">
                        </td>
                        <td>
                            <input type="number" name="incomes[0][amount]" step="0.01" required
                                class="form-control-plain">
                        </td>
                        <td>
                            <select name="incomes[0][income_source]" required class="form-select-plain">
                                @foreach($incomeSources as $source)
                                    <option value="{{ $source }}">{{ $source }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="incomes[0][income_type]" required class="form-select-plain">
                                @foreach($incomeTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="incomes[0][payment_method_id]" required class="form-select-plain"
                                    onchange="toggleBankFields(this)">
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}"
                                            data-type="{{ $method->type }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="bank-fields">
                            <input type="text" name="incomes[0][bank_name]" class="form-control-plain">
                        </td>
                        <td class="bank-fields">
                            <input type="text" name="incomes[0][transaction_id]" class="form-control-plain">
                        </td>
                        <td>
                            <select name="incomes[0][customer_id]" class="form-select-plain">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="incomes[0][order_id]" class="form-select-plain">
                                <option value="">Select Order</option>
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}">{{ $order->reference }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="incomes[0][details]" class="form-control-plain">
                        </td>
                        <td>
                            <div class="image-preview-container">
                                <img class="file-preview" style="display: none;">
                                <input type="file" name="incomes[0][image]" accept="image/*"
                                    class="form-control-plain" onchange="previewImage(this)">
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="removeRow(this)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>
@endsection

@section('js')
<script>
    let rowCount = 1;

    function addRow() {
        const tbody = document.getElementById('incomeTableBody');
        const newRow = document.createElement('tr');
        newRow.className = 'income-row';
        newRow.innerHTML = `
            <td>
                <input type="date" name="incomes[${rowCount}][date]" required class="form-control-plain"
                    value="${new Date().toISOString().split('T')[0]}">
            </td>
            <td>
                <input type="number" name="incomes[${rowCount}][amount]" step="0.01" required class="form-control-plain">
            </td>
            <td>
                <select name="incomes[${rowCount}][income_source]" required class="form-select-plain">
                    ${Array.from(document.querySelector('select[name="incomes[0][income_source]"]').options)
                        .map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('')}
                </select>
            </td>
            <td>
                <select name="incomes[${rowCount}][income_type]" required class="form-select-plain">
                    ${Array.from(document.querySelector('select[name="incomes[0][income_type]"]').options)
                        .map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('')}
                </select>
            </td>
            <td>
                <select name="incomes[${rowCount}][payment_method_id]" required class="form-select-plain"
                        onchange="toggleBankFields(this)">
                    ${Array.from(document.querySelector('select[name="incomes[0][payment_method_id]"]').options)
                        .map(opt => `<option value="${opt.value}" data-type="${opt.dataset.type}">${opt.text}</option>`).join('')}
                </select>
            </td>
            <td class="bank-fields">
                <input type="text" name="incomes[${rowCount}][bank_name]" class="form-control-plain">
            </td>
            <td class="bank-fields">
                <input type="text" name="incomes[${rowCount}][transaction_id]" class="form-control-plain">
            </td>
            <td>
                <select name="incomes[${rowCount}][customer_id]" class="form-select-plain">
                    ${Array.from(document.querySelector('select[name="incomes[0][customer_id]"]').options)
                        .map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('')}
                </select>
            </td>
            <td>
                <select name="incomes[${rowCount}][order_id]" class="form-select-plain">
                    ${Array.from(document.querySelector('select[name="incomes[0][order_id]"]').options)
                        .map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('')}
                </select>
            </td>
            <td>
                <input type="text" name="incomes[${rowCount}][details]" class="form-control-plain">
            </td>
            <td>
                <div class="image-preview-container">
                    <img class="file-preview" style="display: none;">
                    <input type="file" name="incomes[${rowCount}][image]" accept="image/*"
                        class="form-control-plain" onchange="previewImage(this)">
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Delete</button>
            </td>
        `;
        tbody.appendChild(newRow);
        rowCount++;
    }

    function removeRow(button) {
        if (document.getElementsByClassName('income-row').length > 1) {
            button.closest('tr').remove();
        }
    }

    function toggleBankFields(select) {
        const row = select.closest('tr');
        const bankFields = row.querySelectorAll('.bank-fields input');
        const selectedOption = select.options[select.selectedIndex];
        const isBank = selectedOption.dataset.type === 'bank';

        bankFields.forEach(field => {
            field.style.display = isBank ? 'block' : 'none';
            field.required = isBank;
        });
    }

    function previewImage(input) {
        const preview = input.closest('.image-preview-container').querySelector('.file-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }

    // Handle keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') {
            const currentCell = e.target.closest('td');
            const currentRow = currentCell.parentElement;
            const cells = Array.from(currentRow.cells);
            const currentIndex = cells.indexOf(currentCell);

            if (e.key === 'Enter' || e.key === 'ArrowDown') {
                e.preventDefault();
                const nextRow = currentRow.nextElementSibling;
                if (nextRow) {
                    const nextInput = nextRow.cells[currentIndex].querySelector('input, select');
                    if (nextInput) nextInput.focus();
                } else {
                    addRow();
                    const newRow = document.querySelector('.income-row:last-child');
                    const newInput = newRow.cells[currentIndex].querySelector('input, select');
                    if (newInput) newInput.focus();
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prevRow = currentRow.previousElementSibling;
                if (prevRow) {
                    const prevInput = prevRow.cells[currentIndex].querySelector('input, select');
                    if (prevInput) prevInput.focus();
                }
            }
        }
    });

    // Initialize bank fields visibility
    document.querySelectorAll('select[name$="[payment_method_id]"]').forEach(toggleBankFields);
</script>
@endsection

