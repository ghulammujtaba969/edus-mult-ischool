@extends('layouts.app')

@section('title', 'Reports | EduCore SMS')
@section('page_title', 'Reports Dashboard')
@section('breadcrumb', '/ Main / Reports')

@section('content')
    <div class="info-grid-3">
        <a href="{{ route('admin.reports.attendance') }}" class="data-card" style="text-decoration:none;transition:transform 0.2s;">
            <div style="text-align:center;padding:1rem;">
                <i class="bi bi-calendar-check" style="font-size:3rem;color:var(--primary);margin-bottom:1rem;display:block;"></i>
                <div style="font-weight:800;font-size:1.2rem;color:var(--charcoal);">Attendance Report</div>
                <div style="color:var(--text-light);font-size:.9rem;margin-top:.5rem;">Daily student attendance summary across sections.</div>
            </div>
        </a>

        <a href="{{ route('admin.reports.fees') }}" class="data-card" style="text-decoration:none;transition:transform 0.2s;">
            <div style="text-align:center;padding:1rem;">
                <i class="bi bi-cash-coin" style="font-size:3rem;color:var(--success);margin-bottom:1rem;display:block;"></i>
                <div style="font-weight:800;font-size:1.2rem;color:var(--charcoal);">Fee Collection</div>
                <div style="color:var(--text-light);font-size:.9rem;margin-top:.5rem;">Monthly fee collection and defaulters summary.</div>
            </div>
        </a>

        <div class="data-card" style="text-opacity:0.5;cursor:not-allowed;">
            <div style="text-align:center;padding:1rem;">
                <i class="bi bi-graph-up-arrow" style="font-size:3rem;color:var(--text-light);margin-bottom:1rem;display:block;"></i>
                <div style="font-weight:800;font-size:1.2rem;color:var(--text-light);">Exam Results</div>
                <div style="color:var(--text-light);font-size:.9rem;margin-top:.5rem;">(Coming Soon) Class-wise academic performance.</div>
            </div>
        </div>
    </div>
@endsection
