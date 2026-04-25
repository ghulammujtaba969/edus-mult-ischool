@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="{{ route('admin.roles.index') }}" class="btn-outline-sms" style="padding: 0.5rem; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--charcoal); margin: 0;">Edit Role: {{ $role->name }}</h1>
            <p style="color: #64748b; margin-top: 0.25rem;">Modify role details and permissions</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.roles.update', $role) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-4">
            <div class="card-sms mb-4">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--charcoal);">Role Details</h3>
                
                <div class="form-group-sms">
                    <label class="form-label-sms">Role Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control-sms @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" placeholder="e.g. Senior Teacher" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group-sms">
                    <label class="form-label-sms">Description</label>
                    <textarea name="description" class="form-control-sms @error('description') is-invalid @enderror" rows="3" placeholder="Briefly describe the responsibilities of this role...">{{ old('description', $role->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card-sms">
                <button type="submit" class="btn-primary-sms w-100">
                    <i class="bi bi-check-lg"></i> Update Role
                </button>
                <a href="{{ route('admin.roles.index') }}" class="btn-outline-sms w-100 mt-2" style="text-align: center; display: block;">
                    Cancel
                </a>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card-sms">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--charcoal);">Assign Permissions</h3>
                <p class="muted mb-4" style="font-size: 0.875rem;">Select the modules and actions this role is allowed to perform.</p>

                @foreach($permissions as $module => $modulePermissions)
                    <div class="module-permission-section mb-4 pb-3" style="border-bottom: 1px solid #f1f5f9;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--charcoal); margin: 0;">{{ $module }}</h4>
                            <button type="button" class="btn-outline-sms" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" onclick="toggleModule('{{ Str::slug($module) }}')">Toggle All</button>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 g-3" id="module-{{ Str::slug($module) }}">
                            @foreach($modulePermissions as $permission)
                                <div class="col">
                                    <div class="permission-checkbox-card" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; transition: all 0.2s ease;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm-{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm-{{ $permission->id }}" style="font-weight: 600; font-size: 0.875rem; color: var(--charcoal); cursor: pointer;">
                                                {{ $permission->name }}
                                                <small class="d-block text-muted" style="font-weight: 400; margin-top: 0.1rem;">{{ $permission->description }}</small>
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
</form>

<script>
    function toggleModule(moduleId) {
        const container = document.getElementById('module-' + moduleId);
        const checkboxes = container.querySelectorAll('input[type="checkbox"]');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
    }
</script>

<style>
    .permission-checkbox-card:hover {
        border-color: var(--coral) !important;
        background-color: rgba(232, 93, 58, 0.02);
    }
    .form-check-input:checked + .form-check-label {
        color: var(--coral) !important;
    }
</style>
@endsection
