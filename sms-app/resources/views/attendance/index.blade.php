@extends('layouts.app')

@section('title', 'Attendance Management | EduCore SMS')
@section('page_title', 'Attendance')
@section('breadcrumb', '/ Attendance')

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <div class="card-title">Select Section to Mark Attendance</div>
        <div class="kpi-grid" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));">
            @foreach($classes as $class)
                @foreach($class->sections as $section)
                    <div class="kpi-card" style="padding:1.5rem;">
                        <div style="display:flex;justify-content:space-between;align-items:start;">
                            <div>
                                <div class="kpi-label">{{ $class->name }}</div>
                                <div class="kpi-value" style="font-size:1.5rem;">Section {{ $section->name }}</div>
                            </div>
                            <div class="brand-icon" style="width:32px;height:32px;border-radius:8px;font-size:.9rem;">{{ $section->name }}</div>
                        </div>
                        <div style="margin-top:1.5rem;">
                            <form action="{{ route('admin.attendance.create') }}" method="GET">
                                <input type="hidden" name="section_id" value="{{ $section->id }}">
                                <div style="display:flex;gap:.5rem;">
                                    <input class="form-control-sms" type="date" name="date" value="{{ date('Y-m-d') }}" style="padding:.5rem;font-size:.85rem;">
                                    <button class="btn-primary-sms" type="submit" style="padding:.5rem 1rem;"><i class="bi bi-pencil-square"></i> Mark</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
