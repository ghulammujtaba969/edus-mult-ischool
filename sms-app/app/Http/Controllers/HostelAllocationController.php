<?php

namespace App\Http\Controllers;

use App\Models\HostelAllocation;
use App\Models\HostelRoom;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HostelAllocationController extends Controller
{
    public function index(): View
    {
        $allocations = HostelAllocation::with(['room.hostel', 'student.user'])->latest()->get();
        return view('hostel-allocations.index', compact('allocations'));
    }

    public function create(Request $request): View
    {
        $students = Student::with('user')->get();
        $rooms = HostelRoom::with('hostel')->get()->filter(function ($room) {
            return $room->available_beds > 0;
        });
        $selectedRoomId = $request->input('room_id');

        return view('hostel-allocations.create', compact('students', 'rooms', 'selectedRoomId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hostel_room_id' => 'required|exists:hostel_rooms,id',
            'student_id' => 'required|exists:students,id',
            'bed_no' => 'nullable|integer|min:1',
            'allocated_at' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $room = HostelRoom::findOrFail($validated['hostel_room_id']);
        if ($room->available_beds <= 0) {
            return back()->with('error', 'No beds available in this room.');
        }

        // Check if student already has an active allocation
        $activeAllocation = HostelAllocation::where('student_id', $validated['student_id'])
            ->where('status', 'active')
            ->exists();
        if ($activeAllocation) {
            return back()->with('error', 'Student is already allocated to a room.');
        }

        HostelAllocation::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
            'status' => 'active'
        ]));

        return redirect()->route('admin.hostel-allocations.index')
            ->with('success', 'Room allocated successfully.');
    }

    public function show(HostelAllocation $hostelAllocation): View
    {
        $hostelAllocation->load(['room.hostel', 'student.user']);
        return view('hostel-allocations.show', compact('hostelAllocation'));
    }

    public function update(Request $request, HostelAllocation $hostelAllocation): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:active,vacated',
            'vacated_at' => 'required_if:status,vacated|nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $hostelAllocation->update($validated);

        return redirect()->route('admin.hostel-allocations.index')
            ->with('success', 'Allocation updated successfully.');
    }

    public function destroy(HostelAllocation $hostelAllocation): RedirectResponse
    {
        $hostelAllocation->delete();
        return redirect()->route('admin.hostel-allocations.index')
            ->with('success', 'Allocation record deleted.');
    }
}
