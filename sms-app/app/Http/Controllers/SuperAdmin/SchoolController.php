<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Plan;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function index(): View
    {
        $schools = School::with(['plan', 'primaryDomain'])->latest()->paginate(10);
        return view('super-admin.schools.index', compact('schools'));
    }

    public function create(): View
    {
        $plans = Plan::where('is_active', true)->get();
        return view('super-admin.schools.create', compact('plans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:schools,slug',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:pending,active,suspended',
        ]);

        $school = School::create($validated);

        // Create default subdomain
        Domain::create([
            'school_id' => $school->id,
            'domain' => $validated['slug'] . '.' . config('app.url_base', 'localhost'),
            'type' => 'subdomain',
            'is_verified' => true,
        ]);

        return redirect()->route('super-admin.schools.index')
            ->with('success', 'School created successfully.');
    }

    public function edit(School $school): View
    {
        $plans = Plan::where('is_active', true)->get();
        return view('super-admin.schools.edit', compact('school', 'plans'));
    }

    public function update(Request $request, School $school): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:pending,active,suspended',
        ]);

        $school->update($validated);

        return redirect()->route('super-admin.schools.index')
            ->with('success', 'School updated successfully.');
    }
}
