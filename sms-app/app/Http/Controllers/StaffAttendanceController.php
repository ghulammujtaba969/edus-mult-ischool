<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\StaffAttendance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffAttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $date = $request->input('date', date('Y-m-d'));
        $attendances = StaffAttendance::with('employee.user')
            ->whereDate('date', $date)
            ->get();

        return view('staff.attendance.index', compact('attendances', 'date'));
    }

    public function create(): View
    {
        $employees = Employee::with('user')->where('status', 'active')->get();
        $date = date('Y-m-d');
        return view('staff.attendance.create', compact('employees', 'date'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|string|in:present,absent,late,half_day',
            'attendance.*.note' => 'nullable|string',
        ]);

        foreach ($validated['attendance'] as $employeeId => $data) {
            StaffAttendance::updateOrCreate(
                [
                    'campus_id' => auth()->user()->campus_id,
                    'employee_id' => $employeeId,
                    'date' => $validated['date'],
                ],
                [
                    'status' => $data['status'],
                    'note' => $data['note'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.staff-attendance.index', ['date' => $validated['date']])
            ->with('success', 'Staff attendance marked successfully.');
    }
}
