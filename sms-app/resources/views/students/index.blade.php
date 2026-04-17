@extends('layouts.app')

@section('title', 'Students | EduCore SMS')
@section('page_title', 'Students')
@section('breadcrumb', '/ All Students')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.students.create') }}"><i class="bi bi-plus-lg"></i> Enroll Student</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif
    <div class="summary-row">
        <div class="summary-pill"><span class="status-pill pill-active">Active</span> <strong>{{ $statusCounts['active'] }}</strong></div>
        <div class="summary-pill"><span class="status-pill pill-partial">New</span> <strong>{{ $statusCounts['enrolled'] }}</strong></div>
        <div class="summary-pill"><span class="status-pill pill-inactive">Left / TC</span> <strong>{{ $statusCounts['left'] }}</strong></div>
        <div class="summary-pill alert"><i class="bi bi-exclamation-circle"></i> <strong>{{ $statusCounts['defaulters'] }}</strong> fee defaulters</div>
    </div>

    <form class="list-toolbar" method="GET" action="{{ route('admin.students.index') }}">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input class="search-input" type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search by name, reg no, B-Form">
        </div>
        <select class="filter-select" name="class">
            <option value="">All Classes</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" @selected(($filters['class'] ?? '') == $class->id)>{{ $class->name }}</option>
            @endforeach
        </select>
        <select class="filter-select" name="status">
            <option value="">All Status</option>
            @foreach(['active' => 'Active', 'enrolled' => 'Enrolled', 'left' => 'Left', 'transferred' => 'Transferred'] as $value => $label)
                <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select class="filter-select" name="gender">
            <option value="">All Genders</option>
            @foreach(['Male', 'Female'] as $gender)
                <option value="{{ $gender }}" @selected(($filters['gender'] ?? '') === $gender)>{{ $gender }}</option>
            @endforeach
        </select>
        <button class="btn-primary-sms" type="submit"><i class="bi bi-funnel"></i> Filter</button>
    </form>

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong>{{ $students->count() }}</strong> of <strong>{{ $students->total() }}</strong> students</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Student</th>
                <th>Reg No.</th>
                <th>Class / Section</th>
                <th>Gender</th>
                <th>Father</th>
                <th>Contact</th>
                <th>Fee Status</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                @php($invoice = $student->feeInvoices->first())
                <tr>
                    <td>
                        <div style="display:flex;gap:.75rem;align-items:center;">
                            <div class="student-avatar" style="background:var(--coral-pale);color:var(--coral);">{{ str($student->user?->name ?? 'ST')->substr(0, 2)->upper() }}</div>
                            <div>
                                <div style="font-weight:700;">{{ $student->user?->name ?? 'Student' }}</div>
                                <div class="student-reg">{{ $student->b_form_no }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="mono">{{ $student->registration_no }}</td>
                    <td>{{ $student->currentAcademicRecord?->schoolClass?->name }} / {{ $student->currentAcademicRecord?->section?->name }}</td>
                    <td><span class="status-pill {{ $student->gender === 'Male' ? 'pill-male' : 'pill-female' }}">{{ $student->gender }}</span></td>
                    <td>{{ $student->guardian?->father_name }}</td>
                    <td class="mono">{{ $student->guardian?->father_phone }}</td>
                    <td>
                        <span class="status-pill {{ $invoice?->status?->value === 'paid' ? 'pill-paid' : ($invoice?->status?->value === 'partial' ? 'pill-partial' : 'pill-unpaid') }}">
                            {{ $invoice?->status?->value ? ucfirst($invoice->status->value) : 'N/A' }}
                        </span>
                    </td>
                    <td><span class="status-pill {{ in_array($student->status->value, ['active', 'enrolled']) ? 'pill-active' : 'pill-inactive' }}">{{ ucfirst($student->status->value) }}</span></td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.students.show', $student) }}" title="View Profile"><i class="bi bi-eye"></i></a>
                            <a class="btn-outline-sms" href="{{ route('admin.students.edit', $student) }}" title="Edit Student"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit" title="Delete Student"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="data-footer">
            <div class="muted">Page {{ $students->currentPage() }} of {{ $students->lastPage() }}</div>
            <div style="display:flex;gap:.5rem;">
                @if($students->onFirstPage())
                    <span class="btn-outline-sms" style="opacity:.55;">Previous</span>
                @else
                    <a class="btn-outline-sms" href="{{ $students->previousPageUrl() }}">Previous</a>
                @endif

                @if($students->hasMorePages())
                    <a class="btn-outline-sms" href="{{ $students->nextPageUrl() }}">Next</a>
                @else
                    <span class="btn-outline-sms" style="opacity:.55;">Next</span>
                @endif
            </div>
        </div>
    </div>
@endsection
