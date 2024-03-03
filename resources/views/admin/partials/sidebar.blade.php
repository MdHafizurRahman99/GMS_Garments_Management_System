<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-briefcase" aria-hidden="true"></i>
        </div>
        <div class="sidebar-brand-text mx-3">EMS </div>
    </a>

    @if (Auth::user()->can('staff.view'))
        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaff"
                aria-expanded="true" aria-controls="collapseStaff">
                {{-- <i class="fa fa-Staff" aria-hidden="true"></i> --}}
                <span>Staff informations</span>
            </a>

            <div id="collapseStaff" class="collapse" aria-labelledby="headingStaff" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    {{-- <a class="collapse-item" href="{{ route('staff.create') }}">Staff Form</a> --}}
                    <a class="collapse-item" href="{{ route('staff.index') }}">List</a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>

        </li>
    @endif
    <!-- Divider -->
    @if (Auth::user()->can('shift.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShift"
                aria-expanded="true" aria-controls="collapseShift">
                {{-- <i class="fa fa-Shift" aria-hidden="true"></i> --}}
                <span>Shifts</span>
            </a>
            <div id="collapseShift" class="collapse" aria-labelledby="headingShift" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    {{-- <a class="collapse-item" href="{{ route('shift.create') }}">Add Shift</a> --}}
                    <a class="collapse-item" href="{{ route('shift.index') }}">List</a>

                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>

        </li>
    @endif
    @if (Auth::user()->can('staffschedule.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaffSchedule"
                aria-expanded="true" aria-controls="collapseStaffSchedule">
                {{-- <i class="fa fa-StaffSchedule" aria-hidden="true"></i> --}}
                <span>Schedules</span>
            </a>
            <div id="collapseStaffSchedule" class="collapse" aria-labelledby="headingStaffSchedule"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    {{-- <a class="collapse-item" href="{{ route('staff.create') }}">Add Staff</a> --}}
                    <a class="collapse-item" href="{{ route('staffschedule.index') }}">List</a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
    @endif

    <!-- Nav Item - Dashboard -->
    {{-- <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li> --}}

    <!-- Divider -->
    {{-- @if (Auth::user()->can('client.add'))
        <hr class="sidebar-divider">
        <!-- Heading -->
        @if (Auth::user()->hasRole('Super Admin'))
            <div class="sidebar-heading">
                Client side
            </div>
        @endif
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
                aria-expanded="true" aria-controls="collapseUser">
                <span>Request informations</span>
            </a>
            <div id="collapseUser" class="collapse" aria-labelledby="headingUser" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (Auth::user()->can('client.add'))
                        <a class="collapse-item" href="{{ route('client.create') }}">Request Form</a>
                    @endif
                    <a class="collapse-item" href="{{ route('user.index') }}">My Requests</a>

                </div>
            </div>

        </li>
 @endif --}}
    {{-- @if (Auth::user()->can('client_request.view'))
        <hr class="sidebar-divider">
        <!-- Heading -->
        @if (Auth::user()->hasRole('Super Admin'))
            <div class="sidebar-heading">
                Accountant side
            </div>
        @endif
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientRequest"
                aria-expanded="true" aria-controls="collapseClientRequest">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>Client</span>
            </a>
            <div id="collapseClientRequest" class="collapse" aria-labelledby="headingClientRequest"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (Auth::user()->can('client_request.add'))
                        <a class="collapse-item" href="{{ route('client_request.create') }}"> Add Client </a>
                    @endif

                    <a class="collapse-item" href="{{ route('client_request.index') }}"> List</a>

                </div>
            </div>
        </li>
 @endif --}}
    {{-- @if (Auth::user()->can('client.view'))

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClient"
                aria-expanded="true" aria-controls="collapseClient">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>Submited Requests</span>
            </a>
            <div id="collapseClient" class="collapse" aria-labelledby="headingClient" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('client.index') }}">Client Requests</a>
                </div>
            </div>
        </li>
 @endif --}}
    {{-- @if (Auth::user()->can('business.view'))
        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBusiness"
                aria-expanded="true" aria-controls="collapseBusiness">
                <i class="fa fa-briefcase" aria-hidden="true"></i>
                <span>Business</span>
            </a>
            <div id="collapseBusiness" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (Auth::user()->can('business.add'))
                        <a class="collapse-item" href="{{ route('business.create') }}">Add Business Profile</a>
                    @endif

                    <a class="collapse-item" href="{{ route('business.index') }}">Business Profile List</a>
                </div>
            </div>
        </li>
 @endif --}}


    <hr class="sidebar-divider">
    @if (Auth::user()->can('permission.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePermission"
                aria-expanded="true" aria-controls="collapsePermission">
                <i class="fa fa-briefcase" aria-hidden="true"></i>
                <span>Permission</span>
            </a>
            <div id="collapsePermission" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @if (Auth::user()->can('permission.add'))
                        <a class="collapse-item" href="{{ route('permission.create') }}">Add Permission </a>
                    @endif
                    <a class="collapse-item" href="{{ route('permission.index') }}">All Permission </a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->can('role.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRole"
                aria-expanded="true" aria-controls="collapseRole">
                <i class="fa fa-briefcase" aria-hidden="true"></i>
                <span>Role</span>
            </a>
            <div id="collapseRole" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @if (Auth::user()->can('role.add'))
                        <a class="collapse-item" href="{{ route('role.create') }}">Add Role </a>
                    @endif

                    <a class="collapse-item" href="{{ route('role.index') }}">All Roles </a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->can('roles_permission.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRolesPermissions"
                aria-expanded="true" aria-controls="collapseRolesPermissions">
                <i class="fa fa-briefcase" aria-hidden="true"></i>
                <span>Roles Permissions</span>
            </a>
            <div id="collapseRolesPermissions" class="collapse" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (Auth::user()->can('roles_permission.add'))
                        <a class="collapse-item" href="{{ route('roles-permission.create') }}">Add Roles Permissions
                        </a>
                    @endif

                    <a class="collapse-item" href="{{ route('roles-permission.index') }}">All Roles Permissions </a>
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->can('admin.view'))
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin"
                aria-expanded="true" aria-controls="collapseAdmin">
                <i class="fa fa-briefcase" aria-hidden="true"></i>
                <span>Admin</span>
            </a>
            <div id="collapseAdmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @if (Auth::user()->can('admin.add'))
                        <a class="collapse-item" href="{{ route('admin.create') }}">Add Admin </a>
                    @endif
                    <a class="collapse-item" href="{{ route('admin.index') }}">All Admins </a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">
    @endif
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
