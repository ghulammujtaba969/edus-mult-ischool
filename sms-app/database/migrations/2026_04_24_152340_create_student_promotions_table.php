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
        // Schema::create('student_promotions', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('campus_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('student_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('from_year_id')->constrained('academic_years')->onDelete('cascade');
        //     $table->foreignId('to_year_id')->constrained('academic_years')->onDelete('cascade');
        //     $table->foreignId('from_class_id')->constrained('school_classes')->onDelete('cascade');
        //     $table->foreignId('to_class_id')->constrained('school_classes')->onDelete('cascade');
        //     $table->foreignId('from_section_id')->constrained('sections')->onDelete('cascade');
        //     $table->foreignId('to_section_id')->constrained('sections')->onDelete('cascade');
        //     $table->foreignId('promoted_by')->constrained('users')->onDelete('cascade');
        //     $table->text('remarks')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_promotions');
    }
};
