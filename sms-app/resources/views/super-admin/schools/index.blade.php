@extends('layouts.app')

@section('title', 'Manage Schools | EduCore SaaS')
@section('page_title', 'Registered Schools')
@section('breadcrumb', '/ Super Admin / Schools')

@section('topbar_actions')
    <a href="{{ route('super-admin.schools.create') }}" class="btn-primary-sms"><i class="bi bi-plus-lg"></i> Register New School</a>
@endsection

@section('content')
    <div class="list-toolbar">
        <form action="{{ route('super-admin.schools.index') }}" method="GET" style="display: flex; gap: 0.75rem; flex: 1; align-items: center;">
            <div class="search-wrap" style="max-width: 400px;">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="search-input" placeholder="Search by name or slug..." value="{{ request('search') }}">
            </div>

            <select name="status" class="filter-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
            </select>

            <select name="plan_id" class="filter-select" style="width: 180px;" onchange="this.form.submit()">
                <option value="">All Plans</option>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" @selected(request('plan_id') == $plan->id)>{{ $plan->name }}</option>
                @endforeach
            </select>

            @if(request()->anyFilled(['search', 'status', 'plan_id']))
                <a href="{{ route('super-admin.schools.index') }}" class="btn-outline-sms" title="Clear Filters">
                    <i class="bi bi-x-circle"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>School Name</th>
                <th>Domain / Subdomain</th>
                <th>Plan</th>
                <th>Status</th>
                <th>Branches</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($schools as $school)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div class="student-avatar" style="background: var(--surface); color: var(--primary);">
                                {{ str($school->name)->substr(0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight:700;">{{ $school->name }}</div>
                                <div style="font-size:.75rem;color:var(--text-light);">Slug: <span class="mono">{{ $school->slug }}</span></div>
                            </div>
                        </div>
                    </td>
                    <td class="mono">
                        <span style="background: var(--surface); padding: 0.2rem 0.5rem; border-radius: 6px; font-size: 0.85rem;">
                            {{ $school->primaryDomain->domain ?? 'Not configured' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-sms badge-outline-sms" style="font-weight: 600;">{{ $school->plan->name }}</span>
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
                    <td class="text-center">
                        <span class="badge-sms" style="background: var(--surface); color: var(--text-dark);">{{ $school->branches_count ?? 0 }}</span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a href="{{ route('super-admin.schools.edit', $school) }}" class="btn-outline-sms" title="Edit School"><i class="bi bi-pencil"></i></a>
                            <a href="{{ route('super-admin.users.index', ['school_id' => $school->id]) }}" class="btn-outline-sms" title="Manage Users"><i class="bi bi-people"></i></a>
                            <a href="{{ route('super-admin.schools.impersonate', $school) }}" class="btn-outline-sms" title="Login as Admin"><i class="bi bi-box-arrow-in-right"></i></a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 4rem; color: var(--text-light);">
                        <i class="bi bi-search" style="font-size: 3rem; display: block; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <div style="font-size: 1.1rem; font-weight: 600;">No schools found matching your criteria.</div>
                        <div style="margin-top: 0.5rem;">Try adjusting your filters or search terms.</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div style="margin-top:1.5rem;">
            {{ $schools->links() }}
        </div>
    </div>
@endsection
