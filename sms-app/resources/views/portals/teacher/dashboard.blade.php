@extends('layouts.app')

@section('title', 'Teacher Dashboard | EduCore SMS')
@section('page_title', 'Welcome, ' . auth()->user()->name)
@section('breadcrumb', '/ Teacher / Dashboard')

@section('content')
    <div class="info-grid-3">
        <div class="data-card" style="border-left:5px solid var(--primary);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">My Assigned Classes</div>
            <div style="font-size:2rem;font-weight:800;color:var(--primary);">{{ count($myClasses) }}</div>
        </div>
        <div class="data-card" style="border-left:5px solid var(--success);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Today's Lectures</div>
            <div style="font-size:2rem;font-weight:800;color:var(--success);">{{ count($todayClasses) }}</div>
        </div>
        <div class="data-card" style="border-left:5px solid var(--info);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Active Lesson Plans</div>
            <div style="font-size:2rem;font-weight:800;color:var(--info);">{{ $pendingLessonPlans }}</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-top:2rem;">
        <!-- Today's Schedule -->
        <div class="data-card">
            <div class="card-title"><i class="bi bi-clock"></i> Today's Schedule</div>
            <table class="sms-table">
                <thead>
                <tr>
                    <th>Time</th>
                    <th>Class</th>
                    <th>Subject</th>
                </tr>
                </thead>
                <tbody>
                @forelse($todayClasses as $class)
                    <tr>
                        <td class="mono">{{ date('H:i', strtotime($class->slot->start_time)) }}</td>
                        <td>{{ $class->schoolClass->name }} - {{ $class->section->name }}</td>
                        <td style="font-weight:700;">{{ $class->subject->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;padding:2rem;color:var(--text-light);">No classes scheduled for today.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Quick Actions -->
        <div class="data-card">
            <div class="card-title"><i class="bi bi-lightning-charge"></i> Quick Actions</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <a href="{{ route('admin.attendance.create') }}" class="btn-outline-sms" style="text-align:center;padding:1.5rem;display:block;text-decoration:none;">
                    <i class="bi bi-check2-square" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
                    Mark Attendance
                </a>
                <a href="{{ route('admin.marks.create') }}" class="btn-outline-sms" style="text-align:center;padding:1.5rem;display:block;text-decoration:none;">
                    <i class="bi bi-pencil-square" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
                    Enter Marks
                </a>
                <a href="{{ route('admin.lesson-plans.create') }}" class="btn-outline-sms" style="text-align:center;padding:1.5rem;display:block;text-decoration:none;">
                    <i class="bi bi-journal-plus" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
                    New Lesson Plan
                </a>
                <a href="{{ route('admin.homework.create') }}" class="btn-outline-sms" style="text-align:center;padding:1.5rem;display:block;text-decoration:none;">
                    <i class="bi bi-book" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
                    Assign Homework
                </a>
            </div>
        </div>
    </div>
@endsection
