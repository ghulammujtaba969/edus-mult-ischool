@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.subscriptions.index') }}">School Subscriptions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Manage Subscription: {{ $school->name }}</h1>
                <p class="text-muted small mb-0 mt-1">Adjust plan entitlements, billing status, and trial configurations for this school.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('super-admin.subscriptions.index') }}" class="btn-outline-sms px-4">
                    <i class="bi bi-arrow-left mr-2"></i> Back to Subscriptions
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0">
    <form action="{{ route('super-admin.subscriptions.update', $school) }}" method="POST" class="has-sticky-bar">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-info-circle mr-2"></i> Subscription Entitlements
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="plan_id" class="form-label-sms">Assigned Plan <span class="text-danger">*</span></label>
                                <select name="plan_id" id="plan_id" class="form-control-sms @error('plan_id') is-invalid @enderror" required>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" @selected(old('plan_id', $school->plan_id) == $plan->id)>
                                            {{ $plan->name }} (PKR {{ number_format($plan->monthly_price, 0) }}/mo)
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted mt-1 d-block">Plan determines branch limits and available modules.</small>
                                @error('plan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="status" class="form-label-sms">Subscription Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control-sms @error('status') is-invalid @enderror" required>
                                    <option value="active" @selected(old('status', $school->status) == 'active')>Active - Full Access</option>
                                    <option value="suspended" @selected(old('status', $school->status) == 'suspended')>Suspended - Access Denied</option>
                                    <option value="pending" @selected(old('status', $school->status) == 'pending')>Pending - Awaiting Activation</option>
                                </select>
                                <small class="text-muted mt-1 d-block">Suspended schools cannot access any system features.</small>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-0">
                                <label for="trial_ends_at" class="form-label-sms">Trial Period Expiry</label>
                                <input type="date" name="trial_ends_at" id="trial_ends_at"
                                       class="form-control-sms @error('trial_ends_at') is-invalid @enderror"
                                       value="{{ old('trial_ends_at', $school->trial_ends_at ? $school->trial_ends_at->format('Y-m-d') : '') }}">
                                <small class="text-muted mt-1 d-block">Leave blank to disable trial mode for this school.</small>
                                @error('trial_ends_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-shield-check mr-2"></i> Access Summary
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3 mb-md-0 border-right">
                                <div class="text-muted small mb-1">Max Branches</div>
                                <div class="h4 font-weight-bold text-dark mb-0">{{ $school->plan->max_branches }}</div>
                            </div>
                            <div class="col-md-4 text-center mb-3 mb-md-0 border-right">
                                <div class="text-muted small mb-1">Modules Included</div>
                                <div class="h4 font-weight-bold text-dark mb-0">{{ count($school->plan->features ?? []) }}</div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="text-muted small mb-1">Billing Rate</div>
                                <div class="h4 font-weight-bold text-primary mb-0">PKR {{ number_format($school->plan->monthly_price, 0) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-sms shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-building mr-2"></i> School Metadata
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="metadata-item mb-4">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Internal Name</label>
                            <div class="font-weight-bold text-dark">{{ $school->name }}</div>
                        </div>
                        <div class="metadata-item mb-4">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Platform URL</label>
                            <div class="mono small text-primary bg-light p-2 rounded border">
                                <a href="http://{{ $school->primaryDomain->domain ?? $school->slug . '.' . config('app.domain') }}" target="_blank" class="text-decoration-none">
                                    {{ $school->primaryDomain->domain ?? $school->slug . '.' . config('app.domain') }}
                                    <i class="bi bi-box-arrow-up-right ml-1 small"></i>
                                </a>
                            </div>
                        </div>
                        <div class="metadata-item mb-4">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Registration Date</label>
                            <div class="small font-weight-bold text-dark">
                                <i class="bi bi-calendar-check mr-1"></i>
                                {{ $school->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="metadata-item mb-0">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Subscription Age</label>
                            <div class="small font-weight-bold text-dark">
                                <i class="bi bi-hourglass-split mr-1"></i>
                                {{ $school->created_at->diffForHumans(null, true) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky-save-bar">
            <div class="container-fluid d-flex justify-content-end align-items-center gap-2">
                <span class="text-muted small d-none d-md-inline mr-3">Subscription updates trigger immediate access changes for the school</span>
                <button type="submit" class="btn-primary-sms px-5 shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i> Update Subscription
                </button>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .has-sticky-bar { padding-bottom: 80px; }
    .mono { font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; }
</style>
@endpush
@endsection
