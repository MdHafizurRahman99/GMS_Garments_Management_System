@extends('layouts.admin.master')

@section('title', 'User Profile')

@section('css')
    <!-- Add any additional CSS here -->
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> Profile </h1>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> --}}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> --}}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="d-flex align-items-center mb-4">
                            <div class="position-relative mr-3">
                                {{-- <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : asset('img/undraw_profile.svg') }}" --}}
                                <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('img/undraw_profile.svg') }}"
                                    alt="Profile Picture" class="img-profile rounded-circle"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div>
                                <h4 class="mb-1">{{ $user->name }}</h4>
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#editProfileModal">
                            <span class="icon text-white-50">
                                <i class="fas fa-edit"></i>
                            </span>
                            <span class="text">Edit Profile</span>
                        </button>
                    </div>
                </div>

                <!-- Change Password Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user-profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user-profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" class="form-control-file @error('profile_picture') is-invalid @enderror"
                                id="profile_picture" name="profile_picture" accept="image/*">
                            @error('profile_picture')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" readonly
                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="HourlyRate">Hourly Rate</label>
                            <input type="number" step="0.01"
                                class="form-control @error('HourlyRate') is-invalid @enderror" id="HourlyRate"
                                name="HourlyRate" value="{{ old('HourlyRate', $user->HourlyRate) }}">
                            @error('HourlyRate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Salary">Salary</label>
                            <input type="number" step="0.01"
                                class="form-control @error('Salary') is-invalid @enderror" id="Salary" name="Salary"
                                value="{{ old('Salary', $user->Salary) }}">
                            @error('Salary')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="BankAccountNumber">Bank Account Number</label>
                            <input type="text" class="form-control @error('BankAccountNumber') is-invalid @enderror"
                                id="BankAccountNumber" name="BankAccountNumber"
                                value="{{ old('BankAccountNumber', $user->BankAccountNumber) }}">
                            @error('BankAccountNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="TaxFileNumber">Tax File Number</label>
                            <input type="text" class="form-control @error('TaxFileNumber') is-invalid @enderror"
                                id="TaxFileNumber" name="TaxFileNumber"
                                value="{{ old('TaxFileNumber', $user->TaxFileNumber) }}">
                            @error('TaxFileNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Check for errors and show modal if needed
            @if ($errors->any())
                $('#editProfileModal').modal('show');
            @endif

            // Log to console for debugging
            console.log('User profile script loaded');
        });
    </script>
@endsection
