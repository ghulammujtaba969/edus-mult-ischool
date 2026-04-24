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
        Schema::table('domains', function (Blueprint $table) {
            $table->timestamp('dns_verified_at')->nullable()->after('is_verified');
            $table->integer('dns_check_count')->default(0)->after('dns_verified_at');
            $table->text('last_dns_error')->nullable()->after('dns_check_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            //
        });
    }
};
