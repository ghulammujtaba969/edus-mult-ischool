<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
            $table->foreignId('online_exam_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->string('question_type')->default('mcq'); // mcq, true_false, descriptive
            $table->json('options')->nullable(); // For MCQs
            $table->string('correct_option')->nullable();
            $table->unsignedInteger('marks')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_exam_questions');
    }
};
