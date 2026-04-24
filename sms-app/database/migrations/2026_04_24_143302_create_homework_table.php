<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('homework', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
        //     $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
        //     $table->foreignId('section_id')->constrained()->cascadeOnDelete();
        //     $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
        //     $table->date('homework_date');
        //     $table->date('submission_date');
        //     $table->text('description');
        //     $table->string('attachment')->nullable();
        //     $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        Schema::dropIfExists('homework');
    }
};
