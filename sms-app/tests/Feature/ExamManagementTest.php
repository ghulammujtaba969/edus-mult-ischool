<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Database\Seeders\DemoSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSchoolSeeder::class);
        $this->admin = User::where('email', 'admin@alfalah.edu.pk')->first();
    }

    public function test_admin_can_view_exam_types(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.exam-types.index'))
            ->assertOk()
            ->assertSee('Exam Types');
    }

    public function test_admin_can_schedule_exam(): void
    {
        $type = ExamType::first();
        $class = SchoolClass::first();
        $year = AcademicYear::where('is_current', true)->first();

        $this->actingAs($this->admin)
            ->post(route('admin.exams.store'), [
                'academic_year_id' => $year->id,
                'exam_type_id' => $type->id,
                'school_class_id' => $class->id,
                'name' => 'Mid Term 2026',
                'start_date' => '2026-05-01',
                'end_date' => '2026-05-15',
            ])
            ->assertRedirect(route('admin.exams.index'));

        $this->assertDatabaseHas('exams', ['name' => 'Mid Term 2026']);
    }

    public function test_admin_can_view_marks_entry_page(): void
    {
        $exam = Exam::first();
        $subject = Subject::first();

        $this->actingAs($this->admin)
            ->get(route('admin.marks.create', ['exam_id' => $exam->id, 'subject_id' => $subject->id]))
            ->assertOk()
            ->assertSee('Mark Entry')
            ->assertSee($exam->name);
    }
}
