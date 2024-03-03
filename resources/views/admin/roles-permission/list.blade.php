@extends('layouts.admin.master')
@section('title')
    Role Permissions
@endsection

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Role Permissions List</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    {{-- <h6 class="m-0 font-weight-bold text-primary">roles List</h6> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Role Name</th>
                                    <th>Permissions</th>
                                    @if (Auth::user()->can('roles_permission.edit') || Auth::user()->can('roles_permission.delete'))
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
                                {{-- @dd($roles) --}}
                                {{-- @foreach ($roles as $groupName => $group) --}}
                                @foreach ($roles_permissions as $role_permissions)
                                    <tr>
                                        <td>
                                            <p class="p-2"> {{ $role_permissions->name }}</p>
                                        </td>
                                        {{-- @dd($role_permissions->roleHasPermissions) --}}
                                        @if (Auth::user()->can('roles_permission.edit') || Auth::user()->can('roles_permission.delete'))
                                            <td>
                                                @if (!empty($role_permissions->roleHasPermissions) && count($role_permissions->roleHasPermissions) > 0)
                                                    @foreach ($role_permissions->roleHasPermissions as $permissions)
                                                        {{-- @dd($permissions->permission->name) --}}
                                                        <p class=""> {{ $permissions->permission->name }}</p>
                                                    @endforeach
                                                @endif
                                            </td>
                                        @endif

                                        <td>
                                            @if (Auth::user()->can('roles_permission.edit'))
                                                <a
                                                    href="{{ route('roles-permission.edit', ['roles_permission' => $role_permissions->id]) }}">
                                                    <input class="btn btn-warning" type="button" value="Edit">
                                                </a>
                                            @endif

                                            @if (Auth::user()->can('roles_permission.delete'))
                                                <form
                                                    action="{{ route('roles-permission.destroy', ['roles_permission' => $role_permissions->id]) }}"
                                                    method="POST">
                                                    {{-- @method('DELETE') --}}
                                                    @csrf
                                                    <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                                        onclick="return confirm('Do you want to delete this Role Permissions!')">
                                                </form>
                                            @endif
                                        </td>
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
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
