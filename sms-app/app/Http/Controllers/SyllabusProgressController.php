<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\SyllabusProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SyllabusProgressController extends Controller
{
    public function index(): View
    {
        $progress = SyllabusProgress::with(['schoolClass', 'subject'])->latest()->get();
        return view('syllabus.index', compact('progress'));
    }

    public function create(): View
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        return view('syllabus.create', compact('classes', 'subjects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic' => 'required|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
            'status' => 'required|string|in:pending,in_progress,completed',
        ]);

        SyllabusProgress::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id
        ]));

        return redirect()->route('admin.syllabus-progress.index')
            ->with('success', 'Syllabus progress updated.');
    }

    public function update(Request $request, SyllabusProgress $syllabusProgress): RedirectResponse
    {
        $validated = $request->validate([
            'percentage' => 'required|integer|min:0|max:100',
            'status' => 'required|string|in:pending,in_progress,completed',
        ]);

        $syllabusProgress->update($validated);

        return redirect()->route('admin.syllabus-progress.index')
            ->with('success', 'Progress updated.');
    }
}
