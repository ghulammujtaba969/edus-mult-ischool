<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CampusController extends Controller
{
    public function index(): View
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }
        $campuses = Campus::all();
        return view('campuses.index', compact('campuses'));
    }

    public function create(): View
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }
        return view('campuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:campuses,code',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        Campus::create($validated);

        return redirect()->route('admin.campuses.index')
            ->with('success', 'Campus created successfully.');
    }

    public function edit(Campus $campus): View
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }
        return view('campuses.edit', compact('campus'));
    }

    public function update(Request $request, Campus $campus): RedirectResponse
    {
        if ($request->has('campus_id')) {
            // This is for campus switching
            $validated = $request->validate([
                'campus_id' => ['required', 'integer', 'exists:campuses,id'],
            ]);

            if (! $request->user()->isSuperAdmin()) {
                abort(403);
            }

            $request->session()->put('active_campus_id', $validated['campus_id']);

            return back();
        }

        // This is for standard CRUD update
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:campuses,code,' . $campus->id,
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $campus->update($validated);

        return redirect()->route('admin.campuses.index')
            ->with('success', 'Campus updated successfully.');
    }

    public function destroy(Campus $campus): RedirectResponse
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }
        $campus->delete();
        return redirect()->route('admin.campuses.index')
            ->with('success', 'Campus deleted successfully.');
    }
}
