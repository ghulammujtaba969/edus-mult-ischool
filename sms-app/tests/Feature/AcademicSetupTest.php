<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Database\Seeders\DemoSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicSetupTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSchoolSeeder::class);
        $this->admin = User::where('email', 'admin@alfalah.edu.pk')->first();
    }

    public function test_admin_can_view_academic_years(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.academic-years.index'))
            ->assertOk()
            ->assertSee('Academic Years');
    }

    public function test_admin_can_view_classes(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.classes.index'))
            ->assertOk()
            ->assertSee('Classes');
    }

    public function test_admin_can_view_sections(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.sections.index'))
            ->assertOk()
            ->assertSee('Sections');
    }

    public function test_admin_can_view_subjects(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.subjects.index'))
            ->assertOk()
            ->assertSee('Subjects');
    }

    public function test_admin_can_create_class(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.classes.store'), [
                'name' => 'Test Class',
                'order_seq' => 10,
            ])
            ->assertRedirect(route('admin.classes.index'));

        $this->assertDatabaseHas('school_classes', [
            'name' => 'Test Class',
            'order_seq' => 10,
        ]);
    }
}
