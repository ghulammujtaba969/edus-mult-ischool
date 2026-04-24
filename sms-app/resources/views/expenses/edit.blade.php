@extends('layouts.app')

@section('title', 'Edit Expense | EduCore SMS')
@section('page_title', 'Edit Recorded Expense')
@section('breadcrumb', '/ Finance / Expenses / Edit')

@section('content')
    <div class="data-card" style="max-width:800px;margin:0 auto;">
        <div class="card-title">Expense Details</div>
        <form action="{{ route('admin.expenses.update', $expense) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="title">Expense Title</label>
                <input class="form-control-sms @error('title') is-invalid @enderror" type="text" id="title" name="title" value="{{ old('title', $expense->title) }}" placeholder="e.g. Electricity Bill - March" required>
                @error('title') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="category">Category</label>
                    <select class="form-control-sms @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Utilities" @selected(old('category', $expense->category) == 'Utilities')>Utilities</option>
                        <option value="Maintenance" @selected(old('category', $expense->category) == 'Maintenance')>Maintenance</option>
                        <option value="Salaries" @selected(old('category', $expense->category) == 'Salaries')>Salaries (Extra)</option>
                        <option value="Supplies" @selected(old('category', $expense->category) == 'Supplies')>Supplies</option>
                        <option value="Marketing" @selected(old('category', $expense->category) == 'Marketing')>Marketing</option>
                        <option value="Other" @selected(old('category', $expense->category) == 'Other')>Other</option>
                    </select>
                    @error('category') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="amount">Amount</label>
                    <input class="form-control-sms @error('amount') is-invalid @enderror" type="number" id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" step="0.01" min="0" required>
                    @error('amount') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="expense_date">Date</label>
                <input class="form-control-sms @error('expense_date') is-invalid @enderror" type="date" id="expense_date" name="expense_date" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" required>
                @error('expense_date') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="description">Description (Optional)</label>
                <textarea class="form-control-sms @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter additional details...">{{ old('description', $expense->description) }}</textarea>
                @error('description') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Update Expense</button>
                <a class="btn-outline-sms" href="{{ route('admin.expenses.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
