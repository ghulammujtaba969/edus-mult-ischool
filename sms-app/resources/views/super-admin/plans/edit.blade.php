@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.plans.index') }}">Subscription Plans</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Edit Subscription Plan: {{ $plan->name }}</h1>
                <p class="text-muted small mb-0 mt-1">Modify pricing, capacity, and feature entitlements for this package.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('super-admin.plans.index') }}" class="btn-outline-sms px-4">
                    <i class="bi bi-arrow-left mr-2"></i> Back to Plans
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0">
    <form action="{{ route('super-admin.plans.update', $plan) }}" method="POST" class="has-sticky-bar">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-info-circle mr-2"></i> Plan Details
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label for="name" class="form-label-sms">Plan Display Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control-sms @error('name') is-invalid @enderror"
                                   value="{{ old('name', $plan->name) }}" placeholder="e.g. Enterprise Plan" required autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="monthly_price" class="form-label-sms">Monthly Subscription Fee (PKR) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-right-0">PKR</span>
                                    <input type="number" step="0.01" name="monthly_price" id="monthly_price"
                                           class="form-control-sms border-left-0 @error('monthly_price') is-invalid @enderror"
                                           value="{{ old('monthly_price', $plan->monthly_price) }}" placeholder="0.00" required>
                                </div>
                                @error('monthly_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="max_branches" class="form-label-sms">Branch Capacity Limit <span class="text-danger">*</span></label>
                                <input type="number" name="max_branches" id="max_branches"
                                       class="form-control-sms @error('max_branches') is-invalid @enderror"
                                       value="{{ old('max_branches', $plan->max_branches) }}" required>
                                @error('max_branches') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="form-check form-switch custom-switch-sms">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" @checked(old('is_active', $plan->is_active))>
                                <label class="form-check-label font-weight-bold text-dark cursor-pointer" for="is_active">Plan Availability</label>
                                <small class="d-block text-muted">Inactive plans are hidden from the public registration and upgrade options.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-sms shadow-sm mb-5">
                    <div class="card-header-sms py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-list-check mr-2"></i> Feature Entitlements
                        </h6>
                        <span class="text-muted small">Select modules available in this plan</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            @foreach($availableFeatures as $category => $features)
                                <div class="col-md-6 mb-4">
                                    <h6 class="text-dark font-weight-bold border-bottom pb-2 mb-3">
                                        <i class="bi bi-folder2-open text-primary mr-2 small"></i> {{ $category }}
                                    </h6>
                                    <div class="feature-list">
                                        @foreach($features as $key => $label)
                                            <div class="form-check custom-check-sms mb-2">
                                                <input class="form-check-input" type="checkbox" name="features[]"
                                                       value="{{ $key }}" id="feat-{{ $key }}"
                                                       @checked(is_array(old('features', $plan->features)) && in_array($key, old('features', $plan->features)))>
                                                <label class="form-check-label text-muted small cursor-pointer" for="feat-{{ $key }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-sms shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-info-circle mr-2"></i> Metadata
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="metadata-item mb-4">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Creation Date</label>
                            <div class="small font-weight-bold text-dark">
                                <i class="bi bi-calendar-event mr-1"></i>
                                {{ $plan->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="metadata-item mb-4">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Last Modification</label>
                            <div class="small font-weight-bold text-dark">
                                <i class="bi bi-clock-history mr-1"></i>
                                {{ $plan->updated_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="metadata-item mb-0">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Current Usage</label>
                            <div class="small font-weight-bold text-dark">
                                <i class="bi bi-building mr-1"></i>
                                {{ $plan->schools_count ?? 0 }} Schools Subscribed
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky-save-bar">
            <div class="container-fluid d-flex justify-content-end align-items-center gap-2">
                <span class="text-muted small d-none d-md-inline mr-3">Pricing changes apply to new billing cycles for existing schools</span>
                <button type="submit" class="btn-primary-sms px-5 shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i> Update Subscription Plan
                </button>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .has-sticky-bar { padding-bottom: 80px; }
    .custom-switch-sms .form-check-input { width: 2.5rem; height: 1.25rem; cursor: pointer; }
    .custom-check-sms .form-check-input { width: 1.1rem; height: 1.1rem; margin-top: 0.1rem; cursor: pointer; }
    .feature-list { max-height: 300px; overflow-y: auto; padding-right: 5px; }
    .feature-list::-webkit-scrollbar { width: 4px; }
    .feature-list::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 10px; }
</style>
@endpush
@endsection
