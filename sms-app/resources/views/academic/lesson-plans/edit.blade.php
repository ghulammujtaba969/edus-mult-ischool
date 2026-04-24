@extends('layouts.app')

@section('title', 'Edit Lesson Plan | EduCore SMS')
@section('page_title', 'Edit Lesson Plan')
@section('breadcrumb', '/ Academics / Lesson Plans / Edit')

@section('content')
    <div class="data-card" style="max-width:800px;margin:0 auto;">
        <div class="card-title">Lesson Plan Information</div>
        <form action="{{ route('admin.lesson-plans.update', $lessonPlan) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="school_class_id">Class</label>
                    <select class="form-control-sms @error('school_class_id') is-invalid @enderror" id="school_class_id" name="school_class_id" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" @selected(old('school_class_id', $lessonPlan->school_class_id) == $class->id)>{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('school_class_id') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="subject_id">Subject</label>
                    <select class="form-control-sms @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected(old('subject_id', $lessonPlan->subject_id) == $subject->id)>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="lesson_name">Lesson Name / Topic</label>
                <input class="form-control-sms @error('lesson_name') is-invalid @enderror" type="text" id="lesson_name" name="lesson_name" value="{{ old('lesson_name', $lessonPlan->lesson_name) }}" placeholder="e.g. Introduction to Algebra" required>
                @error('lesson_name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="date">Date</label>
                    <input class="form-control-sms @error('date') is-invalid @enderror" type="date" id="date" name="date" value="{{ old('date', $lessonPlan->date->format('Y-m-d')) }}" required>
                    @error('date') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="time_from">Time From</label>
                    <input class="form-control-sms @error('time_from') is-invalid @enderror" type="time" id="time_from" name="time_from" value="{{ old('time_from', $lessonPlan->time_from) }}">
                    @error('time_from') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="time_to">Time To</label>
                    <input class="form-control-sms @error('time_to') is-invalid @enderror" type="time" id="time_to" name="time_to" value="{{ old('time_to', $lessonPlan->time_to) }}">
                    @error('time_to') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="lecture_youtube_url">Lecture YouTube URL (Optional)</label>
                <input class="form-control-sms @error('lecture_youtube_url') is-invalid @enderror" type="url" id="lecture_youtube_url" name="lecture_youtube_url" value="{{ old('lecture_youtube_url', $lessonPlan->lecture_youtube_url) }}" placeholder="https://youtube.com/watch?v=...">
                @error('lecture_youtube_url') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Update Lesson Plan</button>
                <a class="btn-outline-sms" href="{{ route('admin.lesson-plans.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
