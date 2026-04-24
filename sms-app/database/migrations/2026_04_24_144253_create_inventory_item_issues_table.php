<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('inventory_item_issues', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
        //     $table->foreignId('inventory_item_id')->constrained()->cascadeOnDelete();
        //     $table->foreignId('issued_to')->constrained('users')->cascadeOnDelete();
        //     $table->unsignedInteger('quantity')->default(1);
        //     $table->date('issue_date');
        //     $table->date('return_date')->nullable();
        //     $table->string('status')->default('issued'); // issued, returned
        //     $table->text('note')->nullable();
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_item_issues');
    }
};
