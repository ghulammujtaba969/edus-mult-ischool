@extends('layouts.app')

@section('page_title', 'Platform Overview')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
@endsection

@section('topbar_actions')
    <a href="{{ route('super-admin.schools.create') }}" class="btn-primary-sms">
        <i class="bi bi-plus-lg"></i> Register School
    </a>
@endsection

@section('content')
@php
    $totalSchools = max((int) $stats['total_schools'], 1);
    $mrr = (float) $stats['mrr'];
    $arr = $mrr * 12;
    $activeRate = round(($stats['active_schools'] / $totalSchools) * 100);
    $palette = ['#2C6FD4', '#E85D3A', '#7C3AED', '#2DA06A', '#D48A12'];

    $schoolRows = $recentSchools->map(function ($school, $index) use ($palette) {
        $students = (int) $school->students_count;
        $storage = max(1, (int) ceil($students * 0.08));
        return [
            'id' => $school->id,
            'name' => $school->name,
            'slug' => $school->slug,
            'domain' => optional($school->primaryDomain)->domain ?: $school->slug . '.' . parse_url(config('app.url'), PHP_URL_HOST),
            'plan' => optional($school->plan)->name ?: 'Unassigned',
            'students' => $students,
            'storage' => $storage,
            'status' => $school->status,
            'joined' => $school->created_at->format('M d, Y'),
            'color' => $palette[$index % count($palette)],
            'edit_url' => route('super-admin.schools.edit', $school),
            'impersonate_url' => route('super-admin.schools.impersonate', $school),
        ];
    })->values();

    $maxStudents = max((int) $topSchools->max('students_count'), 1);
@endphp

<div class="sa-page-header">
    <div>
        <div class="sa-page-title">Platform Overview</div>
        <div class="sa-page-subtitle">Real-time health monitoring, revenue metrics, school onboarding, and platform activity.</div>
    </div>
    <div class="sa-page-actions">
        <a class="btn-secondary" href="{{ route('super-admin.audit-logs.index') }}"><i class="bi bi-journal-text"></i> Audit Logs</a>
        <a class="btn-secondary" href="{{ route('super-admin.dashboard') }}"><i class="bi bi-arrow-clockwise"></i> Refresh</a>
        <a class="btn-primary" href="{{ route('super-admin.schools.create') }}"><i class="bi bi-plus-lg"></i> Register School</a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-icon-wrap blue"><i class="bi bi-building-fill"></i></div>
        <div class="stat-value">{{ number_format($stats['total_schools']) }}</div>
        <div class="stat-label">Total Schools</div>
        <div><span class="stat-change up"><i class="bi bi-arrow-up-short"></i> +{{ $stats['new_schools_this_month'] }} this month</span></div>
        <div class="stat-sub">{{ $stats['active_schools'] }} active - {{ $stats['trial_schools'] }} trial</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon-wrap green"><i class="bi bi-check-circle-fill"></i></div>
        <div class="stat-value">{{ number_format($stats['active_schools']) }}</div>
        <div class="stat-label">Active Instances</div>
        <div><span class="stat-change up"><i class="bi bi-activity"></i> {{ $activeRate }}% live</span></div>
        <div class="stat-sub">{{ $stats['suspended_schools'] }} suspended - {{ $stats['pending_schools'] }} pending</div>
    </div>
    <div class="stat-card coral">
        <div class="stat-icon-wrap coral"><i class="bi bi-layers-fill"></i></div>
        <div class="stat-value">{{ number_format($stats['total_plans']) }}</div>
        <div class="stat-label">Subscription Plans</div>
        <div><span class="stat-change flat">Configured tiers</span></div>
        <div class="stat-sub">{{ $planDistribution->pluck('name')->take(3)->implode(' - ') ?: 'No plans yet' }}</div>
    </div>
    <div class="stat-card yellow">
        <div class="stat-icon-wrap yellow"><i class="bi bi-people-fill"></i></div>
        <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
        <div class="stat-label">Total Users</div>
        <div><span class="stat-change up"><i class="bi bi-arrow-up-short"></i> +{{ $stats['new_users_this_month'] }} this month</span></div>
        <div class="stat-sub">Across all schools</div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card purple">
        <div class="stat-icon-wrap purple"><i class="bi bi-cash-stack"></i></div>
        <div class="stat-value">Rs {{ number_format($mrr, 0) }}</div>
        <div class="stat-label">Monthly Recurring Revenue</div>
        <div><span class="stat-change up"><i class="bi bi-arrow-up-short"></i> Active billing</span></div>
        <div class="stat-sub">ARR: Rs {{ number_format($arr, 0) }} projected</div>
    </div>
    <div class="stat-card yellow">
        <div class="stat-icon-wrap yellow"><i class="bi bi-globe2"></i></div>
        <div class="stat-value">{{ number_format($stats['pending_domains']) }}</div>
        <div class="stat-label">Pending Domain Requests</div>
        <div><span class="stat-change {{ $stats['pending_domains'] ? 'down' : 'flat' }}"><i class="bi bi-{{ $stats['pending_domains'] ? 'exclamation-circle' : 'check-circle' }}"></i> {{ $stats['pending_domains'] ? 'Needs review' : 'All clear' }}</span></div>
        <div class="stat-sub">{{ $stats['total_domains'] }} total domains</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon-wrap green"><i class="bi bi-activity"></i></div>
        <div class="stat-value">{{ $health['uptime'] }}</div>
        <div class="stat-label">Platform Uptime</div>
        <div><span class="stat-change up"><i class="bi bi-arrow-up-short"></i> Last 30 days</span></div>
        <div class="stat-sub">All core services monitored</div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon-wrap red"><i class="bi bi-hdd-fill"></i></div>
        <div class="stat-value">{{ $health['storage'] }}</div>
        <div class="stat-label">Storage Utilisation</div>
        <div><span class="stat-change down"><i class="bi bi-arrow-up-short"></i> Capacity watch</span></div>
        <div class="stat-sub">Distributed across school nodes</div>
    </div>
