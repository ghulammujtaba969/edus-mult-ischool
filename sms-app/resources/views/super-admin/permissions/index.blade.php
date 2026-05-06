@extends('layouts.app')

@section('title', 'Permissions | SaaSAdmin')
@section('page_title', 'Permissions Matrix')
@section('breadcrumb', 'Super Admin / Access Control / Permissions')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Permissions Management</h1>
                <p class="text-muted small mb-0 mt-1">Manage individual granular permissions grouped by system modules.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('super-admin.permissions.create') }}" class="btn-primary-sms px-4">
                    <i class="bi bi-plus-lg mr-2"></i> Add Permission
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

    @foreach($permissions as $module => $modulePermissions)
        <div class="card-sms shadow-sm mb-4">
            <div class="card-header-sms py-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-light">
                <h6 class="m-0 font-weight-bold text-dark">
                    <i class="bi bi-folder2-open text-primary mr-2"></i> {{ $module }}
                </h6>
                <span class="status-pill pill-active" style="background: white; border: 1px solid #eee;">
                    {{ count($modulePermissions) }} Permissions
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="sms-table mb-0">
                        <thead>
                            <tr>
                                <th class="pl-4" style="width: 250px;">Permission Name</th>
                                <th style="width: 200px;">Slug</th>
                                <th>Description</th>
                                <th class="text-right pr-4" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modulePermissions as $permission)
                                <tr class="hover-bg-light transition-all">
                                    <td class="pl-4">
                                        <span class="font-weight-bold text-dark">{{ $permission->name }}</span>
                                    </td>
                                    <td><code class="mono text-primary bg-light px-2 py-1 rounded small" style="font-size: 0.75rem;">{{ $permission->slug }}</code></td>
                                    <td class="text-muted small">{{ $permission->description }}</td>
                                    <td class="text-right pr-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('super-admin.permissions.edit', $permission) }}" 
                                               class="btn-outline-sms btn-sm" 
                                               title="Edit Permission">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('super-admin.permissions.destroy', $permission) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this permission? This may break roles that rely on it.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-outline-sms btn-sm text-danger border-danger-hover" title="Delete Permission">
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
    @endforeach
</div>

@push('styles')
<style>
    .hover-bg-light:hover { background-color: #fcfdfe; }
    .border-danger-hover:hover { background-color: #fff5f5 !important; }
</style>
@endpush
@endsection
