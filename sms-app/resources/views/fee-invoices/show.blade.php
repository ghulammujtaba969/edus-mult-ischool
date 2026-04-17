@extends('layouts.app')

@section('title', 'Invoice Details | EduCore SMS')
@section('page_title', 'Invoice Details')
@section('breadcrumb', '/ Finance / Invoices / ' . $feeInvoice->challan_no)

@section('topbar_actions')
    <div style="display:flex;gap:.5rem;">
        <a class="btn-outline-sms" href="{{ route('admin.fee-invoices.index') }}"><i class="bi bi-arrow-left"></i> Back to Invoices</a>
        @if($feeInvoice->status->value !== 'paid')
            <a class="btn-primary-sms" href="{{ route('admin.fee-payments.create', $feeInvoice) }}"><i class="bi bi-cash-stack"></i> Record Payment</a>
        @endif
        <button class="btn-outline-sms" type="button" onclick="window.print()"><i class="bi bi-printer"></i> Print Challan</button>
    </div>
@endsection

@section('content')
    <div class="profile-grid">
        <div class="profile-card">
            <div class="card-title">Challan Summary</div>
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.25rem;">Status</div>
                    <div>
                        <span class="status-pill {{ $feeInvoice->status->value === 'paid' ? 'pill-active' : ($feeInvoice->status->value === 'partial' ? 'pill-warning' : 'pill-inactive') }}">
                            {{ ucfirst($feeInvoice->status->value) }}
                        </span>
                    </div>
                </div>
                <div>
                    <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.25rem;">Challan No</div>
                    <div style="font-weight:800;font-family:monospace;font-size:1.1rem;">{{ $feeInvoice->challan_no }}</div>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.25rem;">Billing Month</div>
                    <div style="font-weight:700;">{{ $feeInvoice->billing_month->format('F Y') }}</div>
                </div>
                <div>
                    <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.25rem;">Due Date</div>
                    <div style="font-weight:700;color:{{ $feeInvoice->due_date->isPast() && $feeInvoice->status->value !== 'paid' ? 'var(--danger)' : 'var(--text-main)' }}">
                        {{ $feeInvoice->due_date->format('M d, Y') }}
                        @if($feeInvoice->due_date->isPast() && $feeInvoice->status->value !== 'paid')
                            <span style="font-size:.7rem;display:block;">(Overdue)</span>
                        @endif
                    </div>
                </div>
            </div>

            <div style="border-top:1px solid var(--border-color);padding-top:1.5rem;">
                <div class="info-grid-2" style="margin-bottom:.75rem;">
                    <div style="color:var(--text-light);">Base Amount</div>
                    <div style="text-align:right;font-weight:700;">PKR {{ number_format($feeInvoice->amount) }}</div>
                </div>
                <div class="info-grid-2" style="margin-bottom:.75rem;">
                    <div style="color:var(--text-light);">Discount</div>
                    <div style="text-align:right;font-weight:700;color:var(--success);">(-) PKR {{ number_format($feeInvoice->discount_amount) }}</div>
                </div>
                <div class="info-grid-2" style="margin-bottom:.75rem;">
                    <div style="color:var(--text-light);">Late Fine</div>
                    <div style="text-align:right;font-weight:700;color:var(--danger);">(+) PKR {{ number_format($feeInvoice->fine_amount) }}</div>
                </div>
                <div class="info-grid-2" style="margin-top:1rem;border-top:2px solid var(--charcoal);padding-top:1rem;">
                    <div style="font-weight:800;font-size:1.2rem;">Net Payable</div>
                    <div style="text-align:right;font-weight:800;font-size:1.2rem;">PKR {{ number_format($feeInvoice->net_amount) }}</div>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-title">Student Information</div>
            <div style="display:flex;align-items:center;gap:1.5rem;margin-bottom:2rem;">
                <div class="user-avatar" style="width:80px;height:80px;font-size:2rem;">{{ str($feeInvoice->student->user->name)->substr(0, 2)->upper() }}</div>
                <div>
                    <div style="font-size:1.2rem;font-weight:800;">{{ $feeInvoice->student->user->name }}</div>
                    <div class="student-reg">{{ $feeInvoice->student->registration_no }}</div>
                    <div class="muted">{{ $feeInvoice->student->currentAcademicRecord->schoolClass->name }} - {{ $feeInvoice->student->currentAcademicRecord->section->name }}</div>
                </div>
            </div>

            <div class="card-title" style="font-size:1rem;">Payment History</div>
            @if($feeInvoice->payments->count() > 0)
                <table class="sms-table" style="font-size:.9rem;">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Method</th>
                        <th style="text-align:right;">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($feeInvoice->payments as $payment)
                        <tr>
                            <td class="mono">{{ $payment->payment_date->format('M d, Y') }}</td>
                            <td>{{ ucfirst($payment->payment_method) }}</td>
                            <td style="text-align:right;font-weight:700;">PKR {{ number_format($payment->amount_paid) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr style="background:var(--gray-bg);font-weight:800;">
                        <td colspan="2">Total Paid</td>
                        <td style="text-align:right;">PKR {{ number_format($feeInvoice->paid_amount) }}</td>
                    </tr>
                    <tr style="font-weight:800;color:var(--danger);">
                        <td colspan="2">Remaining</td>
                        <td style="text-align:right;">PKR {{ number_format($feeInvoice->balance_amount) }}</td>
                    </tr>
                    </tfoot>
                </table>
            @else
                <div style="text-align:center;padding:2rem;color:var(--text-light);background:var(--gray-bg);border-radius:12px;">
                    <i class="bi bi-info-circle" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
                    No payments recorded for this invoice yet.
                </div>
            @endif
        </div>
    </div>
@endsection
