@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Audit Logs</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">System Audit Logs</h1>
                <p class="text-muted small mb-0 mt-1">Track all critical actions performed by super admins across the platform.</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0">
    <div class="list-toolbar mb-4">
        <form action="{{ route('super-admin.audit-logs.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center flex-grow-1">
            <div class="search-wrap flex-grow-1" style="max-width: 400px;">
                <i class="bi bi-search text-muted"></i>
                <input type="text" name="search" class="search-input" placeholder="Search logs by action or user..." value="{{ request('search') }}">
            </div>

            @if(request()->filled('search'))
                <a href="{{ route('super-admin.audit-logs.index') }}" class="btn-outline-sms" title="Clear Search">
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
                        <th class="pl-4">User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th class="text-right pr-4">Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="hover-bg-light transition-all">
                            <td class="pl-4">
                                <div class="d-flex align-items-center py-1">
                                    <div class="user-avatar mr-3" style="width: 36px; height: 36px; background: rgba(78, 115, 223, 0.1); color: #4e73df; font-weight: 600; font-size: 0.85rem;">
                                        {{ str($log->user->name ?? 'System')->substr(0, 1)->upper() }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark small">{{ $log->user->name ?? 'System' }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ $log->user->email ?? 'platform@system' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="status-pill pill-active" style="background: rgba(100, 116, 139, 0.1); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.2); font-size: 0.7rem; letter-spacing: 0.5px; font-weight: 600;">
                                    <i class="bi bi-lightning-fill mr-1 small"></i> {{ strtoupper($log->action) }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-dark" style="max-width: 300px; line-height: 1.4;">
                                    {{ $log->description }}
                                </div>
                            </td>
                            <td>
                                <span class="mono small bg-light px-2 py-1 rounded border text-muted">
                                    {{ $log->ip_address }}
                                </span>
                            </td>
                            <td class="text-right pr-4">
                                <div class="small text-dark">{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="text-muted" style="font-size: 0.7rem;">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="empty-state-icon mb-3">
                                    <i class="bi bi-journal-text display-4 opacity-25"></i>
                                </div>
                                <div class="h5 font-weight-bold text-dark">No logs found</div>
                                <p class="small mb-0">No audit records match your current criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $logs->links() }}
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

