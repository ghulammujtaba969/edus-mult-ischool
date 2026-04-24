@extends('layouts.app')

@section('title', 'Student Transcripts | EduCore SMS')
@section('page_title', 'Student Academic Transcripts')
@section('breadcrumb', '/ Reports / Transcripts')

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Reg No.</th>
                <th>Student Name</th>
                <th>Class - Section</th>
                <th>Academic History</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($students as $student)
                <tr>
                    <td class="mono">{{ $student->admission_no }}</td>
                    <td style="font-weight:700;">{{ $student->user->name }}</td>
                    <td>{{ $student->schoolClass->name }} - {{ $student->section->name }}</td>
                    <td>
                        <span class="badge-sms badge-outline-sms">GPA: --</span>
                        <span class="badge-sms badge-outline-sms">Rank: --</span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.students.show', $student) }}"><i class="bi bi-eye"></i> View Profile</a>
                            <a href="{{ route('admin.reports.transcripts.show', $student) }}" target="_blank" class="btn-primary-sms" style="padding:.3rem .8rem;font-size:.8rem;text-decoration:none;"><i class="bi bi-printer"></i> View Transcript</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No students found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
