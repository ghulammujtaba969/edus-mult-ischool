@extends('layouts.app')

@section('title', 'Edit Role | SaaSAdmin')
@section('page_title', 'Edit Global Role')
@section('breadcrumb', 'Super Admin / Access Control / Roles / Edit')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.roles.index') }}">Global Roles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Edit Global Role: {{ $role->name }}</h1>
                <p class="text-muted small mb-0 mt-1">Modify role definitions and capability assignments for all school tenants.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('super-admin.roles.index') }}" class="btn-outline-sms px-4">
                    <i class="bi bi-arrow-left mr-2"></i> Back to Roles
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0" x-data="{
    toggleModule(module, checked) {
        const checkboxes = document.querySelectorAll(`.perm-group-${module}`);
        checkboxes.forEach(cb => {
            cb.checked = checked;
        });
    }
}">
    <form action="{{ route('super-admin.roles.update', $role) }}" method="POST" class="has-sticky-bar">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-info-circle mr-2"></i> Role Identity
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label for="name" class="form-label-sms">Role Display Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-sms @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $role->name) }}"
                                   placeholder="e.g. Campus Coordinator" required autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label for="description" class="form-label-sms">Role Description</label>
                            <textarea class="form-control-sms @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="2"
                                      placeholder="Briefly describe the responsibilities and scope of this role...">{{ old('description', $role->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="card-sms shadow-sm mb-5">
                    <div class="card-header-sms py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-shield-check mr-2"></i> Define Capabilities
                        </h6>
                        <span class="text-muted small">Select permissions to grant this role</span>
                    </div>
                    <div class="card-body p-4">
                        @foreach($permissions as $module => $modulePermissions)
                            <div class="mb-5 last-child-mb-0">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                    <h6 class="text-dark font-weight-bold mb-0">
                                        <i class="bi bi-folder2-open text-primary mr-2"></i> {{ $module }}
                                    </h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="module-{{ Str::slug($module) }}"
                                               @change="toggleModule('{{ Str::slug($module) }}', $event.target.checked)">
                                        <label class="form-check-label text-muted small cursor-pointer" for="module-{{ Str::slug($module) }}">Select All</label>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach($modulePermissions as $permission)
                                        <div class="col-xl-4 col-md-6 mb-3">
                                            <label class="permission-card p-3 rounded border d-block cursor-pointer transition-all h-100" for="perm-{{ $permission->id }}">
                                                <div class="d-flex align-items-start">
                                                    <div class="form-check custom-check-sms mb-0">
                                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                            class="form-check-input perm-group-{{ Str::slug($module) }}"
                                                            id="perm-{{ $permission->id }}"
                                                            @checked($role->permissions->contains($permission->id))>
                                                    </div>
                                                    <div class="ml-2">
                                                        <span class="d-block font-weight-bold text-dark mb-1 small">{{ $permission->name }}</span>
                                                        <span class="d-block text-muted tiny" style="line-height: 1.3;">{{ $permission->description ?: 'No detailed description available' }}</span>
                                                    </div>
                                                </div>
                                            </label>
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
                            <i class="bi bi-info-circle mr-2"></i> Metadata
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="metadata-item mb-4">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">System Identifier</label>
                            <div class="mono small text-primary bg-light p-2 rounded border">{{ $role->slug }}</div>
                            <small class="text-muted mt-1 d-block italic">This unique identifier is used for role-based access checks in code.</small>
                        </div>
                        <div class="metadata-item mb-4">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Creation Date</label>
                            <div class="small font-weight-bold text-dark">
                                <i class="bi bi-calendar-event mr-1"></i>
                                {{ $role->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="metadata-item mb-0">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Last Modification</label>
                            <div class="small font-weight-bold text-dark">
                                <i class="bi bi-clock-history mr-1"></i>
                                {{ $role->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky-save-bar">
            <div class="container-fluid d-flex justify-content-end align-items-center gap-2">
                <span class="text-muted small d-none d-md-inline mr-3">Role updates are synchronized across all schools immediately</span>
                <button type="submit" class="btn-primary-sms px-5 shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i> Save Global Role
                </button>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .has-sticky-bar { padding-bottom: 80px; }
    .permission-card { background: #fff; }
    .permission-card:hover { border-color: var(--primary) !important; background: #f8fbff; }
    .permission-card input:checked + div + div span.text-dark { color: var(--primary) !important; }
    .tiny { font-size: 0.7rem; }
    .last-child-mb-0:last-child { margin-bottom: 0 !important; }
    .custom-check-sms .form-check-input { width: 1.1rem; height: 1.1rem; margin-top: 0.1rem; cursor: pointer; }
</style>
@endpush
@endsection
