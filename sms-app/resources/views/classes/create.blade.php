@extends('layouts.app')

@section('title', 'Add Class | EduCore SMS')
@section('page_title', 'Add Class')
@section('breadcrumb', '/ Academic Setup / Classes / Add')

@section('content')
    <div class="data-card" style="max-width:600px;margin:0 auto;">
        <div class="card-title">Class Information</div>
        <form action="{{ route('admin.classes.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="name">Class Name</label>
                <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Class 1, Grade 9" required>
                @error('name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="level">Level (Optional)</label>
                <select class="filter-select" id="level" name="level">
                    <option value="">Select Level</option>
                    @foreach(['primary' => 'Primary', 'middle' => 'Middle', 'secondary' => 'Secondary', 'higher_secondary' => 'Higher Secondary'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('level') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('level') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="order_seq">Order Sequence</label>
                <input class="form-control-sms @error('order_seq') is-invalid @enderror" type="number" id="order_seq" name="order_seq" value="{{ old('order_seq', 0) }}" min="0" required>
                <div style="color:var(--text-light);font-size:.75rem;margin-top:.35rem;">Used to sort classes in lists (0 is first).</div>
                @error('order_seq') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save Class</button>
                <a class="btn-outline-sms" href="{{ route('admin.classes.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
