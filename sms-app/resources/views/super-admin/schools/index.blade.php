@extends('layouts.app')

@section('title', 'Schools | SaaSAdmin')
@section('page_title', 'Schools')
@section('breadcrumb', 'Super Admin / Schools')

@php
    $activeFilters = collect([
        'search' => request('search') ? 'Search: ' . request('search') : null,
        'plan_id' => request('plan_id') ? 'Plan: ' . optional($plans->firstWhere('id', (int) request('plan_id')))->name : null,
        'status' => request('status') ? 'Status: ' . Str::of(request('status'))->replace('_', ' ')->title() : null,
        'country' => request('country') ? 'Region: ' . request('country') : null,
        'students_min' => request('students_min') ? 'Students from ' . request('students_min') : null,
        'students_max' => request('students_max') ? 'Students to ' . request('students_max') : null,
        'mrr_min' => request('mrr_min') ? 'MRR from $' . request('mrr_min') : null,
        'mrr_max' => request('mrr_max') ? 'MRR to $' . request('mrr_max') : null,
        'registered_from' => request('registered_from') ? 'From ' . request('registered_from') : null,
        'registered_to' => request('registered_to') ? 'To ' . request('registered_to') : null,
        'domain_status' => request('domain_status') ? 'Domain: ' . Str::of(request('domain_status'))->title() : null,
        'storage_min' => request('storage_min') ? 'Storage from ' . request('storage_min') . '%' : null,
        'storage_max' => request('storage_max') ? 'Storage to ' . request('storage_max') . '%' : null,
    ])->filter();
@endphp

@section('content')
<div class="schools-head">
    <div>
        <h1>Schools</h1>
        <p>Manage all registered schools and instances across the platform</p>
    </div>
    <div class="page-actions">
        <button type="button" class="btn-outline-sms" onclick="window.print()">
            <i class="bi bi-download"></i> Export
        </button>
        <a href="{{ route('super-admin.schools.create') }}" class="btn-primary-sms">
            <i class="bi bi-plus-lg"></i> Add School
        </a>
    </div>
</div>

