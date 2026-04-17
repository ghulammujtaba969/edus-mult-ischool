<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function index(): View
    {
        $exams = Exam::with(['examType', 'schoolClass'])->latest()->paginate(10);
        return view('exams.index', compact('exams'));
    }

    public function create(): View
    {
        $academicYears = AcademicYear::query()->latest()->get();
        $examTypes = ExamType::query()->orderBy('name')->get();
        $classes = SchoolClass::query()->orderBy('order_seq')->get();

        return view('exams.create', compact('academicYears', 'examTypes', 'classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'exam_type_id' => 'required|exists:exam_types,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Exam::create([
            'campus_id' => auth()->user()->campus_id,
            'academic_year_id' => $validated['academic_year_id'],
            'exam_type_id' => $validated['exam_type_id'],
            'school_class_id' => $validated['school_class_id'],
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'draft',
        ]);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam scheduled successfully.');
    }

    public function edit(Exam $exam): View
    {
        $academicYears = AcademicYear::query()->latest()->get();
        $examTypes = ExamType::query()->orderBy('name')->get();
        $classes = SchoolClass::query()->orderBy('order_seq')->get();

        return view('exams.edit', compact('exam', 'academicYears', 'examTypes', 'classes'));
    }

    public function update(Request $request, Exam $exam): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'exam_type_id' => 'required|exists:exam_types,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
        ]);

        $exam->update($validated);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam): RedirectResponse
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam deleted successfully.');
    }
}
