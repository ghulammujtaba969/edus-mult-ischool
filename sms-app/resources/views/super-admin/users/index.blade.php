@extends('layouts.app')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--charcoal); margin: 0;">User Management</h1>
        <p style="color: #64748b; margin-top: 0.25rem;">Manage all system users across schools</p>
    </div>
    <a href="{{ route('super-admin.users.create') }}" class="btn-primary-sms">
        <i class="bi bi-person-plus"></i> Add New User
    </a>
</div>

<div class="list-toolbar">
    <form action="{{ route('super-admin.users.index') }}" method="GET" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; flex: 1;">
        <div class="search-wrap" style="flex: 1; min-width: 250px;">
            <i class="bi bi-search"></i>
            <input type="text" name="search" class="search-input" placeholder="Search by name or email..." value="{{ request('search') }}">
        </div>

        <select name="school_id" class="filter-select" style="min-width: 180px;" onchange="this.form.submit()">
            <option value="">All Schools</option>
            @foreach($schools as $school)
                <option value="{{ $school->id }}" @selected(request('school_id') == $school->id)>{{ $school->name }}</option>
            @endforeach
        </select>

        <select name="role" class="filter-select" style="min-width: 150px;" onchange="this.form.submit()">
            <option value="">All Roles</option>
            @foreach($roles as $role)
                <option value="{{ $role->value }}" @selected(request('role') == $role->value)>{{ $role->label() }}</option>
            @endforeach
        </select>

        @if(request()->anyFilled(['search', 'school_id', 'role']))
            <a href="{{ route('super-admin.users.index') }}" class="btn-outline-sms" title="Clear Filters">
                <i class="bi bi-x-circle"></i>
            </a>
        @endif
    </form>
</div>

<div class="card-sms" style="padding: 0; overflow: hidden;">
    <div class="table-responsive">
        <table class="sms-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>School</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div class="student-avatar" style="background: var(--coral-pale); color: var(--coral);">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700;">{{ $user->name }}</div>
                                    <div class="muted" style="font-size: 0.75rem;">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->school)
                                <div style="font-weight: 600;">{{ $user->school->name }}</div>
                            @else
                                <span class="muted" style="font-style: italic;">Platform Wide</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-pill pill-partial">
                                {{ $user->role->label() }}
                            </span>
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="status-pill pill-active">Active</span>
                            @else
                                <span class="status-pill pill-inactive">Inactive</span>
                            @endif
                        </td>
                        <td class="muted">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                <a href="{{ route('super-admin.users.permissions', $user) }}" class="btn-outline-sms" style="padding: 0.4rem; height: auto;" title="Manage Permissions">
                                    <i class="bi bi-key"></i>
                                </a>
                                <a href="{{ route('super-admin.users.edit', $user) }}" class="btn-outline-sms" style="padding: 0.4rem; height: auto;" title="Edit User">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('super-admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-outline-sms" style="padding: 0.4rem; height: auto; border-color: var(--danger-bg); color: var(--danger);" title="Delete User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 4rem; text-align: center;" class="muted">
                            <i class="bi bi-people" style="font-size: 3rem; display: block; margin-bottom: 1rem; opacity: 0.3;"></i>
                            No users found matching your filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div style="padding: 1rem 1.25rem; border-top: 1px solid var(--border);">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
