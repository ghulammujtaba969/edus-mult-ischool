@extends('layouts.app')

@section('title', 'Fee Structures | EduCore SMS')
@section('page_title', 'Fee Structures')
@section('breadcrumb', '/ Fees / Structures')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.fee-structures.create') }}"><i class="bi bi-plus-lg"></i> Set Class Fees</a>
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
                <th>Academic Year</th>
                <th>Class</th>
                <th>Fee Type</th>
                <th>Amount</th>
                <th>Due Day</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($structures as $structure)
                <tr>
                    <td class="mono">{{ $structure->academicYear->name }}</td>
                    <td style="font-weight:700;">{{ $structure->schoolClass->name }}</td>
                    <td><span class="status-pill pill-active">{{ $structure->feeType->name }}</span></td>
                    <td class="mono">Rs. {{ number_format($structure->amount, 2) }}</td>
                    <td class="mono">Day {{ $structure->due_day }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.fee-structures.edit', $structure) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.fee-structures.destroy', $structure) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No fee structures defined.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
