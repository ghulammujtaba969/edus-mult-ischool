@extends('layouts.app')

@section('title', 'Edit School | EduCore SaaS')
@section('page_title', 'Edit School: ' . $school->name)
@section('breadcrumb', '/ Super Admin / Schools / Edit')

@section('content')
    <div class="data-card" style="max-width:800px;margin:0 auto;">
        <div class="card-title">School Information</div>
        <form action="{{ route('super-admin.schools.update', $school) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms">School Name</label>
                    <input type="text" name="name" class="form-control-sms @error('name') is-invalid @enderror" value="{{ old('name', $school->name) }}" required>
                    @error('name') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Slug (Immutable)</label>
                    <input type="text" class="form-control-sms" value="{{ $school->slug }}" disabled style="background-color: var(--bg-light);">
                    <div class="muted" style="font-size: 0.8rem; margin-top: 0.3rem;">Slug cannot be changed after registration.</div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms">Subscription Plan</label>
                    <select name="plan_id" class="form-control-sms @error('plan_id') is-invalid @enderror" required>
                        <option value="">-- Select Plan --</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" @selected(old('plan_id', $school->plan_id) == $plan->id)>{{ $plan->name }} ({{ $plan->max_branches }} Branches)</option>
                        @endforeach
                    </select>
                    @error('plan_id') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Current Status</label>
                    <select name="status" class="form-control-sms @error('status') is-invalid @enderror" required>
                        <option value="active" @selected(old('status', $school->status) == 'active')>Active</option>
                        <option value="pending" @selected(old('status', $school->status) == 'pending')>Pending</option>
                        <option value="suspended" @selected(old('status', $school->status) == 'suspended')>Suspended</option>
                    </select>
                    @error('status') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary-sms"><i class="bi bi-save"></i> Update School</button>
                <a href="{{ route('super-admin.schools.index') }}" class="btn-outline-sms">Cancel</a>
            </div>
        </form>
    </div>
@endsection
