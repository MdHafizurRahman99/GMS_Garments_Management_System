@extends('layouts.admin.master')

@section('title')
    Attendance Management
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <style>
        .filter-container {
            background-color: #f8f9fc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .modal-header {
            background-color: #4e73df;
            color: white;
        }

        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Attendance Management</h1>

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filter Section -->
            <div class="filter-container">
                <form action="{{ route('attendance.admin') }}" method="GET">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="filter_date">Date:</label>
                            <input type="date" id="filter_date" name="filter_date" class="form-control" value="{{ $filterDate }}">
                        </div>

                        <div class="filter-group">
                            <label for="staff_id">Staff:</label>
                            <select id="staff_id" name="staff_id" class="form-control">
                                <option value="">All Staff</option>
                                @foreach ($allStaff as $staff)
                                    <option value="{{ $staff->id }}" {{ $selectedStaffId == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->first_name . ' ' . $staff->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group" style="flex: 0 0 auto;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter"></i> Filter
                            </button>

                            <a href="{{ route('attendance.admin') }}" class="btn btn-secondary">
                                <i class="fa fa-refresh"></i> Reset
                            </a>

                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAttendanceModal">
                                <i class="fa fa-plus"></i> Add Record
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Attendance Records Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Attendance Records</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Date</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendanceRecords as $record)
                                    <tr>
                                        <td>{{ $record->staff->first_name . ' ' . $record->staff->last_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($record->date)->format('Y-m-d') }}</td>
                                        <td>{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('H:i:s A') : 'N/A' }}</td>
                                        <td>{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('H:i:s A') : 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $record->status == 'present' ? 'success' : ($record->status == 'late' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($record->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $record->notes ?? 'N/A' }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button type="button" class="btn btn-sm btn-primary edit-record"
                                                    data-id="{{ $record->id }}"
                                                    data-staff="{{ $record->staff_id }}"
                                                    data-date="{{ $record->date }}"
                                                    data-checkin="{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('H:i') : '' }}"
                                                    data-checkout="{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('H:i') : '' }}"
                                                    data-status="{{ $record->status }}"
                                                    data-notes="{{ $record->notes }}"
                                                    data-toggle="modal" data-target="#editAttendanceModal">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <form action="{{ route('attendance.destroy', $record->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No attendance records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            Showing {{ $attendanceRecords->firstItem() ?? 0 }} to {{ $attendanceRecords->lastItem() ?? 0 }} of {{ $attendanceRecords->total() }} entries
                        </div>
                        <div>
                            {{ $attendanceRecords->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Attendance Modal -->
    <div class="modal fade" id="addAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="addAttendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAttendanceModalLabel">Add Attendance Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="staff_id">Staff:</label>
                            <select id="staff_id" name="staff_id" class="form-control" required>
                                <option value="">Select Staff</option>
                                @foreach ($allStaff as $staff)
                                    <option value="{{ $staff->id }}">
                                        {{ $staff->first_name . ' ' . $staff->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="date" id="date" name="date" class="form-control" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="check_in">Check In Time:</label>
                            <input type="time" id="check_in" name="check_in" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="check_out">Check Out Time:</label>
                            <input type="time" id="check_out" name="check_out" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="present">Present</option>
                                <option value="late">Late</option>
                                <option value="absent">Absent</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes:</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Attendance Modal -->
    <div class="modal fade" id="editAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="editAttendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAttendanceModalLabel">Edit Attendance Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('attendance.store') }}" method="POST" id="editAttendanceForm">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_staff_id">Staff:</label>
                            <select id="edit_staff_id" name="staff_id" class="form-control" required>
                                @foreach ($allStaff as $staff)
                                    <option value="{{ $staff->id }}">
                                        {{ $staff->first_name . ' ' . $staff->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_date">Date:</label>
                            <input type="date" id="edit_date" name="date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_check_in">Check In Time:</label>
                            <input type="time" id="edit_check_in" name="check_in" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="edit_check_out">Check Out Time:</label>
                            <input type="time" id="edit_check_out" name="check_out" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="edit_status">Status:</label>
                            <select id="edit_status" name="status" class="form-control" required>
                                <option value="present">Present</option>
                                <option value="late">Late</option>
                                <option value="absent">Absent</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_notes">Notes:</label>
                            <textarea id="edit_notes" name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Populate edit modal with record data
            $('.edit-record').click(function() {
                const id = $(this).data('id');
                const staffId = $(this).data('staff');
                const date = $(this).data('date');
                const checkIn = $(this).data('checkin');
                const checkOut = $(this).data('checkout');
                const status = $(this).data('status');
                const notes = $(this).data('notes');

                $('#edit_id').val(id);
                $('#edit_staff_id').val(staffId);
                $('#edit_date').val(date);
                $('#edit_check_in').val(checkIn);
                $('#edit_check_out').val(checkOut);
                $('#edit_status').val(status);
                $('#edit_notes').val(notes);
            });
        });
    </script>
@endsection
