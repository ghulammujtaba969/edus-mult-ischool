<?php

namespace App\Http\Controllers;

use App\Enums\AttendanceStatus;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\Employee;
use App\Models\TimetableEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $query = SchoolClass::query()->with('sections')->orderBy('order_seq');

        // If the user is a teacher, only show their assigned classes/sections
        if ($user->role->value === 'teacher') {
            $employee = Employee::where('user_id', $user->id)->first();
            $assignedSectionIds = TimetableEntry::where('employee_id', $employee?->id)->pluck('section_id')->unique();

            $query->whereHas('sections', function($q) use ($assignedSectionIds) {
                $q->whereIn('id', $assignedSectionIds);
            });
        }

        $classes = $query->get();

        return view('attendance.index', compact('classes'));
    }

    public function create(Request $request): View
    {
        $sectionId = $request->input('section_id');
        $date = $request->input('date', date('Y-m-d'));

        $section = Section::with('schoolClass')->findOrFail($sectionId);

        $students = Student::query()
            ->whereHas('currentAcademicRecord', function ($query) use ($sectionId) {
                $query->where('section_id', $sectionId);
            })
            ->with(['user', 'currentAcademicRecord'])
            ->get();

        $existingAttendance = StudentAttendance::where('section_id', $sectionId)
            ->whereDate('attendance_date', $date)
            ->get()
            ->keyBy('student_id');

        return view('attendance.create', compact('section', 'date', 'students', 'existingAttendance'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|string',
        ]);

        $sectionId = $validated['section_id'];
        $date = \Carbon\Carbon::parse($validated['attendance_date'])->startOfDay();

        DB::transaction(function () use ($sectionId, $date, $validated) {
            foreach ($validated['attendance'] as $studentId => $status) {
                $attendance = StudentAttendance::where('student_id', $studentId)
                    ->where('attendance_date', $date)
                    ->first();

                if ($attendance) {
                    $attendance->update([
                        'status' => $status,
                        'marked_by' => auth()->id(),
                    ]);
                } else {
                    StudentAttendance::create([
                        'student_id' => $studentId,
                        'attendance_date' => $date,
                        'campus_id' => auth()->user()->campus_id,
                        'section_id' => $sectionId,
                        'status' => $status,
                        'method' => 'manual',
                        'marked_by' => auth()->id(),
                    ]);
                }
            }
        });

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance marked successfully.');
    }
}
