<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentPromotion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PromotionController extends Controller
{
    public function index(Request $request): View
    {
        $classes = SchoolClass::all();
        $sections = Section::all();
        $academicYears = AcademicYear::all();

        $selectedClass = $request->input('class_id');
        $selectedSection = $request->input('section_id');
        $selectedYear = $request->input('academic_year_id');

        $students = [];
        if ($selectedClass && $selectedSection && $selectedYear) {
            $students = Student::with('user')
                ->where('school_class_id', $selectedClass)
                ->where('section_id', $selectedSection)
                ->where('academic_year_id', $selectedYear)
                ->get();
        }

        return view('students.promotions.index', compact('classes', 'sections', 'academicYears', 'students', 'selectedClass', 'selectedSection', 'selectedYear'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'from_year_id' => 'required|exists:academic_years,id',
            'to_year_id' => 'required|exists:academic_years,id|different:from_year_id',
            'from_class_id' => 'required|exists:school_classes,id',
            'to_class_id' => 'required|exists:school_classes,id',
            'from_section_id' => 'required|exists:sections,id',
            'to_section_id' => 'required|exists:sections,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['student_ids'] as $studentId) {
                // 1. Log the promotion
                StudentPromotion::create([
                    'campus_id' => auth()->user()->campus_id,
                    'student_id' => $studentId,
                    'from_year_id' => $validated['from_year_id'],
                    'to_year_id' => $validated['to_year_id'],
                    'from_class_id' => $validated['from_class_id'],
                    'to_class_id' => $validated['to_class_id'],
                    'from_section_id' => $validated['from_section_id'],
                    'to_section_id' => $validated['to_section_id'],
                    'promoted_by' => auth()->id(),
                ]);

                // 2. Update student's current academic status
                $student = Student::find($studentId);
                $student->update([
                    'academic_year_id' => $validated['to_year_id'],
                    'school_class_id' => $validated['to_class_id'],
                    'section_id' => $validated['to_section_id'],
                ]);
            }
        });

        return redirect()->route('admin.promotions.index')
            ->with('success', count($validated['student_ids']) . ' students promoted successfully.');
    }
}
