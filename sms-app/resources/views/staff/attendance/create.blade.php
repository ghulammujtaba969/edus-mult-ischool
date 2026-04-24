@extends('layouts.app')

@section('title', 'Mark Staff Attendance | EduCore SMS')
@section('page_title', 'Mark Attendance')
@section('breadcrumb', '/ Staff / Attendance / Mark')

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.staff-attendance.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:2rem;display:flex;align-items:center;gap:1rem;">
                <label class="form-label-sms" style="margin:0;">Attendance Date:</label>
                <input class="form-control-sms" type="date" name="date" value="{{ $date }}" required style="width:200px;">
            </div>

            <table class="sms-table">
                <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Designation</th>
                    <th>Attendance Status</th>
                    <th>Note</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td style="font-weight:700;">{{ $employee->user->name }}</td>
                        <td>{{ $employee->designation }}</td>
                        <td>
                            <div style="display:flex;gap:1rem;">
                                <label style="display:flex;align-items:center;gap:.3rem;cursor:pointer;">
                                    <input type="radio" name="attendance[{{ $employee->id }}][status]" value="present" checked> Present
                                </label>
                                <label style="display:flex;align-items:center;gap:.3rem;cursor:pointer;">
                                    <input type="radio" name="attendance[{{ $employee->id }}][status]" value="absent"> Absent
                                </label>
                                <label style="display:flex;align-items:center;gap:.3rem;cursor:pointer;">
                                    <input type="radio" name="attendance[{{ $employee->id }}][status]" value="late"> Late
                                </label>
                                <label style="display:flex;align-items:center;gap:.3rem;cursor:pointer;">
                                    <input type="radio" name="attendance[{{ $employee->id }}][status]" value="half_day"> Half Day
                                </label>
                            </div>
                        </td>
                        <td>
                            <input class="form-control-sms" type="text" name="attendance[{{ $employee->id }}][note]" placeholder="Optional note">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div style="margin-top:2rem;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 4rem;"><i class="bi bi-save"></i> Save Attendance</button>
            </div>
        </form>
    </div>
@endsection
