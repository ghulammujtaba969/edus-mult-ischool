@extends('layouts.app')

@section('title', 'Global Roles | SaaSAdmin')
@section('page_title', 'Roles & Permissions')
@section('breadcrumb', 'Super Admin / Access Control / Roles')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Global Roles</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Global Roles Management</h1>
                <p class="text-muted small mb-0 mt-1">Define and manage system-wide roles available across all school tenants.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('super-admin.roles.create') }}" class="btn-primary-sms px-4 shadow-sm">
                    <i class="bi bi-plus-lg mr-2"></i> Add Global Role
                </a>
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

    <div class="card-sms shadow-sm mb-4">
        <div class="card-header-sms py-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-light">
            <h6 class="m-0 font-weight-bold text-dark">
                <i class="bi bi-shield-lock text-primary mr-2"></i> System Defined Roles
            </h6>
            <span class="status-pill pill-active" style="background: white; border: 1px solid #eee;">
                {{ count($roles) }} Total Roles
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="sms-table mb-0">
                    <thead>
                        <tr>
                            <th class="pl-4">Role Name</th>
                            <th>Identifier (Slug)</th>
                            <th>Permissions Count</th>
                            <th>Description Summary</th>
                            <th class="text-right pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr class="hover-bg-light transition-all">
                                <td class="pl-4">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar mr-3" style="width: 36px; height: 36px; background: var(--surface); color: var(--primary); font-size: 0.9rem;">
                                            {{ strtoupper(substr($role->name, 0, 1)) }}
                                        </div>
                                        <span class="font-weight-bold text-dark">{{ $role->name }}</span>
                                    </div>
                                </td>
                                <td><code class="mono text-primary bg-light px-2 py-1 rounded small" style="font-size: 0.75rem;">{{ $role->slug }}</code></td>
                                <td>
                                    <span class="status-pill pill-active" style="font-size: 0.75rem;">
                                        <i class="bi bi-key-fill mr-1"></i> {{ $role->permissions->count() }} Capabilties
                                    </span>
                                </td>
                                <td class="text-muted small">{{ Str::limit($role->description, 60) }}</td>
                                <td class="text-right pr-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('super-admin.roles.edit', $role) }}" 
                                           class="btn-outline-sms btn-sm" 
                                           title="Edit Role">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('super-admin.roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this global role? This may affect all schools using it.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-outline-sms btn-sm text-danger border-danger-hover" title="Delete Role">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .hover-bg-light:hover { background-color: #fcfdfe; }
    .border-danger-hover:hover { background-color: #fff5f5 !important; }
</style>
@endpush
@endsection
