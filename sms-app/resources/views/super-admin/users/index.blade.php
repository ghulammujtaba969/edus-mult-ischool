@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Management</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">System Users</h1>
                <p class="text-muted mb-0">Manage all system users and their platform access</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('super-admin.users.create') }}" class="btn-primary-sms px-4">
                    <i class="bi bi-person-plus mr-2"></i> Add New User
                </a>
            </div>
        </div>
    </div>
</div>

<div class="list-toolbar mb-4 bg-white p-3 rounded shadow-sm border">
    <form action="{{ route('super-admin.users.index') }}" method="GET" class="row align-items-center">
        <div class="col-lg-4 col-md-6 mb-2 mb-md-0">
            <div class="search-wrap position-relative">
                <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 50%; transform: translateY(-50%);"></i>
                <input type="text" name="search" class="form-control-sms pl-5" placeholder="Search by name or email..." value="{{ request('search') }}">
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2 mb-md-0">
            <select name="school_id" class="form-control-sms" onchange="this.form.submit()">
                <option value="">All Schools</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" @selected(request('school_id') == $school->id)>{{ $school->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-3 col-md-6 mb-2 mb-md-0">
            <select name="role" class="form-control-sms" onchange="this.form.submit()">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->value }}" @selected(request('role') == $role->value)>{{ $role->label() }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-2 col-md-6 d-flex gap-2">
            <button type="submit" class="btn-primary-sms flex-grow-1">Filter</button>
            @if(request()->anyFilled(['search', 'school_id', 'role']))
                <a href="{{ route('super-admin.users.index') }}" class="btn-outline-sms" title="Clear Filters">
                    <i class="bi bi-x-circle"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<div class="card-sms shadow-sm border-0">
    <div class="table-responsive">
        <table class="sms-table mb-0">
            <thead>
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">School Assignment</th>
                    <th class="px-4 py-3">System Role</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Joined Date</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="transition-all">
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sms mr-3 bg-light text-primary font-weight-bold d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-weight-bold text-dark">{{ $user->name }}</div>
                                    <div class="small text-muted">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if($user->school)
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-building mr-2 text-muted"></i>
                                    <span class="font-weight-600 text-dark">{{ $user->school->name }}</span>
                                </div>
                            @else
                                <span class="badge badge-soft-secondary px-2 py-1">
                                    <i class="bi bi-globe mr-1"></i> Platform Wide
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="status-pill pill-partial">
                                {{ $user->role->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($user->is_active)
                                <span class="status-pill pill-active">
                                    <i class="bi bi-check-circle-fill mr-1"></i> Active
                                </span>
                            @else
                                <span class="status-pill pill-inactive">
                                    <i class="bi bi-dash-circle-fill mr-1"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-muted small">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('super-admin.users.permissions', $user) }}" class="btn-icon-sms" title="Manage Permissions">
                                    <i class="bi bi-key"></i>
                                </a>
                                <a href="{{ route('super-admin.users.edit', $user) }}" class="btn-icon-sms" title="Edit User Account">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('super-admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-sms text-danger border-danger-soft" title="Delete User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-people text-muted" style="font-size: 3.5rem; opacity: 0.2;"></i>
                                <h5 class="mt-3 text-dark">No users found</h5>
                                <p class="text-muted">Try adjusting your filters or search terms.</p>
                                @if(request()->anyFilled(['search', 'school_id', 'role']))
                                    <a href="{{ route('super-admin.users.index') }}" class="btn-outline-sms mt-2">
                                        Clear All Filters
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $users->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
    .btn-icon-sms {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        color: #64748b;
        transition: all 0.2s;
        background: white;
    }
    .btn-icon-sms:hover {
        background: #f8fafc;
        color: var(--primary);
        border-color: var(--primary-soft);
        text-decoration: none;
    }
    .btn-icon-sms.text-danger:hover {
        color: #ef4444;
        background: #fef2f2;
        border-color: #fee2e2;
    }
    .badge-soft-secondary {
        background-color: #f1f5f9;
        color: #475569;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .transition-all {
        transition: all 0.2s ease;
    }
    tr.transition-all:hover {
        background-color: #fbfcfd;
    }
</style>
@endpush
@endsection
