<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Employee;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\TimetableEntry;
use App\Models\TimetableSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimetableController extends Controller
{
    public function index(Request $request): View
    {
        $classes = SchoolClass::all();
        $sections = Section::all();
        $academicYears = AcademicYear::all();

        $selectedClass = $request->input('class_id');
        $selectedSection = $request->input('section_id');

        $timetable = [];
        if ($selectedClass && $selectedSection) {
            $timetable = TimetableEntry::with(['slot', 'subject', 'teacher.user'])
                ->where('school_class_id', $selectedClass)
                ->where('section_id', $selectedSection)
                ->get()
                ->groupBy('slot.day');
        }

        return view('academic.timetable.index', compact('classes', 'sections', 'academicYears', 'timetable', 'selectedClass', 'selectedSection'));
    }

    public function slots(): View
    {
        $slots = TimetableSlot::orderBy('day')->orderBy('period_no')->get();
        return view('academic.timetable.slots', compact('slots'));
    }

    public function storeSlot(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'day' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'period_no' => 'required|integer|min:1',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'is_break' => 'boolean',
        ]);

        TimetableSlot::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
        ]));

        return redirect()->route('admin.timetable.slots')
            ->with('success', 'Timetable slot created successfully.');
    }

    public function createEntry(): View
    {
        $classes = SchoolClass::all();
        $sections = Section::all();
        $subjects = Subject::all();
        $teachers = Employee::with('user')->get();
        $slots = TimetableSlot::orderBy('day')->orderBy('period_no')->get();

        return view('academic.timetable.create', compact('classes', 'sections', 'subjects', 'teachers', 'slots'));
    }

    public function storeEntry(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'timetable_slot_id' => 'required|exists:timetable_slots,id',
            'subject_id' => 'required|exists:subjects,id',
            'employee_id' => 'required|exists:employees,id',
            'room_no' => 'nullable|string|max:50',
        ]);

        $currentYear = AcademicYear::where('is_current', true)->first();

        try {
            TimetableEntry::create(array_merge($validated, [
                'campus_id' => auth()->user()->campus_id,
                'academic_year_id' => $currentYear->id,
            ]));
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') { // Duplicate entry
                return redirect()->back()->withErrors(['clash' => 'Clash detected: Either the section or the teacher is already booked for this slot.']);
            }
            throw $e;
        }

        return redirect()->route('admin.timetable.index', [
            'class_id' => $validated['school_class_id'],
            'section_id' => $validated['section_id']
        ])->with('success', 'Timetable entry added successfully.');
    }

    public function destroyEntry(TimetableEntry $timetableEntry): RedirectResponse
    {
        $timetableEntry->delete();
        return redirect()->back()->with('success', 'Timetable entry removed.');
    }

    public function destroySlot(TimetableSlot $timetableSlot): RedirectResponse
    {
        $timetableSlot->delete();
        return redirect()->back()->with('success', 'Timetable slot removed.');
    }
}
