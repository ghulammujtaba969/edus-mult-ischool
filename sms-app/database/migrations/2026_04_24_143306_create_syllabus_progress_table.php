<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    //     Schema::create('syllabus_progress', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
    //         $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
    //         $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
    //         $table->string('topic');
    //         $table->text('description')->nullable();
    //         $table->unsignedInteger('percentage')->default(0);
    //         $table->date('completed_at')->nullable();
    //         $table->string('status')->default('pending'); // pending, in_progress, completed
    //         $table->timestamps();
    //     });
    }

    public function down(): void
    {
        Schema::dropIfExists('syllabus_progress');
    }
};
