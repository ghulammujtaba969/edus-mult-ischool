@extends('layouts.app')

@section('title', 'Add Academic Year | EduCore SMS')
@section('page_title', 'Add Academic Year')
@section('breadcrumb', '/ Academic Setup / Academic Years / Add')

@section('content')
    <div class="data-card" style="max-width:600px;margin:0 auto;">
        <div class="card-title">Academic Year Information</div>
        <form action="{{ route('admin.academic-years.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="name">Academic Year Name</label>
                <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. 2024-2025" required>
                @error('name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="start_date">Start Date</label>
                    <input class="form-control-sms @error('start_date') is-invalid @enderror" type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                    @error('start_date') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="end_date">End Date</label>
                    <input class="form-control-sms @error('end_date') is-invalid @enderror" type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                    @error('end_date') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label style="display:flex;align-items:center;gap:.75rem;cursor:pointer;">
                    <input type="checkbox" name="is_current" value="1" @checked(old('is_current')) style="width:1.2rem;height:1.2rem;">
                    <span style="font-weight:600;">Set as Current Academic Year</span>
                </label>
                <div style="color:var(--text-light);font-size:.75rem;margin-top:.35rem;margin-left:2rem;">Only one year can be current at a time. This will deactivate the previous current year.</div>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save Year</button>
                <a class="btn-outline-sms" href="{{ route('admin.academic-years.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
