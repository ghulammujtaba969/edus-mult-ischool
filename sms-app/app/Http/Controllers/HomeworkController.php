<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeworkController extends Controller
{
    public function index(): View
    {
        $homeworks = Homework::with(['schoolClass', 'section', 'subject'])->latest()->get();
        return view('homework.index', compact('homeworks'));
    }

    public function create(): View
    {
        $classes = SchoolClass::all();
        $sections = Section::all();
        $subjects = Subject::all();
        return view('homework.create', compact('classes', 'sections', 'subjects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'homework_date' => 'required|date',
            'submission_date' => 'required|date|after_or_equal:homework_date',
            'description' => 'required|string',
        ]);

        Homework::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
            'created_by' => auth()->id()
        ]));

        return redirect()->route('admin.homework.index')
            ->with('success', 'Homework assigned successfully.');
    }

    public function show(Homework $homework): View
    {
        $homework->load(['schoolClass', 'section', 'subject', 'submissions.student.user']);
        return view('homework.show', compact('homework'));
    }
}
