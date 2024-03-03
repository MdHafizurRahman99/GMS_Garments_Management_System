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
    </style>
@endsection

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Schedules</h1>
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
                    {{-- <h6 class="m-0 font-weight-bold text-primary">staffs List</h6> --}}
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                @php
                                    // Get the current date
                                    $currentDate = now();
                                    $startDate = $currentDate->copy()->startOfWeek();
                                    // ->subDays();
                                    // ->subDays(($currentDate->dayOfWeek + 5) % 7);
                                    // dd($startDate);

                                    $datesArray = [];
                                    // Loop through the dates of the week and add them to the array
                                    for ($i = 0; $i < 7; $i++) {
                                        $datesArray[] = $startDate->copy()->addDays($i);
                                    }
                                    // dd($datesArray);
                                @endphp
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
                                        <th style="text-align: center;">
                                            <div class="user-add-schedule-list" style="display: inline-block;">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div class="user-add-schedule-list" style="display: inline-block;">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div class="user-add-schedule-list" style="display: inline-block;">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div class="user-add-schedule-list" style="display: inline-block;">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div class="user-add-schedule-list" style="display: inline-block;">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div class="user-add-schedule-list" style="display: inline-block;">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div class="user-add-schedule-list" style="display: inline-block;">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            @endif
                            <tbody>
                                @foreach ($schedules as $schedule)
                                    @php

                                        $daysArray = json_decode($schedule->days);
                                        // dd($daysArray);
                                    @endphp
                                    <tr>

                                        @if ($daysArray != null)
                                            {{-- @dd($daysArray) --}}
                                            <td>
                                                {{ $schedule->staff->first_name . ' ' . $schedule->staff->last_name }}
                                            </td>
                                            @if (in_array('Mon', $daysArray))
                                                <td>
                                                    <div class="user-add-shedule-list">
                                                        <h2>
                                                            <input type="hidden" name="staff_id"
                                                                value="{{ $schedule->staff->id }}">
                                                            <input type="hidden" name="shift_id"
                                                                value="{{ $schedule->shift->id }}">
                                                            <button data-toggle="modal" data-target="#edit_schedule"
                                                                class="btn-primary edit-schedule">
                                                                <span
                                                                    class="username-info m-b-10">{{ $schedule->shift->shift_name }}
                                                                </span>
                                                                {{-- <span
                                                                    class="userrole-info">{{ $schedule->staff->first_name . ' ' . $schedule->staff->last_name }}</span> --}}
                                                            </button>
                                                        </h2>
                                                    </div>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if (in_array('Tue', $daysArray))
                                                <td>
                                                    <div class="user-add-shedule-list">
                                                        <h2>
                                                            <input type="hidden" name="staff_id"
                                                                value="{{ $schedule->staff->id }}">
                                                            <input type="hidden" name="shift_id"
                                                                value="{{ $schedule->shift->id }}">
                                                            <button data-toggle="modal" data-target="#edit_schedule"
                                                                class="btn-primary edit-schedule">
                                                                <span
                                                                    class="username-info m-b-10">{{ $schedule->shift->shift_name }}
                                                                </span>
                                                                {{-- <span
                                                                    class="userrole-info">{{ $schedule->staff->first_name . ' ' . $schedule->staff->last_name }}</span> --}}
                                                            </button>
                                                        </h2>
                                                    </div>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if (in_array('Wed', $daysArray))
                                                <td>
                                                    <div class="user-add-shedule-list">
                                                        <h2>
                                                            <input type="hidden" name="staff_id"
                                                                value="{{ $schedule->staff->id }}">
                                                            <input type="hidden" name="shift_id"
                                                                value="{{ $schedule->shift->id }}">
                                                            <button data-toggle="modal" data-target="#edit_schedule"
                                                                class="btn-primary edit-schedule">
                                                                <span
                                                                    class="username-info m-b-10">{{ $schedule->shift->shift_name }}
                                                                </span>
                                                                {{-- <span
                                                                    class="userrole-info">{{ $schedule->staff->first_name . ' ' . $schedule->staff->last_name }}</span> --}}
                                                            </button>
                                                        </h2>
                                                    </div>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if (in_array('Thu', $daysArray))
                                                <td>
                                                    <div class="user-add-shedule-list">
                                                        <h2>
                                                            <input type="hidden" name="staff_id"
                                                                value="{{ $schedule->staff->id }}">
                                                            <input type="hidden" name="shift_id"
                                                                value="{{ $schedule->shift->id }}">
                                                            <button data-toggle="modal" data-target="#edit_schedule"
                                                                class="btn-primary edit-schedule">
                                                                <span
                                                                    class="username-info m-b-10">{{ $schedule->shift->shift_name }}
                                                                </span>
                                                                {{-- <span
                                                                    class="userrole-info">{{ $schedule->staff->first_name . ' ' . $schedule->staff->last_name }}</span> --}}
                                                            </button>
                                                        </h2>
                                                    </div>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if (in_array('Fri', $daysArray))
                                                <td>
                                                    <div class="user-add-shedule-list">
                                                        <h2>
                                                            <input type="hidden" name="staff_id"
                                                                value="{{ $schedule->staff->id }}">
                                                            <input type="hidden" name="shift_id"
                                                                value="{{ $schedule->shift->id }}">
                                                            <button data-toggle="modal" data-target="#edit_schedule"
                                                                class="btn-primary edit-schedule">
                                                                <span
                                                                    class="username-info m-b-10">{{ $schedule->shift->shift_name }}
                                                                </span>
                                                                {{-- <span
                                                                    class="userrole-info">{{ $schedule->staff->first_name . ' ' . $schedule->staff->last_name }}</span> --}}
                                                            </button>
                                                        </h2>
                                                    </div>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if (in_array('Sat', $daysArray))
                                                <td>
                                                    <div class="user-add-shedule-list">
                                                        <h2>
                                                            <input type="hidden" name="staff_id"
                                                                value="{{ $schedule->staff->id }}">
                                                            <input type="hidden" name="shift_id"
                                                                value="{{ $schedule->shift->id }}">
                                                            <button data-toggle="modal" data-target="#edit_schedule"
                                                                class="btn-primary edit-schedule">
                                                                <span
                                                                    class="username-info m-b-10">{{ $schedule->shift->shift_name }}
                                                                </span>
                                                                {{-- <span
                                                                    class="userrole-info">{{ $schedule->staff->first_name . ' ' . $schedule->staff->last_name }}</span> --}}
                                                            </button>
                                                        </h2>
                                                    </div>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if (in_array('Sun', $daysArray))
                                                <td>
                                                    <div class="user-add-shedule-list">
                                                        <h2>
                                                            <input type="hidden" name="staff_id"
                                                                value="{{ $schedule->staff->id }}">
                                                            <input type="hidden" name="shift_id"
                                                                value="{{ $schedule->shift->id }}">
                                                            <button data-toggle="modal" data-target="#edit_schedule"
                                                                class="btn-primary edit-schedule">
                                                                <span
                                                                    class="username-info m-b-10">{{ $schedule->shift->shift_name }}
                                                                </span>
                                                                {{-- <span
                                                                    class="userrole-info">{{ $schedule->staff->first_name . ' ' . $schedule->staff->last_name }}</span> --}}
                                                            </button>
                                                        </h2>
                                                    </div>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endif

                                    </tr>
                                @endforeach

                                {{-- <tr>
                                        
                                    <td>

                                        <div class="user-add-shedule-list">
                                            <h2>
                                                <button data-toggle="modal" data-target="#edit_schedule"
                                                    class="btn-primary">
                                                    <span class="username-info m-b-10">6:30 am - 9:30 pm </span>
                                                    <span class="userrole-info">Hafiz</span>
                                                </button>
                                            </h2>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <h2>
                                                <button data-toggle="modal" data-target="#edit_schedule"
                                                    class="btn-primary">
                                                    <span class="username-info m-b-10">6:30 am - 9:30 pm </span>
                                                    <span class="userrole-info">Hafiz</span>
                                                </button>
                                            </h2>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <h2>
                                                <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                    style="border:2px dashed #1eb53a">
                                                    <span class="username-info m-b-10">6:30 am - 9:30 pm </span>
                                                    <span class="userrole-info">Hafiz</span>
                                                </a>
                                            </h2>
                                        </div>
                                    </td>


                                </tr> --}}


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    {{-- <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Staff List</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach ($datesArray as $date)
                                        <th>{{ $date->format('D j') }}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align: center;">
                                        <div class="user-add-schedule-list" style="display: inline-block;">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </th>
                                    <th style="text-align: center;">
                                        <div class="user-add-schedule-list" style="display: inline-block;">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </th>
                                    <th style="text-align: center;">
                                        <div class="user-add-schedule-list" style="display: inline-block;">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </th>
                                    <th style="text-align: center;">
                                        <div class="user-add-schedule-list" style="display: inline-block;">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </th>
                                    <th style="text-align: center;">
                                        <div class="user-add-schedule-list" style="display: inline-block;">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </th>
                                    <th style="text-align: center;">
                                        <div class="user-add-schedule-list" style="display: inline-block;">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </th>
                                    <th style="text-align: center;">
                                        <div class="user-add-schedule-list" style="display: inline-block;">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </th>
                                </tr>
                            </tfoot>
                            <tbody>

                                <tr>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                <span><i class="fa fa-plus"></i></span>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <h2>
                                                <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                    style="border:2px dashed #1eb53a">
                                                    <span class="username-info m-b-10">6:30 am - 9:30 pm </span>
                                                    <span class="userrole-info">Hafiz</span>
                                                </a>
                                            </h2>
                                        </div>
                                    </td>
           

                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <div class="user-add-shedule-list">
                                            <h2>
                                                <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                    style="border:2px dashed #1eb53a">
                                                    <span class="username-info m-b-10">6:30 am - 9:30 pm </span>
                                                    <span class="userrole-info">Hafiz</span>
                                                </a>
                                            </h2>
                                        </div>
                                    </td>
                                  

                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div> --}}
    {{-- <section class="signup-step-container ">
        <div class="container border pt-5">
            <div class="row d-flex justify-content-center">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th>Scheduled Shift</th>
                                        <th>Fri 21</th>
                                        <th>Sat 22</th>
                                        <th>Sun 23</th>
                                        <th>Mon 24</th>
                                        <th>Tue 25</th>
                                        <th>Wed 26</th>
                                        <th>Thu 27</th>
                                        <th>Fri 28</th>
                                        <th>Sat 29</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar"><img alt=""
                                                        src="{{ asset('staff&shedule/') }}img/profiles/avatar-02.jpg"></a>
                                                <a href="profile.html">John Doe <span>Web Designer</span></a>
                                            </h2>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar"><img alt=""
                                                        src="{{ asset('staff&shedule/') }}img/profiles/avatar-09.jpg"></a>
                                                <a href="profile.html">Richard Miles <span>Web Developer</span></a>
                                            </h2>
                                        </td>

                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar"><img alt=""
                                                        src="assets/img/profiles/avatar-10.jpg"></a>
                                                <a href="profile.html">John Smith <span>Android Developer</span></a>
                                            </h2>
                                        </td>

                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar"><img alt=""
                                                        src="assets/img/profiles/avatar-05.jpg"></a>
                                                <a href="profile.html">Mike Litorus <span>IOS Developer</span></a>
                                            </h2>
                                        </td>

                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar"><img alt=""
                                                        src="assets/img/profiles/avatar-11.jpg"></a>
                                                <a href="profile.html">Wilmer Deluna <span>Team Leader</span></a>
                                            </h2>
                                        </td>

                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar"><img alt=""
                                                        src="assets/img/profiles/avatar-12.jpg"></a>
                                                <a href="profile.html">Jeffrey Warden <span>Web Developer</span></a>
                                            </h2>
                                        </td>

                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar"><img alt=""
                                                        src="assets/img/profiles/avatar-13.jpg"></a>
                                                <a href="profile.html">Bernardo Galaviz <span>Web Developer</span></a>
                                            </h2>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <h2>
                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule"
                                                        style="border:2px dashed #1eb53a">
                                                        <span class="username-info m-b-10">6:30 am - 9:30 pm ( 14 hrs 15
                                                            mins)</span>
                                                        <span class="userrole-info">Hafiz</span>
                                                    </a>
                                                </h2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-add-shedule-list">
                                                <a href="#" data-toggle="modal" data-target="#add_schedule">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> --}}
    <!-- /Content End -->

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
                            {{-- <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option value="">Select</option>
                                        <option value="">Development</option>
                                        <option value="1">Finance</option>
                                        <option value="2">Finance and Management</option>
                                        <option value="3">Hr & Finance</option>
                                        <option value="4">ITech</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Staff Name <span class="text-danger">*</span></label>
                                    <select class="select" name="staff_id">
                                        {{-- <option value="">Select </option> --}}
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
                                        {{-- <option value="">Select </option> --}}
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}"> {{ $shift->shift_name }} </option>
                                        @endforeach

                                        {{-- <option value="1">10'o clock Shift</option>
                                        <option value="2">10:30 shift</option>
                                        <option value="3">Daily Shift </option>
                                        <option value="4">New Shift</option> --}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Start Date</label>
                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text"
                                            name="start_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">End Date</label>
                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text"
                                            name="end_date">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">Min Start Time <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control"><span
                                            class="input-group-append input-group-addon"><span class="input-group-text"><i
                                                    class="fa fa-clock-o"></i></span></span>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">Start Time <span class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control"><span
                                            class="input-group-append input-group-addon"><span class="input-group-text"><i
                                                    class="fa fa-clock-o"></i></span></span>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">Max Start Time <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control"><span
                                            class="input-group-append input-group-addon"><span class="input-group-text"><i
                                                    class="fa fa-clock-o"></i></span></span>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">Min End Time <span class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control"><span
                                            class="input-group-append input-group-addon"><span class="input-group-text"><i
                                                    class="fa fa-clock-o"></i></span></span>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">End Time <span class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control"><span
                                            class="input-group-append input-group-addon"><span class="input-group-text"><i
                                                    class="fa fa-clock-o"></i></span></span>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">Max End Time <span class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control"><span
                                            class="input-group-append input-group-addon"><span class="input-group-text"><i
                                                    class="fa fa-clock-o"></i></span></span>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">Break Time <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Accept Extra Hours </label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1"
                                            checked="">
                                        <label class="custom-control-label" for="customSwitch1"></label>
                                    </div>
                                </div>
                            </div> --}}

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
                                        {{-- <option value="">Select </option> --}}
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
                            {{-- <div>
                                <a href=""></a>
                                <button class="btn btn-danger ">Delete</button>
                            </div> --}}
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
                            {{-- <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Shift Name <span class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control" name="shift_name">
                              
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="startTime">Start Time <span class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control" type="time" name="start_time" id="startTime">
                                        {{-- <span
                                            class="input-group-append input-group-addon"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </span></span> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Time <span class="text-danger">*</span></label>
                                    <div class="input-group time timepicker">
                                        <input class="form-control" type="time" name="end_time">
                                        {{-- <span
                                            class="input-group-append input-group-addon"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </span></span> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Break Time (In Minutes) </label>
                                    <input type="text" class="form-control" name="break_time">
                                </div>
                            </div>

                            {{-- <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Repeat Every</label>
                                    <select class="select">
                                        <option value="">1 </option>
                                        <option value="1">2</option>
                                        <option value="2">3</option>
                                        <option value="3">4</option>
                                        <option selected value="4">5</option>
                                        <option value="3">6</option>
                                    </select>
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-12">
                                <div class="form-group wday-box">
                                    <label class="col-form-label">Week(s)</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="monday"
                                            class="days recurring" checked=""><span
                                            class="checkmark">M</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" value="tuesday"
                                            class="days recurring" checked=""><span
                                            class="checkmark">T</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" value="wednesday"
                                            class="days recurring" checked=""><span
                                            class="checkmark">W</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" value="thursday"
                                            class="days recurring" checked=""><span
                                            class="checkmark">T</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" value="friday"
                                            class="days recurring" checked=""><span
                                            class="checkmark">F</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" value="saturday"
                                            class="days recurring"><span class="checkmark">S</span></label>

                                    <label class="checkbox-inline"><input type="checkbox" value="sunday"
                                            class="days recurring"><span class="checkmark">S</span></label>
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">End On <span class="text-danger">*</span></label>
                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text">
                                    </div>
                                </div>
                            </div> --}}


                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <label>Add Tag </label>
                                    <input type="text" class="form-control">
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <label>Add Note </label>
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div> --}}
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
    {{-- <script src="{{ asset('staff&shedule/js') }}/jquery-3.5.1.min.js"></script> --}}
    <!-- Bootstrap Core JS -->
    <script src="{{ asset('staff&shedule/js') }}/popper.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/bootstrap.min.js"></script>
    <!-- Slimscroll JS -->
    <script src="{{ asset('staff&shedule/js') }}/jquery.slimscroll.min.js"></script>
    <!-- Select2 JS -->
    <script src="{{ asset('staff&shedule/js') }}/select2.min.js"></script>
    <!-- Datetimepicker JS -->
    <script src="{{ asset('staff&shedule/js') }}/moment.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/bootstrap-datetimepicker.min.js"></script>
    <!-- Datatable JS -->
    <script src="{{ asset('staff&shedule/js') }}/jquery.dataTables.min.js"></script>
    <script src="{{ asset('staff&shedule/js') }}/dataTables.bootstrap4.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('staff&shedule/js') }}/app.js"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

    <script>
        $(document).ready(function() {
            var userRole = "{{ Auth::user()->role }}";
            console.log(userRole);
            $('.edit-schedule').on('click', function() {
                var staffId = $(this).closest('td').find('input[name="staff_id"]').val();
                var shiftId = $(this).closest('td').find('input[name="shift_id"]').val();

                // console.log(staffId, shiftId);
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
                        // console.log(scheduleData);
                        $('select[name="staff_id"]').val(scheduleData.staff_id).change();
                        $('select[name="shift_id"]').val(scheduleData.shift.id).change();
                        $('input[name="start_date"]').val(scheduleData.start_date);
                        $('input[name="end_date"]').val(scheduleData.end_date);
                        $('input[name="schedule_id"]').val(scheduleData.id);

                        // Populate the days checkboxes if 'days' is an array of selected days
                        var days = JSON.parse(scheduleData
                            .days); // Parse the days string to an array
                        $('.days.recurring').prop('checked',
                            false); // Uncheck all checkboxes first
                        days.forEach(function(day) {
                            $('.days.recurring[value="' + day + '"]').prop('checked',
                                true); // Check the checkboxes for selected days
                        });

                        $('textarea[name="note"]').val(scheduleData
                            .note); // Assuming 'note' is the correct key for the note field
                        // if (scheduleData.publish !== 'Published') {
                        //     $('input[name="publish"]').prop('checked', false);
                        // }
                        // console.log('scheduleData.publish:', scheduleData.publish);
                        $('input[name="publish"]').prop('checked', scheduleData.publish ==
                            'Published');
                        // Set the checkbox based on the 'publish' value
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
