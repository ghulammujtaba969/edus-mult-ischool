@extends('layouts.app')

@section('title', 'Role Management')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--charcoal); margin: 0;">Role Management</h1>
        <p style="color: #64748b; margin-top: 0.25rem;">Define and manage staff roles and their permissions</p>
    </div>
    <a href="{{ route('admin.roles.create') }}" class="btn-primary-sms">
        <i class="bi bi-plus-lg"></i> Create New Role
    </a>
</div>

@if(session('success'))
    <div class="alert-sms alert-success-sms mb-4">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif

<div class="card-sms" style="padding: 0; overflow: hidden;">
    <div class="table-responsive">
        <table class="sms-table">
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Slug</th>
                    <th>Permissions</th>
                    <th>Description</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td style="font-weight: 700; color: var(--charcoal);">{{ $role->name }}</td>
                        <td><code>{{ $role->slug }}</code></td>
                        <td>
                            <span class="status-pill pill-partial">
                                {{ $role->permissions->count() }} Permissions
                            </span>
                        </td>
                        <td class="muted">{{ Str::limit($role->description, 50) }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn-outline-sms" style="padding: 0.4rem; height: auto;" title="Edit Role">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline-sms text-danger" style="padding: 0.4rem; height: auto;" title="Delete Role">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem;" class="muted">
                            <i class="bi bi-shield-slash" style="font-size: 2rem; display: block; margin-bottom: 1rem;"></i>
                            No roles defined yet. Create your first role to start managing permissions.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
