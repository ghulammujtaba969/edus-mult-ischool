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
        if (Schema::hasTable('inventory_suppliers')) {
            Schema::table('inventory_suppliers', function (Blueprint $table) {
                if (! Schema::hasColumn('inventory_suppliers', 'campus_id')) {
                    $table->foreignId('campus_id')->nullable()->after('school_id')->constrained()->nullOnDelete();
                }

                if (! Schema::hasColumn('inventory_suppliers', 'name')) {
                    $table->string('name')->after('campus_id');
                }

                if (! Schema::hasColumn('inventory_suppliers', 'contact_person')) {
                    $table->string('contact_person')->nullable()->after('name');
                }

                if (! Schema::hasColumn('inventory_suppliers', 'phone')) {
                    $table->string('phone')->nullable()->after('contact_person');
                }

                if (! Schema::hasColumn('inventory_suppliers', 'email')) {
                    $table->string('email')->nullable()->after('phone');
                }

                if (! Schema::hasColumn('inventory_suppliers', 'address')) {
                    $table->text('address')->nullable()->after('email');
                }
            });
        }

        if (Schema::hasTable('inventory_items')) {
            Schema::table('inventory_items', function (Blueprint $table) {
                if (! Schema::hasColumn('inventory_items', 'campus_id')) {
                    $table->foreignId('campus_id')->nullable()->after('school_id')->constrained()->nullOnDelete();
                }

                if (! Schema::hasColumn('inventory_items', 'inventory_supplier_id')) {
                    $table->foreignId('inventory_supplier_id')->nullable()->after('campus_id')->constrained('inventory_suppliers')->nullOnDelete();
                }

                if (! Schema::hasColumn('inventory_items', 'name')) {
                    $table->string('name')->after('inventory_supplier_id');
                }

                if (! Schema::hasColumn('inventory_items', 'category')) {
                    $table->string('category')->after('name');
                }

                if (! Schema::hasColumn('inventory_items', 'quantity')) {
                    $table->unsignedInteger('quantity')->default(0)->after('category');
                }

                if (! Schema::hasColumn('inventory_items', 'available_quantity')) {
                    $table->unsignedInteger('available_quantity')->default(0)->after('quantity');
                }

                if (! Schema::hasColumn('inventory_items', 'unit')) {
                    $table->string('unit')->after('available_quantity');
                }

                if (! Schema::hasColumn('inventory_items', 'unit_price')) {
                    $table->decimal('unit_price', 12, 2)->default(0)->after('unit');
                }
            });
        }

        if (Schema::hasTable('inventory_item_issues')) {
            Schema::table('inventory_item_issues', function (Blueprint $table) {
                if (! Schema::hasColumn('inventory_item_issues', 'campus_id')) {
                    $table->foreignId('campus_id')->nullable()->after('school_id')->constrained()->nullOnDelete();
                }

                if (! Schema::hasColumn('inventory_item_issues', 'inventory_item_id')) {
                    $table->foreignId('inventory_item_id')->nullable()->after('campus_id')->constrained('inventory_items')->cascadeOnDelete();
                }

                if (! Schema::hasColumn('inventory_item_issues', 'issued_to')) {
                    $table->foreignId('issued_to')->nullable()->after('inventory_item_id')->constrained('users')->nullOnDelete();
                }

                if (! Schema::hasColumn('inventory_item_issues', 'quantity')) {
                    $table->unsignedInteger('quantity')->default(1)->after('issued_to');
                }

                if (! Schema::hasColumn('inventory_item_issues', 'issue_date')) {
                    $table->date('issue_date')->nullable()->after('quantity');
                }

                if (! Schema::hasColumn('inventory_item_issues', 'return_date')) {
                    $table->date('return_date')->nullable()->after('issue_date');
                }

                if (! Schema::hasColumn('inventory_item_issues', 'status')) {
                    $table->string('status')->default('issued')->after('return_date');
                }

                if (! Schema::hasColumn('inventory_item_issues', 'note')) {
                    $table->text('note')->nullable()->after('status');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
