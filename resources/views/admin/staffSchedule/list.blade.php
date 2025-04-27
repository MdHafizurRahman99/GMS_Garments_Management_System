@extends('layouts.admin.master')

@section('title')
    Staff Details
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('staff&shedule/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('staff&shedule/css/font-awesome.min.css') }}">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ asset('staff&shedule/css/line-awesome.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('staff&shedule/css/dataTables.bootstrap4.min.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('staff&shedule/css/select2.min.css') }}">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('staff&shedule/css/bootstrap-datetimepicker.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('staff&shedule/css/style copy.css') }}">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <style>
        .user-add-shedule-list {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .user-add-shedule-list button.btn-primary,
        .user-add-shedule-list button.btn-primary span {
            color: white !important;
            border-radius: 10px;
        }

        .week-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .week-navigation .btn {
            padding: 5px 15px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }
    </style>
@endsection

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Schedules</h1>

            <!-- Week Navigation -->
            <div class="week-navigation">
                <a href="{{ route('staffschedule.index', ['week_offset' => ($weekOffset - 1)]) }}" class="btn btn-primary">
                    <i class="fa fa-chevron-left"></i> Previous Week
                </a>
                <h5>
                    {{ $datesArray[0]->format('M d') }} - {{ $datesArray[6]->format('M d, Y') }}
                </h5>
                <a href="{{ route('staffschedule.index', ['week_offset' => ($weekOffset + 1)]) }}" class="btn btn-primary">
                    Next Week <i class="fa fa-chevron-right"></i>
                </a>
            </div>

            @if (Auth::user()->hasRole('User'))
            @else
                <div class="user-add-shedule-list">
                    <div class="col-auto float-right ml-auto">
                        <button class="btn-primary" data-toggle="modal" data-target="#add_schedule"> Add Schedule</button>
                        <button class="btn-primary" data-toggle="modal" data-target="#add_shift"> Add Shifts</button>
                    </div>
                </div>
            @endif

            <!-- DataTales Example -->
            <div class="card shadow mb-4">

                <div class="card-header py-3">
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
                </div>
                @php
                // Group schedules by staff
                $staffSchedules = [];
                foreach ($schedules as $schedule) {
                    if (!isset($staffSchedules[$schedule->staff_id])) {
                        $staffSchedules[$schedule->staff_id] = [
                            'staff' => $schedule->staff,
                            'schedules' => []
                        ];
                    }
                    $staffSchedules[$schedule->staff_id]['schedules'][] = $schedule;
                }
            @endphp
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    @foreach ($datesArray as $date)
                                        <th>{!! '<strong>' . $date->format('D') . '</strong> ' . $date->format('j') !!}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            @if (Auth::user()->hasRole('User'))
                            @else
                                <tfoot>
                                    <tr>
                                        <th style="text-align: center;">
                                            <div class="user-add-schedule-list" style="display: inline-block;">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </th>
                                        @foreach ($datesArray as $date)
                                            <th style="text-align: center;">
                                                <div class="user-add-schedule-list" style="display: inline-block;">
                                                    <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                        <span><i class="fa fa-plus"></i></span>
                                                    </a>
                                                </div>
                                            </th>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            @endif
                            <tbody>
                                @foreach ($staffSchedules as $staffId => $data)
                                    <tr>
                                        <td>
                                            {{ $data['staff']->first_name . ' ' . $data['staff']->last_name }}
                                        </td>

                                        @foreach ($datesArray as $date)
                                            <td>
                                                @php
                                                    $dayName = $date->format('D');
                                                    $shiftsForDay = [];

                                                    // Find schedules for this day
                                                    foreach ($data['schedules'] as $schedule) {
                                                        $daysArray = json_decode($schedule->days);

                                                        // Check if this day is in the schedule's days array
                                                        if (in_array($dayName, $daysArray)) {
                                                            $shiftsForDay[] = $schedule;
                                                        }
                                                    }
                                                @endphp

                                                @foreach ($shiftsForDay as $schedule)
                                                    <div class="user-add-shedule-list mb-1">
                                                        <h2>
                                                            <button data-toggle="modal" data-target="#edit_schedule"
                                                                class="btn-primary edit-schedule"
                                                                data-staff-id="{{ $schedule->staff_id }}"
                                                                data-shift-id="{{ $schedule->shift_id }}">
                                                                <span class="username-info m-b-10">{{ $schedule->shift->shift_name }}</span>
                                                            </button>
                                                        </h2>
                                                    </div>
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>

    <!-- /Add Schedule Modal -->
    <div id="add_schedule" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('staffschedule.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Staff Name <span class="text-danger">*</span></label>
                                    <select class="select" name="staff_id">
                                        @foreach ($staffs as $staff)
                                            <option value="{{ $staff->id }}">
                                                {{ $staff->first_name . ' ' . $staff->last_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Shifts <span class="text-danger">*</span></label>
                                    <select class="select" name="shift_id">
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}"> {{ $shift->shift_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Start Date</label>
                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text"
                                            name="start_date" value="{{ $datesArray[0]->format('d/m/Y') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">End Date</label>
                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text"
                                            name="end_date" value="{{ $datesArray[6]->format('d/m/Y') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group wday-box">
                                    <label class="col-form-label">Week(s)</label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            value="Mon" class="days recurring" checked><span
                                            class="checkmark">M</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            value="Tue" class="days recurring" checked><span
                                            class="checkmark">T</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            value="Wed" class="days recurring" checked><span
                                            class="checkmark">W</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            value="Thu" class="days recurring" checked><span
                                            class="checkmark">T</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            value="Fri" class="days recurring" checked><span
                                            class="checkmark">F</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            value="Sat" class="days recurring"><span
                                            class="checkmark">S</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            value="Sun" class="days recurring"><span
                                            class="checkmark">S</span></label>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Note </label>
                                    <textarea class="form-control" name="note"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Publish </label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" checked
                                            value="Published" name="publish">
                                        <label class="custom-control-label" for="customSwitch1"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Schedule Modal -->
    <div id="edit_schedule" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('staffschedule.update') }}" method="POST">
                        @csrf
                        <input type="hidden" value="" name="schedule_id">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Staff Name <span class="text-danger">*</span></label>
                                    <select class="select" name="staff_id"
                                        {{ Auth::user()->role === 'user' ? 'disabled' : '' }}>
                                        @foreach ($staffs as $staff)
                                            <option value="{{ $staff->id }}">
                                                {{ $staff->first_name . ' ' . $staff->last_name }} </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Shifts <span class="text-danger">*</span></label>
                                    <select class="select" name="shift_id"
                                        {{ Auth::user()->role === 'user' ? 'disabled' : '' }}>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}"> {{ $shift->shift_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Start Date</label>
                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text"
                                            name="start_date" {{ Auth::user()->role === 'user' ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">End Date</label>
                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text"
                                            name="end_date" {{ Auth::user()->role === 'user' ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group wday-box">
                                    <label class="col-form-label">Week(s)</label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            {{ Auth::user()->role === 'user' ? 'disabled' : '' }} value="Mon"
                                            class="days recurring" checked><span class="checkmark">M</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            {{ Auth::user()->role === 'user' ? 'disabled' : '' }} value="Tue"
                                            class="days recurring" checked><span class="checkmark">T</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            {{ Auth::user()->role === 'user' ? 'disabled' : '' }} value="Wed"
                                            class="days recurring" checked><span class="checkmark">W</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            {{ Auth::user()->role === 'user' ? 'disabled' : '' }} value="Thu"
                                            class="days recurring" checked><span class="checkmark">T</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            {{ Auth::user()->role === 'user' ? 'disabled' : '' }} value="Fri"
                                            class="days recurring" checked><span class="checkmark">F</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            {{ Auth::user()->role === 'user' ? 'disabled' : '' }} value="Sat"
                                            class="days recurring"><span class="checkmark">S</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" name="week_days[]"
                                            {{ Auth::user()->role === 'user' ? 'disabled' : '' }} value="Sun"
                                            class="days recurring"><span class="checkmark">S</span></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note </label>
                                    <textarea class="form-control" name="note" {{ Auth::user()->role === 'user' ? 'disabled' : '' }}></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Publish </label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2"
                                            value="Published" name="publish">
                                        <label class="custom-control-label" for="customSwitch2"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->hasRole('User'))
                        @else
                            <div class="submit-section ">
                                <button class="btn btn-primary submit-btn">Update</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Shift Modal -->
    <div id="add_shift" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Shift</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('shift.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="startTime">Start Time <span class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control" type="time" name="start_time" id="startTime">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Time <span class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control" type="time" name="end_time">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Break Time (In Minutes) </label>
                                    <input type="text" class="form-control" name="break_time">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('staff&shedule/js') }}/popper.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/bootstrap.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/jquery.slimscroll.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/select2.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/moment.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/bootstrap-datetimepicker.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/jquery.dataTables.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/app.js"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

    <script>
        $(document).ready(function() {
            var userRole = "{{ Auth::user()->role }}";
            console.log(userRole);
            $('.edit-schedule').on('click', function() {
                var staffId = $(this).data('staff-id');
                var shiftId = $(this).data('shift-id');

                // AJAX request to fetch schedule data
                $.ajax({
                    url: '/get-schedule-data',
                    method: 'GET',
                    data: {
                        staff_id: staffId,
                        shift_id: shiftId
                    },
                    success: function(response) {
                        var scheduleData = response.data;
                        $('select[name="staff_id"]').val(scheduleData.staff_id).change();
                        $('select[name="shift_id"]').val(scheduleData.shift.id).change();
                        $('input[name="start_date"]').val(scheduleData.start_date);
                        $('input[name="end_date"]').val(scheduleData.end_date);
                        $('input[name="schedule_id"]').val(scheduleData.id);

                        // Populate the days checkboxes if 'days' is an array of selected days
                        var days = JSON.parse(scheduleData.days); // Parse the days string to an array
                        $('.days.recurring').prop('checked', false); // Uncheck all checkboxes first
                        days.forEach(function(day) {
                            $('.days.recurring[value="' + day + '"]').prop('checked', true); // Check the checkboxes for selected days
                        });

                        $('textarea[name="note"]').val(scheduleData.note); // Assuming 'note' is the correct key for the note field
                        $('input[name="publish"]').prop('checked', scheduleData.publish == 'Published');
                        // Display the modal
                        $('#edit_schedule').modal('show');
                    },
                    error: function(error) {
                        // Handle error scenarios here
                        console.error('Error fetching schedule data:', error);
                    }
                });
            });
        });
    </script>
@endsection
