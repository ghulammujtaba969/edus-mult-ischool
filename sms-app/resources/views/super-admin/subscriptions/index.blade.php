@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">School Subscriptions</h1>
                <p class="text-muted small mb-0 mt-1">Monitor and manage school subscription plans, billing cycles, and trial statuses across the platform.</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill mr-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="list-toolbar mb-4">
        <form action="{{ route('super-admin.subscriptions.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center flex-grow-1">
            <div class="search-wrap flex-grow-1" style="max-width: 400px;">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="search-input" placeholder="Search school name or slug..." value="{{ request('search') }}">
            </div>

            <select name="plan_id" class="filter-select" style="width: 180px;" onchange="this.form.submit()">
                <option value="">All Plans</option>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" @selected(request('plan_id') == $plan->id)>{{ $plan->name }}</option>
                @endforeach
            </select>

            <select name="status" class="filter-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
            </select>

            @if(request()->anyFilled(['search', 'plan_id', 'status']))
                <a href="{{ route('super-admin.subscriptions.index') }}" class="btn-outline-sms" title="Clear Filters">
                    <i class="bi bi-x-circle"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="card-sms shadow-sm mb-4" style="overflow: hidden;">
        <div class="table-responsive">
            <table class="sms-table mb-0">
                <thead>
                    <tr>
                        <th class="pl-4">School</th>
                        <th>Current Plan</th>
                        <th>Status</th>
                        <th>Trial Status</th>
                        <th>Billing Cycle</th>
                        <th class="text-right pr-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schools as $school)
                        <tr class="hover-bg-light transition-all">
                            <td class="pl-4">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar mr-3" style="width: 36px; height: 36px; background: var(--surface); color: var(--primary); font-size: 0.9rem;">
                                        {{ strtoupper(substr($school->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark">{{ $school->name }}</div>
                                        <div class="text-muted small">{{ $school->primaryDomain->domain ?? 'No domain' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-sms badge-outline-sms font-weight-bold">
                                    {{ $school->plan->name }}
                                </span>
                            </td>
                            <td>
                                @if($school->status == 'active')
                                    <span class="status-pill pill-active"><i class="bi bi-dot"></i> Active</span>
                                @elseif($school->status == 'suspended')
                                    <span class="status-pill pill-inactive"><i class="bi bi-dot"></i> Suspended</span>
                                @else
                                    <span class="status-pill pill-partial"><i class="bi bi-dot"></i> Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($school->trial_ends_at)
                                    <div class="{{ $school->trial_ends_at->isPast() ? 'text-danger' : 'text-success' }} small font-weight-bold">
                                        <i class="bi bi-clock-history mr-1"></i> {{ $school->trial_ends_at->format('M d, Y') }}
                                    </div>
                                    <small class="text-muted">{{ $school->trial_ends_at->diffForHumans() }}</small>
                                @else
                                    <span class="text-muted italic small">No trial active</span>
                                @endif
                            </td>
                            <td>
                                <div class="small font-weight-bold text-dark">
                                    <i class="bi bi-calendar-check mr-1 text-primary"></i>
                                    {{ $school->created_at->format('M d, Y') }}
                                </div>
                                <small class="text-muted">Registered Date</small>
                            </td>
                            <td class="text-right pr-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('super-admin.subscriptions.edit', $school) }}" class="btn-icon-sms text-primary" title="Manage Subscription">
                                        <i class="bi bi-gear-wide-connected"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                    <p>No subscriptions found matching your criteria.</p>
                                    <a href="{{ route('super-admin.subscriptions.index') }}" class="btn btn-sm btn-link text-primary">Clear all filters</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($schools->hasPages())
            <div class="card-footer bg-white border-top py-3 px-4">
                {{ $schools->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .hover-bg-light:hover { background-color: #fcfdfe; }
    .btn-icon-sms {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        background: #f8f9fa;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
        color: inherit;
    }
    .btn-icon-sms:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
        text-decoration: none;
    }
</style>
@endpush
@endsection
