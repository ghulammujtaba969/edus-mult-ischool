@extends('layouts.app')

@section('title', 'Edit Alumni Event | EduCore SMS')
@section('page_title', 'Edit Alumni Event')
@section('breadcrumb', '/ Alumni / Events / Edit')

@section('content')
    <div class="data-card" style="max-width:800px;margin:0 auto;">
        <div class="card-title">Event Information</div>
        <form action="{{ route('admin.alumni-events.update', $alumniEvent) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="title">Event Title</label>
                <input class="form-control-sms @error('title') is-invalid @enderror" type="text" id="title" name="title" value="{{ old('title', $alumniEvent->title) }}" placeholder="e.g. Annual Alumni Meet 2026" required>
                @error('title') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="event_date">Event Date & Time</label>
                    <input class="form-control-sms @error('event_date') is-invalid @enderror" type="datetime-local" id="event_date" name="event_date" value="{{ old('event_date', $alumniEvent->event_date->format('Y-m-d\TH:i')) }}" required>
                    @error('event_date') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="location">Location</label>
                    <input class="form-control-sms @error('location') is-invalid @enderror" type="text" id="location" name="location" value="{{ old('location', $alumniEvent->location) }}" placeholder="e.g. School Main Auditorium">
                    @error('location') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="description">Event Description</label>
                <textarea class="form-control-sms @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Describe the event...">{{ old('description', $alumniEvent->description) }}</textarea>
                @error('description') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Update Event</button>
                <a class="btn-outline-sms" href="{{ route('admin.alumni-events.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
