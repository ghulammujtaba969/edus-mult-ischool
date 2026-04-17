@extends('layouts.app')

@section('title', 'Mark Entry | EduCore SMS')
@section('page_title', 'Mark Entry')
@section('breadcrumb', '/ Exams / Marks')

@section('content')
    <div class="data-card">
        <div class="card-title">Select Exam & Subject</div>
        <form action="{{ route('admin.marks.create') }}" method="GET">
            <div class="info-grid-2" style="margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms" for="exam_id">Select Exam</label>
                    <select class="filter-select" id="exam_id" name="exam_id" required>
                        <option value="">Select Exam Schedule</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->schoolClass->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="subject_id">Select Subject</label>
                    <select class="filter-select" id="subject_id" name="subject_id" required>
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }} @if($subject->code) ({{ $subject->code }}) @endif</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-pencil-square"></i> Enter Marks</button>
        </form>
    </div>

    <div class="data-card" style="margin-top:2rem;">
        <div class="card-title">Recent Marks Entry</div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Exam</th>
                <th>Student</th>
                <th>Subject</th>
                <th>Marks</th>
                <th>Status</th>
                <th>Entered By</th>
            </tr>
            </thead>
            <tbody>
            @forelse($marks as $mark)
                <tr>
                    <td style="font-weight:700;">{{ $mark->exam->name }}</td>
                    <td style="font-weight:700;">{{ $mark->student->user->name }}</td>
                    <td><span class="status-pill pill-active">{{ $mark->subject->name }}</span></td>
                    <td class="mono">
                        @if($mark->is_absent)
                            <span style="color:var(--danger);">ABSENT</span>
                        @else
                            <strong>{{ $mark->obtained_marks }}</strong> / {{ $mark->total_marks }}
                        @endif
                    </td>
                    <td>
                        <span class="status-pill {{ $mark->obtained_marks / max($mark->total_marks, 1) >= 0.33 ? 'pill-active' : 'pill-inactive' }}">
                            {{ $mark->obtained_marks / max($mark->total_marks, 1) >= 0.33 ? 'Pass' : 'Fail' }}
                        </span>
                    </td>
                    <td class="muted"><i class="bi bi-person"></i> System</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No marks recorded yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="data-footer">
            {{ $marks->links() }}
        </div>
    </div>
@endsection
