@extends('layouts.app')

@section('title', 'Staff Management | EduCore SMS')
@section('page_title', 'Staff Management')
@section('breadcrumb', '/ Staff')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.employees.create') }}"><i class="bi bi-plus-lg"></i> Add Employee</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <form class="list-toolbar" method="GET" action="{{ route('admin.employees.index') }}">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input class="search-input" type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search by name, code, CNIC">
        </div>
        <select class="filter-select" name="role">
            <option value="">All Roles</option>
            @foreach($roles as $value => $label)
                <option value="{{ $value }}" @selected(($filters['role'] ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select class="filter-select" name="status">
            <option value="">All Status</option>
            @foreach(['active' => 'Active', 'inactive' => 'Inactive', 'on_leave' => 'On Leave'] as $value => $label)
                <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="btn-primary-sms" type="submit"><i class="bi bi-funnel"></i> Filter</button>
    </form>

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong>{{ $employees->count() }}</strong> of <strong>{{ $employees->total() }}</strong> employees</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Code</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>
                        <div style="display:flex;gap:.75rem;align-items:center;">
                            <div class="student-avatar" style="background:var(--info-bg);color:var(--info);">{{ str($employee->user->name)->substr(0, 2)->upper() }}</div>
                            <div style="font-weight:700;">{{ $employee->user->name }}</div>
                        </div>
                    </td>
                    <td class="mono">{{ $employee->employee_code }}</td>
                    <td>{{ $employee->designation }}</td>
                    <td>{{ $employee->department ?? 'N/A' }}</td>
                    <td><span class="status-pill pill-active">{{ $employee->user->role->label() }}</span></td>
                    <td class="mono">{{ $employee->phone }}</td>
                    <td><span class="status-pill {{ $employee->status === 'active' ? 'pill-active' : 'pill-inactive' }}">{{ ucfirst($employee->status) }}</span></td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.employees.show', $employee) }}"><i class="bi bi-eye"></i></a>
                            <a class="btn-outline-sms" href="{{ route('admin.employees.edit', $employee) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="data-footer">
            <div class="muted">Page {{ $employees->currentPage() }} of {{ $employees->lastPage() }}</div>
            <div style="display:flex;gap:.5rem;">
                @if($employees->onFirstPage())
                    <span class="btn-outline-sms" style="opacity:.55;">Previous</span>
                @else
                    <a class="btn-outline-sms" href="{{ $employees->previousPageUrl() }}">Previous</a>
                @endif

                @if($employees->hasMorePages())
                    <a class="btn-outline-sms" href="{{ $employees->nextPageUrl() }}">Next</a>
                @else
                    <span class="btn-outline-sms" style="opacity:.55;">Next</span>
                @endif
            </div>
        </div>
    </div>
@endsection
