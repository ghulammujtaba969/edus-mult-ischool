<?php

namespace App\Http\Controllers;

use App\Models\AlumniEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumniEventController extends Controller
{
    public function index(): View
    {
        $events = AlumniEvent::latest()->get();
        return view('alumni.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('alumni.events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
        ]);

        AlumniEvent::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
        ]));

        return redirect()->route('admin.alumni-events.index')
            ->with('success', 'Alumni event created successfully.');
    }

    public function edit(AlumniEvent $alumniEvent): View
    {
        return view('alumni.events.edit', compact('alumniEvent'));
    }

    public function update(Request $request, AlumniEvent $alumniEvent): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
        ]);

        $alumniEvent->update($validated);

        return redirect()->route('admin.alumni-events.index')
            ->with('success', 'Alumni event updated successfully.');
    }

    public function destroy(AlumniEvent $alumniEvent): RedirectResponse
    {
        $alumniEvent->delete();
        return redirect()->route('admin.alumni-events.index')
            ->with('success', 'Alumni event deleted successfully.');
    }
}
