@extends('layouts.app')

@section('title', 'Alumni Events | EduCore SMS')
@section('page_title', 'Alumni Events')
@section('breadcrumb', '/ Alumni / Events')

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.alumni.index') }}"><i class="bi bi-people"></i> Alumni Directory</a>
    <a class="btn-primary-sms" href="{{ route('admin.alumni-events.create') }}"><i class="bi bi-calendar-plus"></i> Create Event</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Event Title</th>
                <th>Date & Time</th>
                <th>Location</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($events as $event)
                <tr>
                    <td style="font-weight:700;">{{ $event->title }}</td>
                    <td class="mono">{{ $event->event_date->format('M d, Y H:i') }}</td>
                    <td>{{ $event->location ?? '--' }}</td>
                    <td>{{ str($event->description)->limit(50) }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.alumni-events.edit', $event) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.alumni-events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline-sms text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No alumni events found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
