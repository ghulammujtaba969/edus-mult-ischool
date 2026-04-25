<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Services\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CampusController extends Controller
{
    public function index(): View
    {
        $campuses = Campus::all();
        return view('campuses.index', compact('campuses'));
    }

    public function create(): View
    {
        $school = app(TenantManager::class)->getSchool() ?? auth()->user()->school;
        
        if (!$school) {
            return redirect()->route('admin.dashboard')->with('error', 'Could not identify your school context.');
        }

        $maxBranches = $school->plan->max_branches;
        
        if (Campus::count() >= $maxBranches) {
            return redirect()->route('admin.campuses.index')
                ->with('error', "Your current plan allows a maximum of {$maxBranches} branches. Please upgrade to add more.");
        }

        return view('campuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $school = app(TenantManager::class)->getSchool() ?? auth()->user()->school;

        if (!$school) {
            return redirect()->route('admin.campuses.index')->with('error', 'Could not identify your school context.');
        }

        if (Campus::count() >= $school->plan->max_branches) {
            return redirect()->route('admin.campuses.index')->with('error', 'Branch limit reached.');
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
            ->with('success', 'Branch created successfully.');
    }

    public function edit(Campus $campus): View
    {
        return view('campuses.edit', compact('campus'));
    }

    public function update(Request $request, Campus $campus): RedirectResponse
    {
        if ($request->has('campus_id')) {
            // This is for campus switching
            $validated = $request->validate([
                'campus_id' => ['required', 'integer', 'exists:campuses,id'],
            ]);

            // Allow switching if user is campus_admin or super_admin
            if (! in_array(auth()->user()->role->value, ['super_admin', 'campus_admin', 'principal'])) {
                abort(403);
            }

            $request->session()->put('active_campus_id', $validated['campus_id']);

            return back();
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
            ->with('success', 'Branch updated successfully.');
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
