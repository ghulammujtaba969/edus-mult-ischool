@extends('layouts.app')

@section('title', 'User Permissions | EduCore SMS')
@section('page_title', 'User Permissions')
@section('breadcrumb', 'Admin / Users / Permissions')

@php
    $directCount = count($userPermissions);
    $roleCount = count($userRoles);
    $permissionTotal = $permissions->flatten()->count();
@endphp

@section('content')
<form action="{{ route('admin.users.permissions.update', $user) }}" method="POST" class="access-page">
    @csrf
    @method('PUT')

    <div class="access-head">
        <div>
            <span class="eyebrow">Access Control</span>
            <h1>Manage Permissions</h1>
            <p>Assign roles and direct capability overrides for {{ $user->name }}.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.employees.index') }}" class="btn-outline-sms"><i class="bi bi-arrow-left"></i> Back to Staff</a>
            <button type="submit" class="btn-primary-sms"><i class="bi bi-shield-check"></i> Update Permissions</button>
        </div>
    </div>

    <div class="access-layout">
        <aside class="access-sidebar">
            <section class="access-user-card">
                <div class="access-avatar">{{ str($user->name)->substr(0, 2)->upper() }}</div>
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
                <span class="status-pill {{ $user->is_active ? 'pill-active' : 'pill-inactive' }}">
                    <i class="bi bi-circle-fill"></i> {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>

                <div class="access-mini-grid">
                    <div><strong>{{ $roleCount }}</strong><span>Roles</span></div>
                    <div><strong>{{ $directCount }}</strong><span>Direct</span></div>
                    <div><strong>{{ $permissionTotal }}</strong><span>Available</span></div>
                </div>
            </section>

            <section class="access-side-card">
                <div class="section-heading-saas compact">
                    <div class="section-icon coral"><i class="bi bi-person-badge"></i></div>
                    <div><h3>Assigned Roles</h3><p>Inherited permission bundles</p></div>
                </div>

                <div class="role-stack">
                    @forelse($roles as $role)
                        <label class="role-select-card">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" @checked(in_array($role->id, $userRoles))>
                            <span>
                                <strong>{{ $role->name }}</strong>
                                <small>{{ $role->description ?: 'No description added' }}</small>
                            </span>
                        </label>
                    @empty
                        <div class="empty-access-state">
                            <i class="bi bi-shield-exclamation"></i>
                            <p>No roles available.</p>
                            <a href="{{ route('admin.roles.create') }}">Create role</a>
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="access-side-card">
                <h3 class="side-title">Permission Notes</h3>
                <p class="side-copy">Direct permissions supplement the selected roles. Keep direct overrides limited so future role changes remain predictable.</p>
                <div class="access-hint">
                    <i class="bi bi-lightbulb"></i>
                    <span>Use module select-all only when the user truly owns that workflow.</span>
                </div>
            </section>
        </aside>

        <main class="access-main">
            <section class="access-toolbar">
                <div>
                    <h2>Direct Permissions</h2>
                    <p>Grant granular access beyond role defaults.</p>
                </div>
                <div class="search-wrap access-search">
                    <i class="bi bi-search"></i>
                    <input type="text" class="search-input" placeholder="Search permissions..." oninput="filterPermissionCards(this.value)">
                </div>
            </section>

            <section class="permission-workspace">
                @foreach($permissions as $module => $modulePermissions)
                    @php
                        $moduleSlug = Str::slug($module);
                        $checkedCount = $modulePermissions->whereIn('id', $userPermissions)->count();
                    @endphp
                    <div class="access-module" data-permission-module>
                        <div class="access-module-head">
                            <div>
                                <h3><i class="bi bi-folder2-open"></i> {{ $module }}</h3>
                                <p>{{ $checkedCount }} of {{ count($modulePermissions) }} direct permissions selected</p>
                            </div>
                            <button type="button" class="btn-outline-sms btn-small" onclick="toggleModule('{{ $moduleSlug }}')">
                                <i class="bi bi-check2-square"></i> Toggle All
                            </button>
                        </div>

                        <div class="access-permission-grid" id="module-{{ $moduleSlug }}">
                            @foreach($modulePermissions as $permission)
                                <label class="access-permission-card {{ in_array($permission->id, $userPermissions) ? 'selected' : '' }}" data-permission-card data-search="{{ Str::lower($module . ' ' . $permission->name . ' ' . $permission->description) }}">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked(in_array($permission->id, $userPermissions)) onchange="this.closest('.access-permission-card').classList.toggle('selected', this.checked)">
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
            <span class="text-muted small d-none d-md-inline mr-3">Changes apply immediately after saving</span>
            <a href="{{ route('admin.employees.index') }}" class="btn-outline-sms">Cancel</a>
            <button type="submit" class="btn-primary-sms"><i class="bi bi-save"></i> Save Permission Changes</button>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
.access-page { padding-bottom:90px; }
.access-head { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; margin-bottom:1.25rem; }
.access-head h1 { margin:.15rem 0 .25rem; font-size:1.65rem; }
.access-head p { margin:0; color:var(--text-mid); }
.access-layout { display:grid; grid-template-columns:310px minmax(0, 1fr); gap:1.25rem; align-items:start; }
.access-sidebar { display:grid; gap:1rem; position:sticky; top:92px; }
.access-user-card, .access-side-card, .access-toolbar, .permission-workspace { background:white; border:1px solid var(--border); border-radius:16px; }
.access-user-card { padding:1.25rem; text-align:center; }
.access-avatar { width:76px; height:76px; border-radius:22px; background:var(--coral); color:white; display:inline-flex; align-items:center; justify-content:center; font-weight:800; font-size:1.45rem; margin-bottom:.85rem; }
.access-user-card h2 { margin:0; font-size:1.15rem; }
.access-user-card p { margin:.25rem 0 .75rem; color:var(--text-mid); overflow-wrap:anywhere; }
.access-mini-grid { display:grid; grid-template-columns:repeat(3, 1fr); gap:.45rem; margin-top:1rem; }
.access-mini-grid div { border:1px solid var(--border); border-radius:12px; padding:.65rem .35rem; }
.access-mini-grid strong { display:block; }
.access-mini-grid span { color:var(--text-light); font-size:.7rem; }
.access-side-card { padding:1rem; }
.section-heading-saas.compact { margin-bottom:.85rem; }
.section-heading-saas.compact .section-icon { width:36px; height:36px; border-radius:10px; }
.section-heading-saas.compact h3 { font-size:.95rem; }
.role-stack { display:grid; gap:.65rem; }
.role-select-card { display:flex; gap:.65rem; padding:.8rem; border:1px solid var(--border); border-radius:12px; cursor:pointer; }
.role-select-card:has(input:checked) { border-color:var(--coral-border); background:var(--coral-pale); }
.role-select-card input { margin-top:.18rem; accent-color:var(--coral); }
.role-select-card strong, .role-select-card small { display:block; }
.role-select-card small { margin-top:.15rem; color:var(--text-light); font-size:.76rem; }
.empty-access-state { text-align:center; color:var(--text-mid); padding:1rem; }
.empty-access-state i { font-size:1.8rem; color:var(--coral); }
.side-title { margin:0 0 .5rem; font-size:.95rem; }
.side-copy { color:var(--text-mid); font-size:.84rem; line-height:1.55; margin:0 0 .85rem; }
.access-hint { display:flex; gap:.65rem; padding:.75rem; border-radius:12px; background:var(--warning-bg); color:var(--warning); font-size:.8rem; line-height:1.4; }
.access-main { display:grid; gap:1rem; min-width:0; }
.access-toolbar { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1rem 1.25rem; }
.access-toolbar h2 { margin:0; font-size:1.05rem; }
.access-toolbar p { margin:.2rem 0 0; color:var(--text-light); font-size:.84rem; }
.access-search { max-width:320px; }
.permission-workspace { padding:1rem; display:grid; gap:1rem; }
.access-module { border:1px solid var(--border); border-radius:14px; overflow:hidden; }
.access-module-head { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1rem; background:var(--surface); border-bottom:1px solid var(--border); }
.access-module-head h3 { margin:0; font-size:.98rem; display:flex; align-items:center; gap:.5rem; }
.access-module-head h3 i { color:var(--coral); }
.access-module-head p { margin:.2rem 0 0; color:var(--text-light); font-size:.8rem; }
.access-permission-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:.8rem; padding:1rem; }
.access-permission-card { display:flex; align-items:flex-start; gap:.75rem; padding:.9rem; border:1px solid var(--border); border-radius:12px; cursor:pointer; background:white; transition:.18s; }
.access-permission-card:hover { border-color:var(--coral-border); background:var(--coral-pale); }
.access-permission-card.selected { border-color:var(--coral); background:var(--coral-pale); }
.access-permission-card input { position:absolute; opacity:0; pointer-events:none; }
.permission-check { width:22px; height:22px; border-radius:7px; border:1px solid var(--border); display:inline-flex; align-items:center; justify-content:center; color:white; flex:0 0 auto; margin-top:.05rem; }
.access-permission-card.selected .permission-check { background:var(--coral); border-color:var(--coral); }
.access-permission-card strong { display:block; font-size:.86rem; }
.access-permission-card small { display:block; color:var(--text-light); margin-top:.2rem; font-size:.76rem; line-height:1.35; }
.btn-small { padding:.45rem .7rem; font-size:.78rem; }
.status-pill i { font-size:.45rem; }
@media (max-width:1100px) {
    .access-layout { grid-template-columns:1fr; }
    .access-sidebar { position:static; grid-template-columns:repeat(2, minmax(0, 1fr)); }
    .access-user-card { grid-column:1 / -1; }
}
@media (max-width:760px) {
    .access-head, .access-toolbar, .access-module-head { flex-direction:column; align-items:stretch; }
    .access-sidebar, .access-permission-grid { grid-template-columns:1fr; }
    .access-search { max-width:none; }
}
</style>
@endpush

@push('scripts')
<script>
function toggleModule(moduleId) {
    const container = document.getElementById('module-' + moduleId);
    const checkboxes = container.querySelectorAll('input[type="checkbox"]');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

    checkboxes.forEach(cb => {
        cb.checked = !allChecked;
        cb.closest('.access-permission-card').classList.toggle('selected', cb.checked);
    });
}

function filterPermissionCards(value) {
    const q = value.trim().toLowerCase();
    document.querySelectorAll('[data-permission-card]').forEach(card => {
        card.style.display = card.dataset.search.includes(q) ? '' : 'none';
    });

    document.querySelectorAll('[data-permission-module]').forEach(module => {
        const visible = Array.from(module.querySelectorAll('[data-permission-card]')).some(card => card.style.display !== 'none');
        module.style.display = visible ? '' : 'none';
    });
}
</script>
@endpush
