<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Database\Seeders\DemoSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmsMvpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DemoSchoolSeeder::class);
    }

    public function test_login_screen_is_available_and_dashboard_requires_authentication(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Sign in');

        $this->get('/admin/dashboard')
            ->assertRedirect('/');
    }

    public function test_campus_admin_can_sign_in_and_open_dashboard_and_student_pages(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@alfalah.edu.pk',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        $this->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Total Students');

        $student = Student::query()->firstOrFail();

        $this->get(route('admin.students.show', $student))
            ->assertOk()
            ->assertSee('Student Profile')
            ->assertSee($student->user->name);
    }

    public function test_campus_scope_hides_students_from_other_campuses(): void
    {
        $admin = User::query()->where('email', 'admin@alfalah.edu.pk')->firstOrFail();
        $otherCampusStudent = Student::query()->where('registration_no', 'REG-2025-99999')->firstOrFail();

        $this->actingAs($admin)
            ->get('/admin/students')
            ->assertOk()
            ->assertDontSee('Other Campus Student');

        $this->actingAs($admin)
            ->get(route('admin.students.show', $otherCampusStudent))
            ->assertNotFound();
    }
}