<form action="{{ route('super-admin.schools.index') }}" method="GET" class="advanced-filter-card">
    <div class="filter-card-head">
        <div><i class="bi bi-funnel-fill"></i> Advanced Filters</div>
        <button type="button" class="filter-collapse" onclick="document.querySelector('.filter-card-body').classList.toggle('collapsed')" title="Toggle filters">
            <i class="bi bi-chevron-up"></i>
        </button>
    </div>

    <div class="filter-card-body">
        <div class="advanced-filter-grid">
            <div>
                <label class="filter-label">School Name / ID</label>
                <div class="search-wrap full">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" class="search-input" placeholder="Search name or ID..." value="{{ request('search') }}">
                </div>
            </div>

            <div>
                <label class="filter-label">Plan</label>
                <select name="plan_id" class="filter-select">
                    <option value="">Any plan</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" @selected(request('plan_id') == $plan->id)>{{ $plan->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="filter-label">Status</label>
                <select name="status" class="filter-select">
                    <option value="">Any status</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="trial" @selected(request('status') === 'trial')>Trial</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
                </select>
            </div>

            <div>
                <label class="filter-label">Country / Region</label>
                <select name="country" class="filter-select">
                    <option value="">Any region</option>
                    <option value="Pakistan" @selected(request('country', 'Pakistan') === 'Pakistan')>Pakistan</option>
                    <option value="UAE" @selected(request('country') === 'UAE')>UAE</option>
                    <option value="Saudi Arabia" @selected(request('country') === 'Saudi Arabia')>Saudi Arabia</option>
                </select>
            </div>

            <div>
                <label class="filter-label">Students Range</label>
                <div class="range-pair">
                    <input type="number" min="0" name="students_min" class="form-control-sms" placeholder="100" value="{{ request('students_min') }}">
                    <span>-</span>
                    <input type="number" min="0" name="students_max" class="form-control-sms" placeholder="5000" value="{{ request('students_max') }}">
                </div>
            </div>

            <div>
                <label class="filter-label">MRR Range ($)</label>
                <div class="range-pair">
                    <input type="number" min="0" name="mrr_min" class="form-control-sms" placeholder="0" value="{{ request('mrr_min') }}">
                    <span>-</span>
                    <input type="number" min="0" name="mrr_max" class="form-control-sms" placeholder="9999" value="{{ request('mrr_max') }}">
                </div>
            </div>

            <div>
                <label class="filter-label">Registration Date</label>
                <div class="range-pair">
                    <input type="date" name="registered_from" class="form-control-sms" value="{{ request('registered_from') }}">
                    <span>-</span>
                    <input type="date" name="registered_to" class="form-control-sms" value="{{ request('registered_to') }}">
                </div>
            </div>

            <div>
                <label class="filter-label">Storage Used (%)</label>
                <div class="range-pair">
                    <input type="number" min="0" max="100" name="storage_min" class="form-control-sms" placeholder="0" value="{{ request('storage_min') }}">
                    <span>-</span>
                    <input type="number" min="0" max="100" name="storage_max" class="form-control-sms" placeholder="100" value="{{ request('storage_max') }}">
                </div>
            </div>

            <div>
                <label class="filter-label">Domain Status</label>
                <select name="domain_status" class="filter-select">
                    <option value="">Any</option>
                    <option value="verified" @selected(request('domain_status') === 'verified')>Verified</option>
                    <option value="pending" @selected(request('domain_status') === 'pending')>Pending</option>
                    <option value="none" @selected(request('domain_status') === 'none')>None</option>
                </select>
            </div>

            <div>
                <label class="filter-label">Sort By</label>
                <select name="sort" class="filter-select">
                    <option value="newest" @selected(request('sort', 'newest') === 'newest')>Newest First</option>
                    <option value="oldest" @selected(request('sort') === 'oldest')>Oldest First</option>
                    <option value="name_asc" @selected(request('sort') === 'name_asc')>School Name</option>
                    <option value="mrr_desc" @selected(request('sort') === 'mrr_desc')>Highest MRR</option>
                    <option value="students_desc" @selected(request('sort') === 'students_desc')>Most Students</option>
                </select>
            </div>
        </div>

        <div class="filter-footer">
            <div class="active-filter-row">
                <strong>Active:</strong>
                @forelse($activeFilters as $key => $label)
                    <span class="filter-chip">{{ $label }} <i class="bi bi-x"></i></span>
                @empty
                    <span class="text-muted small">No advanced filters applied</span>
                @endforelse
            </div>

            <div class="filter-actions">
                <span class="text-muted small">Showing <strong>{{ $matchingCount }}</strong> of {{ $statusStats['total'] }} schools</span>
                <a href="{{ route('super-admin.schools.index') }}" class="clear-link"><i class="bi bi-x-circle"></i> Clear All</a>
                <button type="submit" class="btn-primary-sms"><i class="bi bi-search"></i> Apply Filters</button>
            </div>
        </div>
    </div>
</form>

<div class="school-list-controls">
    <div class="search-wrap list-search">
        <i class="bi bi-search"></i>
        <input type="text" class="search-input" placeholder="Quick search schools..." oninput="filterSchoolRows(this.value)">
    </div>
    <button type="button" class="btn-outline-sms"><i class="bi bi-layout-three-columns"></i> Columns</button>
    <div class="view-toggle">
        <button type="button" class="active" title="Table view"><i class="bi bi-table"></i></button>
        <button type="button" title="Grid view"><i class="bi bi-grid"></i></button>
    </div>
</div>

<div class="bulk-action-bar" id="bulkBar">
    <div class="bulk-selected"><input type="checkbox" checked disabled> <strong><span id="selectedCount">0</span> schools selected</strong></div>
    <div class="bulk-actions">
        <button type="button"><i class="bi bi-envelope"></i> Send Email</button>
        <button type="button"><i class="bi bi-tag"></i> Change Plan</button>
        <button type="button" class="tone-success-btn"><i class="bi bi-check-circle"></i> Activate</button>
        <button type="button" class="tone-danger-btn"><i class="bi bi-trash"></i> Delete</button>
        <button type="button" onclick="clearSchoolSelection()"><i class="bi bi-x-lg"></i></button>
    </div>
</div>

