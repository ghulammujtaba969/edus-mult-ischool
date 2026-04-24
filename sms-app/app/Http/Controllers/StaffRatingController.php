<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\StaffRating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffRatingController extends Controller
{
    public function index(): View
    {
        $ratings = StaffRating::with(['employee.user', 'rater'])->latest()->get();
        return view('staff.ratings.index', compact('ratings'));
    }

    public function create(): View
    {
        $employees = Employee::with('user')->where('status', 'active')->get();
        return view('staff.ratings.create', compact('employees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
        ]);

        StaffRating::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
            'rated_by' => auth()->id(),
        ]));

        return redirect()->route('admin.staff-ratings.index')
            ->with('success', 'Staff rating submitted.');
    }
}
