@extends('layouts.app')

@section('title', 'Staff Ratings | EduCore SMS')
@section('page_title', 'Performance Ratings')
@section('breadcrumb', '/ Staff / Ratings')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.staff-ratings.create') }}"><i class="bi bi-star-fill"></i> Add Rating</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Rating</th>
                <th>Feedback</th>
                <th>Rated By</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @forelse($ratings as $rating)
                <tr>
                    <td style="font-weight:700;">{{ $rating->employee->user->name }}</td>
                    <td>
                        @for($i=1; $i<=5; $i++)
                            <i class="bi bi-star{{ $i <= $rating->rating ? '-fill' : '' }}" style="color:var(--warning);"></i>
                        @endfor
                    </td>
                    <td>{{ $rating->feedback }}</td>
                    <td>{{ $rating->rater->name }}</td>
                    <td class="mono">{{ $rating->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No ratings found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
