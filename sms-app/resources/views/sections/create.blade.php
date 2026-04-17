@extends('layouts.app')

@section('title', 'Add Section | EduCore SMS')
@section('page_title', 'Add Section')
@section('breadcrumb', '/ Academic Setup / Sections / Add')

@section('content')
    <div class="data-card" style="max-width:600px;margin:0 auto;">
        <div class="card-title">Section Information</div>
        <form action="{{ route('admin.sections.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="school_class_id">Class</label>
                <select class="filter-select @error('school_class_id') is-invalid @enderror" id="school_class_id" name="school_class_id" required>
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected(old('school_class_id') == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
                @error('school_class_id') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="name">Section Name</label>
                <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. A, Blue, Rose" required>
                @error('name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="capacity">Capacity</label>
                <input class="form-control-sms @error('capacity') is-invalid @enderror" type="number" id="capacity" name="capacity" value="{{ old('capacity', 0) }}" min="0" required>
                <div style="color:var(--text-light);font-size:.75rem;margin-top:.35rem;">Maximum number of students in this section.</div>
                @error('capacity') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save Section</button>
                <a class="btn-outline-sms" href="{{ route('admin.sections.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
