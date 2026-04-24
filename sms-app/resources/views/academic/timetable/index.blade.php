@extends('layouts.app')

@section('title', 'Timetable | EduCore SMS')
@section('page_title', 'Class Timetable')
@section('breadcrumb', '/ Academics / Timetable')

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.timetable.slots') }}"><i class="bi bi-clock-history"></i> Manage Slots</a>
    <a class="btn-primary-sms" href="{{ route('admin.timetable.create') }}"><i class="bi bi-plus-lg"></i> Add Entry</a>
@endsection

@section('content')
    <div class="data-card" style="margin-bottom:2rem;">
        <form action="{{ route('admin.timetable.index') }}" method="GET" style="display:grid;grid-template-columns:1fr 1fr auto;gap:1.5rem;align-items:end;">
            <div>
                <label class="form-label-sms">Select Class</label>
                <select name="class_id" class="form-control-sms" required>
                    <option value="">-- Select Class --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected($selectedClass == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label-sms">Select Section</label>
                <select name="section_id" class="form-control-sms" required>
                    <option value="">-- Select Section --</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" @selected($selectedSection == $section->id)>{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary-sms"><i class="bi bi-search"></i> View Timetable</button>
        </form>
    </div>

    @if($selectedClass && $selectedSection)
        <div class="data-card">
            <div class="card-title">Weekly Schedule</div>
            <div style="overflow-x:auto;">
                <table class="sms-table timetable-table">
                    <thead>
                    <tr>
                        <th>Time / Day</th>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <th>{{ $day }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $slots = \App\Models\TimetableSlot::orderBy('start_time')->get()->groupBy('start_time');
                    @endphp
                    @foreach($slots as $startTime => $daySlots)
                        @php $firstSlot = $daySlots->first(); @endphp
                        <tr>
                            <td class="mono" style="background:var(--bg-light);font-weight:700;white-space:nowrap;">
                                {{ date('H:i', strtotime($startTime)) }} - {{ date('H:i', strtotime($firstSlot->end_time)) }}
                                @if($firstSlot->is_break) <br><span style="color:var(--danger);font-size:.7rem;">BREAK</span> @endif
                            </td>
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                <td style="min-width:150px;vertical-align:top;">
                                    @php
                                        $entry = $timetable->get($day)?->where('slot.start_time', $startTime)->first();
                                    @endphp
                                    @if($entry)
                                        <div class="timetable-entry-box">
                                            <div style="font-weight:800;color:var(--primary);">{{ $entry->subject->name }}</div>
                                            <div style="font-size:.75rem;margin-top:.25rem;"><i class="bi bi-person"></i> {{ $entry->teacher->user->name }}</div>
                                            @if($entry->room_no)
                                                <div style="font-size:.7rem;color:var(--charcoal-muted);"><i class="bi bi-geo-alt"></i> Room: {{ $entry->room_no }}</div>
                                            @endif
                                            <form action="{{ route('admin.timetable.destroy', $entry) }}" method="POST" style="margin-top:.5rem;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger" style="background:none;border:none;padding:0;font-size:.7rem;cursor:pointer;" onclick="return confirm('Remove this entry?')">
                                                    <i class="bi bi-x-circle"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($firstSlot->is_break)
                                        <div style="text-align:center;color:var(--text-light);font-style:italic;font-size:.8rem;padding:1rem;">Break Time</div>
                                    @else
                                        <div style="text-align:center;color:var(--text-light);font-size:.7rem;padding:1rem;">--</div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <style>
        .timetable-table td { padding: .5rem !important; }
        .timetable-entry-box {
            background: #f0f4ff;
            border-left: 3px solid var(--primary);
            padding: .75rem;
            border-radius: 4px;
        }
    </style>
@endsection
