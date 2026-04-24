@extends('layouts.app')

@section('title', 'Online Exams | EduCore SMS')
@section('page_title', 'Online Exams')
@section('breadcrumb', '/ Academics / Online Exams')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.online-exams.create') }}"><i class="bi bi-plus-lg"></i> Create Online Exam</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Exam Title</th>
                <th>From</th>
                <th>To</th>
                <th>Duration</th>
                <th>Min %</th>
                <th>Questions</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td style="font-weight:700;">{{ $exam->exam_title }}</td>
                    <td class="mono">{{ $exam->exam_from->format('M d, H:i') }}</td>
                    <td class="mono">{{ $exam->exam_to->format('M d, H:i') }}</td>
                    <td class="mono">{{ $exam->duration_minutes }} min</td>
                    <td class="mono">{{ $exam->minimum_percentage }}%</td>
                    <td class="mono text-center">{{ $exam->questions_count }}</td>
                    <td>
                        @if($exam->is_active)
                            <span class="badge-sms badge-success-sms">Active</span>
                        @else
                            <span class="badge-sms badge-danger-sms">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.online-exams.edit', $exam) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.online-exams.destroy', $exam) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this exam?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline-sms text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:2rem;color:var(--text-light);">No online exams found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
