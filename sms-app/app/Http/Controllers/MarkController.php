<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Employee;
use App\Models\TimetableEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MarkController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        $examsQuery = Exam::query()->latest();
        $subjectsQuery = Subject::query()->orderBy('name');

        // If user is a teacher, restrict to their assigned subjects/classes
        if ($user->role->value === 'teacher') {
            $employee = Employee::where('user_id', $user->id)->first();
            $assignedSubjectIds = TimetableEntry::where('employee_id', $employee?->id)->pluck('subject_id')->unique();
            $assignedClassIds = TimetableEntry::where('employee_id', $employee?->id)->pluck('school_class_id')->unique();

            $examsQuery->whereIn('school_class_id', $assignedClassIds);
            $subjectsQuery->whereIn('id', $assignedSubjectIds);
        }

        $exams = $examsQuery->get();
        $subjects = $subjectsQuery->get();

        $marks = Mark::with(['exam', 'student.user', 'subject'])
            ->when($request->exam_id, fn ($q) => $q->where('exam_id', $request->exam_id))
            ->when($request->subject_id, fn ($q) => $q->where('subject_id', $request->subject_id))
            ->latest()
            ->paginate(15);

        return view('marks.index', compact('marks', 'exams', 'subjects'));
    }

    public function create(Request $request): View
    {
        $examId = $request->input('exam_id');
        $subjectId = $request->input('subject_id');

        $exam = Exam::with('schoolClass')->findOrFail($examId);
        $subject = Subject::findOrFail($subjectId);

        $students = Student::query()
            ->whereHas('currentAcademicRecord', function ($query) use ($exam) {
                $query->where('school_class_id', $exam->school_class_id);
            })
            ->with(['user', 'currentAcademicRecord'])
            ->get();

        $existingMarks = Mark::where('exam_id', $examId)
            ->where('subject_id', $subjectId)
            ->get()
            ->keyBy('student_id');

        return view('marks.create', compact('exam', 'subject', 'students', 'existingMarks'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|array',
            'marks.*.obtained' => 'nullable|numeric|min:0',
            'marks.*.total' => 'required|numeric|min:1',
            'marks.*.is_absent' => 'nullable|boolean',
            'marks.*.remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['marks'] as $studentId => $markData) {
                Mark::updateOrCreate(
                    [
                        'exam_id' => $validated['exam_id'],
                        'student_id' => $studentId,
                        'subject_id' => $validated['subject_id'],
                    ],
                    [
                        'campus_id' => auth()->user()->campus_id,
                        'obtained_marks' => $markData['is_absent'] ?? false ? 0 : ($markData['obtained'] ?? 0),
                        'total_marks' => $markData['total'],
                        'is_absent' => $markData['is_absent'] ?? false,
                        'remarks' => $markData['remarks'],
                        'entered_by' => auth()->id(),
                    ]
                );
            }
        });

        return redirect()->route('admin.marks.index')
            ->with('success', 'Marks saved successfully.');
    }
}
