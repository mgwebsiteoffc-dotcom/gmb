<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Each brand/client gets its own agency (white-label, payment & AI)
     * settings so one brand never inherits another brand's configuration.
     * A null `client_id` row holds the marketing-site / Super Admin global
     * defaults, as before.
     */
    public function up(): void
    {
        Schema::table('agency_settings', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->after('id')->constrained('clients')->nullOnDelete();
            $table->index('client_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agency_settings', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropIndex(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};
