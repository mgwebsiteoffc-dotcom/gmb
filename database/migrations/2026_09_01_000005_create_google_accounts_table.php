<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Stores OAuth 2.0 tokens for a connected Google Business Profile account.
     * Multiple /accounts resource names (one per Google business account) can
     * share the same OAuth grant, so we keep both the grant and the account.
     */
    public function up(): void
    {
        Schema::create('google_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_name')->unique();       // resource name e.g. accounts/1234567890
            $table->string('display_name')->nullable();     // human label for the account
            $table->string('type')->default('LOCATION_GROUP');
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->integer('expires_in')->default(3600);
            $table->timestamp('token_expires_at')->nullable();
            $table->string('status')->default('connected'); // connected, pending, expired, revoked
            $table->unsignedBigInteger('location_count')->default(0);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_accounts');
    }
};
