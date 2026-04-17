@extends('layouts.app')

@section('title', 'Send Notification | EduCore SMS')
@section('page_title', 'Send Notification')
@section('breadcrumb', '/ Main / Notifications / Send')

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="type">Notification Type</label>
                    <select class="filter-select" id="type" name="type" required>
                        <option value="announcement">Announcement</option>
                        <option value="emergency">Emergency Alert</option>
                        <option value="event">Event Update</option>
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="target_role">Target Audience</label>
                    <select class="filter-select" id="target_role" name="target_role">
                        <option value="">All Roles</option>
                        <option value="teacher">Teachers</option>
                        <option value="student">Students</option>
                        <option value="parent">Parents</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="title">Title</label>
                <input class="form-control-sms @error('title') is-invalid @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. School Holiday Notice" required>
                @error('title') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="body">Message Body</label>
                <textarea class="form-control-sms" id="body" name="body" rows="5" placeholder="Write your message here..." required>{{ old('body') }}</textarea>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 4rem;"><i class="bi bi-send-fill"></i> Send Now</button>
                <a class="btn-outline-sms" href="{{ route('admin.notifications.index') }}" style="padding:1rem 4rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
