@extends('layouts.app')

@section('title', 'Asset Assignments | EduCore SMS')
@section('page_title', 'Asset Allocations')
@section('breadcrumb', '/ Assets / Assignments')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.asset-assignments.create') }}"><i class="bi bi-plus-lg"></i> New Assignment</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Asset Code</th>
                <th>Asset Name</th>
                <th>Assigned To</th>
                <th>Assigned Date</th>
                <th>Returned</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($assignments as $assignment)
                <tr>
                    <td class="mono" style="font-weight:700;">{{ $assignment->asset->code }}</td>
                    <td>{{ $assignment->asset->name }}</td>
                    <td>
                        <div style="font-weight:700;">{{ $assignment->assignedTo->user->name }}</div>
                        <div class="muted" style="font-size:.75rem;">{{ str($assignment->assigned_to_type)->afterLast('\\') }}</div>
                    </td>
                    <td class="mono">{{ $assignment->assigned_at->format('M d, Y') }}</td>
                    <td>
                        @if($assignment->returned_at)
                            <span class="mono">{{ $assignment->returned_at->format('M d, Y') }}</span>
                        @else
                            <span class="status-pill pill-active">In Use</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            @if(!$assignment->returned_at)
                                <form action="{{ route('admin.asset-assignments.update', $assignment) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="returned_at" value="{{ date('Y-m-d') }}">
                                    <button class="btn-outline-sms" type="submit" title="Mark as Returned" style="color:var(--success);"><i class="bi bi-box-arrow-in-left"></i> Return</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.asset-assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No assignment records found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
