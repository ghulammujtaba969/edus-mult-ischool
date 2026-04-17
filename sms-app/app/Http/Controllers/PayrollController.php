<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PayrollController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['month', 'status']);
        
        $payrolls = Payroll::with('employee.user')
            ->when($filters['month'] ?? null, fn ($q, $m) => $q->whereDate('billing_month', $m))
            ->when($filters['status'] ?? null, fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15);

        return view('payrolls.index', compact('payrolls', 'filters'));
    }

    public function create(): View
    {
        return view('payrolls.generate');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'billing_month' => 'required|date',
        ]);

        $billingMonth = \Carbon\Carbon::parse($validated['billing_month'])->startOfMonth();

        $employees = Employee::where('status', 'active')->get();
        $count = 0;

        DB::transaction(function () use ($employees, $billingMonth, &$count) {
            foreach ($employees as $employee) {
                // Check if payroll already exists
                $exists = Payroll::where('employee_id', $employee->id)
                    ->whereDate('billing_month', $billingMonth)
                    ->exists();

                if ($exists) continue;

                Payroll::create([
                    'campus_id' => auth()->user()->campus_id,
                    'employee_id' => $employee->id,
                    'billing_month' => $billingMonth,
                    'basic_salary' => $employee->basic_salary,
                    'net_salary' => $employee->basic_salary, // For now, no allowances/deductions
                    'status' => 'unpaid',
                ]);
                $count++;
            }
        });

        return redirect()->route('admin.payrolls.index')
            ->with('success', "$count payroll records generated successfully.");
    }

    public function show(Payroll $payroll): View
    {
        $payroll->load('employee.user');
        return view('payrolls.show', compact('payroll'));
    }

    public function update(Request $request, Payroll $payroll): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:unpaid,paid',
            'payment_date' => 'required_if:status,paid|nullable|date',
            'payment_method' => 'required_if:status,paid|nullable|string',
            'notes' => 'nullable|string',
        ]);

        $payroll->update($validated);

        return redirect()->route('admin.payrolls.index')
            ->with('success', 'Payroll updated successfully.');
    }
}
