@extends('layouts.app')

@section('title', 'Super Admin Dashboard | EduCore SaaS')
@section('page_title', 'Platform Overview')
@section('breadcrumb', '/ Super Admin / Dashboard')

@section('content')
    <div class="info-grid-4">
        <div class="data-card" style="border-left:5px solid var(--primary);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Total Schools</div>
            <div style="font-size:2rem;font-weight:800;color:var(--primary);">{{ $stats['total_schools'] }}</div>
        </div>
        <div class="data-card" style="border-left:5px solid var(--success);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Active Schools</div>
            <div style="font-size:2rem;font-weight:800;color:var(--success);">{{ $stats['active_schools'] }}</div>
        </div>
        <div class="data-card" style="border-left:5px solid var(--info);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Subscription Plans</div>
            <div style="font-size:2rem;font-weight:800;color:var(--info);">{{ $stats['total_plans'] }}</div>
        </div>
        <div class="data-card" style="border-left:5px solid var(--warning);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Total Users</div>
            <div style="font-size:2rem;font-weight:800;color:var(--warning);">{{ $stats['total_users'] }}</div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <div class="data-card">
            <div class="card-title">Recently Registered Schools</div>
            <table class="sms-table">
                <thead>
                <tr>
                    <th>School Name</th>
                    <th>Slug</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Joined Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($recentSchools as $school)
                    <tr>
                        <td style="font-weight:700;">{{ $school->name }}</td>
                        <td class="mono">{{ $school->slug }}</td>
                        <td><span class="badge-sms badge-outline-sms">{{ $school->plan->name }}</span></td>
                        <td>
                            @if($school->status == 'active')
                                <span class="badge-sms badge-success-sms">Active</span>
                            @else
                                <span class="badge-sms badge-danger-sms">{{ ucfirst($school->status) }}</span>
                            @endif
                        </td>
                        <td class="mono">{{ $school->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('super-admin.schools.edit', $school) }}" class="btn-outline-sms"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
