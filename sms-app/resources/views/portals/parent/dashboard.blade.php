@extends('layouts.app')

@section('title', 'Parent Dashboard | EduCore SMS')
@section('page_title', 'Parent Dashboard')
@section('breadcrumb', '/ Parent / Dashboard')

@section('content')
    <div class="info-grid-3">
        <div class="data-card" style="border-left:5px solid var(--primary);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">My Children Enrolled</div>
            <div style="font-size:2rem;font-weight:800;color:var(--primary);">{{ count($children) }}</div>
        </div>
        <div class="data-card" style="border-left:5px solid var(--danger);">
            <div style="color:var(--text-light);font-size:.9rem;font-weight:600;">Pending Fee Invoices</div>
            <div style="font-size:2rem;font-weight:800;color:var(--danger);">{{ $unpaidInvoices }}</div>
        </div>
    </div>

    <div class="data-card" style="margin-top:2rem;">
        <div class="card-title"><i class="bi bi-people"></i> My Children</div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));gap:1.5rem;">
            @forelse($children as $child)
                <div style="border:1px solid var(--border-color);padding:1.5rem;border-radius:12px;background:var(--bg-light);">
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                        <div style="width:50px;height:50px;background:var(--primary);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.2rem;">
                            {{ substr($child->user->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight:800;font-size:1.1rem;color:var(--charcoal);">{{ $child->user->name }}</div>
                            <div style="font-size:.85rem;color:var(--text-light);">{{ $child->schoolClass->name }} - {{ $child->section->name }}</div>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-top:1rem;">
                        <a href="{{ route('admin.reports.transcripts.show', $child) }}" target="_blank" class="btn-outline-sms" style="font-size:.75rem;text-align:center;text-decoration:none;">
                            <i class="bi bi-file-text"></i> Transcript
                        </a>
                        <a href="{{ route('admin.fee-invoices.index') }}" class="btn-outline-sms" style="font-size:.75rem;text-align:center;text-decoration:none;">
                            <i class="bi bi-receipt"></i> Fees
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align:center; padding:3rem; color:var(--text-light);">
                    No student records linked to your account. Please contact the school office.
                </div>
            @endforelse
        </div>
    </div>
@endsection
