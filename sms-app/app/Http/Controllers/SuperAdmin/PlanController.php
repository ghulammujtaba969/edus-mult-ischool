<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PlanController extends Controller
{
    public function index(): View
    {
        $plans = Plan::latest()->paginate(10);
        return view('super-admin.plans.index', compact('plans'));
    }

    private function getAvailableFeatures(): array
    {
        return [
            'Main' => [
                'student_management' => 'Student Management',
                'admission_inquiries' => 'Admission Inquiries',
                'promotions' => 'Promotions',
                'staff_management' => 'Staff Management',
                'staff_attendance' => 'Staff Attendance',
                'staff_leaves' => 'Staff Leaves',
                'staff_ratings' => 'Staff Ratings',
                'payroll' => 'Payroll',
                'notifications' => 'Notifications',
                'reports' => 'Reports',
            ],
            'Resources' => [
                'hostel' => 'Hostel',
                'assets' => 'Assets',
                'inventory' => 'Inventory',
                'transport' => 'Transport',
                'library' => 'Library',
                'front_office' => 'Front Office',
                'homework' => 'Homework',
                'syllabus' => 'Syllabus',
                'alumni' => 'Alumni',
                'templates' => 'Templates',
            ],
            'Academic' => [
                'academic_years' => 'Academic Years',
                'classes' => 'Classes',
                'sections' => 'Sections',
                'subjects' => 'Subjects',
                'timetable' => 'Timetable',
                'lesson_plans' => 'Lesson Plans',
                'attendance' => 'Attendance',
            ],
            'Examinations' => [
                'exam_types' => 'Exam Types',
                'grade_scales' => 'Grading Scales',
                'exam_schedules' => 'Exam Schedules',
                'online_exams' => 'Online Exams',
                'marks_entry' => 'Marks Entry',
                'result_cards' => 'Result Cards',
            ],
            'Finance' => [
                'fee_types' => 'Fee Types',
                'fee_structures' => 'Fee Structures',
                'fee_invoices' => 'Fee Invoices',
                'expenses' => 'Expenses',
            ],
        ];
    }

    public function create(): View
    {
        $availableFeatures = $this->getAvailableFeatures();
        return view('super-admin.plans.create', compact('availableFeatures'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'max_branches' => 'required|integer|min:1',
            'monthly_price' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['features'] = $request->input('features') ? array_filter($request->input('features')) : [];

        Plan::create($validated);

        return redirect()->route('super-admin.plans.index')
            ->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan): View
    {
        $availableFeatures = $this->getAvailableFeatures();
        return view('super-admin.plans.edit', compact('plan', 'availableFeatures'));
    }

    public function update(Request $request, Plan $plan): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'max_branches' => 'required|integer|min:1',
            'monthly_price' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['features'] = $request->input('features') ? array_filter($request->input('features')) : [];

        $plan->update($validated);

        return redirect()->route('super-admin.plans.index')
            ->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        if ($plan->schools()->exists()) {
            return back()->with('error', 'Cannot delete plan as it is currently assigned to schools.');
        }

        $plan->delete();

        return redirect()->route('super-admin.plans.index')
            ->with('success', 'Plan deleted successfully.');
    }
}
