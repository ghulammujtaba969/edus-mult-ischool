<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('front_office_complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
            $table->string('complaint_by');
            $table->string('phone')->nullable();
            $table->date('date');
            $table->text('description')->nullable();
            $table->text('action_taken')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, resolved
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('front_office_complaints');
    }
};
