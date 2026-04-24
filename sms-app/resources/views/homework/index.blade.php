@extends('layouts.app')

@section('title', 'Homework | EduCore SMS')
@section('page_title', 'Homework List')
@section('breadcrumb', '/ Academics / Homework')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.homework.create') }}"><i class="bi bi-plus-lg"></i> Add Homework</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Subject</th>
                <th>Class - Section</th>
                <th>Date</th>
                <th>Submission</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($homeworks as $hw)
                <tr>
                    <td style="font-weight:700;">{{ $hw->subject->name }}</td>
                    <td>{{ $hw->schoolClass->name }} - {{ $hw->section->name }}</td>
                    <td class="mono">{{ $hw->homework_date->format('M d, Y') }}</td>
                    <td class="mono" style="color:var(--danger);">{{ $hw->submission_date->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.homework.show', $hw) }}"><i class="bi bi-eye"></i></a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No homework assigned.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
