@extends('layouts.app')

@section('title', 'Generate Invoices | EduCore SMS')
@section('page_title', 'Generate Bulk Invoices')
@section('breadcrumb', '/ Fees / Invoices / Generate')

@section('content')
    <div class="data-card" style="max-width:700px;margin:0 auto;">
        <div class="card-title">Billing Configuration</div>
        <form action="{{ route('admin.fee-invoices.store') }}" method="POST">
            @csrf
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="academic_year_id">Academic Year</label>
                    <select class="filter-select @error('academic_year_id') is-invalid @enderror" id="academic_year_id" name="academic_year_id" required>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" @selected(old('academic_year_id') == $year->id || $year->is_current)>{{ $year->name }} @if($year->is_current) (Current) @endif</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="school_class_id">Class (Optional)</label>
                    <select class="filter-select @error('school_class_id') is-invalid @enderror" id="school_class_id" name="school_class_id">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" @selected(old('school_class_id') == $class->id)>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms" for="fee_type_id">Fee Type</label>
                    <select class="filter-select @error('fee_type_id') is-invalid @enderror" id="fee_type_id" name="fee_type_id" required>
                        @foreach($feeTypes as $type)
                            <option value="{{ $type->id }}" @selected(old('fee_type_id') == $type->id)>{{ $type->name }} ({{ ucfirst($type->frequency) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="billing_month">Billing Month</label>
                    <input class="form-control-sms @error('billing_month') is-invalid @enderror" type="month" id="billing_month" name="billing_month" value="{{ old('billing_month', date('Y-m')) }}" required>
                </div>
            </div>

            <div class="alert-box" style="margin-bottom:2rem;background:var(--info-bg);border-color:var(--info);color:var(--info);">
                <i class="bi bi-info-circle"></i> This will generate invoices for all students in the selected class(es) based on the defined fee structure. It will skip students who already have an invoice for the same month and fee type.
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit" style="flex:1;"><i class="bi bi-lightning-charge-fill"></i> Generate Invoices</button>
                <a class="btn-outline-sms" href="{{ route('admin.fee-invoices.index') }}" style="flex:1;justify-content:center;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
