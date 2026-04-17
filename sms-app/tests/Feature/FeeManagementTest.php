<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\FeeType;
use App\Models\SchoolClass;
use App\Models\User;
use Database\Seeders\DemoSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeeManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSchoolSeeder::class);
        $this->admin = User::where('email', 'admin@alfalah.edu.pk')->first();
    }

    public function test_admin_can_view_fee_types(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.fee-types.index'))
            ->assertOk()
            ->assertSee('Fee Types');
    }

    public function test_admin_can_create_fee_type(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.fee-types.store'), [
                'name' => 'Lab Fee',
                'is_recurring' => 1,
                'frequency' => 'monthly',
            ])
            ->assertRedirect(route('admin.fee-types.index'));

        $this->assertDatabaseHas('fee_types', ['name' => 'Lab Fee']);
    }

    public function test_admin_can_set_fee_structure(): void
    {
        $class = SchoolClass::first();
        $type = FeeType::first();
        $year = AcademicYear::where('is_current', true)->first();

        $this->actingAs($this->admin)
            ->post(route('admin.fee-structures.store'), [
                'academic_year_id' => $year->id,
                'school_class_id' => $class->id,
                'fee_type_id' => $type->id,
                'amount' => 5500,
                'due_day' => 10,
            ])
            ->assertRedirect(route('admin.fee-structures.index'));

        $this->assertDatabaseHas('fee_structures', [
            'amount' => 5500,
            'school_class_id' => $class->id,
        ]);
    }
}
