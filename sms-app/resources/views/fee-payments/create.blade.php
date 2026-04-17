@extends('layouts.app')

@section('title', 'Pay Invoice | EduCore SMS')
@section('page_title', 'Pay Invoice')
@section('breadcrumb', '/ Finance / Invoices / Pay')

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.fee-invoices.show', $feeInvoice) }}"><i class="bi bi-arrow-left"></i> Back to Invoice</a>
@endsection

@section('content')
    <div class="data-card">
        <div class="data-card-header" style="flex-direction:column;align-items:start;gap:.5rem;">
            <div style="font-size:1.2rem;font-weight:800;">Challan # {{ $feeInvoice->challan_no }}</div>
            <div class="muted">Student: <strong>{{ $feeInvoice->student->user->name }}</strong></div>
            <div class="muted">Type: <strong>{{ $feeInvoice->feeType->name }}</strong></div>
        </div>

        <div class="info-grid-2" style="margin:2rem 0;background:var(--gray-bg);padding:1.5rem;border-radius:12px;">
            <div>
                <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.25rem;">Net Amount</div>
                <div style="font-size:1.5rem;font-weight:800;color:var(--charcoal);">PKR {{ number_format($feeInvoice->net_amount) }}</div>
            </div>
            <div>
                <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.25rem;">Remaining Balance</div>
                <div style="font-size:1.5rem;font-weight:800;color:var(--danger);">PKR {{ number_format($feeInvoice->balance_amount) }}</div>
            </div>
        </div>

        <form action="{{ route('admin.fee-payments.store', $feeInvoice) }}" method="POST">
            @csrf
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="amount_paid">Amount to Pay (PKR)</label>
                    <input class="form-control-sms @error('amount_paid') is-invalid @enderror" type="number" step="0.01" id="amount_paid" name="amount_paid" value="{{ old('amount_paid', $feeInvoice->balance_amount) }}" max="{{ $feeInvoice->balance_amount }}" required>
                    @error('amount_paid') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="payment_date">Payment Date</label>
                    <input class="form-control-sms" type="date" id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="payment_method">Payment Method</label>
                    <select class="filter-select" id="payment_method" name="payment_method" required>
                        <option value="cash" @selected(old('payment_method') === 'cash')>Cash</option>
                        <option value="bank" @selected(old('payment_method') === 'bank')>Bank Deposit</option>
                        <option value="online" @selected(old('payment_method') === 'online')>Online Transfer</option>
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="reference_no">Reference / Receipt #</label>
                    <input class="form-control-sms" type="text" id="reference_no" name="reference_no" value="{{ old('reference_no') }}" placeholder="e.g. Bank Ref #">
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="notes">Notes (Optional)</label>
                <textarea class="form-control-sms" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
            </div>

            <button class="btn-primary-sms" type="submit" style="padding:1rem 4rem;"><i class="bi bi-cash-stack"></i> Record Payment</button>
        </form>
    </div>
@endsection
