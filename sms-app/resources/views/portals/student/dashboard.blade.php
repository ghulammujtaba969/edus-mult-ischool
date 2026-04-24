@extends('layouts.app')

@section('title', 'Student Dashboard | EduCore SMS')
@section('page_title', 'Hello, ' . auth()->user()->name)
@section('breadcrumb', '/ Student / Dashboard')

@section('content')
    <div class="info-grid-3">
        <div class="data-card" style="border-left:5px solid var(--primary);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Today's Classes</div>
            <div style="font-size:2rem;font-weight:800;color:var(--primary);">{{ count($todayTimetable) }}</div>
        </div>
        <div class="data-card" style="border-left:5px solid var(--warning);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Pending Homework</div>
            <div style="font-size:2rem;font-weight:800;color:var(--warning);">{{ $pendingHomework }}</div>
        </div>
        <div class="data-card" style="border-left:5px solid var(--danger);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Active Online Exams</div>
            <div style="font-size:2rem;font-weight:800;color:var(--danger);">{{ $activeExams }}</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:2rem;margin-top:2rem;">
        <!-- Today's Timetable -->
        <div class="data-card">
            <div class="card-title"><i class="bi bi-calendar3"></i> My Schedule for Today</div>
            <table class="sms-table">
                <thead>
                <tr>
                    <th>Time</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th>Room</th>
                </tr>
                </thead>
                <tbody>
                @forelse($todayTimetable as $item)
                    <tr>
                        <td class="mono">{{ date('H:i', strtotime($item->slot->start_time)) }}</td>
                        <td style="font-weight:700;color:var(--primary);">{{ $item->subject->name }}</td>
                        <td>{{ $item->teacher->user->name }}</td>
                        <td class="mono">{{ $item->room_no ?? '--' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:2rem;color:var(--text-light);">No classes scheduled for today. Enjoy your day!</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- My Info -->
        <div class="data-card">
            <div class="card-title"><i class="bi bi-person-circle"></i> My Academic Info</div>
            <div style="margin-bottom:1rem;">
                <div style="color:var(--text-light);font-size:.8rem;">Registration Number</div>
                <div style="font-weight:700;" class="mono">{{ $student->admission_no }}</div>
            </div>
            <div style="margin-bottom:1rem;">
                <div style="color:var(--text-light);font-size:.8rem;">Class & Section</div>
                <div style="font-weight:700;">{{ $student->schoolClass->name }} - {{ $student->section->name }}</div>
            </div>
            <div style="margin-bottom:1.5rem;">
                <div style="color:var(--text-light);font-size:.8rem;">Roll Number</div>
                <div style="font-weight:700;" class="mono">{{ $student->roll_no ?? '--' }}</div>
            </div>
            <a href="{{ route('admin.reports.transcripts.show', $student) }}" target="_blank" class="btn-outline-sms w-full" style="text-align:center;text-decoration:none;display:block;">
                <i class="bi bi-file-earmark-person"></i> View My Transcript
            </a>
        </div>
    </div>
@endsection
