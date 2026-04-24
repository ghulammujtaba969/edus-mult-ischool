@extends('layouts.app')

@section('title', 'Alumni Directory | EduCore SMS')
@section('page_title', 'Alumni Directory')
@section('breadcrumb', '/ Alumni / Directory')

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.alumni-events.index') }}"><i class="bi bi-calendar-event"></i> Alumni Events</a>
    <a class="btn-primary-sms" href="{{ route('admin.alumni.create') }}"><i class="bi bi-plus-lg"></i> Add Alumni</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Graduation Year</th>
                <th>Contact</th>
                <th>Occupation</th>
                <th>Organization</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($alumni as $person)
                <tr>
                    <td style="font-weight:700;">{{ $person->name }}</td>
                    <td class="mono text-center">{{ $person->graduation_year }}</td>
                    <td>
                        <div style="font-size:.85rem;">
                            @if($person->email) <div><i class="bi bi-envelope"></i> {{ $person->email }}</div> @endif
                            @if($person->phone) <div><i class="bi bi-telephone"></i> {{ $person->phone }}</div> @endif
                        </div>
                    </td>
                    <td>{{ $person->current_occupation ?? '--' }}</td>
                    <td>{{ $person->current_organization ?? '--' }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.alumni.edit', $person) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.alumni.destroy', $person) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline-sms text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No alumni records found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
