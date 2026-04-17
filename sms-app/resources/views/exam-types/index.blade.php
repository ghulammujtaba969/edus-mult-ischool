@extends('layouts.app')

@section('title', 'Exam Types | EduCore SMS')
@section('page_title', 'Exam Types')
@section('breadcrumb', '/ Exams / Exam Types')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.exam-types.create') }}"><i class="bi bi-plus-lg"></i> Add Exam Type</a>
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
                <th>Name</th>
                <th>Weightage (%)</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($examTypes as $type)
                <tr>
                    <td style="font-weight:700;">{{ $type->name }}</td>
                    <td class="mono">{{ $type->weightage_percent }}%</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.exam-types.edit', $type) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.exam-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center;padding:2rem;color:var(--text-light);">No exam types found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
