@extends('layouts.app')

@section('title', 'Exam Schedules | EduCore SMS')
@section('page_title', 'Exam Schedules')
@section('breadcrumb', '/ Exams / Schedules')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.exams.create') }}"><i class="bi bi-calendar-plus"></i> Schedule Exam</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Exam Name</th>
                <th>Class</th>
                <th>Exam Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td style="font-weight:700;">{{ $exam->name }}</td>
                    <td style="font-weight:700;">{{ $exam->schoolClass->name }}</td>
                    <td><span class="status-pill pill-active">{{ $exam->examType->name }}</span></td>
                    <td class="mono">{{ $exam->start_date->format('M d, Y') }}</td>
                    <td class="mono">{{ $exam->end_date->format('M d, Y') }}</td>
                    <td>
                        <span class="status-pill {{ $exam->status->value === 'published' ? 'pill-active' : ($exam->status->value === 'draft' ? 'pill-inactive' : 'pill-partial') }}">
                            {{ ucfirst($exam->status->value) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.exams.edit', $exam) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-light);">No exams scheduled.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="data-footer">
            {{ $exams->links() }}
        </div>
    </div>
@endsection
