@extends('layouts.app')

@section('title', 'Add Alumni | EduCore SMS')
@section('page_title', 'Add Alumni Record')
@section('breadcrumb', '/ Alumni / Directory / Add')

@section('content')
    <div class="data-card" style="max-width:800px;margin:0 auto;">
        <div class="card-title">Alumni Information</div>
        <form action="{{ route('admin.alumni.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="name">Full Name</label>
                <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. John Doe" required>
                @error('name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="email">Email Address</label>
                    <input class="form-control-sms @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="john@example.com">
                    @error('email') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="phone">Phone Number</label>
                    <input class="form-control-sms @error('phone') is-invalid @enderror" type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1234567890">
                    @error('phone') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="graduation_year">Graduation Year</label>
                    <input class="form-control-sms @error('graduation_year') is-invalid @enderror" type="number" id="graduation_year" name="graduation_year" value="{{ old('graduation_year', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                    @error('graduation_year') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="student_id">Link to Student Record (Optional)</label>
                    <select class="form-control-sms @error('student_id') is-invalid @enderror" id="student_id" name="student_id">
                        <option value="">-- Not Linked --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>{{ $student->name }} (Graduated)</option>
                        @endforeach
                    </select>
                    @error('student_id') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms" for="current_occupation">Current Occupation</label>
                    <input class="form-control-sms @error('current_occupation') is-invalid @enderror" type="text" id="current_occupation" name="current_occupation" value="{{ old('current_occupation') }}" placeholder="e.g. Software Engineer">
                    @error('current_occupation') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="current_organization">Current Organization</label>
                    <input class="form-control-sms @error('current_organization') is-invalid @enderror" type="text" id="current_organization" name="current_organization" value="{{ old('current_organization') }}" placeholder="e.g. Google">
                    @error('current_organization') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save Alumni</button>
                <a class="btn-outline-sms" href="{{ route('admin.alumni.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
