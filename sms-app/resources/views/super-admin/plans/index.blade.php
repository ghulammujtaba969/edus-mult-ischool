@extends('layouts.app')

@section('title', 'Subscription Plans | SaaS Admin')
@section('page_title', 'Subscription Plans')
@section('breadcrumb', '/ Super Admin / Plans')

@section('topbar_actions')
    <a href="{{ route('super-admin.plans.create') }}" class="btn-primary-sms"><i class="bi bi-plus-lg"></i> Create New Plan</a>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Subscription Plans</h1>
            <p class="text-muted small mb-0">Manage and configure different subscription packages for schools.</p>
        </div>
        <a href="{{ route('super-admin.plans.create') }}" class="btn-primary-sms shadow-sm">
            <i class="bi bi-plus-lg"></i> Create New Plan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card-sms shadow-sm mb-4" style="overflow: hidden;">
        <div class="table-responsive">
            <table class="sms-table">
                <thead>
                    <tr>
                        <th>Plan Name</th>
                        <th>Price</th>
                        <th>Limits</th>
                        <th>Features</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                        <tr class="hover-bg-light transition-all">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar mr-3" style="width: 32px; height: 32px; font-size: 0.8rem; background: var(--surface); color: var(--primary);">
                                        {{ substr($plan->name, 0, 1) }}
                                    </div>
                                    <span class="font-weight-bold text-dark">{{ $plan->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark">PKR {{ number_format($plan->monthly_price, 2) }}</div>
                                <small class="text-muted">per month</small>
                            </td>
                            <td>
                                <div class="badge-sms badge-outline-sms" style="font-weight: 600;">
                                    <i class="bi bi-diagram-3 mr-1"></i> {{ $plan->max_branches }} Branches
                                </div>
                            </td>
                            <td>
                                @if(is_array($plan->features))
                                    <div class="text-primary small font-weight-bold">
                                        <i class="bi bi-list-check mr-1"></i> {{ count($plan->features) }} Enabled
                                    </div>
                                @else
                                    <span class="text-muted italic small">No features</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->is_active)
                                    <span class="status-pill pill-active"><i class="bi bi-dot"></i> Active</span>
                                @else
                                    <span class="status-pill pill-inactive"><i class="bi bi-dot"></i> Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <a href="{{ route('super-admin.plans.edit', $plan) }}" class="btn-icon-sms text-info hover-shadow" title="Edit Plan">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('super-admin.plans.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-sms text-danger hover-shadow" title="Delete Plan">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($plans->hasPages())
            <div style="padding: 1rem 1.25rem; border-top: 1px solid var(--border);">
                {{ $plans->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .hover-bg-light:hover {
        background-color: #fafafa;
    }
    .btn-icon-sms {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f8f9fa;
        border: 1px solid var(--border);
        transition: all 0.2s;
        cursor: pointer;
    }
    .btn-icon-sms:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
</style>
@endsection
