@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Domain Management</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Domain Management</h1>
                <p class="text-muted small mb-0 mt-1">Manage custom domains and subdomains across all school instances.</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0">
    <div class="list-toolbar mb-4">
        <form action="{{ route('super-admin.domains.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center flex-grow-1">
            <div class="search-wrap flex-grow-1" style="max-width: 400px;">
                <i class="bi bi-search text-muted"></i>
                <input type="text" name="search" class="search-input" placeholder="Search by domain or school..." value="{{ request('search') }}">
            </div>

            <select name="type" class="filter-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="subdomain" @selected(request('type') === 'subdomain')>Subdomain</option>
                <option value="custom" @selected(request('type') === 'custom')>Custom Domain</option>
            </select>

            @if(request()->anyFilled(['search', 'type']))
                <a href="{{ route('super-admin.domains.index') }}" class="btn-outline-sms" title="Clear Filters">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            @endif
        </form>
    </div>

    <div class="card-sms shadow-sm mb-4" style="overflow: hidden;">
        <div class="table-responsive">
            <table class="sms-table mb-0">
                <thead>
                    <tr>
                        <th class="pl-4">School</th>
                        <th>Domain / Host</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="text-right pr-4">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($domains as $domain)
                        <tr class="hover-bg-light transition-all">
                            <td class="pl-4">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar mr-3" style="width: 36px; height: 36px; background: rgba(78, 115, 223, 0.1); color: #4e73df; font-weight: 600; font-size: 0.85rem;">
                                        {{ str($domain->school->name)->substr(0, 1)->upper() }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark">{{ $domain->school->name }}</div>
                                        <div class="text-muted small">ID: {{ $domain->school->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="mono small bg-light px-2 py-1 rounded border text-dark">
                                    {{ $domain->domain }}
                                </span>
                            </td>
                            <td>
                                <span class="status-pill pill-active" style="background: rgba(100, 116, 139, 0.1); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.2);">
                                    {{ ucfirst($domain->type) }}
                                </span>
                            </td>
                            <td>
                                @if($domain->is_verified)
                                    <span class="status-pill pill-active"><i class="bi bi-check-circle-fill mr-1 small"></i> Verified</span>
                                @else
                                    <span class="status-pill pill-pending"><i class="bi bi-clock-fill mr-1 small"></i> Pending</span>
                                @endif
                            </td>
                            <td class="text-right pr-4 text-muted small">
                                {{ $domain->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="empty-state-icon mb-3">
                                    <i class="bi bi-globe display-4 opacity-25"></i>
                                </div>
                                <div class="h5 font-weight-bold text-dark">No domains found</div>
                                <p class="small mb-0">Try adjusting your filters or search terms.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($domains->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $domains->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .hover-bg-light:hover {
        background-color: #fcfdfe;
    }
    .mono {
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
    }
</style>
@endpush
@endsection

