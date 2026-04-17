@extends('layouts.app')

@section('title', 'Mark Attendance | EduCore SMS')
@section('page_title', 'Mark Attendance')
@section('breadcrumb', '/ Attendance / ' . $section->schoolClass->name . ' - ' . $section->name)

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.attendance.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
@endsection

@section('content')
    <div class="data-card">
        <div class="data-card-header" style="flex-direction:column;align-items:start;gap:.5rem;">
            <div style="font-size:1.2rem;font-weight:800;">{{ $section->schoolClass->name }} - Section {{ $section->name }}</div>
            <div class="muted"><i class="bi bi-calendar-event"></i> Date: <strong>{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</strong></div>
        </div>

        <form action="{{ route('admin.attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="section_id" value="{{ $section->id }}">
            <input type="hidden" name="attendance_date" value="{{ $date }}">

            <table class="sms-table">
                <thead>
                <tr>
                    <th style="width:80px;">Roll #</th>
                    <th>Student Name</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    @php($attendance = $existingAttendance->get($student->id))
                    @php($status = $attendance?->status->value ?? 'present')
                    <tr>
                        <td class="mono">{{ $student->currentAcademicRecord->roll_no }}</td>
                        <td>
                            <div style="font-weight:700;">{{ $student->user->name }}</div>
                            <div class="student-reg">{{ $student->registration_no }}</div>
                        </td>
                        <td>
                            <div class="role-tabs" style="margin:0;max-width:400px;">
                                @foreach(App\Enums\AttendanceStatus::cases() as $attendanceStatus)
                                    @if($attendanceStatus->value !== 'holiday')
                                        <label class="role-tab" style="cursor:pointer;text-align:center;flex:1;" :class="{ 'active': status === '{{ $attendanceStatus->value }}' }" x-data="{ status: '{{ $status }}' }">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="{{ $attendanceStatus->value }}" style="display:none;" @change="status = '{{ $attendanceStatus->value }}'" @checked($status === $attendanceStatus->value)>
                                            {{ ucfirst(str_replace('_', ' ', $attendanceStatus->value)) }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div style="margin-top:2rem;display:flex;justify-content:flex-end;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-check-all"></i> Save Attendance</button>
            </div>
        </form>
    </div>
@endsection
