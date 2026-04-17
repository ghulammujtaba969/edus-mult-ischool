@extends('layouts.app')

@section('title', 'New Allocation | EduCore SMS')
@section('page_title', 'Room Allocation')
@section('breadcrumb', '/ Hostel / Allocations / New')

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.hostel-allocations.store') }}" method="POST">
            @csrf
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="student_id">Select Student</label>
                    <select class="filter-select" id="student_id" name="student_id" required>
                        <option value="">Choose Student...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->user->name }} ({{ $student->registration_no }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="hostel_room_id">Select Room</label>
                    <select class="filter-select" id="hostel_room_id" name="hostel_room_id" required>
                        <option value="">Choose Available Room...</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" @selected($selectedRoomId == $room->id)>
                                {{ $room->hostel->name }} - Room {{ $room->room_no }} ({{ $room->available_beds }} beds left)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="bed_no">Bed Number (Optional)</label>
                    <input class="form-control-sms" type="number" id="bed_no" name="bed_no" placeholder="e.g. 1">
                </div>
                <div>
                    <label class="form-label-sms" for="allocated_at">Allocation Date</label>
                    <input class="form-control-sms" type="date" id="allocated_at" name="allocated_at" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="remarks">Remarks</label>
                <textarea class="form-control-sms" id="remarks" name="remarks" rows="2"></textarea>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-check-circle"></i> Complete Allocation</button>
                <a class="btn-outline-sms" href="{{ route('admin.hostel-allocations.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