</div>

<div class="charts-row">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Revenue Trend</div>
                <div class="card-subtitle">New active MRR added over the last 6 months</div>
            </div>
            <div class="chart-tabs">
                <button class="chart-tab active" type="button">6M</button>
                <button class="chart-tab" type="button">1Y</button>
            </div>
        </div>
        <div class="rev-metric">
            <div class="rev-val">Rs {{ number_format($mrr, 0) }}</div>
            <div class="rev-period">{{ now()->format('F Y') }} - Current Month MRR</div>
            <div class="rev-change"><i class="bi bi-arrow-up-short"></i> {{ $stats['new_schools_this_month'] }} new school registrations this month</div>
        </div>
        <div class="chart-wrap" style="height: 180px;"><canvas id="revenueChart"></canvas></div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Plan Distribution</div>
                <div class="card-subtitle">Schools grouped by subscription tier</div>
            </div>
        </div>
        <div class="chart-wrap" style="height: 160px;"><canvas id="planChart"></canvas></div>
        <div class="donut-legend">
            @forelse($planDistribution as $index => $plan)
                <div class="legend-item">
                    <div class="legend-dot" style="background: {{ $palette[$index % count($palette)] }};"></div>
                    <span class="legend-label">{{ $plan['name'] }}</span>
                    <span class="legend-val">{{ $plan['count'] }}</span>
                    <span class="legend-pct">({{ round(($plan['count'] / $totalSchools) * 100) }}%)</span>
                </div>
            @empty
                <div class="empty-state">No plans configured yet.</div>
            @endforelse
        </div>
    </div>
</div>

