@push('styles')
<style>
.role-builder-page { padding-bottom:90px; }
.role-builder-head { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; margin-bottom:1.25rem; }
.role-builder-head h1 { margin:.15rem 0 .25rem; font-size:1.65rem; }
.role-builder-head h1 span { color:var(--coral); }
.role-builder-head p { margin:0; color:var(--text-mid); }
.role-builder-layout { display:grid; grid-template-columns:310px minmax(0, 1fr); gap:1.25rem; align-items:start; }
.role-builder-sidebar { display:grid; gap:1rem; position:sticky; top:92px; }
.role-side-card, .role-permission-toolbar, .role-permission-workspace { background:white; border:1px solid var(--border); border-radius:16px; }
.role-side-card { padding:1rem; }
.section-heading-saas.compact { margin-bottom:.85rem; }
.section-heading-saas.compact .section-icon { width:36px; height:36px; border-radius:10px; }
.section-heading-saas.compact h3 { font-size:.95rem; }
.form-group-sms { margin-bottom:1rem; }
.form-textarea { min-height:110px; resize:vertical; }
.side-title { margin:0 0 .75rem; font-size:.95rem; }
.side-copy { color:var(--text-mid); font-size:.84rem; line-height:1.55; margin:0 0 .85rem; }
.access-hint { display:flex; gap:.65rem; padding:.75rem; border-radius:12px; background:var(--warning-bg); color:var(--warning); font-size:.8rem; line-height:1.4; }
.quick-detail { display:flex; justify-content:space-between; gap:.75rem; padding:.55rem 0; border-top:1px solid var(--border); font-size:.82rem; }
.quick-detail:first-of-type { border-top:0; }
.quick-detail span { color:var(--text-light); }
.quick-detail strong { text-align:right; overflow-wrap:anywhere; }
.side-actions { display:grid; gap:.55rem; }
.side-actions .btn-primary-sms, .side-actions .btn-outline-sms { justify-content:center; width:100%; text-align:center; }
.role-builder-main { display:grid; gap:1rem; min-width:0; }
.role-permission-toolbar { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1rem 1.25rem; }
.role-permission-toolbar h2 { margin:0; font-size:1.05rem; }
.role-permission-toolbar p { margin:.2rem 0 0; color:var(--text-light); font-size:.84rem; }
.role-search { max-width:320px; }
.role-permission-workspace { padding:1rem; display:grid; gap:1rem; }
.role-module { border:1px solid var(--border); border-radius:14px; overflow:hidden; }
.role-module-head { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1rem; background:var(--surface); border-bottom:1px solid var(--border); }
.role-module-head h3 { margin:0; font-size:.98rem; display:flex; align-items:center; gap:.5rem; }
.role-module-head h3 i { color:var(--coral); }
.role-module-head p { margin:.2rem 0 0; color:var(--text-light); font-size:.8rem; }
.role-permission-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:.8rem; padding:1rem; }
.role-permission-card { display:flex; align-items:flex-start; gap:.75rem; padding:.9rem; border:1px solid var(--border); border-radius:12px; cursor:pointer; background:white; transition:.18s; }
.role-permission-card:hover { border-color:var(--coral-border); background:var(--coral-pale); }
.role-permission-card.selected { border-color:var(--coral); background:var(--coral-pale); }
.role-permission-card input { position:absolute; opacity:0; pointer-events:none; }
.permission-check { width:22px; height:22px; border-radius:7px; border:1px solid var(--border); display:inline-flex; align-items:center; justify-content:center; color:white; flex:0 0 auto; margin-top:.05rem; }
.role-permission-card.selected .permission-check { background:var(--coral); border-color:var(--coral); }
.role-permission-card strong { display:block; font-size:.86rem; }
.role-permission-card small { display:block; color:var(--text-light); margin-top:.2rem; font-size:.76rem; line-height:1.35; }
.btn-small { padding:.45rem .7rem; font-size:.78rem; }
@media (max-width:1100px) {
    .role-builder-layout { grid-template-columns:1fr; }
    .role-builder-sidebar { position:static; grid-template-columns:repeat(2, minmax(0, 1fr)); }
    .side-actions { grid-column:1 / -1; }
}
@media (max-width:760px) {
    .role-builder-head, .role-permission-toolbar, .role-module-head { flex-direction:column; align-items:stretch; }
    .role-builder-sidebar, .role-permission-grid { grid-template-columns:1fr; }
    .role-search { max-width:none; }
}
</style>
@endpush

@push('scripts')
<script>
function toggleRoleModule(moduleId) {
    const container = document.getElementById('module-' + moduleId);
    const checkboxes = container.querySelectorAll('input[type="checkbox"]');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

    checkboxes.forEach(cb => {
        cb.checked = !allChecked;
        cb.closest('.role-permission-card').classList.toggle('selected', cb.checked);
    });
}

function filterRolePermissionCards(value) {
    const q = value.trim().toLowerCase();
    document.querySelectorAll('[data-role-permission-card]').forEach(card => {
        card.style.display = card.dataset.search.includes(q) ? '' : 'none';
    });

    document.querySelectorAll('[data-role-module]').forEach(module => {
        const visible = Array.from(module.querySelectorAll('[data-role-permission-card]')).some(card => card.style.display !== 'none');
        module.style.display = visible ? '' : 'none';
    });
}
</script>
@endpush
