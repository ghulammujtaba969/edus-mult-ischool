@extends('layouts.app')

@section('title', 'Fee Types | EduCore SMS')
@section('page_title', 'Fee Types')
@section('breadcrumb', '/ Fees / Fee Types')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.fee-types.create') }}"><i class="bi bi-plus-lg"></i> Add Fee Type</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Frequency</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($feeTypes as $type)
                <tr>
                    <td style="font-weight:700;">{{ $type->name }}</td>
                    <td>
                        @if($type->is_recurring)
                            <span class="status-pill pill-active">Recurring</span>
                        @else
                            <span class="status-pill pill-partial">One-time</span>
                        @endif
                    </td>
                    <td class="mono">{{ ucfirst($type->frequency) }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.fee-types.edit', $type) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.fee-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:2rem;color:var(--text-light);">No fee types found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
