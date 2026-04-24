<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
            $table->foreignId('online_exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->dateTime('started_at');
            $table->dateTime('submitted_at')->nullable();
            $table->unsignedInteger('total_marks')->default(0);
            $table->unsignedInteger('obtained_marks')->default(0);
            $table->string('status')->default('in_progress'); // in_progress, submitted
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_exam_attempts');
    }
};
