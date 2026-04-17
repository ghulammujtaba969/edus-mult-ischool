@extends('layouts.app')

@section('title', 'Academic Years | EduCore SMS')
@section('page_title', 'Academic Years')
@section('breadcrumb', '/ Academic Setup / Academic Years')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.academic-years.create') }}"><i class="bi bi-plus-lg"></i> Add Year</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong>{{ $years->count() }}</strong> academic years</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($years as $year)
                <tr>
                    <td style="font-weight:700;">{{ $year->name }}</td>
                    <td class="mono">{{ $year->start_date->format('M d, Y') }}</td>
                    <td class="mono">{{ $year->end_date->format('M d, Y') }}</td>
                    <td>
                        @if($year->is_current)
                            <span class="status-pill pill-active">Current</span>
                        @else
                            <span class="status-pill pill-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.academic-years.edit', $year) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.academic-years.destroy', $year) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No academic years found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
