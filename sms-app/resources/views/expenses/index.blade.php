@extends('layouts.app')

@section('title', 'Expenses | EduCore SMS')
@section('page_title', 'Expense Management')
@section('breadcrumb', '/ Finance / Expenses')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.expenses.create') }}"><i class="bi bi-plus-lg"></i> Record Expense</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($expenses as $expense)
                <tr>
                    <td class="mono">{{ $expense->expense_date->format('M d, Y') }}</td>
                    <td style="font-weight:700;">{{ $expense->title }}</td>
                    <td><span class="badge-sms badge-outline-sms">{{ $expense->category }}</span></td>
                    <td class="mono" style="font-weight:700;">{{ number_format($expense->amount, 2) }}</td>
                    <td>{{ str($expense->description)->limit(40) }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.expenses.edit', $expense) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline-sms text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No expenses recorded.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
