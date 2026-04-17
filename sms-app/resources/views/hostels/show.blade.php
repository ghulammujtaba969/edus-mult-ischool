@extends('layouts.app')

@section('title', $hostel->name . ' | EduCore SMS')
@section('page_title', 'Hostel Details')
@section('breadcrumb', '/ Hostel / Hostels / ' . $hostel->name)

@section('topbar_actions')
    <div style="display:flex;gap:.5rem;">
        <a class="btn-outline-sms" href="{{ route('admin.hostels.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
        <button class="btn-primary-sms" onclick="document.getElementById('add-room-modal').style.display='flex'"><i class="bi bi-plus-lg"></i> Add Room</button>
    </div>
@endsection

@section('content')
    <div class="profile-grid">
        <div class="profile-card">
            <div class="card-title">Hostel Information</div>
            <div class="info-grid-2">
                <div>
                    <div class="muted">Name</div>
                    <div style="font-weight:700;font-size:1.1rem;">{{ $hostel->name }}</div>
                </div>
                <div>
                    <div class="muted">Type</div>
                    <div><span class="status-pill pill-active">{{ ucfirst($hostel->type) }}</span></div>
                </div>
                <div>
                    <div class="muted">City</div>
                    <div style="font-weight:700;">{{ $hostel->city }}</div>
                </div>
                <div>
                    <div class="muted">Capacity</div>
                    <div style="font-weight:700;">{{ $hostel->capacity }} Persons</div>
                </div>
            </div>
            <div style="margin-top:1.5rem;">
                <div class="muted">Address</div>
                <div style="font-weight:600;">{{ $hostel->address }}</div>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-title">Rooms & Occupancy</div>
            <table class="sms-table">
                <thead>
                <tr>
                    <th>Room #</th>
                    <th>Type</th>
                    <th>Beds</th>
                    <th>Available</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($hostel->rooms as $room)
                    <tr>
                        <td class="mono" style="font-weight:700;">{{ $room->room_no }}</td>
                        <td>{{ ucfirst($room->room_type) }}</td>
                        <td class="mono">{{ $room->no_of_beds }}</td>
                        <td class="mono">
                            <span style="color:{{ $room->available_beds > 0 ? 'var(--success)' : 'var(--danger)' }};">
                                {{ $room->available_beds }}
                            </span>
                        </td>
                        <td>
                            @if($room->available_beds > 0)
                                <a href="{{ route('admin.hostel-allocations.create', ['room_id' => $room->id]) }}" class="btn-outline-sms" style="font-size:.75rem;padding:.25rem .5rem;">Allocate</a>
                            @else
                                <span class="muted" style="font-size:.75rem;">Full</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:1rem;color:var(--text-light);">No rooms added.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div id="add-room-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;z-index:1000;">
        <div class="data-card" style="width:100%;max-width:500px;margin:0 1rem;">
            <div class="card-title">Add New Room</div>
            <form action="{{ route('admin.hostels.rooms.add', $hostel) }}" method="POST">
                @csrf
                <div class="info-grid-2" style="margin-bottom:1.25rem;">
                    <div>
                        <label class="form-label-sms">Room Number</label>
                        <input class="form-control-sms" type="text" name="room_no" required>
                    </div>
                    <div>
                        <label class="form-label-sms">Room Type</label>
                        <select class="filter-select" name="room_type" required>
                            <option value="non-ac">Non-AC</option>
                            <option value="ac">AC</option>
                        </select>
                    </div>
                </div>
                <div class="info-grid-2" style="margin-bottom:1.5rem;">
                    <div>
                        <label class="form-label-sms">Number of Beds</label>
                        <input class="form-control-sms" type="number" name="no_of_beds" value="1" min="1" required>
                    </div>
                    <div>
                        <label class="form-label-sms">Cost per Bed</label>
                        <input class="form-control-sms" type="number" step="0.01" name="cost_per_bed" value="0" required>
                    </div>
                </div>
                <div style="display:flex;gap:1rem;">
                    <button class="btn-primary-sms" type="submit" style="flex:1;">Save Room</button>
                    <button class="btn-outline-sms" type="button" onclick="document.getElementById('add-room-modal').style.display='none'" style="flex:1;justify-content:center;">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
