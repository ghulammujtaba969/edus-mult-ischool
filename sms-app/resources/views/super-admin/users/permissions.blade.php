@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Granular Permissions: {{ $user->name }}</h1>
                <p class="text-muted small mb-0 mt-1">Directly manage individual access capabilities for this specific user account.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('super-admin.users.index') }}" class="btn-outline-sms px-4">
                    <i class="bi bi-arrow-left mr-2"></i> Back to Users
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0" x-data="{ 
    isSuperAdmin: {{ $user->isSuperAdmin() ? 'true' : 'false' }},
    toggleModule(module, checked) {
        if (this.isSuperAdmin) return;
        const checkboxes = document.querySelectorAll(`.perm-group-${module}`);
        checkboxes.forEach(cb => {
            cb.checked = checked;
        });
    }
}">
    @if($user->isSuperAdmin())
        <div class="alert alert-info border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #4e73df !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle-fill mr-3 fs-4"></i>
                <div>
                    <h6 class="font-weight-bold mb-1">Super Admin Account Detected</h6>
                    <p class="small mb-0">This user is assigned the <strong>{{ $user->role->name }}</strong> role which grants full system access. Manual permission overrides are disabled for security reasons.</p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('super-admin.users.permissions.update', $user) }}" method="POST" class="has-sticky-bar">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-shield-check mr-2"></i> Permission Matrix
                        </h6>
                        <span class="status-pill pill-active">
                            Role: {{ $user->role->name }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @foreach($permissions as $module => $modulePermissions)
                            <div class="permission-module {{ !$loop->last ? 'mb-5' : '' }}" x-data="{ 
                                allChecked: false,
                                init() {
                                    this.checkStatus();
                                },
                                checkStatus() {
                                    const moduleSlug = '{{ Str::slug($module) }}';
                                    const total = document.querySelectorAll('.perm-group-' + moduleSlug).length;
                                    const checked = document.querySelectorAll('.perm-group-' + moduleSlug + ':checked').length;
                                    this.allChecked = total > 0 && total === checked;
                                }
                            }">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                    <h5 class="text-dark font-weight-bold mb-0 h6">
                                        <i class="bi bi-folder2-open mr-2 text-primary"></i>
                                        {{ $module }}
                                        <span class="badge badge-light ml-2 font-weight-normal text-muted" style="font-size: 0.7rem;">
                                            {{ count($modulePermissions) }} Items
                                        </span>
                                    </h5>
                                    
                                    @if(!$user->isSuperAdmin())
                                    <div class="form-check form-switch p-0 m-0 d-flex align-items-center">
                                        <label class="small font-weight-bold text-muted mr-2 mb-0" for="select-all-{{ Str::slug($module) }}">
                                            Select All
                                        </label>
                                        <input class="form-check-input ml-0" type="checkbox" id="select-all-{{ Str::slug($module) }}" 
                                            x-model="allChecked" 
                                            @change="toggleModule('{{ Str::slug($module) }}', $event.target.checked)"
                                            style="width: 34px; height: 17px; cursor: pointer; position: static;">
                                    </div>
                                    @endif
                                </div>

                                <div class="row">
                                    @foreach($modulePermissions as $permission)
                                        <div class="col-xl-4 col-md-6 mb-3">
                                            <div class="permission-card p-3 border rounded transition-all {{ in_array($permission->id, $userPermissions) ? 'is-selected' : '' }}" 
                                                style="background: #fcfdfe; cursor: pointer;"
                                                @click="if(!isSuperAdmin) { $refs.checkbox_{{ $permission->id }}.click() }">
                                                <div class="custom-control custom-checkbox pointer-events-none">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                                        class="custom-control-input perm-group-{{ Str::slug($module) }}" 
                                                        id="perm-{{ $permission->id }}"
                                                        x-ref="checkbox_{{ $permission->id }}"
                                                        {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}
                                                        {{ $user->isSuperAdmin() ? 'disabled' : '' }}
                                                        @change="checkStatus(); $el.closest('.permission-card').classList.toggle('is-selected', $el.checked)"
                                                        @click.stop>
                                                    <label class="custom-control-label d-block" for="perm-{{ $permission->id }}">
                                                        <span class="d-block font-weight-bold text-dark mb-1" style="font-size: 0.85rem;">
                                                            {{ $permission->name }}
                                                        </span>
                                                        <small class="text-muted d-block lh-sm" style="font-size: 0.75rem;">
                                                            {{ $permission->description }}
                                                        </small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-sms shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-person-badge mr-2"></i> User Overview
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="user-avatar mr-3" style="width: 48px; height: 48px; background: rgba(78, 115, 223, 0.1); color: #4e73df; font-weight: 700; font-size: 1.2rem;">
                                {{ str($user->name)->substr(0, 1)->upper() }}
                            </div>
                            <div>
                                <h6 class="font-weight-bold text-dark mb-0">{{ $user->name }}</h6>
                                <p class="text-muted small mb-0">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="info-group mb-3">
                            <label class="small text-muted font-weight-bold text-uppercase mb-1 d-block">System Role</label>
                            <div class="p-2 bg-light rounded border small font-weight-bold text-dark">
                                <i class="bi bi-shield-lock mr-2 text-primary"></i> {{ $user->role->name }}
                            </div>
                        </div>

                        <div class="info-group mb-0 pt-3 border-top">
                            <h6 class="font-weight-bold small text-dark">About Permissions</h6>
                            <p class="text-muted small mb-0">Changes here will override any role-based permissions for this specific user. Use sparingly to avoid maintenance complexity.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!$user->isSuperAdmin())
            <div class="sticky-save-bar">
                <div class="container-fluid d-flex justify-content-end align-items-center gap-2">
                    <span class="text-muted small d-none d-md-inline mr-3">Applying changes will immediately update user capabilities</span>
                    <button type="submit" class="btn-primary-sms px-5 shadow-sm">
                        <i class="bi bi-save mr-2"></i> Save Permission Changes
                    </button>
                </div>
            </div>
        @endif
    </form>
</div>

@push('styles')
<style>
    .has-sticky-bar {
        padding-bottom: 80px;
    }
    .permission-card {
        border-color: #eaecf4 !important;
        transition: all 0.2s ease;
    }
    .permission-card:hover {
        border-color: #d1d3e2 !important;
        background: #f8f9fc !important;
        transform: translateY(-2px);
    }
    .permission-card.is-selected {
        background: rgba(78, 115, 223, 0.03) !important;
        border-color: rgba(78, 115, 223, 0.3) !important;
    }
    .permission-card.is-selected .custom-control-label::before {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .form-switch .form-check-input {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
    }
    .form-switch .form-check-input:checked {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
    }
    .pointer-events-none {
        pointer-events: none;
    }
    .lh-sm {
        line-height: 1.25;
    }
</style>
@endpush
@endsection

