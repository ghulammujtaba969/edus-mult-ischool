@extends('layouts.app')

@section('title', 'Add Hostel | EduCore SMS')
@section('page_title', 'Add Hostel')
@section('breadcrumb', '/ Hostel / Hostels / Add')

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.hostels.store') }}" method="POST">
            @csrf
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="name">Hostel Name</label>
                    <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="type">Hostel Type</label>
                    <select class="filter-select" id="type" name="type" required>
                        <option value="boys">Boys</option>
                        <option value="girls">Girls</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="city">City</label>
                    <input class="form-control-sms" type="text" id="city" name="city" value="{{ old('city') }}">
                </div>
                <div>
                    <label class="form-label-sms" for="capacity">Total Capacity</label>
                    <input class="form-control-sms" type="number" id="capacity" name="capacity" value="{{ old('capacity', 0) }}" required>
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="address">Address</label>
                <textarea class="form-control-sms" id="address" name="address" rows="3">{{ old('address') }}</textarea>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-save"></i> Save Hostel</button>
                <a class="btn-outline-sms" href="{{ route('admin.hostels.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
