@extends('layouts.app')

@section('title', 'Edit Role | EduCore SMS')
@section('page_title', 'Edit Role')
@section('breadcrumb', 'Admin / Roles / Edit')

@section('content')
<form action="{{ route('admin.roles.update', $role) }}" method="POST" class="role-builder-page">
    @csrf
    @method('PUT')

    <div class="role-builder-head">
        <div>
            <span class="eyebrow">Access Control</span>
            <h1>Edit Role - <span>{{ $role->name }}</span></h1>
            <p>Modify role details and update the permission bundle.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.roles.index') }}" class="btn-outline-sms"><i class="bi bi-arrow-left"></i> Back to Roles</a>
            <button type="submit" class="btn-primary-sms"><i class="bi bi-check-lg"></i> Update Role</button>
        </div>
    </div>

    <div class="role-builder-layout">
        <aside class="role-builder-sidebar">
            <section class="role-side-card">
                <div class="section-heading-saas compact">
                    <div class="section-icon coral"><i class="bi bi-shield-lock"></i></div>
                    <div><h3>Role Details</h3><p>Name and responsibility scope</p></div>
                </div>

                <div class="form-group-sms">
                    <label class="form-label-sms">Role Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control-sms @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group-sms">
                    <label class="form-label-sms">Description</label>
                    <textarea name="description" class="form-control-sms form-textarea @error('description') is-invalid @enderror">{{ old('description', $role->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </section>

            <section class="role-side-card">
                <h3 class="side-title">Role Snapshot</h3>
                <div class="quick-detail"><span>Slug</span><strong>{{ $role->slug }}</strong></div>
                <div class="quick-detail"><span>Permissions</span><strong>{{ count($rolePermissions) }}</strong></div>
                <div class="quick-detail"><span>Updated</span><strong>{{ $role->updated_at->diffForHumans() }}</strong></div>
            </section>

            <div class="side-actions">
                <button type="submit" class="btn-primary-sms"><i class="bi bi-check-lg"></i> Update Role</button>
                <a href="{{ route('admin.roles.index') }}" class="btn-outline-sms">Cancel</a>
            </div>
        </aside>

        <main class="role-builder-main">
            <section class="role-permission-toolbar">
                <div>
                    <h2>Assign Permissions</h2>
                    <p>{{ count($rolePermissions) }} permissions currently selected.</p>
                </div>
                <div class="search-wrap role-search">
                    <i class="bi bi-search"></i>
                    <input type="text" class="search-input" placeholder="Search permissions..." oninput="filterRolePermissionCards(this.value)">
                </div>
            </section>

            <section class="role-permission-workspace">
                @foreach($permissions as $module => $modulePermissions)
                    @php
                        $moduleSlug = Str::slug($module);
                        $selectedCount = $modulePermissions->whereIn('id', $rolePermissions)->count();
                    @endphp
                    <div class="role-module" data-role-module>
                        <div class="role-module-head">
                            <div>
                                <h3><i class="bi bi-folder2-open"></i> {{ $module }}</h3>
                                <p>{{ $selectedCount }} of {{ count($modulePermissions) }} selected</p>
                            </div>
                            <button type="button" class="btn-outline-sms btn-small" onclick="toggleRoleModule('{{ $moduleSlug }}')">
                                <i class="bi bi-check2-square"></i> Toggle All
                            </button>
                        </div>

                        <div class="role-permission-grid" id="module-{{ $moduleSlug }}">
                            @foreach($modulePermissions as $permission)
                                <label class="role-permission-card {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'selected' : '' }}" data-role-permission-card data-search="{{ Str::lower($module . ' ' . $permission->name . ' ' . $permission->description) }}">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked(in_array($permission->id, old('permissions', $rolePermissions))) onchange="this.closest('.role-permission-card').classList.toggle('selected', this.checked)">
                                    <span class="permission-check"><i class="bi bi-check-lg"></i></span>
                                    <span>
                                        <strong>{{ $permission->name }}</strong>
                                        <small>{{ $permission->description ?: 'No detailed description available.' }}</small>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </section>
        </main>
    </div>

    <div class="sticky-save-bar">
        <div class="container-fluid d-flex justify-content-end align-items-center gap-2">
            <span class="text-muted small d-none d-md-inline mr-3">Role changes apply to assigned users immediately</span>
            <a href="{{ route('admin.roles.index') }}" class="btn-outline-sms">Cancel</a>
            <button type="submit" class="btn-primary-sms"><i class="bi bi-save"></i> Save Changes</button>
        </div>
    </div>
</form>
@include('admin.roles.partials.builder-styles')
@endsection
