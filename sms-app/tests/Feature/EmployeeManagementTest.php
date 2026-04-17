<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Employee;
use App\Models\User;
use Database\Seeders\DemoSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSchoolSeeder::class);
        $this->admin = User::where('email', 'admin@alfalah.edu.pk')->first();
    }

    public function test_admin_can_view_employee_list(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.employees.index'))
            ->assertOk()
            ->assertSee('Staff Management');
    }

    public function test_admin_can_create_employee(): void
    {
        $employeeData = [
            'name' => 'New Teacher',
            'email' => 'teacher.new@example.com',
            'phone' => '0300-1112223',
            'role' => UserRole::TEACHER->value,
            'employee_code' => 'EMP-TEST-001',
            'designation' => 'Science Teacher',
            'department' => 'Science',
            'joining_date' => '2026-04-13',
            'cnic' => '35202-1111111-1',
        ];

        $this->actingAs($this->admin)
            ->post(route('admin.employees.store'), $employeeData)
            ->assertRedirect(route('admin.employees.index'));

        $this->assertDatabaseHas('employees', [
            'employee_code' => 'EMP-TEST-001',
            'designation' => 'Science Teacher',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'teacher.new@example.com',
            'role' => UserRole::TEACHER->value,
        ]);
    }

    public function test_admin_can_update_employee(): void
    {
        $employee = Employee::first();

        $updateData = [
            'name' => 'Updated Employee Name',
            'email' => 'updated.emp@example.com',
            'phone' => '0333-9998887',
            'role' => UserRole::TEACHER->value,
            'employee_code' => 'EMP-UPDATED-001',
            'designation' => 'Principal',
            'department' => 'Management',
            'joining_date' => '2026-04-13',
            'cnic' => '35202-9999999-9',
            'status' => 'active',
        ];

        $this->actingAs($this->admin)
            ->put(route('admin.employees.update', $employee), $updateData)
            ->assertRedirect(route('admin.employees.index'));

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'employee_code' => 'EMP-UPDATED-001',
            'designation' => 'Principal',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $employee->user_id,
            'name' => 'Updated Employee Name',
        ]);
    }
}
