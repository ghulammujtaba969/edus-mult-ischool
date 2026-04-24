@extends('layouts.app')

@section('title', 'Lesson Plans | EduCore SMS')
@section('page_title', 'Lesson Plans')
@section('breadcrumb', '/ Academics / Lesson Plans')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.lesson-plans.create') }}"><i class="bi bi-plus-lg"></i> Create Lesson Plan</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Lesson Name</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Date</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($plans as $plan)
                <tr>
                    <td style="font-weight:700;">{{ $plan->lesson_name }}</td>
                    <td>{{ $plan->schoolClass->name }}</td>
                    <td>{{ $plan->subject->name }}</td>
                    <td>{{ $plan->teacher->name }}</td>
                    <td class="mono">{{ $plan->date->format('M d, Y') }}</td>
                    <td class="mono">
                        {{ $plan->time_from ?? '--' }} - {{ $plan->time_to ?? '--' }}
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.lesson-plans.edit', $plan) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.lesson-plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lesson plan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline-sms text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-light);">No lesson plans found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
