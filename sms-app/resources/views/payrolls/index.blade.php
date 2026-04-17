@extends('layouts.app')

@section('title', 'Payroll | EduCore SMS')
@section('page_title', 'Payroll Management')
@section('breadcrumb', '/ Staff / Payroll')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.payrolls.create') }}"><i class="bi bi-lightning-charge"></i> Bulk Generate</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Month</th>
                <th>Basic Salary</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($payrolls as $payroll)
                <tr>
                    <td style="font-weight:700;">{{ $payroll->employee->user->name }}</td>
                    <td class="mono">{{ $payroll->billing_month->format('M Y') }}</td>
                    <td class="mono">PKR {{ number_format($payroll->basic_salary) }}</td>
                    <td>
                        <span class="status-pill {{ $payroll->status === 'paid' ? 'pill-active' : 'pill-inactive' }}">
                            {{ ucfirst($payroll->status) }}
                        </span>
                    </td>
                    <td>{{ $payroll->payment_method ?? 'N/A' }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.payrolls.show', $payroll) }}"><i class="bi bi-eye"></i></a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No payroll records found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="data-footer">
            {{ $payrolls->links() }}
        </div>
    </div>
@endsection
