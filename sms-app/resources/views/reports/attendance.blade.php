@extends('layouts.app')

@section('title', 'Attendance Report | EduCore SMS')
@section('page_title', 'Daily Attendance Report')
@section('breadcrumb', '/ Reports / Attendance')

@section('topbar_actions')
    <div style="display:flex;gap:.5rem;">
        <a class="btn-outline-sms" href="{{ route('admin.reports.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
        <button class="btn-outline-sms" type="button" onclick="window.print()"><i class="bi bi-printer"></i> Print Report</button>
    </div>
@endsection

@section('content')
    <div class="data-card" style="margin-bottom:2rem;">
        <form action="{{ route('admin.reports.attendance') }}" method="GET" class="list-toolbar">
            <div style="display:flex;align-items:center;gap:1rem;">
                <label class="form-label-sms" style="margin:0;">Select Date:</label>
                <input class="form-control-sms" type="date" name="date" value="{{ $date }}" style="width:200px;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-funnel"></i> Generate</button>
            </div>
        </form>
    </div>

    <div class="data-card">
        <div class="data-card-header">
            <div>Report for <strong>{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</strong></div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Roll #</th>
                <th>Student Name</th>
                <th>Class - Section</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse($attendance as $record)
                <tr>
                    <td class="mono">{{ $record->student->currentAcademicRecord->roll_no }}</td>
                    <td style="font-weight:700;">{{ $record->student->user->name }}</td>
                    <td>{{ $record->section->schoolClass->name }} - {{ $record->section->name }}</td>
                    <td>
                        <span class="status-pill {{ $record->status === 'present' ? 'pill-active' : ($record->status === 'absent' ? 'pill-inactive' : 'pill-warning') }}">
                            {{ ucfirst($record->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:2rem;color:var(--text-light);">No attendance records found for this date.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
