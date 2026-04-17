<?php

namespace Tests\Feature;

use App\Enums\AttendanceStatus;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\DemoSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSchoolSeeder::class);
        $this->admin = User::where('email', 'admin@alfalah.edu.pk')->first();
    }

    public function test_admin_can_view_attendance_index(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.attendance.index'))
            ->assertOk()
            ->assertSee('Attendance');
    }

    public function test_admin_can_view_mark_attendance_page(): void
    {
        $section = Section::first();

        $this->actingAs($this->admin)
            ->get(route('admin.attendance.create', ['section_id' => $section->id, 'date' => date('Y-m-d')]))
            ->assertOk()
            ->assertSee('Mark Attendance')
            ->assertSee($section->name);
    }

    public function test_admin_can_save_attendance(): void
    {
        $section = Section::first();
        $students = Student::whereHas('currentAcademicRecord', function ($query) use ($section) {
            $query->where('section_id', $section->id);
        })->get();

        $testDate = '2026-04-20'; // A future date to avoid seeder conflicts

        $attendanceData = [];
        foreach ($students as $student) {
            $attendanceData[$student->id] = AttendanceStatus::PRESENT->value;
        }

        $this->actingAs($this->admin)
            ->post(route('admin.attendance.store'), [
                'section_id' => $section->id,
                'attendance_date' => $testDate,
                'attendance' => $attendanceData,
            ])
            ->assertRedirect(route('admin.attendance.index'));

        $this->assertDatabaseHas('student_attendance', [
            'student_id' => $students->first()->id,
            'status' => AttendanceStatus::PRESENT->value,
            'attendance_date' => $testDate . ' 00:00:00',
        ]);
    }
}
