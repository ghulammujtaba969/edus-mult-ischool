@extends('layouts.app')

@section('title', 'Manage Schools | EduCore SaaS')
@section('page_title', 'Registered Schools')
@section('breadcrumb', '/ Super Admin / Schools')

@section('topbar_actions')
    <a href="{{ route('super-admin.schools.create') }}" class="btn-primary-sms"><i class="bi bi-plus-lg"></i> Register New School</a>
@endsection

@section('content')
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
            @foreach($schools as $school)
                <tr>
                    <td>
                        <div style="font-weight:700;color:var(--primary);">{{ $school->name }}</div>
                        <div style="font-size:.75rem;color:var(--text-light);">Slug: {{ $school->slug }}</div>
                    </td>
                    <td class="mono">
                        {{ $school->primaryDomain->domain ?? 'Not configured' }}
                    </td>
                    <td>
                        <span class="badge-sms badge-outline-sms">{{ $school->plan->name }}</span>
                    </td>
                    <td>
                        @if($school->status == 'active')
                            <span class="badge-sms badge-success-sms">Active</span>
                        @elseif($school->status == 'suspended')
                            <span class="badge-sms badge-danger-sms">Suspended</span>
                        @else
                            <span class="badge-sms badge-warning-sms">Pending</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $school->branches_count ?? 0 }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a href="{{ route('super-admin.schools.edit', $school) }}" class="btn-outline-sms" title="Edit School"><i class="bi bi-pencil"></i></a>
                            <a href="#" class="btn-outline-sms" title="Login as Admin"><i class="bi bi-box-arrow-in-right"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="margin-top:1.5rem;">
            {{ $schools->links() }}
        </div>
    </div>
@endsection
