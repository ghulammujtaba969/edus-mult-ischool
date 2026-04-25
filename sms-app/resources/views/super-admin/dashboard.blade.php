@extends('layouts.app')

@section('title', 'Super Admin Dashboard | EduCore SaaS')
@section('page_title', 'Platform Overview')
@section('breadcrumb', '/ Super Admin / Dashboard')

@section('content')
    <div class="kpi-grid">
        <div class="kpi-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div class="kpi-label">Total Schools</div>
                    <div class="kpi-value" style="color: var(--primary);">{{ $stats['total_schools'] }}</div>
                </div>
                <div class="activity-icon tone-info" style="width: 45px; height: 45px; font-size: 1.2rem;">
                    <i class="bi bi-building"></i>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.8rem; color: var(--text-light);">
                <span class="delta-up"><i class="bi bi-arrow-up-short"></i> Platform Growth</span>
            </div>
        </div>

        <div class="kpi-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div class="kpi-label">Active Schools</div>
                    <div class="kpi-value" style="color: var(--success);">{{ $stats['active_schools'] }}</div>
                </div>
                <div class="activity-icon tone-success" style="width: 45px; height: 45px; font-size: 1.2rem;">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.8rem; color: var(--text-light);">
                <span class="delta-up"><i class="bi bi-shield-check"></i> System Healthy</span>
            </div>
        </div>

        <div class="kpi-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div class="kpi-label">Subscription Plans</div>
                    <div class="kpi-value" style="color: var(--info);">{{ $stats['total_plans'] }}</div>
                </div>
                <div class="activity-icon tone-warning" style="width: 45px; height: 45px; font-size: 1.2rem;">
                    <i class="bi bi-card-list"></i>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.8rem; color: var(--text-light);">
                <span><i class="bi bi-tags"></i> Active Offerings</span>
            </div>
        </div>

        <div class="kpi-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div class="kpi-label">Total Users</div>
                    <div class="kpi-value" style="color: var(--warning);">{{ $stats['total_users'] }}</div>
                </div>
                <div class="activity-icon tone-danger" style="width: 45px; height: 45px; font-size: 1.2rem;">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.8rem; color: var(--text-light);">
                <span class="delta-up"><i class="bi bi-graph-up"></i> Cross-School</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <div class="card-sms">
            <div class="card-title">
                <span><i class="bi bi-clock-history"></i> Recently Registered Schools</span>
                <a href="{{ route('super-admin.schools.index') }}" class="card-title-action">View All Schools</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="sms-table">
                    <thead>
                    <tr>
                        <th>School Name</th>
                        <th>Slug</th>
                        <th>Subscription Plan</th>
                        <th>Status</th>
                        <th>Joined Date</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($recentSchools as $school)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div class="student-avatar" style="background: var(--surface); color: var(--primary);">
                                        {{ str($school->name)->substr(0, 1) }}
                                    </div>
                                    <div style="font-weight:700;">{{ $school->name }}</div>
                                </div>
                            </td>
                            <td class="mono"><span style="background: var(--surface); padding: 0.2rem 0.5rem; border-radius: 6px;">{{ $school->slug }}</span></td>
                            <td><span class="badge-sms badge-outline-sms" style="font-weight: 600;">{{ $school->plan->name }}</span></td>
                            <td>
                                @if($school->status == 'active')
                                    <span class="status-pill pill-active"><i class="bi bi-dot"></i> Active</span>
                                @else
                                    <span class="status-pill pill-inactive"><i class="bi bi-dot"></i> {{ ucfirst($school->status) }}</span>
                                @endif
                            </td>
                            <td class="mono" style="color: var(--text-light);">{{ $school->created_at->format('M d, Y') }}</td>
                            <td style="text-align: right;">
                                <a href="{{ route('super-admin.schools.edit', $school) }}" class="btn-outline-sms" style="padding: 0.4rem 0.6rem;"><i class="bi bi-pencil"></i> Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 3rem; color: var(--text-light);">
                                <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                No schools registered yet.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
