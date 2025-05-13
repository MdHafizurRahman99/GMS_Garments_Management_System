@extends('layouts.admin.master')

@section('title')
    Add Role Permissions
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/opensans-font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/roboto-font.css') }}">
    <link rel="stylesheet" type="text/css "
        href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css"> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
@endsection

@section('content')
    <div class="page-content">
        <div class="wizard-v4-content">
            <div class="wizard-form">
                <div class="wizard-header">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ 'There is invalid information in Form Data' }}
                        </div>
                    @endif
                    <h3 class="heading">Add Role Permissions </h3>
                    {{-- <p>Add Permissions </p> --}}
                </div>
                <form class="form-register" id="myForm" action="{{ route('roles-permission.store') }}" method="post">
                    @csrf
                    <div id="form-total">
                        <h2>
                            {{-- <span class="step-icon"><i class="zmdi zmdi-lock"></i></span> --}}
                            {{-- <span class="step-text">Contact Details</span> --}}
                        </h2>
                        <section>
                            <div class="inner">
                                <div class="form-group">
                                    <label for="exampleSelect">Roles Name</label>
                                    <select required name="role_id" class="form-control" id="exampleSelect">
                                        {{-- <option value="">Select Role</option> --}}
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"> {{ $role->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <div class="form-check m-2 p-2">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        {{ old('permission_all') ? 'checked' : '' }} id="permission_all"
                                        name="permission_all">
                                    <label class="form-check-label " for="permission_all">
                                        Permission ALL
                                    </label>
                                </div>
                                <hr>

                                <div class="row">
                                    @foreach ($permissions as $group_name => $group)
                                        <div class="col-md-6">
                                            <div class="form-check m-2 p-2">
                                                <input class="form-check-input group-checkbox" type="checkbox"
                                                    value="{{ $group_name }}" id="group_name{{ $group_name }}"
                                                    name="group_name">
                                                <label class="form-check-label " for="group_name{{ $group_name }}">
                                                    {{ $group_name }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            @foreach ($group as $permission)
                                                <div class="form-check m-2 p-2">
                                                    <input
                                                        class="form-check-input permission-checkbox group_{{ $group_name }}"
                                                        type="checkbox" value="{{ $permission->id }}"
                                                        {{ old('name') ? 'checked' : '' }} id="name{{ $permission->id }}"
                                                        name="permission_id[]">
                                                    <label class="form-check-label " for="name{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-12"><!-- Clearfix for smaller screens --></div>
                                    @endforeach
                                </div>

                            </div>
                        </section>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.steps.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
    {{-- this code will disable all the input fields of postal_address if (same as ) checked  --}}
    <script>
        $(document).ready(function() {
            $('.group-checkbox').change(function() {
                var groupName = $(this).val();
                if ($(this).is(':checked')) {
                    $('.group_' + groupName).prop('checked', true);
                } else {
                    $('.group_' + groupName).prop('checked', false);
                }
            });

            // Functionality for "Permission ALL" checkbox
            $('#permission_all').change(function() {
                if ($(this).is(':checked')) {
                    $('.permission-checkbox').prop('checked', true);
                    $('.group-checkbox').prop('checked', true);
                } else {
                    $('.permission-checkbox').prop('checked', false);
                    $('.group-checkbox').prop('checked', false);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.wizard-v4-content').on('click', 'a[href="#finish"]', function(event) {
                event.preventDefault(); // Prevent default link behavior
                $('#myForm').submit(); // Submit the form with ID 'myForm'
            });
        });
    </script>
@endsection
