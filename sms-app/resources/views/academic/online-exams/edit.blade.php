@extends('layouts.app')

@section('title', 'Edit Online Exam | EduCore SMS')
@section('page_title', 'Edit Online Exam')
@section('breadcrumb', '/ Academics / Online Exams / Edit')

@section('content')
    <div class="data-card" style="max-width:800px;margin:0 auto;">
        <div class="card-title">Online Exam Information</div>
        <form action="{{ route('admin.online-exams.update', $onlineExam) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="exam_title">Exam Title</label>
                <input class="form-control-sms @error('exam_title') is-invalid @enderror" type="text" id="exam_title" name="exam_title" value="{{ old('exam_title', $onlineExam->exam_title) }}" placeholder="e.g. Midterm Computer Science" required>
                @error('exam_title') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="exam_from">Exam From</label>
                    <input class="form-control-sms @error('exam_from') is-invalid @enderror" type="datetime-local" id="exam_from" name="exam_from" value="{{ old('exam_from', $onlineExam->exam_from->format('Y-m-d\TH:i')) }}" required>
                    @error('exam_from') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="exam_to">Exam To</label>
                    <input class="form-control-sms @error('exam_to') is-invalid @enderror" type="datetime-local" id="exam_to" name="exam_to" value="{{ old('exam_to', $onlineExam->exam_to->format('Y-m-d\TH:i')) }}" required>
                    @error('exam_to') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms" for="duration_minutes">Duration (Minutes)</label>
                    <input class="form-control-sms @error('duration_minutes') is-invalid @enderror" type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', $onlineExam->duration_minutes) }}" min="1" required>
                    @error('duration_minutes') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="minimum_percentage">Minimum Passing Percentage</label>
                    <input class="form-control-sms @error('minimum_percentage') is-invalid @enderror" type="number" id="minimum_percentage" name="minimum_percentage" value="{{ old('minimum_percentage', $onlineExam->minimum_percentage) }}" min="0" max="100" step="0.1" required>
                    @error('minimum_percentage') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="is_active">Status</label>
                <select class="form-control-sms @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                    <option value="1" @selected(old('is_active', $onlineExam->is_active) == 1)>Active</option>
                    <option value="0" @selected(old('is_active', $onlineExam->is_active) == 0)>Inactive</option>
                </select>
                @error('is_active') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Update Exam</button>
                <a class="btn-outline-sms" href="{{ route('admin.online-exams.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
