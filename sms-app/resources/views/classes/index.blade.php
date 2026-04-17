@extends('layouts.app')

@section('title', 'Classes | EduCore SMS')
@section('page_title', 'Classes')
@section('breadcrumb', '/ Academic Setup / Classes')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.classes.create') }}"><i class="bi bi-plus-lg"></i> Add Class</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-box">
            {{ session('error') }}
        </div>
    @endif

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong>{{ $classes->count() }}</strong> classes</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Order</th>
                <th>Name</th>
                <th>Level</th>
                <th>Sections</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($classes as $class)
                <tr>
                    <td class="mono">{{ $class->order_seq }}</td>
                    <td style="font-weight:700;">{{ $class->name }}</td>
                    <td>{{ $class->level }}</td>
                    <td><span class="status-pill pill-active">{{ $class->sections_count }} Sections</span></td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.classes.edit', $class) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No classes found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
