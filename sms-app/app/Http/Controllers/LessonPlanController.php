<?php

namespace App\Http\Controllers;

use App\Models\LessonPlan;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonPlanController extends Controller
{
    public function index(): View
    {
        $plans = LessonPlan::with(['schoolClass', 'subject', 'teacher'])->latest()->get();
        return view('academic.lesson-plans.index', compact('plans'));
    }

    public function create(): View
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        return view('academic.lesson-plans.create', compact('classes', 'subjects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'lesson_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time_from' => 'nullable|string',
            'time_to' => 'nullable|string',
            'lecture_youtube_url' => 'nullable|url',
        ]);

        LessonPlan::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
            'teacher_id' => auth()->id(),
        ]));

        return redirect()->route('admin.lesson-plans.index')
            ->with('success', 'Lesson plan created successfully.');
    }

    public function edit(LessonPlan $lessonPlan): View
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        return view('academic.lesson-plans.edit', compact('lessonPlan', 'classes', 'subjects'));
    }

    public function update(Request $request, LessonPlan $lessonPlan): RedirectResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'lesson_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time_from' => 'nullable|string',
            'time_to' => 'nullable|string',
            'lecture_youtube_url' => 'nullable|url',
        ]);

        $lessonPlan->update($validated);

        return redirect()->route('admin.lesson-plans.index')
            ->with('success', 'Lesson plan updated successfully.');
    }

    public function destroy(LessonPlan $lessonPlan): RedirectResponse
    {
        $lessonPlan->delete();
        return redirect()->route('admin.lesson-plans.index')
            ->with('success', 'Lesson plan deleted successfully.');
    }
}
