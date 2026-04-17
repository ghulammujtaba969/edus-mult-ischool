@extends('layouts.app')

@section('title', 'Campuses | EduCore SMS')
@section('page_title', 'Campuses')
@section('breadcrumb', '/ Academic Setup / Campuses')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.campuses.create') }}"><i class="bi bi-plus-lg"></i> Add Campus</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong>{{ $campuses->count() }}</strong> campuses</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Campus Name</th>
                <th>Code</th>
                <th>City</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($campuses as $campus)
                <tr>
                    <td style="font-weight:700;">{{ $campus->name }}</td>
                    <td class="mono">{{ $campus->code }}</td>
                    <td>{{ $campus->city }}</td>
                    <td>{{ $campus->phone }}</td>
                    <td>
                        @if($campus->is_active)
                            <span class="status-pill pill-active">Active</span>
                        @else
                            <span class="status-pill pill-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.campuses.edit', $campus) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.campuses.destroy', $campus) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No campuses found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
