<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('homework_submissions', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
        //     $table->foreignId('homework_id')->constrained()->cascadeOnDelete();
        //     $table->foreignId('student_id')->constrained()->cascadeOnDelete();
        //     $table->date('submitted_at');
        //     $table->text('message')->nullable();
        //     $table->string('attachment')->nullable();
        //     $table->string('status')->default('submitted'); // submitted, checked, late
        //     $table->text('teacher_remarks')->nullable();
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        Schema::dropIfExists('homework_submissions');
    }
};
