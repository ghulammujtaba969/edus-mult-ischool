<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
            $table->string('exam_title');
            $table->dateTime('exam_from');
            $table->dateTime('exam_to');
            $table->unsignedInteger('duration_minutes');
            $table->decimal('minimum_percentage', 5, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('publish_result')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_exams');
    }
};
