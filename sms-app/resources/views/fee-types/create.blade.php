@extends('layouts.app')

@section('title', 'Add Fee Type | EduCore SMS')
@section('page_title', 'Add Fee Type')
@section('breadcrumb', '/ Fees / Fee Types / Add')

@section('content')
    <div class="data-card" style="max-width:600px;margin:0 auto;">
        <div class="card-title">Fee Type Information</div>
        <form action="{{ route('admin.fee-types.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="name">Fee Type Name</label>
                <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Monthly Tuition, Admission Fee" required>
                @error('name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:.75rem;cursor:pointer;">
                    <input type="checkbox" name="is_recurring" value="1" @checked(old('is_recurring', true)) style="width:1.2rem;height:1.2rem;">
                    <span style="font-weight:600;">Is Recurring Fee</span>
                </label>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="frequency">Frequency</label>
                <select class="filter-select @error('frequency') is-invalid @enderror" id="frequency" name="frequency" required>
                    <option value="monthly" @selected(old('frequency') === 'monthly')>Monthly</option>
                    <option value="quarterly" @selected(old('frequency') === 'quarterly')>Quarterly</option>
                    <option value="half_yearly" @selected(old('frequency') === 'half_yearly')>Half Yearly</option>
                    <option value="yearly" @selected(old('frequency') === 'yearly')>Yearly</option>
                    <option value="one_time" @selected(old('frequency') === 'one_time')>One-time</option>
                </select>
                @error('frequency') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save Fee Type</button>
                <a class="btn-outline-sms" href="{{ route('admin.fee-types.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
