@extends('layouts.app')

@section('title', 'Subscription Plans | SaaS Admin')
@section('page_title', 'Subscription Plans')
@section('breadcrumb', '/ Super Admin / Plans')

@section('topbar_actions')
    <a href="{{ route('super-admin.plans.create') }}" class="btn-primary-sms"><i class="bi bi-plus-lg"></i> Create New Plan</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
                <tr>
                    <th>Plan Name</th>
                    <th>Price</th>
                    <th>Max Branches</th>
                    <th>Features</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plans as $plan)
                    <tr>
                        <td style="font-weight:700;color:var(--primary);">{{ $plan->name }}</td>
                        <td class="mono">PKR {{ number_format($plan->monthly_price, 2) }} / mo</td>
                        <td>{{ $plan->max_branches }} Branches</td>
                        <td>
                            @if(is_array($plan->features))
                                <div style="font-size: 0.8rem;">
                                    {{ count($plan->features) }} Features
                                </div>
                            @else
                                <span class="muted">No features listed</span>
                            @endif
                        </td>
                        <td>
                            @if($plan->is_active)
                                <span class="badge-sms badge-success-sms">Active</span>
                            @else
                                <span class="badge-sms badge-danger-sms">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:.5rem;">
                                <a href="{{ route('super-admin.plans.edit', $plan) }}" class="btn-outline-sms" title="Edit Plan"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('super-admin.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline-sms" style="color:var(--coral);" title="Delete Plan"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1.5rem;">
            {{ $plans->links() }}
        </div>
    </div>
@endsection
