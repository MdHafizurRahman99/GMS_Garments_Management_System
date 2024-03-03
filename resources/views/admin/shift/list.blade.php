@extends('layouts.admin.master')
@section('title')
    Shifts
@endsection

@section('css')
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
            <h1 class="h3 mb-2 text-gray-800">Shifts</h1>

            <div class="user-add-shedule-list">
                <div class="col-auto float-right ml-auto">

                    <button class="btn-primary" data-toggle="modal" data-target="#add_shift"> Add Shift</button>
                </div>
            </div>
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
                                    <th>Shift Name</th>
                                    @if (Auth::user()->can('shift.edit') || Auth::user()->can('shift.delete'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            {{-- <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </tfoot> --}}
                            <tbody>

                                @foreach ($shifts as $shift)
                                    <tr>
                                        <td>
                                            <p class="p-2"> {{ $shift->shift_name }}</p>
                                        </td>
                                        @if (Auth::user()->can('shift.edit') || Auth::user()->can('shift.delete'))
                                            <td>
                                                @if (Auth::user()->can('shift.edit'))
                                                    {{-- <a href="{{ route('shift.edit', ['id' => $shift->id]) }}">
                                                        <input class="btn btn-warning" type="button" value="Edit">
                                                    </a> --}}
                                                    <input type="hidden" name="shift_id" value="{{ $shift->id }}">

                                                    <button class="btn btn-primary rounded edit-shift" data-toggle="modal"
                                                        data-target="#edit_shift">Edit</button>
                                                @endif
                                                @if (Auth::user()->can('shift.delete'))
                                                    <form action="{{ route('shift.destroy', ['id' => $shift->id]) }}"
                                                        method="POST">
                                                        {{-- @method('DELETE') --}}
                                                        @csrf
                                                        <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                                            onclick="return confirm('Do you want to delete this Shift!')">
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div id="edit_shift" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Shift</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('shift.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="">
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
                            <button class="btn btn-primary submit-btn">Update</button>
                        </div>
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
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('.edit-shift').on('click', function() {
                var shiftId = $(this).closest('td').find('input[name="shift_id"]').val();
                // console.log(shiftId);
                // AJAX request to fetch schedule data
                $.ajax({
                    url: '/get-shift-data',
                    method: 'GET',
                    data: {
                        shift_id: shiftId
                    },
                    success: function(response) {
                        var shiftData = response.data;
                        // console.log(shiftData);

                        $('input[name="start_time"]').val(shiftData.start_time);
                        $('input[name="end_time"]').val(shiftData.end_time);
                        $('input[name="break_time"]').val(shiftData.break_time);
                        $('input[name="id"]').val(shiftData.id);


                        // $('#edit_schedule').modal('show');
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
