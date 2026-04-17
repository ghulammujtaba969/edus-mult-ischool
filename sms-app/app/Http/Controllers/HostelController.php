<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\HostelRoom;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HostelController extends Controller
{
    public function index(): View
    {
        $hostels = Hostel::withCount('rooms')->latest()->get();
        return view('hostels.index', compact('hostels'));
    }

    public function create(): View
    {
        return view('hostels.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:boys,girls,staff',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:1',
        ]);

        Hostel::create($validated);

        return redirect()->route('admin.hostels.index')
            ->with('success', 'Hostel created successfully.');
    }

    public function show(Hostel $hostel): View
    {
        $hostel->load('rooms.allocations.student.user');
        return view('hostels.show', compact('hostel'));
    }

    public function edit(Hostel $hostel): View
    {
        return view('hostels.edit', compact('hostel'));
    }

    public function update(Request $request, Hostel $hostel): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:boys,girls,staff',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:1',
        ]);

        $hostel->update($validated);

        return redirect()->route('admin.hostels.index')
            ->with('success', 'Hostel updated successfully.');
    }

    public function destroy(Hostel $hostel): RedirectResponse
    {
        if ($hostel->rooms()->exists()) {
            return back()->with('error', 'Cannot delete hostel with rooms. Please delete rooms first.');
        }

        $hostel->delete();

        return redirect()->route('admin.hostels.index')
            ->with('success', 'Hostel deleted successfully.');
    }

    // Room Management within HostelController for simplicity
    public function addRoom(Request $request, Hostel $hostel): RedirectResponse
    {
        $validated = $request->validate([
            'room_no' => 'required|string|max:20',
            'room_type' => 'required|string|in:ac,non-ac',
            'no_of_beds' => 'required|integer|min:1',
            'cost_per_bed' => 'required|numeric|min:0',
        ]);

        $hostel->rooms()->create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id
        ]));

        return back()->with('success', 'Room added successfully.');
    }
}
