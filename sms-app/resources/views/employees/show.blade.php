@extends('layouts.app')

@section('title', $employee->user->name . ' | EduCore SMS')
@section('page_title', 'Employee Profile')
@section('breadcrumb', '/ Staff / ' . $employee->user->name)

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.employees.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
    <a class="btn-primary-sms" href="{{ route('admin.employees.edit', $employee) }}"><i class="bi bi-pencil"></i> Edit Profile</a>
@endsection

@section('content')
    <div class="profile-grid">
        <div class="profile-card">
            <div class="profile-hero">
                <div class="profile-avatar">{{ str($employee->user->name)->substr(0, 2)->upper() }}</div>
            </div>
            <div class="profile-name">{{ $employee->user->name }}</div>
            <div class="profile-class">{{ $employee->designation }} | {{ $employee->department ?? 'General' }}</div>
            <div class="profile-reg">{{ $employee->employee_code }}</div>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin:1rem 0;justify-content:center;">
                <span class="status-pill pill-active">{{ ucfirst($employee->status) }}</span>
                <span class="status-pill pill-partial">{{ $employee->user->role->label() }}</span>
            </div>
            <div class="profile-info-grid">
                <div class="info-field"><label>Joining Date</label><span>{{ $employee->joining_date->format('d M, Y') }}</span></div>
                <div class="info-field"><label>CNIC</label><span class="mono">{{ $employee->cnic ?? 'N/A' }}</span></div>
            </div>
            <div class="contact-row"><i class="bi bi-telephone-fill"></i><span>{{ $employee->phone }}</span></div>
            <div class="contact-row"><i class="bi bi-envelope-fill"></i><span>{{ $employee->user->email }}</span></div>
        </div>

        <div class="card-sms">
            <div class="tab-nav">
                <button class="tab-btn active">Employment Details</button>
            </div>
            <div style="margin-top:1.5rem;">
                <div class="info-grid-2">
                    <div class="info-field"><label>Employee Code</label><span>{{ $employee->employee_code }}</span></div>
                    <div class="info-field"><label>Designation</label><span>{{ $employee->designation }}</span></div>
                    <div class="info-field"><label>Department</label><span>{{ $employee->department ?? 'N/A' }}</span></div>
                    <div class="info-field"><label>Joining Date</label><span>{{ $employee->joining_date->format('M d, Y') }}</span></div>
                </div>
            </div>
        </div>
    </div>
@endsection
