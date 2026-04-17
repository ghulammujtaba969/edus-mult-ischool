@extends('layouts.app')

@section('title', 'Hostel Allocations | EduCore SMS')
@section('page_title', 'Room Allocations')
@section('breadcrumb', '/ Hostel / Allocations')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.hostel-allocations.create') }}"><i class="bi bi-plus-lg"></i> New Allocation</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Student</th>
                <th>Hostel / Room</th>
                <th>Allocated At</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($allocations as $allocation)
                <tr>
                    <td>
                        <div style="font-weight:700;">{{ $allocation->student->user->name }}</div>
                        <div class="student-reg">{{ $allocation->student->registration_no }}</div>
                    </td>
                    <td>
                        <div style="font-weight:600;">{{ $allocation->room->hostel->name }}</div>
                        <div class="muted">Room: {{ $allocation->room->room_no }} (Bed #{{ $allocation->bed_no ?? 'N/A' }})</div>
                    </td>
                    <td class="mono">{{ $allocation->allocated_at->format('M d, Y') }}</td>
                    <td>
                        <span class="status-pill {{ $allocation->status === 'active' ? 'pill-active' : 'pill-inactive' }}">
                            {{ ucfirst($allocation->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            @if($allocation->status === 'active')
                                <form action="{{ route('admin.hostel-allocations.update', $allocation) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="vacated">
                                    <input type="hidden" name="vacated_at" value="{{ date('Y-m-d') }}">
                                    <button class="btn-outline-sms" type="submit" title="Mark as Vacated" style="color:var(--danger);"><i class="bi bi-box-arrow-right"></i> Vacate</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.hostel-allocations.destroy', $allocation) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No allocations found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
