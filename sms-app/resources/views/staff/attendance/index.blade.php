@extends('layouts.app')

@section('title', 'Staff Attendance | EduCore SMS')
@section('page_title', 'Staff Attendance')
@section('breadcrumb', '/ Staff / Attendance')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.staff-attendance.create') }}"><i class="bi bi-calendar-check"></i> Mark Attendance</a>
@endsection

@section('content')
    <div class="data-card" style="margin-bottom:2rem;">
        <form action="{{ route('admin.staff-attendance.index') }}" method="GET" class="list-toolbar">
            <div style="display:flex;align-items:center;gap:1rem;">
                <label class="form-label-sms" style="margin:0;">Select Date:</label>
                <input class="form-control-sms" type="date" name="date" value="{{ $date }}" style="width:200px;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-funnel"></i> View</button>
            </div>
        </form>
    </div>

    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Designation</th>
                <th>Status</th>
                <th>Note</th>
            </tr>
            </thead>
            <tbody>
            @forelse($attendances as $att)
                <tr>
                    <td style="font-weight:700;">{{ $att->employee->user->name }}</td>
                    <td>{{ $att->employee->designation }}</td>
                    <td>
                        <span class="status-pill {{ $att->status === 'present' ? 'pill-active' : ($att->status === 'absent' ? 'pill-inactive' : 'pill-warning') }}">
                            {{ ucfirst(str_replace('_', ' ', $att->status)) }}
                        </span>
                    </td>
                    <td>{{ $att->note }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:2rem;color:var(--text-light);">No attendance marked for this date.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
