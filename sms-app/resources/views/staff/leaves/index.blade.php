@extends('layouts.app')

@section('title', 'Staff Leaves | EduCore SMS')
@section('page_title', 'Leave Management')
@section('breadcrumb', '/ Staff / Leaves')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.staff-leaves.create') }}"><i class="bi bi-plus-lg"></i> Request Leave</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Type</th>
                <th>Dates</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($leaves as $leave)
                <tr>
                    <td style="font-weight:700;">{{ $leave->employee->user->name }}</td>
                    <td>{{ ucfirst($leave->leave_type) }}</td>
                    <td class="mono">
                        {{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d, Y') }}
                    </td>
                    <td>{{ $leave->reason }}</td>
                    <td>
                        <span class="status-pill {{ $leave->status === 'approved' ? 'pill-active' : ($leave->status === 'rejected' ? 'pill-inactive' : 'pill-warning') }}">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </td>
                    <td>
                        @if($leave->status === 'pending')
                            <div style="display:flex;gap:.5rem;">
                                <form action="{{ route('admin.staff-leaves.update', $leave) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="btn-outline-sms" type="submit" style="color:var(--success);padding:.25rem .5rem;font-size:.75rem;">Approve</button>
                                </form>
                                <form action="{{ route('admin.staff-leaves.update', $leave) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="btn-outline-sms" type="submit" style="color:var(--danger);padding:.25rem .5rem;font-size:.75rem;">Reject</button>
                                </form>
                            </div>
                        @else
                            <span class="muted" style="font-size:.75rem;">By {{ $leave->approver->name ?? 'System' }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No leave requests found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
