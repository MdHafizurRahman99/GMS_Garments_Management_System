@extends('layouts.admin.master')

@section('css')
    <style>
        .badge {
            font-size: 0.875em;
            padding: 0.35em 0.65em;
            text-transform: uppercase;
        }

        .table> :not(caption)>*>* {
            padding: 0.75rem;
        }

        .btn-group {
            display: flex;
            gap: 0.25rem;
        }

        @media (max-width: 991.98px) {
            .col-lg-4 {
                margin-top: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Leave Requests List -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title h5 mb-0">Leave Requests</h2>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        {{-- <th>Reason</th>
                                    <th>Document</th> --}}
                                        @if (auth()->user()->can('leaves.edit'))
                                            <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leaves as $leave)
                                        <tr>
                                            <td>{{ $leave->leave_type }}</td>
                                            <td>{{ $leave->start_date->format('d-m-Y') }}</td>
                                            <td>{{ $leave->end_date->format('d-m-Y') }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $leave->status === 'pending' ? 'warning' : ($leave->status === 'approved' ? 'success' : 'danger') }}">
                                                    {{ strtoupper($leave->status) }}
                                                </span>
                                            </td>
                                            {{-- <td>{{ $leave->reason }}</td>
                                        <td>
                                            @if ($leave->document_path)
                                                <a href="{{ Storage::url($leave->document_path) }}" target="_blank" class="btn btn-sm btn-link">View Document</a>
                                            @else
                                                No document
                                            @endif
                                        </td> --}}
                                            <td>
                                                @if ($leave->status === 'pending' && auth()->user()->can('leaves.edit'))
                                                    <div class="btn-group">
                                                        <form action="{{ route('leaves.update-status', $leave) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success">Approve</button>
                                                        </form>
                                                        <form action="{{ route('leaves.update-status', $leave) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger">Reject</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $leaves->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Request Leave Form -->
            <!-- Request Leave Form -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title h5 mb-0">Request Leave</h2>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fix the following:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button> --}}
                            </div>
                        @endif

                        <form action="{{ route('leaves.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="leave_type" class="form-label">Leave Type</label>
                                <select class="form-select @error('leave_type') is-invalid @enderror" id="leave_type"
                                    name="leave_type">
                                    <option value="">Select Leave Type</option>
                                    @foreach ($leaveTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ old('leave_type') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('leave_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date') }}"
                                    min="{{ date('Y-m-d') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="end_date" name="end_date" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3"
                                    placeholder="Please provide a detailed reason for your leave request">{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">Minimum 10 characters required</div>
                            </div>

                            <div class="mb-3">
                                <label for="document" class="form-label">Supporting Document</label>
                                <input type="file" class="form-control @error('document') is-invalid @enderror"
                                    id="document" name="document">
                                @error('document')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 10MB)
                                </div>
                            </div> --}}

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Submit Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




        </div>
    </div>

    {{-- @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Set minimum date for end_date based on start_date
                const startDate = document.getElementById('start_date');
                const endDate = document.getElementById('end_date');

                startDate.addEventListener('change', function() {
                    endDate.min = this.value;
                    if (endDate.value && endDate.value < this.value) {
                        endDate.value = this.value;
                    }
                });
            });
        </script>
    @endpush --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Set minimum date for end_date based on start_date
                const startDate = document.getElementById('start_date');
                const endDate = document.getElementById('end_date');

                startDate.addEventListener('change', function() {
                    endDate.min = this.value;
                    if (endDate.value && endDate.value < this.value) {
                        endDate.value = this.value;
                    }
                });

                // Reset file input if there was an error
                // const fileInput = document.getElementById('document');
                // fileInput.addEventListener('click', function() {
                //     this.value = '';
                // });
            });
        </script>
    @endpush
@endsection
