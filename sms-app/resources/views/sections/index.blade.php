@extends('layouts.app')

@section('title', 'Sections | EduCore SMS')
@section('page_title', 'Sections')
@section('breadcrumb', '/ Academic Setup / Sections')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.sections.create') }}"><i class="bi bi-plus-lg"></i> Add Section</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong>{{ $sections->count() }}</strong> sections</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Class</th>
                <th>Section Name</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($sections as $section)
                <tr>
                    <td><span class="status-pill pill-active">{{ $section->schoolClass->name }}</span></td>
                    <td style="font-weight:700;">{{ $section->name }}</td>
                    <td class="mono">{{ $section->capacity }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.sections.edit', $section) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:2rem;color:var(--text-light);">No sections found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
