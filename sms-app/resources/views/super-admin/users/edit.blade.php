@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="{{ route('super-admin.users.index') }}" class="btn-outline-sms rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Edit User Account</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0">
    <form action="{{ route('super-admin.users.update', $user) }}" method="POST" class="has-sticky-bar">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-8">
                <!-- User Basic Information -->
                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-person-badge mr-2"></i> Account Details
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-sms">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control-sms @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" required placeholder="e.g. John Doe">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-sms">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control-sms @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required placeholder="e.g. john@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-sms">New Password</label>
                                <input type="password" name="password" class="form-control-sms @error('password') is-invalid @enderror" 
                                       placeholder="Leave blank to keep current">
                                <small class="text-muted mt-1 d-block">Only fill this if you want to change the password.</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-sms">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control-sms" 
                                       placeholder="Repeat new password">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assignment & Status -->
                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-shield-lock mr-2"></i> Access & Assignment
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label-sms">School Assignment</label>
                                <select name="school_id" class="form-control-sms @error('school_id') is-invalid @enderror">
                                    <option value="">Platform Wide (No School)</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}" @selected(old('school_id', $user->school_id) == $school->id)>{{ $school->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted mt-1 d-block">Changing school assignment will affect user access.</small>
                                @error('school_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-sms">System Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control-sms @error('role') is-invalid @enderror" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->value }}" @selected(old('role', $user->role->value) == $role->value)>{{ $role->label() }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-3 rounded bg-light border">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="is_active" id="is_active" value="1" @checked(old('is_active', $user->is_active))>
                                <label class="custom-control-label font-weight-bold text-dark cursor-pointer" for="is_active">Active Account</label>
                            </div>
                            <p class="text-muted small mb-0 mt-1 ml-4 pl-1">
                                Inactive users cannot log into the platform.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- User Details Sidebar -->
                <div class="card-sms shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-info-circle mr-2"></i> User Details
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="small text-muted mb-1 d-block text-uppercase font-weight-bold" style="letter-spacing: 0.5px;">User ID</label>
                            <div class="mono small bg-light p-2 rounded border">#{{ $user->id }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="small text-muted mb-1 d-block text-uppercase font-weight-bold" style="letter-spacing: 0.5px;">Member Since</label>
                            <div class="small text-dark">{{ $user->created_at->format('M d, Y') }}</div>
                            <div class="tiny text-muted">{{ $user->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="small text-muted mb-1 d-block text-uppercase font-weight-bold" style="letter-spacing: 0.5px;">Last Updated</label>
                            <div class="small text-dark">{{ $user->updated_at->format('M d, Y H:i') }}</div>
                        </div>
                        <div class="mb-0 p-3 bg-light rounded border-left border-primary">
                            <p class="text-dark small mb-0">
                                <i class="bi bi-shield-check text-primary mr-1"></i>
                                Current Role: <span class="font-weight-bold">{{ $user->role->label() }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Save Bar -->
        <div class="sticky-save-bar">
            <div class="container-fluid d-flex justify-content-end align-items-center gap-2">
                <span class="text-muted small d-none d-md-inline mr-3">Updating user account for <strong>{{ $user->name }}</strong></span>
                <a href="{{ route('super-admin.users.index') }}" class="btn-outline-sms px-4">Cancel</a>
                <button type="submit" class="btn-primary-sms px-5">
                    <i class="bi bi-check-lg mr-2"></i> Update User Account
                </button>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .has-sticky-bar {
        padding-bottom: 80px;
    }
</style>
@endpush
@endsection

@endsection
