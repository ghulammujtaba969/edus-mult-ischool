@extends('layouts.app')

@section('title', 'Manage Slots | EduCore SMS')
@section('page_title', 'Timetable Slots')
@section('breadcrumb', '/ Academics / Timetable / Slots')

@section('content')
    <div style="display:grid;grid-template-columns:1fr 2fr;gap:2rem;">
        <!-- Add Slot Form -->
        <div class="data-card">
            <div class="card-title">Add New Slot</div>
            <form action="{{ route('admin.timetable.slots.store') }}" method="POST">
                @csrf
                <div style="margin-bottom:1.5rem;">
                    <label class="form-label-sms">Day</label>
                    <select name="day" class="form-control-sms" required>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom:1.5rem;">
                    <label class="form-label-sms">Period No.</label>
                    <input type="number" name="period_no" class="form-control-sms" placeholder="e.g. 1" required min="1">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                    <div>
                        <label class="form-label-sms">Start Time</label>
                        <input type="time" name="start_time" class="form-control-sms" required>
                    </div>
                    <div>
                        <label class="form-label-sms">End Time</label>
                        <input type="time" name="end_time" class="form-control-sms" required>
                    </div>
                </div>
                <div style="margin-bottom:2rem;">
                    <label style="display:flex;align-items:center;gap:.75rem;cursor:pointer;">
                        <input type="checkbox" name="is_break" value="1" style="width:1.2rem;height:1.2rem;">
                        <span style="font-weight:600;">Is Break Time?</span>
                    </label>
                </div>
                <button type="submit" class="btn-primary-sms w-full"><i class="bi bi-plus-lg"></i> Add Slot</button>
            </form>
        </div>

        <!-- Slots List -->
        <div class="data-card">
            <div class="card-title">Existing Slots</div>
            <table class="sms-table">
                <thead>
                <tr>
                    <th>Day</th>
                    <th>Period</th>
                    <th>Time</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($slots as $slot)
                    <tr>
                        <td style="font-weight:700;">{{ $slot->day }}</td>
                        <td class="mono">{{ $slot->period_no }}</td>
                        <td class="mono">{{ date('H:i', strtotime($slot->start_time)) }} - {{ date('H:i', strtotime($slot->end_time)) }}</td>
                        <td>
                            @if($slot->is_break)
                                <span class="badge-sms badge-danger-sms">Break</span>
                            @else
                                <span class="badge-sms badge-success-sms">Academic</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.timetable.slots.destroy', $slot) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline-sms text-danger" onclick="return confirm('Delete this slot?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No slots defined yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
