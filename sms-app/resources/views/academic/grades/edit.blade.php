@extends('layouts.app')

@section('title', 'Edit Grade Scale | EduCore SMS')
@section('page_title', 'Update Grading Scale')
@section('breadcrumb', '/ Examinations / Grading Scales / Edit')

@section('content')
    <div class="data-card" style="max-width:700px;margin:0 auto;">
        <div class="card-title">Scale Information</div>
        <form action="{{ route('admin.grade-scales.update', $gradeScale) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms">Grade Name</label>
                <input type="text" name="name" class="form-control-sms @error('name') is-invalid @enderror" value="{{ old('name', $gradeScale->name) }}" placeholder="e.g. Excellent / Outstanding" required>
                @error('name') <div class="text-danger-sms">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms">Min Percentage (%)</label>
                    <input type="number" name="min_percent" class="form-control-sms @error('min_percent') is-invalid @enderror" value="{{ old('min_percent', $gradeScale->min_percent) }}" step="0.01" min="0" max="100" required>
                    @error('min_percent') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Max Percentage (%)</label>
                    <input type="number" name="max_percent" class="form-control-sms @error('max_percent') is-invalid @enderror" value="{{ old('max_percent', $gradeScale->max_percent) }}" step="0.01" min="0" max="100" required>
                    @error('max_percent') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms">Grade Point (A+, A, B, etc.)</label>
                    <input type="text" name="grade" class="form-control-sms @error('grade') is-invalid @enderror" value="{{ old('grade', $gradeScale->grade) }}" placeholder="e.g. A+" required>
                    @error('grade') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">GPA Value (0.00 - 4.00)</label>
                    <input type="number" name="gpa_value" class="form-control-sms @error('gpa_value') is-invalid @enderror" value="{{ old('gpa_value', $gradeScale->gpa_value) }}" step="0.01" min="0" max="10" required>
                    @error('gpa_value') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms">Remarks</label>
                <textarea name="remarks" class="form-control-sms" rows="3">{{ old('remarks', $gradeScale->remarks) }}</textarea>
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary-sms"><i class="bi bi-save"></i> Update Scale</button>
                <a href="{{ route('admin.grade-scales.index') }}" class="btn-outline-sms">Cancel</a>
            </div>
        </form>
    </div>
@endsection
