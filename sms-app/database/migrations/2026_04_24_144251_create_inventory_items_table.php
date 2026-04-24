<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('inventory_items', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
        //     $table->foreignId('inventory_supplier_id')->nullable()->constrained()->nullOnDelete();
        //     $table->string('name');
        //     $table->string('category'); // stationery, cleaning, etc.
        //     $table->unsignedInteger('quantity')->default(0);
        //     $table->unsignedInteger('available_quantity')->default(0);
        //     $table->string('unit')->default('pcs'); // pcs, kg, liters
        //     $table->decimal('unit_price', 12, 2)->default(0);
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
