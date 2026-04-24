@extends('layouts.app')

@section('title', 'Syllabus Progress | EduCore SMS')
@section('page_title', 'Syllabus Status')
@section('breadcrumb', '/ Academics / Syllabus')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.syllabus-progress.create') }}"><i class="bi bi-plus-lg"></i> Update Syllabus</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Class</th>
                <th>Subject</th>
                <th>Topic</th>
                <th>Completion</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($progress as $item)
                <tr>
                    <td>{{ $item->schoolClass->name }}</td>
                    <td style="font-weight:700;">{{ $item->subject->name }}</td>
                    <td>{{ $item->topic }}</td>
                    <td>
                        <div style="width:100px;height:8px;background:var(--gray-bg);border-radius:4px;overflow:hidden;">
                            <div style="width:{{ $item->percentage }}%;height:100%;background:{{ $item->percentage == 100 ? 'var(--success)' : 'var(--primary)' }};"></div>
                        </div>
                        <span style="font-size:.7rem;margin-top:.2rem;display:block;">{{ $item->percentage }}% Completed</span>
                    </td>
                    <td>
                        <span class="status-pill {{ $item->status === 'completed' ? 'pill-active' : ($item->status === 'in_progress' ? 'pill-warning' : 'pill-inactive') }}">
                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn-outline-sms" onclick="document.getElementById('update-modal-{{ $item->id }}').style.display='flex'"><i class="bi bi-pencil-square"></i></button>
                        
                        <!-- Update Modal -->
                        <div id="update-modal-{{ $item->id }}" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;z-index:1000;">
                            <div class="data-card" style="width:100%;max-width:400px;margin:0 1rem;">
                                <div class="card-title">Update Progress</div>
                                <form action="{{ route('admin.syllabus-progress.update', $item) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div style="margin-bottom:1.5rem;">
                                        <label class="form-label-sms">Completion Percentage</label>
                                        <input class="form-control-sms" type="number" name="percentage" value="{{ $item->percentage }}" min="0" max="100" required>
                                    </div>
                                    <div style="margin-bottom:1.5rem;">
                                        <label class="form-label-sms">Status</label>
                                        <select class="filter-select" name="status" required>
                                            <option value="pending" @selected($item->status == 'pending')>Pending</option>
                                            <option value="in_progress" @selected($item->status == 'in_progress')>In Progress</option>
                                            <option value="completed" @selected($item->status == 'completed')>Completed</option>
                                        </select>
                                    </div>
                                    <div style="display:flex;gap:1rem;">
                                        <button class="btn-primary-sms" type="submit" style="flex:1;">Update</button>
                                        <button class="btn-outline-sms" type="button" onclick="document.getElementById('update-modal-{{ $item->id }}').style.display='none'" style="flex:1;justify-content:center;">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No syllabus tracking records.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