<div class="schools-registry-card">
    <div class="registry-head">
        <div>
            <h2>Schools Registry</h2>
            <p>{{ $matchingCount }} results matching your filters</p>
        </div>
        <div class="registry-stats">
            <span class="mini-stat active"><i class="bi bi-circle-fill"></i> {{ $statusStats['active'] }} Active</span>
            <span class="mini-stat trial">{{ $statusStats['trial'] }} Trial</span>
            <span class="mini-stat suspended">{{ $statusStats['suspended'] }} Suspended</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="schools-table" id="schoolsTable">
            <thead>
                <tr>
                    <th class="check-col"><input type="checkbox" id="selectAllSchools" onchange="toggleAllSchools(this)"></th>
                    <th>School <i class="bi bi-arrow-down-up"></i></th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Students</th>
                    <th>MRR</th>
                    <th>Storage</th>
                    <th>Registered</th>
                    <th>Domain</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schools as $school)
                    @php
                        $planName = $school->plan->name ?? 'Basic';
                        $planTone = Str::contains(Str::lower($planName), 'enterprise') ? 'enterprise' : (Str::contains(Str::lower($planName), 'pro') ? 'pro' : 'basic');
                        $status = $school->isTrial() ? 'trial' : $school->status;
                        $domain = $school->primaryDomain ?: $school->domains->first();
                        $domainState = $domain ? ($domain->is_verified ? 'verified' : 'pending') : 'none';
                        $maxStorage = Str::contains(Str::lower($planName), 'enterprise') ? 200 : (Str::contains(Str::lower($planName), 'pro') ? 50 : 10);
                        $storagePercent = (($school->id * 13) % 89) + 8;
                        $storageUsed = round(($maxStorage * $storagePercent) / 100, 1);
                        $storageTone = $storagePercent >= 80 ? 'danger' : ($storagePercent >= 55 ? 'warning' : 'good');
                    @endphp
                    <tr data-school-row data-school-search="{{ Str::lower($school->name . ' ' . $school->slug . ' SCH-' . str_pad($school->id, 5, '0', STR_PAD_LEFT)) }}">
                        <td class="check-col">
                            <input type="checkbox" class="school-check" onchange="updateBulkBar()">
                        </td>
                        <td>
                            <div class="table-main-cell">
                                <div class="school-avatar tone-{{ $planTone }}">{{ Str::of($school->name)->explode(' ')->take(2)->map(fn ($part) => Str::substr($part, 0, 1))->join('') }}</div>
                                <div>
                                    <div class="school-name">{{ $school->name }}</div>
                                    <div class="school-code">SCH-{{ str_pad($school->id, 5, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="plan-pill {{ $planTone }}">{{ $planName }}</span></td>
                        <td><span class="school-status-pill {{ $status }}"><i class="bi bi-circle-fill"></i> {{ Str::of($status)->title() }}</span></td>
                        <td class="metric-cell">{{ number_format($school->students_count) }}</td>
                        <td class="metric-cell">${{ number_format($school->plan->monthly_price ?? 0) }}</td>
                        <td>
                            <div class="storage-cell">
                                <div><span>{{ $storagePercent }}%</span><span>{{ $storageUsed }}/{{ $maxStorage }} GB</span></div>
                                <div class="storage-track"><span class="{{ $storageTone }}" style="width: {{ $storagePercent }}%"></span></div>
                            </div>
                        </td>
                        <td class="date-cell">{{ $school->created_at->format('M j, Y') }}</td>
                        <td><span class="domain-pill {{ $domainState }}"><i class="bi bi-check-circle-fill"></i> {{ Str::of($domainState)->title() }}</span></td>
                        <td>
                            <div class="row-actions">
                                <a href="{{ route('super-admin.schools.edit', $school) }}" title="View / edit"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('super-admin.schools.edit', $school) }}" title="Edit"><i class="bi bi-pencil"></i></a>
                                <a href="{{ route('super-admin.users.index', ['school_id' => $school->id]) }}" title="Manage users"><i class="bi bi-three-dots-vertical"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <div class="empty-state-icon mb-3"><i class="bi bi-buildings"></i></div>
                            <strong>No schools found</strong>
                            <p class="text-muted small">Try adjusting your filters or search terms.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="registry-footer">
        <span>Showing <strong>{{ $schools->firstItem() ?? 0 }}-{{ $schools->lastItem() ?? 0 }}</strong> of <strong>{{ $schools->total() }}</strong></span>
        @if($schools->hasPages())
            {{ $schools->links() }}
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.schools-head { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; margin-bottom:1.5rem; }
.schools-head h1 { margin:0; font-size:1.6rem; }
.schools-head p { margin:.25rem 0 0; color:var(--text-mid); }
.advanced-filter-card, .schools-registry-card { background:white; border:1px solid var(--border); border-radius:16px; overflow:hidden; margin-bottom:1.5rem; }
.filter-card-head { display:flex; justify-content:space-between; align-items:center; padding:1.1rem 1.5rem; border-bottom:1px solid var(--border); font-weight:800; }
.filter-card-head i { color:var(--coral); margin-right:.45rem; }
.filter-collapse { border:0; background:transparent; color:var(--text-light); cursor:pointer; }
.filter-card-body { padding:1.5rem; }
.filter-card-body.collapsed { display:none; }
.advanced-filter-grid { display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:1rem 1.1rem; }
.advanced-filter-grid > div:nth-child(5), .advanced-filter-grid > div:nth-child(6), .advanced-filter-grid > div:nth-child(7), .advanced-filter-grid > div:nth-child(8), .advanced-filter-grid > div:nth-child(9), .advanced-filter-grid > div:nth-child(10) { grid-column:span 2; }
.filter-label { display:block; margin-bottom:.45rem; color:#9899a8; font-size:.76rem; font-weight:800; text-transform:uppercase; letter-spacing:.04em; }
.search-wrap.full { max-width:none; }
.range-pair { display:grid; grid-template-columns:minmax(0, 1fr) auto minmax(0, 1fr); align-items:center; gap:.7rem; }
.range-pair span { color:var(--text-light); }
.filter-footer { display:flex; justify-content:space-between; align-items:center; gap:1rem; border-top:1px solid var(--border); margin-top:1.25rem; padding-top:1.25rem; flex-wrap:wrap; }
.active-filter-row, .filter-actions { display:flex; align-items:center; gap:.65rem; flex-wrap:wrap; }
.filter-chip { display:inline-flex; align-items:center; gap:.25rem; border:1px solid var(--coral-border); background:var(--coral-pale); color:var(--coral); border-radius:999px; padding:.35rem .7rem; font-size:.82rem; font-weight:700; }
.clear-link { color:var(--text-mid); font-size:.9rem; }
.school-list-controls { display:flex; align-items:center; gap:.75rem; margin-bottom:1rem; }
.list-search { max-width:none; flex:1; }
.view-toggle { display:inline-flex; border:1px solid var(--border); border-radius:10px; overflow:hidden; background:white; }
.view-toggle button { width:40px; height:40px; border:0; background:white; color:var(--text-light); }
.view-toggle button.active { background:var(--coral); color:white; }
.bulk-action-bar { display:none; align-items:center; justify-content:space-between; gap:1rem; background:var(--charcoal); color:white; border-radius:10px; padding:.9rem 1.1rem; margin-bottom:1rem; }
.bulk-action-bar.open { display:flex; }
.bulk-selected { display:flex; align-items:center; gap:.7rem; }
.bulk-selected input, .school-check:checked, #selectAllSchools:checked { accent-color:var(--coral); }
.bulk-actions { display:flex; align-items:center; gap:.55rem; flex-wrap:wrap; }
.bulk-actions button { border:0; border-radius:8px; padding:.55rem .85rem; background:#343641; color:white; font-weight:800; cursor:pointer; }
.bulk-actions .tone-success-btn { background:var(--coral); }
.bulk-actions .tone-danger-btn { background:var(--danger); }
.registry-head { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1.25rem 1.5rem; border-bottom:1px solid var(--border); }
.registry-head h2 { margin:0; font-size:1rem; }
.registry-head p { margin:.2rem 0 0; color:var(--text-light); font-size:.85rem; }
.registry-stats { display:flex; gap:.55rem; flex-wrap:wrap; }
.mini-stat { display:inline-flex; align-items:center; gap:.35rem; border-radius:999px; padding:.35rem .75rem; font-size:.75rem; font-weight:800; }
.mini-stat.active { background:var(--success-bg); color:var(--success); }
.mini-stat.trial { background:var(--warning-bg); color:var(--warning); }
.mini-stat.suspended { background:var(--danger-bg); color:var(--danger); }
.schools-table { width:100%; border-collapse:collapse; }
.schools-table th, .schools-table td { padding:1rem 1.35rem; border-bottom:1px solid var(--border); text-align:left; vertical-align:middle; }
.schools-table th { color:var(--text-light); font-size:.76rem; text-transform:uppercase; letter-spacing:.04em; font-weight:800; }
.schools-table tbody tr:hover { background:#fcfbfa; }
.check-col { width:42px; padding-right:.25rem !important; }
.school-avatar.tone-enterprise { background:var(--purple-bg); color:var(--purple); }
.school-avatar.tone-pro { background:var(--info-bg); color:var(--info); }
.school-avatar.tone-basic { background:var(--success-bg); color:var(--success); }
.school-name { font-weight:800; color:var(--text-dark); }
.school-code, .date-cell { color:var(--text-light); font-size:.83rem; }
.plan-pill, .school-status-pill, .domain-pill { display:inline-flex; align-items:center; gap:.35rem; border-radius:999px; padding:.35rem .65rem; font-size:.76rem; font-weight:800; }
.plan-pill.enterprise { background:var(--purple-bg); color:var(--purple); }
.plan-pill.pro { background:var(--info-bg); color:var(--info); }
.plan-pill.basic { background:var(--surface); color:var(--text-mid); }
.school-status-pill.active, .domain-pill.verified { background:var(--success-bg); color:var(--success); }
.school-status-pill.trial, .school-status-pill.pending, .domain-pill.pending { background:var(--warning-bg); color:var(--warning); }
.school-status-pill.suspended { background:var(--danger-bg); color:var(--danger); }
.domain-pill.none { background:var(--surface); color:var(--text-mid); }
.domain-pill.none i { display:none; }
.school-status-pill i { font-size:.5rem; }
.metric-cell { font-weight:800; }
.storage-cell { min-width:155px; color:var(--text-light); font-size:.78rem; }
.storage-cell > div:first-child { display:flex; justify-content:space-between; gap:.6rem; margin-bottom:.4rem; }
.storage-track { height:5px; background:#e9e5df; border-radius:999px; overflow:hidden; }
.storage-track span { display:block; height:100%; border-radius:999px; }
.storage-track .good { background:var(--success); }
.storage-track .warning { background:var(--warning); }
.storage-track .danger { background:var(--danger); }
.row-actions { display:flex; justify-content:flex-end; gap:.7rem; color:#8d95aa; }
.row-actions a:hover { color:var(--coral); }
.registry-footer { display:flex; align-items:center; justify-content:space-between; gap:1rem; padding:1rem 1.35rem; color:var(--text-light); }
.registry-footer nav { padding:0; }
@media (max-width:1100px) {
    .advanced-filter-grid { grid-template-columns:repeat(2, minmax(0, 1fr)); }
}
@media (max-width:760px) {
    .schools-head, .school-list-controls, .bulk-action-bar, .registry-head, .registry-footer { flex-direction:column; align-items:stretch; }
    .advanced-filter-grid, .advanced-filter-grid > div:nth-child(n) { grid-template-columns:1fr; grid-column:span 1; }
    .filter-actions { justify-content:flex-start; }
}
</style>
@endpush

@push('scripts')
<script>
function updateBulkBar() {
    const checked = document.querySelectorAll('.school-check:checked');
    const bulkBar = document.getElementById('bulkBar');
    document.getElementById('selectedCount').textContent = checked.length;
    bulkBar.classList.toggle('open', checked.length > 0);
}

function toggleAllSchools(master) {
    document.querySelectorAll('.school-check').forEach(check => {
        check.checked = master.checked;
    });
    updateBulkBar();
}

function clearSchoolSelection() {
    document.querySelectorAll('.school-check, #selectAllSchools').forEach(check => {
        check.checked = false;
    });
    updateBulkBar();
}

function filterSchoolRows(value) {
    const q = value.trim().toLowerCase();
    document.querySelectorAll('[data-school-row]').forEach(row => {
        row.style.display = row.dataset.schoolSearch.includes(q) ? '' : 'none';
    });
}
</script>
@endpush
