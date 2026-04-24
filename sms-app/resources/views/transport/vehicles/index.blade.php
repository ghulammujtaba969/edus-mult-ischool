@extends('layouts.app')

@section('title', 'Transport Vehicles | EduCore SMS')
@section('page_title', 'Transport Vehicles')
@section('breadcrumb', '/ Transport / Vehicles')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.transport-vehicles.create') }}"><i class="bi bi-plus-lg"></i> Add Vehicle</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Vehicle No</th>
                <th>Model</th>
                <th>Driver</th>
                <th>Capacity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($vehicles as $vehicle)
                <tr>
                    <td class="mono" style="font-weight:700;">{{ $vehicle->vehicle_no }}</td>
                    <td>{{ $vehicle->vehicle_model }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $vehicle->driver_name }}</div>
                        <div class="muted" style="font-size:.8rem;">{{ $vehicle->driver_phone }}</div>
                    </td>
                    <td class="mono">{{ $vehicle->capacity }}</td>
                    <td>
                        <span class="status-pill {{ $vehicle->status === 'active' ? 'pill-active' : ($vehicle->status === 'maintenance' ? 'pill-warning' : 'pill-inactive') }}">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.transport-vehicles.edit', $vehicle) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.transport-vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No vehicles found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
