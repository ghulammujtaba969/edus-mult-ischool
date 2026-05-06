<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('short_name')->nullable()->after('name');
            $table->string('registration_number')->nullable()->unique()->after('slug');
            $table->unsignedSmallInteger('established_year')->nullable()->after('registration_number');
            $table->text('description')->nullable()->after('logo');
            $table->string('country')->nullable()->after('description');
            $table->string('province')->nullable()->after('country');
            $table->string('city')->nullable()->after('province');
            $table->string('address')->nullable()->after('city');
            $table->string('official_email')->nullable()->after('address');
            $table->string('phone')->nullable()->after('official_email');
            $table->string('website')->nullable()->after('phone');
            $table->string('custom_subdomain')->nullable()->after('website');
            $table->string('whatsapp')->nullable()->after('custom_subdomain');
            $table->string('twitter')->nullable()->after('whatsapp');
            $table->string('facebook')->nullable()->after('twitter');
            $table->string('billing_cycle')->default('monthly')->after('trial_ends_at');
            $table->unsignedSmallInteger('trial_days')->default(0)->after('billing_cycle');
            $table->unsignedInteger('max_students')->nullable()->after('trial_days');
            $table->unsignedInteger('max_teachers')->nullable()->after('max_students');
            $table->unsignedInteger('storage_gb')->nullable()->after('max_teachers');
            $table->decimal('custom_mrr', 12, 2)->nullable()->after('storage_gb');
            $table->json('tags')->nullable()->after('custom_mrr');
            $table->json('feature_toggles')->nullable()->after('tags');
            $table->text('internal_notes')->nullable()->after('feature_toggles');
            $table->foreignId('account_manager_id')->nullable()->after('internal_notes')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropConstrainedForeignId('account_manager_id');
            $table->dropColumn([
                'short_name',
                'registration_number',
                'established_year',
                'description',
                'country',
                'province',
                'city',
                'address',
                'official_email',
                'phone',
                'website',
                'custom_subdomain',
                'whatsapp',
                'twitter',
                'facebook',
                'billing_cycle',
                'trial_days',
                'max_students',
                'max_teachers',
                'storage_gb',
                'custom_mrr',
                'tags',
                'feature_toggles',
                'internal_notes',
            ]);
        });
    }
};
