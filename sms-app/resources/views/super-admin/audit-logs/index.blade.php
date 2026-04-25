@extends('layouts.app')

@section('title', 'Audit Logs | SaaS Admin')
@section('page_title', 'System Audit Logs')
@section('breadcrumb', '/ Super Admin / Audit Logs')

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>
                            <div style="font-weight:700;">{{ $log->user->name ?? 'System' }}</div>
                            <div style="font-size:.75rem;" class="muted">{{ $log->user->email ?? '' }}</div>
                        </td>
                        <td>
                            <span class="badge-sms badge-outline-sms">{{ strtoupper($log->action) }}</span>
                        </td>
                        <td>{{ $log->description }}</td>
                        <td class="mono">{{ $log->ip_address }}</td>
                        <td>{{ $log->created_at->format('M d, Y H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1.5rem;">
            {{ $logs->links() }}
        </div>
    </div>
@endsection
