<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // SaaS roles: super_admin (platform owner), brand_admin (client/brand admin), user (staff/member)
            $table->string('role')->default('user')->after('password');
            // Which client/brand this admin manages (nullable for super admins / platform-level users)
            $table->foreignId('client_id')->nullable()->after('role')->constrained()->nullOnDelete();
            // Whether the account can sign in
            $table->boolean('is_active')->default(true)->after('client_id');
            // Optional avatar / photo URL
            $table->string('avatar')->nullable()->after('is_active');
            // Stripe / billing plan for SaaS owner tracking
            $table->string('plan')->default('free')->after('avatar');
            $table->index('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropForeign(['client_id']);
            $table->dropColumn(['role', 'client_id', 'is_active', 'avatar', 'plan']);
        });
    }
};
