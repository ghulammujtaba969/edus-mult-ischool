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

        <a href="{{ route('admin.reports.financials') }}" class="data-card" style="text-decoration:none;transition:transform 0.2s;">
            <div style="text-align:center;padding:1rem;">
                <i class="bi bi-bank" style="font-size:3rem;color:var(--info);margin-bottom:1rem;display:block;"></i>
                <div style="font-weight:800;font-size:1.2rem;color:var(--charcoal);">Financial Summary</div>
                <div style="color:var(--text-light);font-size:.9rem;margin-top:.5rem;">Income vs Expense analysis for the academic year.</div>
            </div>
        </a>

        <a href="{{ route('admin.reports.inventory') }}" class="data-card" style="text-decoration:none;transition:transform 0.2s;">
            <div style="text-align:center;padding:1rem;">
                <i class="bi bi-box-seam" style="font-size:3rem;color:var(--warning);margin-bottom:1rem;display:block;"></i>
                <div style="font-weight:800;font-size:1.2rem;color:var(--charcoal);">Inventory Status</div>
                <div style="color:var(--text-light);font-size:.9rem;margin-top:.5rem;">Current stock levels and issuance tracking.</div>
            </div>
        </a>

        <a href="{{ route('admin.reports.transcripts') }}" class="data-card" style="text-decoration:none;transition:transform 0.2s;">
            <div style="text-align:center;padding:1rem;">
                <i class="bi bi-file-earmark-person" style="font-size:3rem;color:var(--danger);margin-bottom:1rem;display:block;"></i>
                <div style="font-weight:800;font-size:1.2rem;color:var(--charcoal);">Student Transcripts</div>
                <div style="color:var(--text-light);font-size:.9rem;margin-top:.5rem;">Consolidated academic results and performance logs.</div>
            </div>
        </a>
    </div>
@endsection
