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
                        <li class="breadcrumb-item active" aria-current="page">Add New User</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Create User Account</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0">
    <form action="{{ route('super-admin.users.store') }}" method="POST" class="has-sticky-bar">
        @csrf
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
                                       value="{{ old('name') }}" required placeholder="e.g. John Doe">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-sms">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control-sms @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required placeholder="e.g. john@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row" x-data="{
                            showPass: false,
                            generatePass() {
                                const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                const lower = 'abcdefghijklmnopqrstuvwxyz';
                                const numbers = '0123456789';
                                const special = '!@#$%^&*()_+-=[]{}|;:,.<>?';

                                let pass = [
                                    upper.charAt(Math.floor(Math.random() * upper.length)),
                                    lower.charAt(Math.floor(Math.random() * lower.length)),
                                    numbers.charAt(Math.floor(Math.random() * numbers.length)),
                                    special.charAt(Math.floor(Math.random() * special.length))
                                ];

                                const allChars = upper + lower + numbers + special;
                                for (let i = 0; i < 8; i++) {
                                    pass.push(allChars.charAt(Math.floor(Math.random() * allChars.length)));
                                }

                                pass = pass.sort(() => Math.random() - 0.5).join('');

                                $refs.userPass.value = pass;
                                $refs.confirmPass.value = pass;
                                this.copyToClipboard(pass);
                            },
                            copyToClipboard(text) {
                                if (!text) return;
                                if (navigator.clipboard && window.isSecureContext) {
                                    navigator.clipboard.writeText(text).then(() => {
                                        this.showToast('Password generated and copied to clipboard!');
                                    }).catch(err => {
                                        this.fallbackCopy(text);
                                    });
                                } else {
                                    this.fallbackCopy(text);
                                }
                            },
                            fallbackCopy(text) {
                                const textArea = document.createElement('textarea');
                                textArea.value = text;
                                textArea.style.position = 'fixed';
                                textArea.style.left = '-9999px';
                                textArea.style.top = '0';
                                document.body.appendChild(textArea);
                                textArea.focus();
                                textArea.select();
                                try {
                                    document.execCommand('copy');
                                    this.showToast('Password generated and copied to clipboard!');
                                } catch (err) {
                                    this.showToast('Password generated, but could not copy automatically.', 'warning');
                                }
                                document.body.removeChild(textArea);
                            },
                            showToast(message, type = 'success') {
                                // Assuming a toast helper exists, if not, alert is fallback
                                alert(message);
                            }
                        }">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-sms">Password <span class="text-danger">*</span></label>
                                <div class="password-group-sms">
                                    <input :type="showPass ? 'text' : 'password'"
                                           name="password"
                                           x-ref="userPass"
                                           class="form-control-sms @error('password') is-invalid @enderror"
                                           required
                                           placeholder="Minimum 8 characters">
                                    <div class="password-actions-sms">
                                        <button type="button" class="password-btn-sms" @click="showPass = !showPass" title="Toggle Visibility">
                                            <i class="bi" :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i>
                                        </button>
                                        <button type="button" class="password-btn-sms text-primary" @click="generatePass()" title="Generate & Copy">
                                            <i class="bi bi-magic"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-sms">Confirm Password <span class="text-danger">*</span></label>
                                <input :type="showPass ? 'text' : 'password'"
                                       name="password_confirmation"
                                       x-ref="confirmPass"
                                       class="form-control-sms"
                                       required
                                       placeholder="Repeat password">
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
                                        <option value="{{ $school->id }}" @selected(old('school_id', $selectedSchoolId) == $school->id)>{{ $school->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted mt-1 d-block">Assign to a school or keep blank for super admin access.</small>
                                @error('school_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-sms">System Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control-sms @error('role') is-invalid @enderror" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->value }}" @selected(old('role', $selectedRole) == $role->value)>{{ $role->label() }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-3 rounded bg-light border">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="is_active" id="is_active" value="1" @checked(old('is_active', true))>
                                <label class="custom-control-label font-weight-bold text-dark cursor-pointer" for="is_active">Active Account</label>
                            </div>
                            <p class="text-muted small mb-0 mt-1 ml-4 pl-1">
                                Inactive users cannot log into the platform. You can change this status at any time.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Tips Sidebar -->
                <div class="card-sms shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-lightbulb mr-2"></i> User Tips
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h6 class="font-weight-bold small">Platform Access</h6>
                            <p class="text-muted small">Platform-wide users have access to all global settings and configurations, while school-assigned users are restricted to their specific school data.</p>
                        </div>
                        <div class="mb-4">
                            <h6 class="font-weight-bold small">Password Security</h6>
                            <p class="text-muted small">Use the <i class="bi bi-magic text-primary"></i> magic wand to generate a strong, secure password automatically. It will be copied to your clipboard.</p>
                        </div>
                        <div class="mb-0 p-3 bg-light rounded border-left border-primary">
                            <p class="text-dark small mb-0">
                                <i class="bi bi-info-circle-fill text-primary mr-1"></i>
                                Ensure the email address is correct as it will be used for login and password resets.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Save Bar -->
        <div class="sticky-save-bar">
            <div class="container-fluid d-flex justify-content-end align-items-center gap-2">
                <span class="text-muted small d-none d-md-inline mr-3">All fields marked with <span class="text-danger">*</span> are required</span>
                <a href="{{ route('super-admin.users.index') }}" class="btn-outline-sms px-4">Cancel</a>
                <button type="submit" class="btn-primary-sms px-5">
                    <i class="bi bi-person-plus mr-2"></i> Create User Account
                </button>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .password-group-sms {
        position: relative;
    }
    .password-actions-sms {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        gap: 5px;
    }
    .password-btn-sms {
        background: none;
        border: none;
        color: #64748b;
        padding: 5px;
        cursor: pointer;
        transition: color 0.2s;
    }
    .password-btn-sms:hover {
        color: var(--primary);
    }
    .has-sticky-bar {
        padding-bottom: 80px;
    }
</style>
@endpush
@endsection
