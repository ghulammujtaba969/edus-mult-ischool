@extends('layouts.app')

@section('title', 'Transport Assignments | EduCore SMS')
@section('page_title', 'Transport Allocations')
@section('breadcrumb', '/ Transport / Assignments')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.transport-assignments.create') }}"><i class="bi bi-plus-lg"></i> New Assignment</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Student</th>
                <th>Route / Point</th>
                <th>Vehicle</th>
                <th>Assigned At</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($assignments as $assignment)
                <tr>
                    <td>
                        <div style="font-weight:700;">{{ $assignment->student->user->name }}</div>
                        <div class="student-reg">{{ $assignment->student->registration_no }}</div>
                    </td>
                    <td>
                        <div style="font-weight:600;">{{ $assignment->route->name }}</div>
                        <div class="muted" style="font-size:.8rem;">{{ $assignment->pickupPoint->name }}</div>
                    </td>
                    <td class="mono">{{ $assignment->vehicle->vehicle_no ?? 'N/A' }}</td>
                    <td class="mono">{{ $assignment->assigned_at->format('M d, Y') }}</td>
                    <td>
                        <span class="status-pill {{ $assignment->status === 'active' ? 'pill-active' : 'pill-inactive' }}">
                            {{ ucfirst($assignment->status) }}
                        </span>
                    </td>
                    <td>
                        @if($assignment->status === 'active')
                            <form action="{{ route('admin.transport-assignments.update', $assignment) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="inactive">
                                <input type="hidden" name="ended_at" value="{{ date('Y-m-d') }}">
                                <button class="btn-outline-sms" type="submit" title="Mark as Inactive" style="color:var(--danger);"><i class="bi bi-x-circle"></i> Stop</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No transport assignments found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
