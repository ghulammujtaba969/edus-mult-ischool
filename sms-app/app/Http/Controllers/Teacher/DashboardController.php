<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LessonPlan;
use App\Models\StudentAttendance;
use App\Models\TimetableEntry;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();
        
        $myClasses = TimetableEntry::with(['schoolClass', 'section'])
            ->where('employee_id', $employee?->id)
            ->get()
            ->unique(function ($item) {
                return $item->school_class_id . '-' . $item->section_id;
            });

        $todayClasses = TimetableEntry::with(['slot', 'schoolClass', 'section', 'subject'])
            ->where('employee_id', $employee?->id)
            ->whereHas('slot', function($q) {
                $q->where('day', date('l'));
            })
            ->orderByHas('slot', 'start_time')
            ->get();

        $pendingLessonPlans = LessonPlan::where('teacher_id', $user->id)
            ->where('date', '>=', now())
            ->count();

        return view('portals.teacher.dashboard', compact('myClasses', 'todayClasses', 'pendingLessonPlans'));
    }
}
