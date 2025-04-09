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
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendanceHistory as $record)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($record->date)->format('Y-m-d') }}</td>
                                        <td>{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('H:i:s A') : 'N/A' }}</td>
                                        <td>{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('H:i:s A') : 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No attendance records found</td>
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
                            {{ \Carbon\Carbon::now()->format('H:i:s') }}
                        </div>

                        <div class="current-date">
                            {{ \Carbon\Carbon::now()->format('l, F jS, Y') }}
                        </div>

                        <div class="attendance-buttons">
                            <form action="{{ route('attendance.check-in') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark" {{ $todayAttendance && $todayAttendance->check_in ? 'disabled' : '' }}>
                                    <i class="fa fa-clock-o"></i> Check In
                                </button>
                            </form>

                            <form action="{{ route('attendance.check-out') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark" {{ !$todayAttendance || !$todayAttendance->check_in || $todayAttendance->check_out ? 'disabled' : '' }}>
                                    <i class="fa fa-clock-o"></i> Check Out
                                </button>
                            </form>
                        </div>
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

        // Start the clock when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateClock();
        });
    </script>
@endsection
