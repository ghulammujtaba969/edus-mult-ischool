<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\StaffLeave;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffLeaveController extends Controller
{
    public function index(): View
    {
        $leaves = StaffLeave::with('employee.user')->latest()->get();
        return view('staff.leaves.index', compact('leaves'));
    }

    public function create(): View
    {
        $employees = Employee::with('user')->where('status', 'active')->get();
        return view('staff.leaves.create', compact('employees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|string|in:casual,sick,annual',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        StaffLeave::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
            'status' => 'pending',
        ]));

        return redirect()->route('admin.staff-leaves.index')
            ->with('success', 'Leave request submitted.');
    }

    public function update(Request $request, StaffLeave $staffLeave): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:approved,rejected',
        ]);

        $staffLeave->update([
            'status' => $validated['status'],
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.staff-leaves.index')
            ->with('success', 'Leave request ' . $validated['status'] . '.');
    }
}
