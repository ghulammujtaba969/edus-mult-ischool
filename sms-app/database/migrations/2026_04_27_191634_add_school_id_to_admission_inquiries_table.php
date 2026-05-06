<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('admission_inquiries') && ! Schema::hasColumn('admission_inquiries', 'school_id')) {
            Schema::table('admission_inquiries', function (Blueprint $table) {
                $table->foreignId('school_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            });

            DB::table('admission_inquiries')
                ->join('campuses', 'admission_inquiries.campus_id', '=', 'campuses.id')
                ->whereNull('admission_inquiries.school_id')
                ->update([
                    'admission_inquiries.school_id' => DB::raw('campuses.school_id'),
                ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('admission_inquiries') && Schema::hasColumn('admission_inquiries', 'school_id')) {
            Schema::table('admission_inquiries', function (Blueprint $table) {
                $table->dropConstrainedForeignId('school_id');
            });
        }
    }
};
