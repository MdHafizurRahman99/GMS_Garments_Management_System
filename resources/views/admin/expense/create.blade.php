@extends('layouts.admin.master')
@section('title', 'Add Expenses')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .expense-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .expense-grid th {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .expense-grid th,
        .expense-grid td {
            border: 1px solid #dee2e6;
            padding: 0.5rem;
        }

        .expense-grid input,
        .expense-grid select {
            width: 100%;
            padding: 0.375rem;
            border: none;
            background: transparent;
        }

        .expense-grid input:focus,
        .expense-grid select:focus {
            outline: 2px solid #0d6efd;
            border-radius: 2px;
        }

        .expense-grid tr:hover {
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

        .expense-grid th:first-child,
        .expense-grid td:first-child {
            width: 120px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Add Expenses</h1>
            <div>
                <a href="{{ route('costs.index') }}" class="btn btn-outline-secondary me-2">Back to List</a>
                <button type="button" class="btn btn-secondary me-2" onclick="addRow()">Add Row</button>
                <button type="submit" form="expenseForm" class="btn btn-primary">Submit Expenses</button>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form id="expenseForm" action="{{ route('costs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="table-responsive">
                <table class="expense-grid">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount ($)</th>
                            <th>Type</th>
                            <th>Other Type</th>
                            <th>Details</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="expenseTableBody">
                        <tr class="expense-row">
                            <td>
                                <input type="date" name="expenses[0][date]" required class="form-control-plain"
                                    value="{{ date('Y-m-d') }}">
                            </td>
                            <td>
                                <input type="number" name="expenses[0][amount]" step="0.01" required
                                    class="form-control-plain">
                            </td>
                            <td>
                                <select name="expenses[0][expense_type]" required class="form-select-plain"
                                    onchange="toggleOtherType(this)">
                                    @foreach ($expenseTypes as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="expenses[0][other_type]" class="form-control-plain other-type"
                                    style="display: none;">
                            </td>
                            <td>
                                <input type="text" name="expenses[0][details]" required class="form-control-plain">
                            </td>
                            <td>
                                <div class="image-preview-container">
                                    <img class="file-preview" style="display: none;">
                                    <input type="file" name="expenses[0][image]" accept="image/*"
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
            const tbody = document.getElementById('expenseTableBody');
            const newRow = document.createElement('tr');
            newRow.className = 'expense-row';
            newRow.innerHTML = `
            <td>
                <input type="date" name="expenses[${rowCount}][date]" required class="form-control-plain" value="${new Date().toISOString().split('T')[0]}">
            </td>
            <td>
                <input type="number" name="expenses[${rowCount}][amount]" step="0.01" required class="form-control-plain">
            </td>
            <td>
                <select name="expenses[${rowCount}][expense_type]" required class="form-select-plain" onchange="toggleOtherType(this)">
                    ${Array.from(document.querySelector('select[name="expenses[0][expense_type]"]').options)
                        .map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('')}
                </select>
            </td>
            <td>
                <input type="text" name="expenses[${rowCount}][other_type]" class="form-control-plain other-type" style="display: none;">
            </td>
            <td>
                <input type="text" name="expenses[${rowCount}][details]" required class="form-control-plain">
            </td>
            <td>
                <div class="image-preview-container">
                    <img class="file-preview" style="display: none;">
                    <input type="file" name="expenses[${rowCount}][image]" accept="image/*" class="form-control-plain" onchange="previewImage(this)">
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
            if (document.getElementsByClassName('expense-row').length > 1) {
                button.closest('tr').remove();
            }
        }

        function toggleOtherType(select) {
            const otherTypeInput = select.closest('tr').querySelector('.other-type');
            otherTypeInput.style.display = select.value === 'Other' ? 'block' : 'none';
            otherTypeInput.required = select.value === 'Other';
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
                        const newRow = document.querySelector('.expense-row:last-child');
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
    </script>
@endsection
