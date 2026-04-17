@extends('layouts.app')

@section('title', 'Fee Report | EduCore SMS')
@section('page_title', 'Monthly Fee Report')
@section('breadcrumb', '/ Reports / Fees')

@section('topbar_actions')
    <div style="display:flex;gap:.5rem;">
        <a class="btn-outline-sms" href="{{ route('admin.reports.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
        <button class="btn-outline-sms" type="button" onclick="window.print()"><i class="bi bi-printer"></i> Print Summary</button>
    </div>
@endsection

@section('content')
    <div class="data-card" style="margin-bottom:2rem;">
        <form action="{{ route('admin.reports.fees') }}" method="GET" class="list-toolbar">
            <div style="display:flex;align-items:center;gap:1rem;">
                <label class="form-label-sms" style="margin:0;">Select Month:</label>
                <input class="form-control-sms" type="month" name="month" value="{{ $month }}" style="width:200px;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-funnel"></i> Generate</button>
            </div>
        </form>
    </div>

    <div class="info-grid-3" style="margin-bottom:2rem;">
        <div class="data-card">
            <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.5rem;">Total Receivable</div>
            <div style="font-size:1.5rem;font-weight:800;color:var(--charcoal);">PKR {{ number_format($summary['total']) }}</div>
        </div>
        <div class="data-card">
            <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.5rem;">Total Collected</div>
            <div style="font-size:1.5rem;font-weight:800;color:var(--success);">PKR {{ number_format($summary['paid']) }}</div>
        </div>
        <div class="data-card">
            <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.5rem;">Total Outstanding</div>
            <div style="font-size:1.5rem;font-weight:800;color:var(--danger);">PKR {{ number_format($summary['balance']) }}</div>
        </div>
    </div>

    <div class="data-card">
        <div class="data-card-header">
            <div>Challan List for <strong>{{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}</strong></div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Challan #</th>
                <th>Student</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse($invoices as $invoice)
                <tr>
                    <td class="mono">{{ $invoice->challan_no }}</td>
                    <td style="font-weight:700;">{{ $invoice->student->user->name }}</td>
                    <td>{{ $invoice->feeType->name }}</td>
                    <td class="mono">PKR {{ number_format($invoice->net_amount) }}</td>
                    <td class="mono">PKR {{ number_format($invoice->paid_amount) }}</td>
                    <td>
                        <span class="status-pill {{ $invoice->status === 'paid' ? 'pill-active' : ($invoice->status === 'unpaid' ? 'pill-inactive' : 'pill-partial') }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No invoices found for this month.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
