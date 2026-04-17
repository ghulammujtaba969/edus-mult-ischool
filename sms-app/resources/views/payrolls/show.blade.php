@extends('layouts.app')

@section('title', 'Payroll Details | EduCore SMS')
@section('page_title', 'Payroll Details')
@section('breadcrumb', '/ Staff / Payroll / ' . $payroll->employee->user->name)

@section('topbar_actions')
    <div style="display:flex;gap:.5rem;">
        <a class="btn-outline-sms" href="{{ route('admin.payrolls.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
        @if($payroll->status !== 'paid')
            <button class="btn-primary-sms" type="button" onclick="document.getElementById('pay-modal').style.display='flex'"><i class="bi bi-cash-stack"></i> Pay Salary</button>
        @endif
        <button class="btn-outline-sms" type="button" onclick="window.print()"><i class="bi bi-printer"></i> Print Pay Slip</button>
    </div>
@endsection

@section('content')
    <div class="profile-grid">
        <div class="profile-card">
            <div class="card-title">Salary Breakdown</div>
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.25rem;">Status</div>
                    <div>
                        <span class="status-pill {{ $payroll->status === 'paid' ? 'pill-active' : 'pill-inactive' }}">
                            {{ ucfirst($payroll->status) }}
                        </span>
                    </div>
                </div>
                <div>
                    <div style="color:var(--text-light);font-size:.85rem;margin-bottom:.25rem;">Billing Month</div>
                    <div style="font-weight:700;">{{ $payroll->billing_month->format('F Y') }}</div>
                </div>
            </div>

            <div style="border-top:1px solid var(--border-color);padding-top:1.5rem;">
                <div class="info-grid-2" style="margin-bottom:.75rem;">
                    <div style="color:var(--text-light);">Basic Salary</div>
                    <div style="text-align:right;font-weight:700;">PKR {{ number_format($payroll->basic_salary) }}</div>
                </div>
                <div class="info-grid-2" style="margin-bottom:.75rem;">
                    <div style="color:var(--text-light);">Allowances</div>
                    <div style="text-align:right;font-weight:700;color:var(--success);">(+) PKR {{ number_format($payroll->allowances) }}</div>
                </div>
                <div class="info-grid-2" style="margin-bottom:.75rem;">
                    <div style="color:var(--text-light);">Deductions</div>
                    <div style="text-align:right;font-weight:700;color:var(--danger);">(-) PKR {{ number_format($payroll->deductions) }}</div>
                </div>
                <div class="info-grid-2" style="margin-top:1rem;border-top:2px solid var(--charcoal);padding-top:1rem;">
                    <div style="font-weight:800;font-size:1.2rem;">Net Salary</div>
                    <div style="text-align:right;font-weight:800;font-size:1.2rem;">PKR {{ number_format($payroll->net_salary) }}</div>
                </div>
            </div>

            @if($payroll->status === 'paid')
                <div style="margin-top:2rem;padding:1.5rem;background:var(--success-bg);border-radius:12px;border:1px solid var(--success);">
                    <div style="font-weight:700;color:var(--success);margin-bottom:.5rem;">Payment Info</div>
                    <div style="font-size:.9rem;color:var(--success);">Paid on: {{ $payroll->payment_date->format('M d, Y') }} via {{ ucfirst($payroll->payment_method) }}</div>
                    @if($payroll->notes)
                        <div style="font-size:.9rem;color:var(--success);margin-top:.25rem;">Note: {{ $payroll->notes }}</div>
                    @endif
                </div>
            @endif
        </div>

        <div class="profile-card">
            <div class="card-title">Employee Information</div>
            <div style="display:flex;align-items:center;gap:1.5rem;margin-bottom:2rem;">
                <div class="user-avatar" style="width:80px;height:80px;font-size:2rem;">{{ str($payroll->employee->user->name)->substr(0, 2)->upper() }}</div>
                <div>
                    <div style="font-size:1.2rem;font-weight:800;">{{ $payroll->employee->user->name }}</div>
                    <div class="student-reg">{{ $payroll->employee->employee_code }}</div>
                    <div class="muted">{{ $payroll->employee->designation }} | {{ $payroll->employee->department }}</div>
                </div>
            </div>
            <div class="info-grid-2">
                <div>
                    <div style="color:var(--text-light);font-size:.85rem;">Phone</div>
                    <div style="font-weight:700;">{{ $payroll->employee->phone }}</div>
                </div>
                <div>
                    <div style="color:var(--text-light);font-size:.85rem;">Joining Date</div>
                    <div style="font-weight:700;">{{ $payroll->employee->joining_date->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal (Simple implementation) -->
    <div id="pay-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;z-index:1000;">
        <div class="data-card" style="width:100%;max-width:500px;margin:0 1rem;">
            <div class="card-title">Mark as Paid</div>
            <form action="{{ route('admin.payrolls.update', $payroll) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="paid">
                
                <div style="margin-bottom:1.5rem;">
                    <label class="form-label-sms" for="payment_date">Payment Date</label>
                    <input class="form-control-sms" type="date" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" required>
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label class="form-label-sms" for="payment_method">Payment Method</label>
                    <select class="filter-select" id="payment_method" name="payment_method" required>
                        <option value="cash">Cash</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="cheque">Cheque</option>
                    </select>
                </div>

                <div style="margin-bottom:2rem;">
                    <label class="form-label-sms" for="notes">Notes</label>
                    <textarea class="form-control-sms" id="notes" name="notes" rows="2"></textarea>
                </div>

                <div style="display:flex;gap:1rem;">
                    <button class="btn-primary-sms" type="submit" style="flex:1;">Confirm Payment</button>
                    <button class="btn-outline-sms" type="button" onclick="document.getElementById('pay-modal').style.display='none'" style="flex:1;justify-content:center;">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
