@extends('layouts.admin.master')

@section('title')
    Attendance Dashboard
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <style>
        .attendance-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .attendance-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .attendance-history {
            flex: 1;
            min-width: 300px;
        }

        .attendance-sidebar {
            flex: 0 0 350px;
        }

        .current-time {
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .current-date {
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .attendance-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .attendance-buttons button {
            flex: 1;
            margin: 0 10px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .attendance-summary {
            margin-top: 20px;
        }

        .summary-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .summary-icon {
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .filter-container {
            margin-bottom: 20px;
        }

        .schedule-item {
            border: 1px solid #e3e6f0;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .schedule-item:hover {
            background-color: #f8f9fc;
        }

        .schedule-item.selected {
            background-color: #4e73df;
            color: white;
            border-color: #4e73df;
        }

        .schedule-time {
            font-weight: bold;
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

        .today-attendance-list {
            margin-top: 15px;
        }

        .today-attendance-item {
            padding: 10px;
            border: 1px solid #e3e6f0;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f8f9fc;
        }

        .today-attendance-item.incomplete {
            border-left: 4px solid #f6c23e;
        }

        .today-attendance-item.complete {
            border-left: 4px solid #1cc88a;
        }

        @media (max-width: 768px) {
            .attendance-container {
                flex-direction: column;
            }

            .attendance-sidebar {
                flex: 1;
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Attendance Dashboard</h1>

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

            <div class="attendance-container">
                <!-- Attendance History Section -->
                <div class="attendance-history attendance-card">
                    <h2>Attendance History</h2>

                    <div class="filter-container">
                        <form action="{{ route('attendance.index') }}" method="GET">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Filter by Date:</span>
                                </div>
                                <input type="date" name="filter_date" class="form-control" value="{{ $filterDate }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Shift</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendanceHistory as $record)
                                    <tr>
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No attendance records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-container">
                        <div>
                            @if ($attendanceHistory->currentPage() > 1)
                                <a href="{{ $attendanceHistory->previousPageUrl() }}" class="btn btn-secondary">
                                    <i class="fa fa-chevron-left"></i> Previous
                                </a>
                            @else
                                <button class="btn btn-secondary" disabled>
                                    <i class="fa fa-chevron-left"></i> Previous
                                </button>
                            @endif
                        </div>

                        <div>
                            Page {{ $attendanceHistory->currentPage() }} of {{ $attendanceHistory->lastPage() }}
                        </div>

                        <div>
                            @if ($attendanceHistory->hasMorePages())
                                <a href="{{ $attendanceHistory->nextPageUrl() }}" class="btn btn-secondary">
                                    Next <i class="fa fa-chevron-right"></i>
                                </a>
                            @else
                                <button class="btn btn-secondary" disabled>
                                    Next <i class="fa fa-chevron-right"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Section -->
                <div class="attendance-sidebar">
                    <!-- Today's Attendance Card -->
                    <div class="attendance-card">
                        <h2>Today's Attendance</h2>

                        <div class="current-time" id="current-time">
                            {{ \Carbon\Carbon::now('Asia/Dhaka')->format('H:i:s') }}
                        </div>

                        <div class="current-date">
                            {{ \Carbon\Carbon::now('Asia/Dhaka')->format('l, F jS, Y') }}
                        </div>

                        <!-- Today's attendance records -->
                        @if($todayAttendances->count() > 0)
                            <h5>Today's Records:</h5>
                            <div class="today-attendance-list">
                                @foreach($todayAttendances as $record)
                                    <div class="today-attendance-item {{ $record->check_out ? 'complete' : 'incomplete' }}">
                                        <div><strong>Shift:</strong> {{ $record->schedule->shift->shift_name }}</div>
                                        <div><strong>Check In:</strong> {{ \Carbon\Carbon::parse($record->check_in)->format('h:i A') }}</div>
                                        <div><strong>Check Out:</strong> {{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('h:i A') : 'Not checked out' }}</div>
                                        <div>
                                            <strong>Status:</strong>
                                            <span class="badge badge-{{ $record->status == 'present' ? 'success' : ($record->status == 'late' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($record->status) }}
                                            </span>
                                            @if ($record->is_overtime)
                                                <span class="overtime-badge overtime-{{ $record->overtime_status }}">
                                                    Overtime: {{ ucfirst($record->overtime_status) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($incompleteAttendance)
                            <!-- Already checked in, show check-out button -->
                            <div class="alert alert-info mt-3">
                                <p>You have an incomplete check-out for shift {{ $incompleteAttendance->schedule->shift->shift_name }}</p>
                            </div>

                            <form action="{{ route('attendance.check-out') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark btn-block">
                                    <i class="fa fa-clock-o"></i> Check Out
                                </button>
                            </form>
                        @else
                            <!-- Not checked in or all check-ins are complete, show schedule selection and check-in button -->
                            <form action="{{ route('attendance.check-in') }}" method="POST" class="mt-3">
                                @csrf
                                <div class="form-group">
                                    <label for="schedule_id">Select Schedule for Check-In:</label>

                                    @if ($availableSchedules->count() > 0)
                                        <div class="schedule-selection">
                                            @foreach ($availableSchedules as $schedule)
                                                <div class="schedule-item" onclick="selectSchedule(this, {{ $schedule->id }})">
                                                    <div class="schedule-time">{{ $schedule->shift->shift_name }}</div>
                                                    <div class="schedule-details">
                                                        {{ \Carbon\Carbon::parse($schedule->shift->start_time)->format('h:i A') }} -
                                                        {{ \Carbon\Carbon::parse($schedule->shift->end_time)->format('h:i A') }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="schedule_id" id="selected_schedule_id" required>

                                        <button type="submit" class="btn btn-dark btn-block mt-3" id="check_in_btn" disabled>
                                            <i class="fa fa-clock-o"></i> Check In
                                        </button>
                                    @else
                                        <div class="alert alert-warning">
                                            No available schedules for today. Please contact your administrator.
                                        </div>
                                    @endif
                                </div>
                            </form>
                        @endif
                    </div>

                    <!-- Attendance Summary Card -->
                    <div class="attendance-card attendance-summary">
                        <h2>Attendance Summary</h2>

                        <div class="summary-item">
                            <div class="summary-icon">
                                <i class="fa fa-check-circle"></i>
                            </div>
                            <div>
                                On-time: {{ $onTimeCount }} days
                            </div>
                        </div>

                        <div class="summary-item">
                            <div class="summary-icon">
                                <i class="fa fa-exclamation-circle"></i>
                            </div>
                            <div>
                                Late: {{ $lateCount }} days
                            </div>
                        </div>

                        <div class="summary-item">
                            <div class="summary-icon">
                                <i class="fa fa-sign-in"></i>
                            </div>
                            <div>
                                Avg. Check-in: {{ $avgCheckIn }}
                            </div>
                        </div>

                        <div class="summary-item">
                            <div class="summary-icon">
                                <i class="fa fa-sign-out"></i>
                            </div>
                            <div>
                                Avg. Check-out: {{ $avgCheckOut }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Update the clock every second
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;

            setTimeout(updateClock, 1000);
        }

        // Schedule selection
        function selectSchedule(element, scheduleId) {
            // Remove selected class from all items
            document.querySelectorAll('.schedule-item').forEach(item => {
                item.classList.remove('selected');
            });

            // Add selected class to clicked item
            element.classList.add('selected');

            // Set the selected schedule ID
            document.getElementById('selected_schedule_id').value = scheduleId;

            // Enable the check-in button
            document.getElementById('check_in_btn').disabled = false;
        }

        // Start the clock when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateClock();
        });
    </script>
@endsection
