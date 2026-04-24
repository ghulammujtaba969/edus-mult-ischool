@extends('layouts.app')

@section('title', 'Grading Scales | EduCore SMS')
@section('page_title', 'Grading Scales')
@section('breadcrumb', '/ Examinations / Grading Scales')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.grade-scales.create') }}"><i class="bi bi-plus-lg"></i> Add Grade Scale</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Grade Name</th>
                <th>Min %</th>
                <th>Max %</th>
                <th>Grade Point</th>
                <th>GPA Value</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($grades as $grade)
                <tr>
                    <td style="font-weight:700;">{{ $grade->name }}</td>
                    <td class="mono">{{ $grade->min_percent }}%</td>
                    <td class="mono">{{ $grade->max_percent }}%</td>
                    <td class="mono" style="font-weight:700;color:var(--primary);">{{ $grade->grade }}</td>
                    <td class="mono">{{ number_format($grade->gpa_value, 2) }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.grade-scales.edit', $grade) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.grade-scales.destroy', $grade) }}" method="POST" onsubmit="return confirm('Delete this grading scale?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline-sms text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No grading scales defined.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
