<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Plan;
use App\Models\School;
use App\Models\Domain;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;

class InitialSmsSaaSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a default Plan
        $plan = Plan::create([
            'name' => 'Enterprise Plan',
            'max_branches' => 10,
            'monthly_price' => 299.00,
            'features' => ['all'],
            'is_active' => true,
        ]);

        // 2. Create the first School (Tenant)
        $school = School::create([
            'name' => 'EduCore International',
            'slug' => 'educore',
            'plan_id' => $plan->id,
            'status' => 'active',
        ]);

        // 3. Create a default Subdomain
        Domain::create([
            'school_id' => $school->id,
            'domain' => 'educore.localhost',
            'type' => 'subdomain',
            'is_verified' => true,
        ]);

        // 4. Migrate existing campuses to this school
        DB::table('campuses')->update(['school_id' => $school->id]);

        // 5. Migrate all existing users to this school
        DB::table('users')->update(['school_id' => $school->id]);

        // 6. Migrate all other operational data
        $tables = [
            'academic_years', 'school_classes', 'sections', 'subjects', 'students',
            'student_parents', 'student_academic_records', 'student_attendances',
            'fee_invoices', 'fee_payments', 'exam_types', 'activity_logs',
            'terms', 'fee_structures', 'fee_types', 'exams', 'marks', 'payrolls',
            'employees', 'assets', 'asset_assignments', 'asset_categories',
            'hostels', 'hostel_allocations', 'hostel_rooms', 'transport_vehicles',
            'transport_routes', 'transport_pickup_points', 'transport_assignments',
            'library_books', 'library_members', 'library_issues', 'front_office_visitors',
            'front_office_enquiries', 'front_office_complaints', 'homeworks',
            'homework_submissions', 'syllabus_progress', 'certificate_templates',
            'id_card_templates', 'staff_attendances', 'staff_leaves', 'staff_ratings',
            'inventory_suppliers', 'inventory_items', 'inventory_item_issues',
            'lesson_plans', 'online_exams', 'online_exam_questions', 'online_exam_attempts'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->update(['school_id' => $school->id]);
            }
        }
        
        // 7. Create a Super Admin for the platform (if not exists)
        if (!User::where('role', UserRole::SUPER_ADMIN)->exists()) {
            User::create([
                'name' => 'SaaS Super Admin',
                'email' => 'admin@sms-saas.com',
                'password' => bcrypt('password'),
                'role' => UserRole::SUPER_ADMIN,
                'is_active' => true,
                'school_id' => null, // Super Admin is platform-level
            ]);
        }
    }
}
