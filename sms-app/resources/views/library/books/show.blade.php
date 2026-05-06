@extends('layouts.app')

@section('title', 'Book Details | EduCore SMS')
@section('page_title', $book->title)
@section('breadcrumb', '/ Library / Books / Details')

@section('topbar_actions')
    <div style="display:flex;gap:.5rem;">
        <a class="btn-outline-sms" href="{{ route('admin.library-books.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
        <a class="btn-primary-sms" href="{{ route('admin.library-books.edit', $book) }}"><i class="bi bi-pencil"></i> Edit</a>
    </div>
@endsection

@section('content')
    <div class="profile-grid">
        <div class="profile-card">
            <div class="card-title">Book Details</div>
            <div style="display:grid;gap:1rem;">
                <div>
                    <div class="muted">Author</div>
                    <div style="font-weight:700;">{{ $book->author ?: 'N/A' }}</div>
                </div>
                <div>
                    <div class="muted">ISBN</div>
                    <div class="mono">{{ $book->isbn_no ?: 'N/A' }}</div>
                </div>
                <div>
                    <div class="muted">Publisher</div>
                    <div>{{ $book->publisher ?: 'N/A' }}</div>
                </div>
                <div>
                    <div class="muted">Rack No</div>
                    <div class="mono">{{ $book->rack_no ?: 'N/A' }}</div>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-title">Stock</div>
            <div class="kpi-grid" style="grid-template-columns:repeat(3,1fr);">
                <div>
                    <div class="muted">Total</div>
                    <div class="mono" style="font-size:1.4rem;font-weight:800;">{{ $book->quantity }}</div>
                </div>
                <div>
                    <div class="muted">Available</div>
                    <div class="mono" style="font-size:1.4rem;font-weight:800;color:{{ $book->available_quantity > 0 ? 'var(--success)' : 'var(--danger)' }};">{{ $book->available_quantity }}</div>
                </div>
                <div>
                    <div class="muted">Price</div>
                    <div class="mono" style="font-size:1.4rem;font-weight:800;">PKR {{ number_format($book->price) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="data-card" style="margin-top:1.25rem;">
        <div class="card-title">Issue History</div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Member</th>
                <th>Issue Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse($book->issues as $issue)
                <tr>
                    <td>{{ $issue->member?->user?->name ?? 'N/A' }}</td>
                    <td class="mono">{{ $issue->issue_date?->format('M d, Y') }}</td>
                    <td class="mono">{{ $issue->due_date?->format('M d, Y') }}</td>
                    <td>
                        <span class="status-pill {{ $issue->status === 'returned' ? 'pill-active' : 'pill-warning' }}">
                            {{ ucfirst($issue->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:2rem;color:var(--text-light);">No issue history found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
