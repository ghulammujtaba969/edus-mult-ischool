@extends('layouts.app')

@section('title', 'Edit Plan | SaaS Admin')
@section('page_title', 'Edit Subscription Plan')
@section('breadcrumb', '/ Super Admin / Plans / Edit')

@section('content')
    <div class="data-card" style="max-width:1000px;margin:0 auto;">
        <div class="card-title">Edit Plan: {{ $plan->name }}</div>
        <form action="{{ route('super-admin.plans.update', $plan) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms">Plan Name</label>
                    <input type="text" name="name" class="form-control-sms @error('name') is-invalid @enderror" value="{{ old('name', $plan->name) }}" required>
                    @error('name') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Monthly Price (PKR)</label>
                    <input type="number" step="0.01" name="monthly_price" class="form-control-sms @error('monthly_price') is-invalid @enderror" value="{{ old('monthly_price', $plan->monthly_price) }}" required>
                    @error('monthly_price') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms">Max Branches</label>
                    <input type="number" name="max_branches" class="form-control-sms @error('max_branches') is-invalid @enderror" value="{{ old('max_branches', $plan->max_branches) }}" required>
                    @error('max_branches') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div style="display:flex;align-items:center;padding-top:1.5rem;">
                    <label style="display:flex;gap:.5rem;align-items:center;cursor:pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                        <span>Active Plan</span>
                    </label>
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" style="font-size: 1.1rem; margin-bottom: 1rem; display: block; font-weight: 700;">Update Plan Features</label>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 2rem;">
                    @foreach($availableFeatures as $category => $features)
                        <div>
                            <div style="font-weight: 700; color: var(--primary); margin-bottom: 0.8rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.3rem;">
                                {{ $category }}
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                @foreach($features as $key => $label)
                                    <label style="display: flex; gap: 0.5rem; align-items: center; cursor: pointer; font-size: 0.9rem;">
                                        <input type="checkbox" name="features[]" value="{{ $key }}" 
                                            @checked(is_array(old('features', $plan->features)) && in_array($key, old('features', $plan->features)))>
                                        <span>{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div style="display:flex;gap:1rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                <button type="submit" class="btn-primary-sms"><i class="bi bi-save"></i> Update Plan</button>
                <a href="{{ route('super-admin.plans.index') }}" class="btn-outline-sms">Cancel</a>
            </div>
        </form>
    </div>
@endsection
