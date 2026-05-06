@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Platform Settings</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Platform Settings</h1>
                <p class="text-muted small mb-0 mt-1">Configure global platform behavior, branding, and operational parameters.</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill mr-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('super-admin.settings.update') }}" method="POST" class="has-sticky-bar">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-gear-wide-connected mr-2"></i> General Configuration
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-sms">Platform Name <span class="text-danger">*</span></label>
                                <input type="text" name="platform_name" class="form-control-sms @error('platform_name') is-invalid @enderror"
                                       value="{{ old('platform_name', $settings['platform_name'] ?? 'EduCore SaaS') }}" required>
                                @error('platform_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label-sms">Support Email <span class="text-danger">*</span></label>
                                <input type="email" name="support_email" class="form-control-sms @error('support_email') is-invalid @enderror"
                                       value="{{ old('support_email', $settings['support_email'] ?? 'support@educore.test') }}" required>
                                @error('support_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-sms">Default Trial Period (Days)</label>
                                <div class="input-group">
                                    <input type="number" name="trial_days" class="form-control-sms @error('trial_days') is-invalid @enderror"
                                           value="{{ old('trial_days', $settings['trial_days'] ?? 14) }}" min="0">
                                    <span class="input-group-text bg-light border-left-0 small">Days</span>
                                </div>
                                @error('trial_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="border-top pt-4 mt-2">
                            <div class="d-flex align-items-center p-3 rounded" style="background: rgba(231, 74, 59, 0.05); border: 1px solid rgba(231, 74, 59, 0.1);">
                                <div class="mr-3">
                                    <div class="form-check form-switch p-0 m-0" style="min-height: auto;">
                                        <input class="form-check-input ml-0" type="checkbox" name="maintenance_mode" id="maintenanceMode"
                                               value="1" @checked(old('maintenance_mode', $settings['maintenance_mode'] ?? '0') == '1')
                                               style="width: 40px; height: 20px; cursor: pointer;">
                                    </div>
                                </div>
                                <div>
                                    <label class="font-weight-bold text-danger mb-0 d-block" for="maintenanceMode" style="cursor: pointer;">Maintenance Mode</label>
                                    <p class="text-muted small mb-0">When enabled, only super admins can access the platform. All other users will see a maintenance page.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-shield-lock mr-2"></i> Security & Access
                        </h6>
                    </div>
                    <div class="card-body p-4 text-center py-5">
                        <i class="bi bi-shield-check display-4 text-muted opacity-25 mb-3 d-block"></i>
                        <p class="text-muted small mb-0">Advanced security settings like IP whitelisting and 2FA requirements will be available in a future update.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-sms shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-lightbulb mr-2"></i> Configuration Tips
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h6 class="font-weight-bold small text-dark">Platform Name</h6>
                            <p class="text-muted small mb-0">This name appears in emails, page titles, and throughout the system UI for all schools.</p>
                        </div>
                        <div class="mb-4">
                            <h6 class="font-weight-bold small text-dark">Support Email</h6>
                            <p class="text-muted small mb-0">Critical system notifications and support requests will be directed to this address.</p>
                        </div>
                        <div class="mb-0">
                            <h6 class="font-weight-bold small text-dark">Maintenance Mode</h6>
                            <p class="text-muted small mb-0 text-danger">Use with caution! This affects all school instances across the entire platform.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky-save-bar">
            <div class="container-fluid">
                <div class="card-sms shadow-lg border-0 p-3 bg-white d-flex flex-row align-items-center justify-content-between">
                    <div class="d-none d-md-flex align-items-center text-muted small">
                        <i class="bi bi-info-circle mr-2 text-primary"></i>
                        <span>System-wide changes will take effect immediately for all tenants.</span>
                    </div>
                    <div class="d-flex gap-2 ml-auto">
                        <button type="submit" class="btn-primary-sms px-5">
                            <i class="bi bi-save mr-2"></i> Save Configuration
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .has-sticky-bar {
        padding-bottom: 80px;
    }
    .form-switch .form-check-input {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
    }
    .form-switch .form-check-input:checked {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
    }
</style>
@endpush
@endsection

