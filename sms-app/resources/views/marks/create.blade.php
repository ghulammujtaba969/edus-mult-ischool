@extends('layouts.app')

@section('title', 'Mark Entry | EduCore SMS')
@section('page_title', 'Mark Entry')
@section('breadcrumb', '/ Exams / Marks / Entry')

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.marks.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
@endsection

@section('content')
    <div class="data-card">
        <div class="data-card-header" style="flex-direction:column;align-items:start;gap:.5rem;">
            <div style="font-size:1.2rem;font-weight:800;">{{ $exam->name }} ({{ $exam->schoolClass->name }})</div>
            <div class="muted"><i class="bi bi-book"></i> Subject: <strong>{{ $subject->name }}</strong></div>
        </div>

        <form action="{{ route('admin.marks.store') }}" method="POST">
            @csrf
            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
            <input type="hidden" name="subject_id" value="{{ $subject->id }}">

            <table class="sms-table">
                <thead>
                <tr>
                    <th style="width:80px;">Roll #</th>
                    <th>Student Name</th>
                    <th>Obtained Marks</th>
                    <th>Total Marks</th>
                    <th>Absent</th>
                    <th>Remarks</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    @php($mark = $existingMarks->get($student->id))
                    <tr>
                        <td class="mono">{{ $student->currentAcademicRecord->roll_no }}</td>
                        <td>
                            <div style="font-weight:700;">{{ $student->user->name }}</div>
                            <div class="student-reg">{{ $student->registration_no }}</div>
                        </td>
                        <td>
                            <input class="form-control-sms" type="number" step="0.01" name="marks[{{ $student->id }}][obtained]" value="{{ old("marks.{$student->id}.obtained", $mark?->obtained_marks) }}" style="width:100px;">
                        </td>
                        <td>
                            <input class="form-control-sms" type="number" step="0.01" name="marks[{{ $student->id }}][total]" value="{{ old("marks.{$student->id}.total", $mark?->total_marks ?? 100) }}" style="width:100px;" required>
                        </td>
                        <td style="text-align:center;">
                            <input type="checkbox" name="marks[{{ $student->id }}][is_absent]" value="1" @checked(old("marks.{$student->id}.is_absent", $mark?->is_absent)) style="width:1.2rem;height:1.2rem;">
                        </td>
                        <td>
                            <input class="form-control-sms" type="text" name="marks[{{ $student->id }}][remarks]" value="{{ old("marks.{$student->id}.remarks", $mark?->remarks) }}" placeholder="e.g. Good performance">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div style="margin-top:2rem;display:flex;justify-content:flex-end;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-save"></i> Save Marks</button>
            </div>
        </form>
    </div>
@endsection
