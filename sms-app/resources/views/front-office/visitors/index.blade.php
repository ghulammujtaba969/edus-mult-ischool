@extends('layouts.app')

@section('title', 'Visitor Log | EduCore SMS')
@section('page_title', 'Front Office - Visitors')
@section('breadcrumb', '/ Front Office / Visitors')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.front-office-visitors.create') }}"><i class="bi bi-person-plus-fill"></i> Add Visitor</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Visitor Name</th>
                <th>Purpose</th>
                <th>Date</th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($visitors as $visitor)
                <tr>
                    <td style="font-weight:700;">{{ $visitor->name }}</td>
                    <td>{{ $visitor->purpose }}</td>
                    <td class="mono">{{ $visitor->date->format('M d, Y') }}</td>
                    <td class="mono">{{ $visitor->in_time }}</td>
                    <td class="mono">
                        @if($visitor->out_time)
                            {{ $visitor->out_time }}
                        @else
                            <form action="{{ route('admin.front-office-visitors.update', $visitor) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="out_time" value="{{ date('H:i:s') }}">
                                <button class="btn-outline-sms" type="submit" style="font-size:.75rem;padding:.2rem .5rem;">Check Out</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <button class="btn-outline-sms" title="View Details" onclick="alert('Note: {{ $visitor->note }}')"><i class="bi bi-info-circle"></i></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No visitor logs found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
