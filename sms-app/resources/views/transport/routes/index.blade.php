@extends('layouts.app')

@section('title', 'Transport Routes | EduCore SMS')
@section('page_title', 'Transport Routes')
@section('breadcrumb', '/ Transport / Routes')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.transport-routes.create') }}"><i class="bi bi-plus-lg"></i> Add Route</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Route Name</th>
                <th>Code</th>
                <th>Base Fare</th>
                <th>Pickup Points</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($routes as $route)
                <tr>
                    <td style="font-weight:700;">{{ $route->name }}</td>
                    <td class="mono">{{ $route->route_code }}</td>
                    <td class="mono">PKR {{ number_format($route->fare) }}</td>
                    <td class="mono">{{ $route->pickup_points_count }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.transport-routes.show', $route) }}"><i class="bi bi-eye"></i></a>
                            <a class="btn-outline-sms" href="{{ route('admin.transport-routes.edit', $route) }}"><i class="bi bi-pencil"></i></a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No routes found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
