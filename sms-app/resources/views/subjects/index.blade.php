@extends('layouts.app')

@section('title', 'Subjects | EduCore SMS')
@section('page_title', 'Subjects')
@section('breadcrumb', '/ Academic Setup / Subjects')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.subjects.create') }}"><i class="bi bi-plus-lg"></i> Add Subject</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong>{{ $subjects->count() }}</strong> subjects</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Type</th>
                <th>Optional</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($subjects as $subject)
                <tr>
                    <td style="font-weight:700;">{{ $subject->name }}</td>
                    <td class="mono">{{ $subject->code ?? 'N/A' }}</td>
                    <td><span class="status-pill pill-active">{{ ucfirst($subject->subject_type) }}</span></td>
                    <td>
                        @if($subject->is_optional)
                            <span class="status-pill pill-partial">Yes</span>
                        @else
                            <span class="status-pill pill-active">No</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.subjects.edit', $subject) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No subjects found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
