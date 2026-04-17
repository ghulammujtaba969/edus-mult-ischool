<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(): View
    {
        $sections = Section::query()
            ->with('schoolClass')
            ->orderBy('school_class_id')
            ->orderBy('name')
            ->get();

        return view('sections.index', compact('sections'));
    }

    public function create(): View
    {
        $classes = SchoolClass::query()->orderBy('order_seq')->get();

        return view('sections.create', compact('classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
        ]);

        Section::create($validated);

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section created successfully.');
    }

    public function edit(Section $section): View
    {
        $classes = SchoolClass::query()->orderBy('order_seq')->get();

        return view('sections.edit', compact('section', 'classes'));
    }

    public function update(Request $request, Section $section): RedirectResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
        ]);

        $section->update($validated);

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section): RedirectResponse
    {
        // Add check for students if needed
        $section->delete();

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section deleted successfully.');
    }
}
