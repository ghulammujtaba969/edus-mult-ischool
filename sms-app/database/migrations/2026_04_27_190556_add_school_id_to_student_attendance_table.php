<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('student_attendance') && ! Schema::hasColumn('student_attendance', 'school_id')) {
            Schema::table('student_attendance', function (Blueprint $table) {
                $table->foreignId('school_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            });

            DB::table('student_attendance')
                ->join('students', 'student_attendance.student_id', '=', 'students.id')
                ->whereNull('student_attendance.school_id')
                ->update([
                    'student_attendance.school_id' => DB::raw('students.school_id'),
                ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('student_attendance') && Schema::hasColumn('student_attendance', 'school_id')) {
            Schema::table('student_attendance', function (Blueprint $table) {
                $table->dropConstrainedForeignId('school_id');
            });
        }
    }
};
