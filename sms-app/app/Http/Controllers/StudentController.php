<?php

namespace App\Http\Controllers;

use App\Enums\StudentStatus;
use App\Enums\UserRole;
use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentAcademicRecord;
use App\Models\StudentParent;
use App\Models\User;
use App\Services\Contracts\ResultServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function __construct(private readonly ResultServiceInterface $resultService)
    {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'class', 'status', 'gender']);

        $students = Student::query()
            ->with(['guardian', 'currentAcademicRecord.schoolClass', 'currentAcademicRecord.section', 'feeInvoices' => fn ($query) => $query->latest('billing_month')])
            ->when($filters['q'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $inner) use ($search): void {
                    $inner->where('registration_no', 'like', "%{$search}%")
                        ->orWhere('b_form_no', 'like', "%{$search}%")
                        ->orWhereHas('guardian', fn (Builder $guardian) => $guardian->where('father_name', 'like', "%{$search}%"))
                        ->orWhereHas('user', fn (Builder $user) => $user->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($filters['class'] ?? null, fn (Builder $query, string $classId) => $query->whereHas('currentAcademicRecord', fn (Builder $record) => $record->where('school_class_id', $classId)))
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['gender'] ?? null, fn (Builder $query, string $gender) => $query->where('gender', $gender))
            ->paginate(10)
            ->withQueryString();

        return view('students.index', [
            'students' => $students,
            'classes' => SchoolClass::query()->orderBy('order_seq')->get(),
            'filters' => $filters,
            'statusCounts' => [
                'active' => Student::query()->where('status', 'active')->count(),
                'enrolled' => Student::query()->where('status', 'enrolled')->count(),
                'left' => Student::query()->whereIn('status', ['left', 'transferred'])->count(),
                'defaulters' => Student::query()->whereHas('feeInvoices', fn (Builder $query) => $query->where('status', '!=', 'paid'))->count(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('students.create', [
            'classes' => SchoolClass::query()->orderBy('order_seq')->get(),
            'sections' => Section::query()->get(),
            'academicYears' => AcademicYear::query()->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_no' => 'required|string|unique:students,registration_no',
            'b_form_no' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'enrollment_date' => 'required|date',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'father_name' => 'required|string|max:255',
            'father_phone' => 'required|string|max:20',
            'emergency_contact' => 'required|string|max:20',
            'academic_year_id' => 'required|exists:academic_years,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'roll_no' => 'required|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'] ?? $validated['registration_no'] . '@school.edu.pk',
                'password' => Hash::make('password'),
                'role' => UserRole::STUDENT,
                'campus_id' => auth()->user()->campus_id,
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'campus_id' => auth()->user()->campus_id,
                'registration_no' => $validated['registration_no'],
                'b_form_no' => $validated['b_form_no'],
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'enrollment_date' => $validated['enrollment_date'],
                'email' => $validated['email'] ?? null,
                'address' => $validated['address'] ?? null,
                'status' => StudentStatus::ACTIVE,
            ]);

            StudentParent::create([
                'student_id' => $student->id,
                'campus_id' => auth()->user()->campus_id,
                'father_name' => $validated['father_name'],
                'father_phone' => $validated['father_phone'],
                'emergency_contact' => $validated['emergency_contact'],
            ]);

            StudentAcademicRecord::create([
                'student_id' => $student->id,
                'campus_id' => auth()->user()->campus_id,
                'academic_year_id' => $validated['academic_year_id'],
                'school_class_id' => $validated['school_class_id'],
                'section_id' => $validated['section_id'],
                'roll_no' => $validated['roll_no'],
                'is_current' => true,
                'assigned_at' => now(),
            ]);
        });

        return redirect()->route('admin.students.index')
            ->with('success', 'Student enrolled successfully.');
    }

    public function show(Student $student): View
    {
        $student->load([
            'guardian',
            'currentAcademicRecord.schoolClass',
            'currentAcademicRecord.section',
            'feeInvoices.payments',
            'feeInvoices.feeType',
            'marks.subject',
            'attendanceRecords',
        ]);

        $resultSummary = $this->resultService->studentResultSummary($student->id);
        $attendanceSummary = [
            'overall' => round($student->attendanceRecords->whereIn('status', ['present', 'late', 'half_day'])->count() / max($student->attendanceRecords->count(), 1) * 100),
            'present' => $student->attendanceRecords->where('status', 'present')->count(),
            'absent' => $student->attendanceRecords->where('status', 'absent')->count(),
            'leave' => $student->attendanceRecords->where('status', 'leave')->count(),
        ];

        return view('students.show', [
            'student' => $student,
            'resultSummary' => $resultSummary,
            'attendanceSummary' => $attendanceSummary,
            'recentInvoices' => $student->feeInvoices->sortByDesc('billing_month')->take(6),
        ]);
    }

    public function edit(Student $student): View
    {
        $student->load(['guardian', 'currentAcademicRecord']);

        return view('students.edit', [
            'student' => $student,
            'classes' => SchoolClass::query()->orderBy('order_seq')->get(),
            'sections' => Section::query()->get(),
            'academicYears' => AcademicYear::query()->latest()->get(),
        ]);
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_no' => 'required|string|unique:students,registration_no,' . $student->id,
            'b_form_no' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'enrollment_date' => 'required|date',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'status' => 'required|string',
            'father_name' => 'required|string|max:255',
            'father_phone' => 'required|string|max:20',
            'emergency_contact' => 'required|string|max:20',
            'academic_year_id' => 'required|exists:academic_years,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'roll_no' => 'required|string|max:20',
        ]);

        DB::transaction(function () use ($student, $validated) {
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'] ?? $student->user->email,
            ]);

            $student->update([
                'registration_no' => $validated['registration_no'],
                'b_form_no' => $validated['b_form_no'],
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'enrollment_date' => $validated['enrollment_date'],
                'email' => $validated['email'] ?? null,
                'address' => $validated['address'] ?? null,
                'status' => $validated['status'],
            ]);

            $student->guardian->update([
                'father_name' => $validated['father_name'],
                'father_phone' => $validated['father_phone'],
                'emergency_contact' => $validated['emergency_contact'],
            ]);

            $student->currentAcademicRecord->update([
                'academic_year_id' => $validated['academic_year_id'],
                'school_class_id' => $validated['school_class_id'],
                'section_id' => $validated['section_id'],
                'roll_no' => $validated['roll_no'],
            ]);
        });

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student soft-deleted successfully.');
    }
}
