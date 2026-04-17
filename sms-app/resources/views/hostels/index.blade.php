@extends('layouts.app')

@section('title', 'Hostels | EduCore SMS')
@section('page_title', 'Hostel Management')
@section('breadcrumb', '/ Hostel / Hostels')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.hostels.create') }}"><i class="bi bi-plus-lg"></i> Add Hostel</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Hostel Name</th>
                <th>Type</th>
                <th>City</th>
                <th>Capacity</th>
                <th>Rooms</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($hostels as $hostel)
                <tr>
                    <td style="font-weight:700;">{{ $hostel->name }}</td>
                    <td><span class="status-pill pill-active">{{ ucfirst($hostel->type) }}</span></td>
                    <td>{{ $hostel->city }}</td>
                    <td class="mono">{{ $hostel->capacity }}</td>
                    <td class="mono">{{ $hostel->rooms_count }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.hostels.show', $hostel) }}"><i class="bi bi-eye"></i></a>
                            <a class="btn-outline-sms" href="{{ route('admin.hostels.edit', $hostel) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.hostels.destroy', $hostel) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No hostels found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