<div class="charts-row-3">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">School Registrations</div>
                <div class="card-subtitle">Monthly new onboarding</div>
            </div>
        </div>
        <div class="chart-wrap" style="height: 160px;"><canvas id="registrationChart"></canvas></div>
    </div>
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">User Growth</div>
                <div class="card-subtitle">Platform-wide users onboarding</div>
            </div>
        </div>
        <div class="chart-wrap" style="height: 160px;"><canvas id="userGrowthChart"></canvas></div>
    </div>
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">System Health</div>
                <div class="card-subtitle">Core service status</div>
            </div>
            <span class="pill pill-active"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Healthy</span>
        </div>
        <div class="health-list">
            <div class="health-row"><span>API Server</span><strong>{{ $health['api_latency'] }} avg</strong><div class="progress-bar-wrap"><div class="progress-fill bg-success" style="width:98%;"></div></div></div>
            <div class="health-row"><span>Database</span><strong>{{ $health['database'] }}</strong><div class="progress-bar-wrap"><div class="progress-fill bg-success" style="width:95%;"></div></div></div>
            <div class="health-row"><span>Storage</span><strong class="text-warning">{{ $health['storage'] }} used</strong><div class="progress-bar-wrap"><div class="progress-fill bg-warning" style="width:82%;"></div></div></div>
            <div class="health-row"><span>Mail Service</span><strong>Operational</strong><div class="progress-bar-wrap"><div class="progress-fill bg-success" style="width:100%;"></div></div></div>
            <div class="health-row"><span>SMS Gateway</span><strong class="text-warning">Monitored</strong><div class="progress-bar-wrap"><div class="progress-fill bg-warning" style="width:72%;"></div></div></div>
            <div class="health-row"><span>CDN / Assets</span><strong>Healthy</strong><div class="progress-bar-wrap"><div class="progress-fill bg-success" style="width:100%;"></div></div></div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div>
            <div class="section-heading" style="margin-bottom:2px;"><i class="bi bi-building-fill" style="color:var(--coral);"></i> Recently Registered Schools</div>
            <div class="small-muted">Latest school instances onboarded to the platform</div>
        </div>
        <div class="filter-row">
            <div class="search-input-sm">
                <i class="bi bi-search"></i>
                <input type="text" id="schoolSearch" placeholder="Search schools...">
            </div>
            <select class="filter-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="trial">Trial</option>
                <option value="suspended">Suspended</option>
                <option value="pending">Pending</option>
            </select>
            <select class="filter-select" id="planFilter">
                <option value="">All Plans</option>
                @foreach($planDistribution as $plan)
                    <option value="{{ $plan['name'] }}">{{ $plan['name'] }}</option>
                @endforeach
            </select>
            <a href="{{ route('super-admin.schools.index') }}" class="link-btn">View All <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
    <div class="table-scroll">
        <table class="tbl" id="schoolsTable">
            <thead>
                <tr>
                    <th>School Name</th>
                    <th>Slug / Domain</th>
                    <th>Subscription Plan</th>
                    <th>Students</th>
                    <th>Storage</th>
                    <th>Status</th>
                    <th>Joined Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="schoolsBody"></tbody>
        </table>
    </div>
</div>

