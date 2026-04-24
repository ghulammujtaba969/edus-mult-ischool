<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use App\Models\OnlineExam;
use App\Models\Student;
use App\Models\TimetableEntry;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $student = Student::where('user_id', $user->id)->first();

        $todayTimetable = TimetableEntry::with(['slot', 'subject', 'teacher.user'])
            ->where('school_class_id', $student?->school_class_id)
            ->where('section_id', $student?->section_id)
            ->whereHas('slot', function($q) {
                $q->where('day', date('l'));
            })
            ->get();

        $activeExams = OnlineExam::where('is_active', true)
            ->where('exam_to', '>', now())
            ->count();

        $pendingHomework = Homework::where('school_class_id', $student?->school_class_id)
            ->where('section_id', $student?->section_id)
            ->where('submission_date', '>=', now())
            ->count();

        return view('portals.student.dashboard', compact('todayTimetable', 'activeExams', 'pendingHomework', 'student'));
    }
}
