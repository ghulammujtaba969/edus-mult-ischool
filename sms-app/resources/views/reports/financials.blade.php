@extends('layouts.app')

@section('title', 'Financial Report | EduCore SMS')
@section('page_title', 'Financial Summary (' . $year . ')')
@section('breadcrumb', '/ Reports / Financials')

@section('content')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
        <div class="data-card" style="border-left:5px solid var(--success);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Total Income (Fees)</div>
            <div style="font-size:2rem;font-weight:800;color:var(--success);">{{ number_format($income, 2) }}</div>
        </div>
        <div class="data-card" style="border-left:5px solid var(--danger);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Total Expenses</div>
            <div style="font-size:2rem;font-weight:800;color:var(--danger);">{{ number_format($expenses, 2) }}</div>
        </div>
    </div>

    <div class="data-card">
        <div class="card-title">Monthly Comparison</div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Month</th>
                <th>Income</th>
                <th>Expense</th>
                <th>Net Profit/Loss</th>
            </tr>
            </thead>
            <tbody>
            @foreach(range(1, 12) as $m)
                @php
                    $inc = $monthly_income[$m] ?? 0;
                    $exp = $monthly_expense[$m] ?? 0;
                    $net = $inc - $exp;
                @endphp
                <tr>
                    <td>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</td>
                    <td class="mono">{{ number_format($inc, 2) }}</td>
                    <td class="mono">{{ number_format($exp, 2) }}</td>
                    <td class="mono" style="font-weight:700;color:{{ $net >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                        {{ number_format($net, 2) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
