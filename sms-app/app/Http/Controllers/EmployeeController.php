<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'role', 'status']);

        $employees = Employee::query()
            ->with('user')
            ->when($filters['q'] ?? null, function ($query, $search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('employee_code', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($user) => $user->where('name', 'like', "%{$search}%"))
                        ->orWhere('cnic', 'like', "%{$search}%");
                });
            })
            ->when($filters['role'] ?? null, function ($query, $role) {
                $query->whereHas('user', fn ($user) => $user->where('role', $role));
            })
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->paginate(10)
            ->withQueryString();

        return view('employees.index', [
            'employees' => $employees,
            'filters' => $filters,
            'roles' => [
                UserRole::TEACHER->value => UserRole::TEACHER->label(),
                UserRole::ACCOUNTANT->value => UserRole::ACCOUNTANT->label(),
                UserRole::PRINCIPAL->value => UserRole::PRINCIPAL->label(),
                UserRole::CAMPUS_ADMIN->value => UserRole::CAMPUS_ADMIN->label(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('employees.create', [
            'roles' => [
                UserRole::TEACHER->value => UserRole::TEACHER->label(),
                UserRole::ACCOUNTANT->value => UserRole::ACCOUNTANT->label(),
                UserRole::PRINCIPAL->value => UserRole::PRINCIPAL->label(),
                UserRole::CAMPUS_ADMIN->value => UserRole::CAMPUS_ADMIN->label(),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'role' => 'required|string',
            'employee_code' => 'required|string|unique:employees,employee_code',
            'designation' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'joining_date' => 'required|date',
            'cnic' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make('password'),
                'role' => $validated['role'],
                'campus_id' => auth()->user()->campus_id,
            ]);

            Employee::create([
                'user_id' => $user->id,
                'campus_id' => auth()->user()->campus_id,
                'employee_code' => $validated['employee_code'],
                'designation' => $validated['designation'],
                'department' => $validated['department'],
                'joining_date' => $validated['joining_date'],
                'cnic' => $validated['cnic'],
                'phone' => $validated['phone'],
                'status' => 'active',
            ]);
        });

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee): View
    {
        $employee->load('user');
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        $employee->load('user');
        return view('employees.edit', [
            'employee' => $employee,
            'roles' => [
                UserRole::TEACHER->value => UserRole::TEACHER->label(),
                UserRole::ACCOUNTANT->value => UserRole::ACCOUNTANT->label(),
                UserRole::PRINCIPAL->value => UserRole::PRINCIPAL->label(),
                UserRole::CAMPUS_ADMIN->value => UserRole::CAMPUS_ADMIN->label(),
            ],
        ]);
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user_id,
            'phone' => 'required|string|max:20',
            'role' => 'required|string',
            'employee_code' => 'required|string|unique:employees,employee_code,' . $employee->id,
            'designation' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'joining_date' => 'required|date',
            'cnic' => 'nullable|string|max:20',
            'status' => 'required|string',
        ]);

        DB::transaction(function () use ($employee, $validated) {
            $employee->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'role' => $validated['role'],
            ]);

            $employee->update([
                'employee_code' => $validated['employee_code'],
                'designation' => $validated['designation'],
                'department' => $validated['department'],
                'joining_date' => $validated['joining_date'],
                'cnic' => $validated['cnic'],
                'phone' => $validated['phone'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
