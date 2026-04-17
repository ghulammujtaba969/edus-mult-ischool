<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\DemoSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSchoolSeeder::class);
        $this->admin = User::where('email', 'admin@alfalah.edu.pk')->first();
    }

    public function test_admin_can_view_student_list(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.students.index'))
            ->assertOk()
            ->assertSee('Students');
    }

    public function test_admin_can_enroll_student(): void
    {
        $class = SchoolClass::first();
        $section = Section::where('school_class_id', $class->id)->first();
        $year = AcademicYear::where('is_current', true)->first();

        $studentData = [
            'name' => 'New Student',
            'registration_no' => 'REG-TEST-001',
            'b_form_no' => '12345-6789012-3',
            'date_of_birth' => '2015-01-01',
            'gender' => 'Male',
            'enrollment_date' => '2026-04-13',
            'email' => 'newstudent@example.com',
            'father_name' => 'Father Name',
            'father_phone' => '0300-1234567',
            'emergency_contact' => '0300-7654321',
            'academic_year_id' => $year->id,
            'school_class_id' => $class->id,
            'section_id' => $section->id,
            'roll_no' => '99',
        ];

        $this->actingAs($this->admin)
            ->post(route('admin.students.store'), $studentData)
            ->assertRedirect(route('admin.students.index'));

        $this->assertDatabaseHas('students', [
            'registration_no' => 'REG-TEST-001',
            'b_form_no' => '12345-6789012-3',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'New Student',
            'email' => 'newstudent@example.com',
        ]);

        $this->assertDatabaseHas('student_parents', [
            'father_name' => 'Father Name',
        ]);

        $this->assertDatabaseHas('student_academic_records', [
            'roll_no' => '99',
            'school_class_id' => $class->id,
        ]);
    }

    public function test_admin_can_update_student(): void
    {
        $student = Student::first();
        $class = SchoolClass::first();
        $section = Section::where('school_class_id', $class->id)->first();
        $year = AcademicYear::where('is_current', true)->first();

        $updateData = [
            'name' => 'Updated Name',
            'registration_no' => $student->registration_no,
            'b_form_no' => '55555-5555555-5',
            'date_of_birth' => '2015-02-02',
            'gender' => 'Female',
            'enrollment_date' => '2026-04-13',
            'email' => 'updated@example.com',
            'status' => 'active',
            'father_name' => 'Updated Father',
            'father_phone' => '0333-1112223',
            'emergency_contact' => '0333-4445556',
            'academic_year_id' => $year->id,
            'school_class_id' => $class->id,
            'section_id' => $section->id,
            'roll_no' => '77',
        ];

        $this->actingAs($this->admin)
            ->put(route('admin.students.update', $student), $updateData)
            ->assertRedirect(route('admin.students.show', $student));

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'b_form_no' => '55555-5555555-5',
            'gender' => 'Female',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $student->user_id,
            'name' => 'Updated Name',
        ]);
    }
}
