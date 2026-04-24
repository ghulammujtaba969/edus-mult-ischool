@extends('layouts.app')

@section('title', 'Request Leave | EduCore SMS')
@section('page_title', 'Request Leave')
@section('breadcrumb', '/ Staff / Leaves / New')

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.staff-leaves.store') }}" method="POST">
            @csrf
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="employee_id">Select Employee</label>
                    <select class="filter-select" id="employee_id" name="employee_id" required>
                        <option value="">Choose Employee...</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->user->name }} ({{ $employee->designation }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="leave_type">Leave Type</label>
                    <select class="filter-select" id="leave_type" name="leave_type" required>
                        <option value="casual">Casual Leave</option>
                        <option value="sick">Sick Leave</option>
                        <option value="annual">Annual Leave</option>
                    </select>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="start_date">Start Date</label>
                    <input class="form-control-sms" type="date" id="start_date" name="start_date" value="{{ date('Y-m-d') }}" required>
                </div>
                <div>
                    <label class="form-label-sms" for="end_date">End Date</label>
                    <input class="form-control-sms" type="date" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="reason">Reason for Leave</label>
                <textarea class="form-control-sms" id="reason" name="reason" rows="3" required></textarea>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-send"></i> Submit Request</button>
                <a class="btn-outline-sms" href="{{ route('admin.staff-leaves.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
