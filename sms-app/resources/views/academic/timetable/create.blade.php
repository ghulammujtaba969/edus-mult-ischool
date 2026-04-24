@extends('layouts.app')

@section('title', 'Add Timetable Entry | EduCore SMS')
@section('page_title', 'New Timetable Entry')
@section('breadcrumb', '/ Academics / Timetable / Create')

@section('content')
    <div class="data-card" style="max-width:800px;margin:0 auto;">
        <div class="card-title">Schedule Information</div>

        @if($errors->has('clash'))
            <div style="background:#fee2e2;border:1px solid #ef4444;color:#b91c1c;padding:1rem;border-radius:8px;margin-bottom:1.5rem;display:flex;align-items:center;gap:.75rem;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size:1.2rem;"></i>
                <div>{{ $errors->first('clash') }}</div>
            </div>
        @endif

        <form action="{{ route('admin.timetable.store') }}" method="POST">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms">Class</label>
                    <select name="school_class_id" class="form-control-sms @error('school_class_id') is-invalid @enderror" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" @selected(old('school_class_id') == $class->id)>{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('school_class_id') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Section</label>
                    <select name="section_id" class="form-control-sms @error('section_id') is-invalid @enderror" required>
                        <option value="">Select Section</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" @selected(old('section_id') == $section->id)>{{ $section->name }}</option>
                        @endforeach
                    </select>
                    @error('section_id') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms">Time Slot</label>
                <select name="timetable_slot_id" class="form-control-sms @error('timetable_slot_id') is-invalid @enderror" required>
                    <option value="">Select Slot (Day - Period - Time)</option>
                    @foreach($slots as $slot)
                        <option value="{{ $slot->id }}" @selected(old('timetable_slot_id') == $slot->id)>
                            {{ $slot->day }} | Period {{ $slot->period_no }} ({{ date('H:i', strtotime($slot->start_time)) }} - {{ date('H:i', strtotime($slot->end_time)) }})
                            @if($slot->is_break) [BREAK] @endif
                        </option>
                    @endforeach
                </select>
                @error('timetable_slot_id') <div class="text-danger-sms">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms">Subject</label>
                    <select name="subject_id" class="form-control-sms @error('subject_id') is-invalid @enderror" required>
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms">Teacher</label>
                    <select name="employee_id" class="form-control-sms @error('employee_id') is-invalid @enderror" required>
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @selected(old('employee_id') == $teacher->id)>{{ $teacher->user->name }}</option>
                        @endforeach
                    </select>
                    @error('employee_id') <div class="text-danger-sms">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms">Room No. (Optional)</label>
                <input type="text" name="room_no" class="form-control-sms" value="{{ old('room_no') }}" placeholder="e.g. Room 101">
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary-sms"><i class="bi bi-save"></i> Save Entry</button>
                <a href="{{ route('admin.timetable.index') }}" class="btn-outline-sms">Cancel</a>
            </div>
        </form>
    </div>
@endsection
