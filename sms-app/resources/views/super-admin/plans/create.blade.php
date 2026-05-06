@extends('layouts.app')

@section('title', 'Create Plan | SaaS Admin')
@section('page_title', 'Create Subscription Plan')
@section('breadcrumb', '/ Super Admin / Plans / Create')

@section('content')
<div class="container-fluid has-sticky-bar">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Create Subscription Plan</h1>
            <p class="text-muted small mb-0">Define pricing and feature sets for a new subscription package.</p>
        </div>
        <a href="{{ route('super-admin.plans.index') }}" class="btn-secondary-sms shadow-sm">
            <i class="bi bi-arrow-left"></i> Back to Plans
        </a>
    </div>

    <form action="{{ route('super-admin.plans.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-info-circle mr-2"></i> Plan Information
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label font-weight-bold">Plan Name</label>
                                <input type="text" name="name" id="name" class="form-control-sms @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" placeholder="e.g. Enterprise Plan" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="monthly_price" class="form-label font-weight-bold">Monthly Price (PKR)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-right-0">PKR</span>
                                    <input type="number" step="0.01" name="monthly_price" id="monthly_price" 
                                           class="form-control-sms border-left-0 @error('monthly_price') is-invalid @enderror" 
                                           value="{{ old('monthly_price') }}" placeholder="0.00" required>
                                </div>
                                @error('monthly_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="max_branches" class="form-label font-weight-bold">Max Branches</label>
                                <input type="number" name="max_branches" id="max_branches" 
                                       class="form-control-sms @error('max_branches') is-invalid @enderror" 
                                       value="{{ old('max_branches', 1) }}" required>
                                @error('max_branches') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-0 mt-2">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                                <label class="custom-control-label font-weight-bold text-dark" for="is_active">Mark this plan as Active</label>
                                <small class="d-block text-muted">Inactive plans cannot be selected for new school subscriptions.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-sms shadow-sm mb-5">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-list-check mr-2"></i> Included Features
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            @foreach($availableFeatures as $category => $features)
                                <div class="col-md-6 mb-4">
                                    <h6 class="text-dark font-weight-bold border-bottom pb-2 mb-3">
                                        {{ $category }}
                                    </h6>
                                    <div class="feature-list">
                                        @foreach($features as $key => $label)
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" class="custom-control-input" name="features[]" 
                                                       value="{{ $key }}" id="feat-{{ $key }}"
                                                       @checked(is_array(old('features')) && in_array($key, old('features')))>
                                                <label class="custom-control-label text-muted small cursor-pointer" for="feat-{{ $key }}">
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
                            <i class="bi bi-lightbulb mr-2"></i> Plan Tips
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="small text-muted mb-1 d-block">Pricing Strategy</label>
                            <p class="small mb-0">Consider offering tiered features to encourage upgrades. Enterprise plans usually include all features.</p>
                        </div>
                        <div class="mb-4">
                            <label class="small text-muted mb-1 d-block">Branch Limits</label>
                            <p class="small mb-0">Set branch limits carefully. Each branch uses system resources and affects performance.</p>
                        </div>
                        <div class="mb-0">
                            <label class="small text-muted mb-1 d-block">Feature Set</label>
                            <p class="small mb-0">Features selected here will be available to all schools subscribed to this plan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky-save-bar">
            <div class="container-fluid d-flex justify-content-end align-items-center gap-2">
                <span class="text-muted small d-none d-md-inline mr-2">Ensure all plan details are correct before saving</span>
                <a href="{{ route('super-admin.plans.index') }}" class="btn-outline-sms">Cancel</a>
                <button type="submit" class="btn-primary-sms px-5">
                    <i class="bi bi-check-lg"></i> Create Plan
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    .feature-list {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 10px;
    }
    .feature-list::-webkit-scrollbar {
        width: 4px;
    }
    .feature-list::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 10px;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endsection
