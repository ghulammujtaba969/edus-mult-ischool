@extends('layouts.app')

@section('title', 'Generate Payroll | EduCore SMS')
@section('page_title', 'Generate Payroll')
@section('breadcrumb', '/ Staff / Payroll / Generate')

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.payrolls.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="billing_month">Select Month</label>
                <input class="form-control-sms" type="month" id="billing_month" name="billing_month" value="{{ date('Y-m') }}" required>
            </div>

            <div class="alert-box" style="margin-bottom:2rem;background:var(--gray-bg);border-color:var(--border-color);color:var(--charcoal);">
                <i class="bi bi-info-circle"></i> This will generate salary records for all active employees for the selected month.
            </div>

            <button class="btn-primary-sms" type="submit" style="padding:1rem 4rem;"><i class="bi bi-lightning-charge"></i> Generate Payroll</button>
        </form>
    </div>
@endsection
