@extends('layouts.app')

@section('title', 'Add Rating | EduCore SMS')
@section('page_title', 'New Staff Rating')
@section('breadcrumb', '/ Staff / Ratings / New')

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.staff-ratings.store') }}" method="POST">
            @csrf
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="employee_id">Select Employee</label>
                    <select class="filter-select" id="employee_id" name="employee_id" required>
                        <option value="">Choose Employee...</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->user->name }} ({{ $employee->designation }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="rating">Rating (1-5)</label>
                    <select class="filter-select" id="rating" name="rating" required>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Good</option>
                        <option value="3">3 - Average</option>
                        <option value="2">2 - Poor</option>
                        <option value="1">1 - Very Poor</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="feedback">Feedback / Comments</label>
                <textarea class="form-control-sms" id="feedback" name="feedback" rows="3"></textarea>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-save"></i> Submit Rating</button>
                <a class="btn-outline-sms" href="{{ route('admin.staff-ratings.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