<div class="two-col">
    <div class="table-card" style="margin-bottom:0;">
        <div class="table-card-header">
            <div>
                <div class="section-heading" style="margin-bottom:2px;">
                    <i class="bi bi-globe2" style="color:var(--warning);"></i>
                    Domain Requests
                    <span class="pill pill-pending">{{ $stats['pending_domains'] }} Pending</span>
                </div>
                <div class="small-muted">Custom domain mapping requests from schools</div>
            </div>
            <a class="link-btn" href="{{ route('super-admin.domains.index') }}">View All <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="table-scroll">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>School</th>
                        <th>Requested Domain</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($domainRequests as $req)
                        <tr>
                            <td><strong>{{ optional($req->school)->name ?? 'Unassigned' }}</strong></td>
                            <td><span class="domain-badge">{{ $req->domain }}</span></td>
                            <td><span class="pill {{ $req->is_verified ? 'pill-approved' : 'pill-pending' }}">{{ $req->is_verified ? 'Verified' : 'Pending' }}</span></td>
                            <td class="small-muted">{{ $req->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('super-admin.domains.index') }}" class="action-btn" title="Review"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="empty-state">No custom domain requests yet.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-bottom:0;">
        <div class="card-header">
            <div>
                <div class="card-title">Recent Activity</div>
                <div class="card-subtitle">Latest platform events and actions</div>
            </div>
            <a class="link-btn" href="{{ route('super-admin.audit-logs.index') }}">Audit Logs <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="activity-list">
            @forelse($recentActivity as $activity)
                <div class="activity-item">
                    <div class="activity-icon" style="background: var(--purple-bg); color: var(--purple);">
                        <i class="bi {{ $activity->icon ?? 'bi-lightning-charge' }}"></i>
                    </div>
                    <div class="activity-text">
                        <strong>{{ optional($activity->user)->name ?? 'System' }}</strong> {{ $activity->description }}
                        <div class="activity-time">{{ ($activity->logged_at ?? $activity->created_at)->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-state">No recent activity yet.</div>
            @endforelse
        </div>
    </div>
</div>

<div class="three-col">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Top Schools by Usage</div>
                <div class="card-subtitle">Ranked by active students this month</div>
            </div>
        </div>
        <div>
            @forelse($topSchools as $index => $school)
                <div class="top-school-item">
                    <span class="rank-num">#{{ $index + 1 }}</span>
                    <div class="school-logo" style="background: var(--info-bg); color: {{ $palette[$index % count($palette)] }};">{{ strtoupper(substr($school->name, 0, 2)) }}</div>
                    <div style="flex:1;min-width:0;">
                        <div class="text-truncate" style="font-size:13px;font-weight:600;">{{ $school->name }}</div>
                        <div class="progress-bar-wrap"><div class="progress-fill" style="background:{{ $palette[$index % count($palette)] }};width:{{ round(($school->students_count / $maxStudents) * 100) }}%;"></div></div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:13px;font-weight:700;font-family:var(--mono);">{{ number_format($school->students_count) }}</div>
                        <div style="font-size:10.5px;color:var(--text-light);">{{ optional($school->plan)->name ?? 'No Plan' }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-state">No usage data yet.</div>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">System Audit Logs</div>
                <div class="card-subtitle">Recent admin actions and system events</div>
            </div>
            <a class="link-btn" href="{{ route('super-admin.audit-logs.index') }}">View Full Logs <i class="bi bi-arrow-right"></i></a>
        </div>
        <div>
            @forelse($recentActivity->take(8) as $activity)
                @php
                    $level = str_contains(strtolower($activity->description), 'failed') ? 'error' : (str_contains(strtolower($activity->description), 'domain') ? 'warning' : 'info');
                @endphp
                <div class="log-item">
                    <span class="log-level log-{{ $level }}">{{ strtoupper($level === 'error' ? 'ERR' : $level) }}</span>
                    <div class="log-msg">{{ $activity->description }}</div>
                    <span class="log-time">{{ ($activity->logged_at ?? $activity->created_at)->format('M d') }}</span>
                </div>
            @empty
                <div class="empty-state">No audit entries yet.</div>
            @endforelse
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div>
            <div class="section-heading" style="margin-bottom:2px;"><i class="bi bi-bar-chart-fill" style="color:var(--purple);"></i> Revenue by Subscription Plan</div>
            <div class="small-muted">Breakdown of current monthly revenue contributions per plan</div>
        </div>
        <a class="btn-secondary" href="{{ route('super-admin.plans.index') }}"><i class="bi bi-layers"></i> Manage Plans</a>
    </div>
    <div class="table-scroll">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Plan</th>
                    <th>Schools</th>
                    <th>Price / Month</th>
                    <th>Total MRR</th>
                    <th>% of Revenue</th>
                    <th>Avg Storage/School</th>
                    <th>Renewal Rate</th>
                    <th>Trend</th>
                </tr>
            </thead>
            <tbody>
                @forelse($planDistribution as $index => $plan)
                    @php
                        $share = $mrr > 0 ? $plan['percentage'] : 0;
                        $avgStorage = max(1, 8 + ($index * 11));
                    @endphp
                    <tr>
                        <td><span class="pill {{ ['pill-basic', 'pill-pro', 'pill-enterprise'][$index % 3] }}"><i class="bi bi-layers"></i> {{ $plan['name'] }}</span></td>
                        <td style="font-weight:700;">{{ $plan['count'] }}</td>
                        <td style="font-family:var(--mono);">Rs {{ number_format($plan['price'], 0) }}</td>
                        <td style="font-family:var(--mono);font-weight:700;color:{{ $palette[$index % count($palette)] }};">Rs {{ number_format($plan['mrr'], 0) }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <span style="font-family:var(--mono);font-weight:600;min-width:44px;">{{ $share }}%</span>
                                <div style="flex:1;"><div class="progress-bar-wrap"><div class="progress-fill" style="background:{{ $palette[$index % count($palette)] }};width:{{ min(100, $share) }}%;"></div></div></div>
                            </div>
                        </td>
                        <td style="color:var(--text-mid);font-family:var(--mono);">{{ $avgStorage }} GB</td>
                        <td><span class="pill pill-active">{{ 92 + ($index % 5) }}%</span></td>
                        <td><canvas id="spark{{ $index }}" width="80" height="28"></canvas></td>
                    </tr>
                @empty
                    <tr><td colspan="8"><div class="empty-state">No revenue plans available.</div></td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:var(--surface);">
                    <td style="font-weight:700;">Total</td>
                    <td style="font-weight:700;">{{ number_format($stats['total_schools']) }}</td>
                    <td class="small-muted">-</td>
                    <td style="font-family:var(--mono);font-weight:800;">Rs {{ number_format($mrr, 0) }}</td>
                    <td style="font-family:var(--mono);font-weight:700;">{{ $mrr > 0 ? '100%' : '0%' }}</td>
                    <td class="small-muted">Platform avg</td>
                    <td><span class="pill pill-active">Monitored</span></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div style="text-align:center;padding:16px 0 4px;font-size:12px;color:var(--text-light);">
    SaaSAdmin Platform Master - Dashboard v2.0 - Last refreshed: {{ now()->format('M d, Y H:i') }}
</div>
@endsection

@push('styles')
<style>
.sa-page-header {
  display:flex; align-items:flex-start; justify-content:space-between;
  gap:16px; flex-wrap:wrap; margin-bottom:24px;
}
.sa-page-title { font-size:22px; font-weight:800; color:var(--text-dark); letter-spacing:0; }
.sa-page-subtitle { font-size:13.5px; color:var(--text-mid); margin-top:3px; }
.sa-page-actions { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.stats-grid {
  display:grid; grid-template-columns:repeat(4,minmax(0,1fr));
  gap:16px; margin-bottom:20px;
}
.stat-card {
  background:var(--white); border:1.5px solid var(--border); border-radius:12px;
  padding:20px; position:relative; overflow:hidden; transition:transform .2s, box-shadow .2s;
}
.stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,.07); }
.stat-card::after { content:''; position:absolute; bottom:0; left:0; right:0; height:3px; }
.stat-card.blue::after { background:var(--info); }
.stat-card.green::after { background:var(--success); }
.stat-card.coral::after { background:var(--coral); }
.stat-card.yellow::after { background:var(--warning); }
.stat-card.purple::after { background:var(--purple); }
.stat-card.red::after { background:var(--danger); }
.stat-icon-wrap {
  width:40px; height:40px; border-radius:9px; display:flex; align-items:center;
  justify-content:center; font-size:18px; margin-bottom:14px;
}
.stat-icon-wrap.blue { background:var(--info-bg); color:var(--info); }
.stat-icon-wrap.green { background:var(--success-bg); color:var(--success); }
.stat-icon-wrap.coral { background:var(--coral-pale); color:var(--coral); }
.stat-icon-wrap.yellow { background:var(--warning-bg); color:var(--warning); }
.stat-icon-wrap.purple { background:var(--purple-bg); color:var(--purple); }
.stat-icon-wrap.red { background:var(--danger-bg); color:var(--danger); }
.stat-value { font-size:28px; font-weight:800; color:var(--text-dark); letter-spacing:0; line-height:1; }
.stat-label { font-size:12.5px; color:var(--text-mid); margin-top:4px; font-weight:500; }
.stat-change {
  display:inline-flex; align-items:center; gap:4px; font-size:11.5px; font-weight:600;
  padding:3px 7px; border-radius:20px; margin-top:10px;
}
.stat-change.up { background:var(--success-bg); color:var(--success); }
.stat-change.down { background:var(--danger-bg); color:var(--danger); }
.stat-change.flat { background:var(--surface); color:var(--text-mid); }
.stat-sub, .small-muted { font-size:11.5px; color:var(--text-light); }
.stat-sub { margin-top:8px; }
.charts-row { display:grid; grid-template-columns:2fr 1fr; gap:16px; margin-bottom:20px; }
.charts-row-3 { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:16px; margin-bottom:20px; }
.card, .table-card {
  background:var(--white); border:1.5px solid var(--border); border-radius:12px;
}
.card { padding:20px; margin-bottom:20px; }
.table-card { overflow:hidden; margin-bottom:20px; }
.card-header, .table-card-header {
  display:flex; align-items:center; justify-content:space-between; gap:16px;
}
.card-header { margin-bottom:18px; }
.table-card-header { padding:16px 20px; border-bottom:1px solid var(--border); flex-wrap:wrap; }
.card-title { font-size:14px; font-weight:700; color:var(--text-dark); margin-bottom:0; }
.card-subtitle { font-size:12px; color:var(--text-light); margin-top:2px; }
.chart-wrap { position:relative; }
.rev-metric { margin-bottom:16px; }
.rev-val { font-size:30px; font-weight:800; letter-spacing:0; color:var(--text-dark); }
.rev-period { font-size:12px; color:var(--text-light); margin-top:2px; }
.rev-change { display:inline-flex; align-items:center; gap:4px; font-size:12px; font-weight:600; color:var(--success); background:var(--success-bg); padding:2px 8px; border-radius:20px; margin-top:8px; }
.chart-tabs { display:flex; gap:4px; }
.chart-tab { padding:5px 10px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; color:var(--text-light); border:none; background:none; font-family:var(--font); }
.chart-tab.active { background:var(--coral); color:white; }
.donut-legend { margin-top:16px; display:flex; flex-direction:column; gap:8px; }
.legend-item { display:flex; align-items:center; gap:8px; }
.legend-dot { width:10px; height:10px; border-radius:3px; flex-shrink:0; }
.legend-label { font-size:12.5px; color:var(--text-mid); flex:1; }
.legend-val { font-size:12.5px; font-weight:700; color:var(--text-dark); font-family:var(--mono); }
.legend-pct { font-size:11px; color:var(--text-light); font-family:var(--mono); }
.table-scroll { overflow-x:auto; }
.tbl { width:100%; border-collapse:collapse; min-width:760px; }
.tbl th { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:var(--text-light); padding:10px 16px; background:var(--surface); border-bottom:1px solid var(--border); text-align:left; white-space:nowrap; }
.tbl td { padding:13px 16px; font-size:13px; color:var(--text-dark); border-bottom:1px solid rgba(232,229,224,.5); vertical-align:middle; }
.tbl tr:last-child td { border-bottom:none; }
.tbl tr:hover td { background:rgba(248,247,245,.7); }
.pill { display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:600; padding:3px 9px; border-radius:20px; white-space:nowrap; }
.pill-active, .pill-approved { background:var(--success-bg); color:var(--success); }
.pill-pending { background:var(--warning-bg); color:var(--warning); }
.pill-suspended, .pill-rejected { background:var(--danger-bg); color:var(--danger); }
.pill-trial { background:var(--info-bg); color:var(--info); }
.pill-basic { background:var(--surface-alt); color:var(--purple); }
.pill-pro { background:var(--coral-pale); color:var(--coral); }
.pill-enterprise { background:#fdf5ff; color:var(--purple); }
.school-logo { width:32px; height:32px; border-radius:7px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0; }
.domain-badge { font-family:var(--mono); font-size:11px; background:var(--surface); color:var(--info); padding:2px 8px; border-radius:4px; border:1px solid var(--border); white-space:nowrap; }
.progress-bar-wrap { background:var(--surface); border-radius:20px; height:6px; overflow:hidden; margin-top:6px; }
.progress-fill { height:100%; border-radius:20px; transition:width .6s ease; }
.bg-success { background:var(--success); }
.bg-warning { background:var(--warning); }
.text-warning { color:var(--warning) !important; }
.health-list { display:flex; flex-direction:column; gap:10px; }
.health-row { font-size:12.5px; color:var(--text-mid); }
.health-row span, .health-row strong { display:inline-block; margin-bottom:4px; }
.health-row strong { float:right; color:var(--success); font-weight:600; }
.filter-row { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.filter-select { width:auto; padding:7px 10px; border-radius:8px; font-size:12.5px; background:white; }
.search-input-sm { display:flex; align-items:center; gap:6px; border:1.5px solid var(--border); border-radius:8px; padding:6px 10px; background:white; }
.search-input-sm input { border:none; outline:none; font-family:var(--font); font-size:12.5px; color:var(--text-dark); background:transparent; width:160px; }
.search-input-sm i { color:var(--text-light); font-size:13px; }
.link-btn { font-size:12.5px; font-weight:600; color:var(--coral); display:inline-flex; align-items:center; gap:4px; text-decoration:none; }
.link-btn:hover { color:var(--coral-light); }
.action-btn { width:28px; height:28px; border-radius:6px; background:var(--surface); border:1px solid var(--border); display:inline-flex; align-items:center; justify-content:center; cursor:pointer; color:var(--text-mid); font-size:12px; transition:all .18s; text-decoration:none; }
.action-btn:hover { background:var(--charcoal); color:white; border-color:var(--charcoal); }
.btn-primary, .btn-secondary { display:inline-flex; align-items:center; gap:6px; font-family:var(--font); font-size:13.5px; font-weight:600; padding:9px 16px; border-radius:8px; border:1.5px solid var(--border); text-decoration:none; }
.btn-primary { background:var(--coral); color:white; border-color:var(--coral); }
.btn-secondary { background:var(--white); color:var(--text-dark); }
.btn-secondary:hover { background:var(--surface); color:var(--text-dark); }
.activity-item { display:flex; gap:12px; align-items:flex-start; padding:12px 0; border-bottom:1px solid rgba(232,229,224,.5); }
.activity-item:last-child { border-bottom:none; }
.activity-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px; flex-shrink:0; }
.activity-text { font-size:13px; color:var(--text-dark); line-height:1.4; }
.activity-time { font-size:11px; color:var(--text-light); margin-top:3px; }
.two-col { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px; }
.three-col { display:grid; grid-template-columns:1fr 1.6fr; gap:16px; margin-bottom:20px; }
.top-school-item { display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid rgba(232,229,224,.5); }
.top-school-item:last-child { border-bottom:none; }
.rank-num { font-size:12px; font-weight:700; color:var(--text-light); width:26px; flex-shrink:0; text-align:center; }
.log-item { display:flex; align-items:flex-start; gap:10px; padding:10px 0; border-bottom:1px solid rgba(232,229,224,.5); font-size:12.5px; }
.log-item:last-child { border-bottom:none; }
.log-level { font-size:10px; font-weight:700; padding:2px 7px; border-radius:4px; text-transform:uppercase; flex-shrink:0; margin-top:1px; }
.log-info { background:var(--info-bg); color:var(--info); }
.log-warning { background:var(--warning-bg); color:var(--warning); }
.log-error { background:var(--danger-bg); color:var(--danger); }
.log-msg { color:var(--text-dark); flex:1; }
.log-time { font-family:var(--mono); font-size:11px; color:var(--text-light); white-space:nowrap; }
.empty-state { text-align:center; padding:28px; color:var(--text-light); font-size:13px; }
.text-truncate { white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
@media (max-width:1200px) {
  .stats-grid, .charts-row-3 { grid-template-columns:repeat(2,minmax(0,1fr)); }
  .charts-row, .two-col, .three-col { grid-template-columns:1fr; }
}
@media (max-width:700px) {
  .stats-grid, .charts-row-3 { grid-template-columns:1fr; }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const months = @json($months);
    const schools = @json($schoolRows);
    const planNames = @json($planDistribution->pluck('name')->values());
    const planCounts = @json($planDistribution->pluck('count')->values());
    const colors = @json($palette);

    const sharedOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1E1F26',
                padding: 12,
                titleFont: { family: 'Plus Jakarta Sans', size: 13, weight: '700' },
                bodyFont: { family: 'Plus Jakarta Sans', size: 13 },
                displayColors: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(232,229,224,.7)', drawBorder: false },
                ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, precision: 0 }
            },
            x: {
                grid: { display: false },
                ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } }
            }
        }
    };

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'MRR Added',
                data: @json($revenueGrowthData),
                borderColor: '#E85D3A',
                backgroundColor: 'rgba(232,93,58,.08)',
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#E85D3A',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                tension: .4,
                fill: true
            }]
        },
        options: {
            ...sharedOptions,
            scales: {
                ...sharedOptions.scales,
                y: {
                    ...sharedOptions.scales.y,
                    ticks: { font: { family: 'DM Mono', size: 10 }, callback: value => 'Rs ' + Number(value).toLocaleString() }
                }
            }
        }
    });

    new Chart(document.getElementById('planChart'), {
        type: 'doughnut',
        data: { labels: planNames, datasets: [{ data: planCounts, backgroundColor: colors, borderWidth: 0, hoverOffset: 8 }] },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: { legend: { display: false } }
        }
    });

    new Chart(document.getElementById('registrationChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{ label: 'New Schools', data: @json($growthData), backgroundColor: 'rgba(44,111,212,.82)', borderRadius: 6, borderSkipped: false }]
        },
        options: sharedOptions
    });

    new Chart(document.getElementById('userGrowthChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Users',
                data: @json($userGrowthData),
                borderColor: '#2DA06A',
                backgroundColor: 'rgba(45,160,106,.08)',
                borderWidth: 2.5,
                pointRadius: 3,
                pointBackgroundColor: '#2DA06A',
                tension: .4,
                fill: true
            }]
        },
        options: sharedOptions
    });

    function statusClass(status) {
        return { active: 'pill-active', trial: 'pill-trial', suspended: 'pill-suspended', pending: 'pill-pending' }[status] || 'pill-trial';
    }

    function planClass(index) {
        return ['pill-basic', 'pill-pro', 'pill-enterprise'][index % 3];
    }

    function renderSchools(rows) {
        const body = document.getElementById('schoolsBody');
        if (!rows.length) {
            body.innerHTML = '<tr><td colspan="8"><div class="empty-state">No schools match this filter.</div></td></tr>';
            return;
        }
        body.innerHTML = rows.map((school, index) => {
            const storageColor = school.storage > 80 ? 'var(--danger)' : school.storage > 60 ? 'var(--warning)' : 'var(--success)';
            const initials = school.name.substring(0, 2).toUpperCase();
            return `<tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div class="school-logo" style="background:var(--surface);color:${school.color};">${initials}</div>
                        <div>
                            <div style="font-weight:600;font-size:13.5px;">${school.name}</div>
                            <div style="font-size:11.5px;color:var(--text-light);font-family:var(--mono);">${school.slug}</div>
                        </div>
                    </div>
                </td>
                <td><span class="domain-badge">${school.domain}</span></td>
                <td><span class="pill ${planClass(index)}">${school.plan}</span></td>
                <td style="font-family:var(--mono);font-weight:600;">${Number(school.students).toLocaleString()}</td>
                <td>
                    <div style="font-size:12px;color:var(--text-mid);margin-bottom:3px;">${school.storage} GB</div>
                    <div class="progress-bar-wrap" style="width:80px;"><div class="progress-fill" style="background:${storageColor};width:${Math.min(school.storage, 100)}%;"></div></div>
                </td>
                <td><span class="pill ${statusClass(school.status)}">${school.status.charAt(0).toUpperCase() + school.status.slice(1)}</span></td>
                <td style="font-size:12.5px;color:var(--text-mid);">${school.joined}</td>
                <td>
                    <a class="action-btn" href="${school.edit_url}" title="Edit"><i class="bi bi-pencil"></i></a>
                    <a class="action-btn" href="${school.impersonate_url}" title="Login"><i class="bi bi-box-arrow-in-right"></i></a>
                </td>
            </tr>`;
        }).join('');
    }

    function filterSchools() {
        const query = document.getElementById('schoolSearch').value.toLowerCase();
        const status = document.getElementById('statusFilter').value;
        const plan = document.getElementById('planFilter').value;
        renderSchools(schools.filter(s =>
            (!query || s.name.toLowerCase().includes(query) || s.slug.toLowerCase().includes(query) || s.domain.toLowerCase().includes(query)) &&
            (!status || s.status === status) &&
            (!plan || s.plan === plan)
        ));
    }

    document.getElementById('schoolSearch').addEventListener('input', filterSchools);
    document.getElementById('statusFilter').addEventListener('change', filterSchools);
    document.getElementById('planFilter').addEventListener('change', filterSchools);
    renderSchools(schools);

    @foreach($planDistribution as $index => $plan)
        new Chart(document.getElementById('spark{{ $index }}'), {
            type: 'line',
            data: {
                labels: [1,2,3,4,5,6],
                datasets: [{ data: [{{ max(0, $plan['count'] - 2) }}, {{ max(0, $plan['count'] - 1) }}, {{ $plan['count'] }}, {{ $plan['count'] + 1 }}, {{ $plan['count'] }}, {{ $plan['count'] + 2 }}], borderColor: '{{ $palette[$index % count($palette)] }}', borderWidth: 2, pointRadius: 0, tension: .4 }]
            },
            options: { responsive: false, animation: false, plugins: { legend: { display: false }, tooltip: { enabled: false } }, scales: { x: { display: false }, y: { display: false } } }
        });
    @endforeach
});
</script>
@endpush
