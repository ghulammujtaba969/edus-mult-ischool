<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumniController extends Controller
{
    public function index(): View
    {
        $alumni = Alumni::latest()->get();
        return view('alumni.index', compact('alumni'));
    }

    public function create(): View
    {
        $students = Student::where('status', 'graduated')->get();
        return view('alumni.create', compact('students'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'current_occupation' => 'nullable|string|max:255',
            'current_organization' => 'nullable|string|max:255',
            'student_id' => 'nullable|exists:students,id',
        ]);

        Alumni::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
        ]));

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Alumni record created successfully.');
    }

    public function edit(Alumni $alumni): View
    {
        return view('alumni.edit', compact('alumni'));
    }

    public function update(Request $request, Alumni $alumni): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'current_occupation' => 'nullable|string|max:255',
            'current_organization' => 'nullable|string|max:255',
        ]);

        $alumni->update($validated);

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Alumni record updated successfully.');
    }

    public function destroy(Alumni $alumni): RedirectResponse
    {
        $alumni->delete();
        return redirect()->route('admin.alumni.index')
            ->with('success', 'Alumni record deleted successfully.');
    }
}
