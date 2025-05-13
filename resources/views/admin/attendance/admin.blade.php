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

        .overtime-badge {
            display: inline-block;
            padding: 0.25em 0.6em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            margin-left: 5px;
        }

        .overtime-pending {
            background-color: #f6c23e;
            color: #fff;
        }

        .overtime-approved {
            background-color: #1cc88a;
            color: #fff;
        }

        .overtime-rejected {
            background-color: #e74a3b;
            color: #fff;
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

                        <div class="filter-group">
                            <label for="overtime_filter">Overtime Status:</label>
                            <select id="overtime_filter" name="overtime_filter" class="form-control">
                                <option value="">All Records</option>
                                <option value="all_overtime" {{ $overtimeFilter == 'all_overtime' ? 'selected' : '' }}>All Overtime</option>
                                <option value="pending" {{ $overtimeFilter == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                                <option value="approved" {{ $overtimeFilter == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $overtimeFilter == 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                                    <th>Shift</th>
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
                                        <td>
                                            @if ($record->schedule)
                                                {{ $record->schedule->shift->shift_name }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('H:i:s A') : 'N/A' }}</td>
                                        <td>
                                            {{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('H:i:s A') : 'N/A' }}
                                            @if ($record->is_overtime)
                                                <span class="overtime-badge overtime-{{ $record->overtime_status }}">
                                                    {{ ucfirst($record->overtime_status) }}
                                                </span>
                                            @endif
                                        </td>
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
                                                    data-schedule="{{ $record->schedule_id }}"
                                                    data-date="{{ $record->date }}"
                                                    data-checkin="{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('H:i') : '' }}"
                                                    data-checkout="{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('H:i') : '' }}"
                                                    data-status="{{ $record->status }}"
                                                    data-overtime="{{ $record->is_overtime ? '1' : '0' }}"
                                                    data-overtime-status="{{ $record->overtime_status }}"
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

                                                @if ($record->is_overtime && $record->overtime_status == 'pending')
                                                    <button type="button" class="btn btn-sm btn-success approve-overtime"
                                                        data-id="{{ $record->id }}"
                                                        data-toggle="modal" data-target="#overtimeModal">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No attendance records found</td>
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
                            <label for="schedule_id">Schedule:</label>
                            <select id="schedule_id" name="schedule_id" class="form-control" required>
                                <option value="">Select Schedule</option>
                                <!-- This will be populated via AJAX when staff is selected -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="date" id="date" name="date" class="form-control" value="{{ \Carbon\Carbon::today('Asia/Dhaka')->format('Y-m-d') }}" required>
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
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_overtime" name="is_overtime" value="1">
                                <label class="custom-control-label" for="is_overtime">Is Overtime</label>
                            </div>
                        </div>

                        <div class="form-group overtime-status-group" style="display: none;">
                            <label for="overtime_status">Overtime Status:</label>
                            <select id="overtime_status" name="overtime_status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
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
                            <label for="edit_schedule_id">Schedule:</label>
                            <select id="edit_schedule_id" name="schedule_id" class="form-control" required>
                                <!-- This will be populated via AJAX when staff is selected -->
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
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="edit_is_overtime" name="is_overtime" value="1">
                                <label class="custom-control-label" for="edit_is_overtime">Is Overtime</label>
                            </div>
                        </div>

                        <div class="form-group edit-overtime-status-group" style="display: none;">
                            <label for="edit_overtime_status">Overtime Status:</label>
                            <select id="edit_overtime_status" name="overtime_status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
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

    <!-- Overtime Approval Modal -->
    <div class="modal fade" id="overtimeModal" tabindex="-1" role="dialog" aria-labelledby="overtimeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="overtimeModalLabel">Overtime Approval</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('attendance.update-overtime' , $record->id ) }}" method="POST" id="overtimeForm">
                    @csrf
                    <input type="hidden" id="overtime_id" name="id" value="{{$record->id}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="overtime_status">Overtime Status:</label>
                            <select id="overtime_status" name="overtime_status" class="form-control" required>
                                <option value="approved">Approve</option>
                                <option value="rejected">Reject</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="overtime_notes">Notes:</label>
                            <textarea id="overtime_notes" name="notes" class="form-control" rows="3" placeholder="Add any comments about this overtime approval/rejection"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Toggle overtime status field based on checkbox
            $('#is_overtime').change(function() {
                if($(this).is(':checked')) {
                    $('.overtime-status-group').show();
                } else {
                    $('.overtime-status-group').hide();
                }
            });

            $('#edit_is_overtime').change(function() {
                if($(this).is(':checked')) {
                    $('.edit-overtime-status-group').show();
                } else {
                    $('.edit-overtime-status-group').hide();
                }
            });

            // Populate edit modal with record data
            $('.edit-record').click(function() {
                const id = $(this).data('id');
                const staffId = $(this).data('staff');
                const scheduleId = $(this).data('schedule');
                const date = $(this).data('date');
                const checkIn = $(this).data('checkin');
                const checkOut = $(this).data('checkout');
                const status = $(this).data('status');
                const isOvertime = $(this).data('overtime') == '1';
                const overtimeStatus = $(this).data('overtime-status');
                const notes = $(this).data('notes');

                $('#edit_id').val(id);
                $('#edit_staff_id').val(staffId);
                $('#edit_date').val(date);
                $('#edit_check_in').val(checkIn);
                $('#edit_check_out').val(checkOut);
                $('#edit_status').val(status);
                $('#edit_is_overtime').prop('checked', isOvertime);
                $('#edit_overtime_status').val(overtimeStatus);
                $('#edit_notes').val(notes);

                // Show/hide overtime status field
                if(isOvertime) {
                    $('.edit-overtime-status-group').show();
                } else {
                    $('.edit-overtime-status-group').hide();
                }

                // Load schedules for this staff
                loadSchedulesForStaff(staffId, scheduleId);
            });

            // Load schedules when staff is selected in add form
            $('#staff_id').change(function() {
                const staffId = $(this).val();
                if(staffId) {
                    loadSchedulesForStaff(staffId);
                } else {
                    $('#schedule_id').html('<option value="">Select Schedule</option>');
                }
            });

            // Load schedules when staff is selected in edit form
            $('#edit_staff_id').change(function() {
                const staffId = $(this).val();
                if(staffId) {
                    loadSchedulesForStaff(staffId, null, 'edit_schedule_id');
                } else {
                    $('#edit_schedule_id').html('<option value="">Select Schedule</option>');
                }
            });

            // Set overtime ID in approval modal
            $('.approve-overtime').click(function() {
                const id = $(this).data('id');
                $('#overtime_id').val(id);
            });

            // Function to load schedules for a staff member
            function loadSchedulesForStaff(staffId, selectedScheduleId = null, targetElement = 'schedule_id') {
                $.ajax({
                    url: '/api/staff-schedules',
                    method: 'GET',
                    data: { staff_id: staffId },
                    success: function(response) {
                        let options = '<option value="">Select Schedule</option>';

                        if(response.schedules && response.schedules.length > 0) {
                            response.schedules.forEach(function(schedule) {
                                const selected = selectedScheduleId && schedule.id == selectedScheduleId ? 'selected' : '';
                                options += `<option value="${schedule.id}" ${selected}>${schedule.shift.shift_name} (${schedule.shift.start_time} - ${schedule.shift.end_time})</option>`;
                            });
                        }

                        $(`#${targetElement}`).html(options);
                    },
                    error: function(error) {
                        console.error('Error loading schedules:', error);
                    }
                });
            }
        });
    </script>
@endsection
