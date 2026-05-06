@extends('layouts.app')

@section('title', 'Role Management | EduCore SMS')
@section('page_title', 'Role Management')
@section('breadcrumb', 'Admin / Roles')

@section('content')
<div class="roles-page">
    <div class="roles-head">
        <div>
            <span class="eyebrow">Access Control</span>
            <h1>Role Management</h1>
            <p>Define staff roles and maintain permission bundles for your school.</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn-primary-sms">
            <i class="bi bi-plus-lg"></i> Create New Role
        </a>
    </div>

    <div class="roles-summary">
        <div><i class="bi bi-shield-lock"></i><strong>{{ $roles->count() }}</strong><span>Total Roles</span></div>
        <div><i class="bi bi-key"></i><strong>{{ $roles->sum(fn ($role) => $role->permissions->count()) }}</strong><span>Assigned Permissions</span></div>
        <div><i class="bi bi-check-circle"></i><strong>{{ $roles->where('permissions_count', '>', 0)->count() ?: $roles->filter(fn ($role) => $role->permissions->count() > 0)->count() }}</strong><span>Configured</span></div>
    </div>

    <div class="roles-card-grid">
        @forelse($roles as $role)
            <article class="role-management-card">
                <div class="role-card-top">
                    <div class="role-icon">{{ Str::of($role->name)->substr(0, 2)->upper() }}</div>
                    <div>
                        <h2>{{ $role->name }}</h2>
                        <code>{{ $role->slug }}</code>
                    </div>
                </div>

                <p>{{ $role->description ?: 'No description added for this role yet.' }}</p>

                <div class="role-card-meta">
                    <span><i class="bi bi-key-fill"></i> {{ $role->permissions->count() }} permissions</span>
                    <span><i class="bi bi-clock-history"></i> {{ $role->updated_at->diffForHumans() }}</span>
                </div>

                <div class="role-card-actions">
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn-outline-sms"><i class="bi bi-pencil"></i> Edit</a>
                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-outline-sms text-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </article>
        @empty
            <div class="roles-empty">
                <i class="bi bi-shield-slash"></i>
                <h2>No roles defined yet</h2>
                <p>Create your first role to start managing staff permissions.</p>
                <a href="{{ route('admin.roles.create') }}" class="btn-primary-sms"><i class="bi bi-plus-lg"></i> Create Role</a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
.roles-head { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; margin-bottom:1.25rem; }
.roles-head h1 { margin:.15rem 0 .25rem; font-size:1.65rem; }
.roles-head p { margin:0; color:var(--text-mid); }
.roles-summary { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:1rem; margin-bottom:1.25rem; }
.roles-summary div { background:white; border:1px solid var(--border); border-radius:16px; padding:1rem; display:flex; align-items:center; gap:.8rem; }
.roles-summary i { width:38px; height:38px; border-radius:12px; background:var(--coral-pale); color:var(--coral); display:inline-flex; align-items:center; justify-content:center; }
.roles-summary strong { font-size:1.2rem; }
.roles-summary span { color:var(--text-light); font-size:.82rem; margin-left:auto; }
.roles-card-grid { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:1rem; }
.role-management-card, .roles-empty { background:white; border:1px solid var(--border); border-radius:16px; padding:1rem; }
.role-card-top { display:flex; align-items:center; gap:.8rem; margin-bottom:1rem; }
.role-icon { width:46px; height:46px; border-radius:14px; background:var(--coral); color:white; display:flex; align-items:center; justify-content:center; font-weight:800; }
.role-card-top h2 { margin:0; font-size:1rem; }
.role-card-top code { display:inline-block; margin-top:.25rem; color:var(--text-light); font-size:.75rem; }
.role-management-card p { color:var(--text-mid); min-height:42px; font-size:.86rem; line-height:1.5; }
.role-card-meta { display:flex; flex-wrap:wrap; gap:.55rem; margin:1rem 0; }
.role-card-meta span { display:inline-flex; align-items:center; gap:.35rem; border-radius:999px; background:var(--surface); color:var(--text-mid); padding:.35rem .65rem; font-size:.75rem; font-weight:700; }
.role-card-actions { display:flex; justify-content:space-between; align-items:center; gap:.5rem; border-top:1px solid var(--border); padding-top:.9rem; }
.roles-empty { grid-column:1 / -1; text-align:center; padding:3rem 1rem; color:var(--text-mid); }
.roles-empty i { font-size:2.2rem; color:var(--coral); }
.roles-empty h2 { margin:.75rem 0 .35rem; color:var(--text-dark); }
.roles-empty p { margin:0 0 1rem; }
@media (max-width:1100px) {
    .roles-card-grid { grid-template-columns:repeat(2, minmax(0, 1fr)); }
}
@media (max-width:760px) {
    .roles-head { flex-direction:column; align-items:stretch; }
    .roles-summary, .roles-card-grid { grid-template-columns:1fr; }
    .roles-summary span { margin-left:0; }
}
</style>
@endpush
