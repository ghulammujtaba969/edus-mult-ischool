<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'school_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->foreignId('school_id')->nullable()->constrained()->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('all_tenant_tables', function (Blueprint $table) {
            //
        });
    }
};
