@extends('layouts.app')

@section('title', 'Item Issuance | EduCore SMS')
@section('page_title', 'Issued Items')
@section('breadcrumb', '/ Inventory / Issues')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.inventory-item-issues.create') }}"><i class="bi bi-box-arrow-right"></i> Issue Item</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Item Name</th>
                <th>Issued To</th>
                <th>Qty</th>
                <th>Issue Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($issues as $issue)
                <tr>
                    <td style="font-weight:700;">{{ $issue->item->name }}</td>
                    <td>{{ $issue->user->name }}</td>
                    <td class="mono">{{ $issue->quantity }} {{ $issue->item->unit }}</td>
                    <td class="mono">{{ $issue->issue_date->format('M d, Y') }}</td>
                    <td>
                        <span class="status-pill {{ $issue->status === 'issued' ? 'pill-warning' : 'pill-active' }}">
                            {{ ucfirst($issue->status) }}
                        </span>
                    </td>
                    <td>
                        @if($issue->status === 'issued')
                            <form action="{{ route('admin.inventory-item-issues.update', $issue) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button class="btn-outline-sms" type="submit" style="color:var(--success);padding:.25rem .5rem;font-size:.75rem;">Return</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No items issued yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
