@extends('layouts.app')

@section('title', 'Domain Requests | SaaS Admin')
@section('page_title', 'Domain Management')
@section('breadcrumb', '/ Super Admin / Domains')

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
                <tr>
                    <th>School</th>
                    <th>Domain</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($domains as $domain)
                    <tr>
                        <td>{{ $domain->school->name }}</td>
                        <td class="mono">{{ $domain->domain }}</td>
                        <td>
                            <span class="badge-sms badge-outline-sms">{{ ucfirst($domain->type) }}</span>
                        </td>
                        <td>
                            @if($domain->is_verified)
                                <span class="badge-sms badge-success-sms">Verified</span>
                            @else
                                <span class="badge-sms badge-warning-sms">Pending</span>
                            @endif
                        </td>
                        <td>{{ $domain->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1.5rem;">
            {{ $domains->links() }}
        </div>
    </div>
@endsection
