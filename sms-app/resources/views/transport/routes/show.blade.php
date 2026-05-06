@extends('layouts.app')

@section('title', 'Transport Route | EduCore SMS')
@section('page_title', $route->name)
@section('breadcrumb', '/ Transport / Routes / Details')

@section('topbar_actions')
    <div style="display:flex;gap:.5rem;">
        <a class="btn-outline-sms" href="{{ route('admin.transport-routes.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
        <a class="btn-primary-sms" href="{{ route('admin.transport-routes.edit', $route) }}"><i class="bi bi-pencil"></i> Edit</a>
    </div>
@endsection

@section('content')
    <div class="profile-grid">
        <div class="profile-card">
            <div class="card-title">Route Details</div>
            <div style="display:grid;gap:1rem;">
                <div>
                    <div class="muted">Route Code</div>
                    <div class="mono" style="font-weight:700;">{{ $route->route_code ?: 'N/A' }}</div>
                </div>
                <div>
                    <div class="muted">Base Fare</div>
                    <div class="mono" style="font-weight:700;">PKR {{ number_format($route->fare) }}</div>
                </div>
                <div>
                    <div class="muted">Description</div>
                    <div>{{ $route->description ?: 'No description added.' }}</div>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-title">Add Pickup Point</div>
            <form action="{{ route('admin.transport-routes.pickup-points.add', $route) }}" method="POST">
                @csrf
                <div style="margin-bottom:1rem;">
                    <label class="form-label-sms" for="name">Point Name</label>
                    <input class="form-control-sms" type="text" id="name" name="name" placeholder="e.g. Main Gate" required>
                </div>
                <div class="info-grid-2" style="margin-bottom:1rem;">
                    <div>
                        <label class="form-label-sms" for="pickup_time">Pickup Time</label>
                        <input class="form-control-sms" type="time" id="pickup_time" name="pickup_time">
                    </div>
                    <div>
                        <label class="form-label-sms" for="additional_fare">Additional Fare</label>
                        <input class="form-control-sms" type="number" min="0" step="0.01" id="additional_fare" name="additional_fare" value="0" required>
                    </div>
                </div>
                <button class="btn-primary-sms" type="submit"><i class="bi bi-plus-lg"></i> Add Point</button>
            </form>
        </div>
    </div>

    <div class="data-card" style="margin-top:1.25rem;">
        <div class="card-title">Pickup Points</div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Pickup Time</th>
                <th>Additional Fare</th>
            </tr>
            </thead>
            <tbody>
            @forelse($route->pickupPoints as $point)
                <tr>
                    <td style="font-weight:700;">{{ $point->name }}</td>
                    <td class="mono">{{ $point->pickup_time ? \Illuminate\Support\Str::of($point->pickup_time)->substr(0, 5) : 'N/A' }}</td>
                    <td class="mono">PKR {{ number_format($point->additional_fare) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center;padding:2rem;color:var(--text-light);">No pickup points added.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
