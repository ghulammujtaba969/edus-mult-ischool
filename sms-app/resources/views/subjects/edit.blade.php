@extends('layouts.app')

@section('title', 'Edit Subject | EduCore SMS')
@section('page_title', 'Edit Subject')
@section('breadcrumb', '/ Academic Setup / Subjects / Edit')

@section('content')
    <div class="data-card" style="max-width:600px;margin:0 auto;">
        <div class="card-title">Subject Information</div>
        <form action="{{ route('admin.subjects.update', $subject) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="name">Subject Name</label>
                <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $subject->name) }}" placeholder="e.g. Mathematics, English" required>
                @error('name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="code">Subject Code (Optional)</label>
                <input class="form-control-sms @error('code') is-invalid @enderror" type="text" id="code" name="code" value="{{ old('code', $subject->code) }}" placeholder="e.g. MATH-101">
                @error('code') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="subject_type">Subject Type</label>
                <select class="filter-select @error('subject_type') is-invalid @enderror" id="subject_type" name="subject_type" required>
                    <option value="theory" @selected(old('subject_type', $subject->subject_type) === 'theory')>Theory</option>
                    <option value="practical" @selected(old('subject_type', $subject->subject_type) === 'practical')>Practical</option>
                    <option value="both" @selected(old('subject_type', $subject->subject_type) === 'both')>Both</option>
                </select>
                @error('subject_type') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:2rem;">
                <label style="display:flex;align-items:center;gap:.75rem;cursor:pointer;">
                    <input type="checkbox" name="is_optional" value="1" @checked(old('is_optional', $subject->is_optional)) style="width:1.2rem;height:1.2rem;">
                    <span style="font-weight:600;">Is Optional Subject</span>
                </label>
                <div style="color:var(--text-light);font-size:.75rem;margin-top:.35rem;margin-left:2rem;">Tick if students can choose whether to take this subject.</div>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Update Subject</button>
                <a class="btn-outline-sms" href="{{ route('admin.subjects.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
