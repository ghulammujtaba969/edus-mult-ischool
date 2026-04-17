@extends('layouts.app')

@section('title', 'Set Class Fees | EduCore SMS')
@section('page_title', 'Set Class Fees')
@section('breadcrumb', '/ Fees / Structures / Create')

@section('content')
    <div class="data-card" style="max-width:700px;margin:0 auto;">
        <div class="card-title">Fee Amount Assignment</div>
        <form action="{{ route('admin.fee-structures.store') }}" method="POST">
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
                    <label class="form-label-sms" for="school_class_id">Class</label>
                    <select class="filter-select @error('school_class_id') is-invalid @enderror" id="school_class_id" name="school_class_id" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" @selected(old('school_class_id') == $class->id)>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="fee_type_id">Fee Type</label>
                    <select class="filter-select @error('fee_type_id') is-invalid @enderror" id="fee_type_id" name="fee_type_id" required>
                        <option value="">Select Fee Type</option>
                        @foreach($feeTypes as $type)
                            <option value="{{ $type->id }}" @selected(old('fee_type_id') == $type->id)>{{ $type->name }} ({{ ucfirst($type->frequency) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="amount">Fee Amount (Rs.)</label>
                    <input class="form-control-sms @error('amount') is-invalid @enderror" type="number" step="0.01" id="amount" name="amount" value="{{ old('amount') }}" placeholder="e.g. 5000" required>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms" for="due_day">Monthly Due Day</label>
                    <input class="form-control-sms @error('due_day') is-invalid @enderror" type="number" min="1" max="31" id="due_day" name="due_day" value="{{ old('due_day', 5) }}" required>
                    <div class="muted" style="font-size:.75rem;margin-top:.35rem;">Day of month when fee becomes due.</div>
                </div>
                <div>
                    <label class="form-label-sms" for="effective_from">Effective From (Optional)</label>
                    <input class="form-control-sms" type="date" id="effective_from" name="effective_from" value="{{ old('effective_from') }}">
                </div>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save Structure</button>
                <a class="btn-outline-sms" href="{{ route('admin.fee-structures.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
