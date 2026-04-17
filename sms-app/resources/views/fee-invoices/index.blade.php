@extends('layouts.app')

@section('title', 'Fee Invoices | EduCore SMS')
@section('page_title', 'Fee Invoices')
@section('breadcrumb', '/ Fees / Invoices')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.fee-invoices.create') }}"><i class="bi bi-lightning-charge"></i> Bulk Generate</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <form class="list-toolbar" method="GET" action="{{ route('admin.fee-invoices.index') }}">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input class="search-input" type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search Challan # or Student">
        </div>
        <select class="filter-select" name="status">
            <option value="">All Status</option>
            <option value="unpaid" @selected(($filters['status'] ?? '') === 'unpaid')>Unpaid</option>
            <option value="partially_paid" @selected(($filters['status'] ?? '') === 'partially_paid')>Partially Paid</option>
            <option value="paid" @selected(($filters['status'] ?? '') === 'paid')>Paid</option>
        </select>
        <button class="btn-primary-sms" type="submit"><i class="bi bi-funnel"></i> Filter</button>
    </form>

    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Challan #</th>
                <th>Student</th>
                <th>Month</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($invoices as $invoice)
                <tr>
                    <td class="mono">{{ $invoice->challan_no }}</td>
                    <td style="font-weight:700;">{{ $invoice->student->user->name }}</td>
                    <td class="mono">{{ $invoice->billing_month->format('M Y') }}</td>
                    <td class="mono">Rs. {{ number_format($invoice->net_amount, 2) }}</td>
                    <td>
                        <span class="status-pill {{ $invoice->status->value === 'paid' ? 'pill-active' : ($invoice->status->value === 'unpaid' ? 'pill-inactive' : 'pill-partial') }}">
                            {{ ucfirst($invoice->status->value) }}
                        </span>
                    </td>
                    <td class="mono">{{ $invoice->due_date->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.fee-invoices.show', $invoice) }}"><i class="bi bi-eye"></i></a>
                            <button class="btn-outline-sms" type="button" title="Print Challan"><i class="bi bi-printer"></i></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-light);">No invoices found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="data-footer">
            {{ $invoices->links() }}
        </div>
    </div>
@endsection
