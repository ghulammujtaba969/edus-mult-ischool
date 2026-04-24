<?php

namespace App\Http\Controllers;

use App\Models\GradeScale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GradeScaleController extends Controller
{
    public function index(): View
    {
        $grades = GradeScale::orderBy('min_percent', 'desc')->get();
        return view('academic.grades.index', compact('grades'));
    }

    public function create(): View
    {
        return view('academic.grades.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_percent' => 'required|numeric|min:0|max:100',
            'max_percent' => 'required|numeric|min:0|max:100|gt:min_percent',
            'grade' => 'required|string|max:10',
            'gpa_value' => 'required|numeric|min:0|max:10',
            'remarks' => 'nullable|string',
        ]);

        GradeScale::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
        ]));

        return redirect()->route('admin.grade-scales.index')
            ->with('success', 'Grade scale created successfully.');
    }

    public function edit(GradeScale $gradeScale): View
    {
        return view('academic.grades.edit', compact('gradeScale'));
    }

    public function update(Request $request, GradeScale $gradeScale): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_percent' => 'required|numeric|min:0|max:100',
            'max_percent' => 'required|numeric|min:0|max:100|gt:min_percent',
            'grade' => 'required|string|max:10',
            'gpa_value' => 'required|numeric|min:0|max:10',
            'remarks' => 'nullable|string',
        ]);

        $gradeScale->update($validated);

        return redirect()->route('admin.grade-scales.index')
            ->with('success', 'Grade scale updated successfully.');
    }

    public function destroy(GradeScale $gradeScale): RedirectResponse
    {
        $gradeScale->delete();
        return redirect()->route('admin.grade-scales.index')
            ->with('success', 'Grade scale deleted successfully.');
    }
}
