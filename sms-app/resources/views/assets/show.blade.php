@extends('layouts.app')

@section('title', $asset->name . ' | EduCore SMS')
@section('page_title', 'Asset Details')
@section('breadcrumb', '/ Assets / ' . $asset->name)

@section('topbar_actions')
    <div style="display:flex;gap:.5rem;">
        <a class="btn-outline-sms" href="{{ route('admin.assets.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
        @if($asset->status === 'available')
            <a class="btn-primary-sms" href="{{ route('admin.asset-assignments.create', ['asset_id' => $asset->id]) }}"><i class="bi bi-person-check"></i> Assign Asset</a>
        @endif
    </div>
@endsection

@section('content')
    <div class="profile-grid">
        <div class="profile-card">
            <div class="card-title">Technical Specifications</div>
            <div class="info-grid-2">
                <div>
                    <div class="muted">Asset Code</div>
                    <div style="font-weight:700;font-family:monospace;">{{ $asset->code }}</div>
                </div>
                <div>
                    <div class="muted">Status</div>
                    <div><span class="status-pill {{ $asset->status === 'available' ? 'pill-active' : 'pill-partial' }}">{{ ucfirst($asset->status) }}</span></div>
                </div>
                <div>
                    <div class="muted">Condition</div>
                    <div><span class="status-pill">{{ ucfirst($asset->condition) }}</span></div>
                </div>
                <div>
                    <div class="muted">Category</div>
                    <div style="font-weight:700;">{{ $asset->category->name }}</div>
                </div>
            </div>
            <div class="info-grid-2" style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--border-color);">
                <div>
                    <div class="muted">Purchase Date</div>
                    <div style="font-weight:700;">{{ $asset->purchase_date?->format('M d, Y') ?? 'N/A' }}</div>
                </div>
                <div>
                    <div class="muted">Purchase Cost</div>
                    <div style="font-weight:700;">PKR {{ number_format($asset->purchase_cost) }}</div>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-title">Assignment History</div>
            <table class="sms-table">
                <thead>
                <tr>
                    <th>Assigned To</th>
                    <th>Date</th>
                    <th>Returned</th>
                </tr>
                </thead>
                <tbody>
                @forelse($asset->assignments as $assignment)
                    <tr>
                        <td>
                            <div style="font-weight:700;">{{ $assignment->assignedTo->user->name }}</div>
                            <div class="muted" style="font-size:.75rem;">{{ str($assignment->assigned_to_type)->afterLast('\\') }}</div>
                        </td>
                        <td class="mono">{{ $assignment->assigned_at->format('M d, Y') }}</td>
                        <td>
                            @if($assignment->returned_at)
                                <span class="mono">{{ $assignment->returned_at->format('M d, Y') }}</span>
                            @else
                                <span class="status-pill pill-active">In Use</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;padding:1rem;color:var(--text-light);">No assignment history.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
