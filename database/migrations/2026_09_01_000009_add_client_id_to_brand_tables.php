<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Per-brand scoping for the remaining shared tables so one brand never sees
     * another brand's Search Console data or connected Google accounts.
     * `client_id = null` rows are the platform/global (Super Admin) rows.
     */
    public function up(): void
    {
        foreach (['search_queries', 'search_pages', 'google_accounts'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->foreignId('client_id')->nullable()->after('id')->constrained('clients')->nullOnDelete();
                $t->index('client_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['search_queries', 'search_pages', 'google_accounts'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropForeign(['client_id']);
                $t->dropIndex(['client_id']);
                $t->dropColumn('client_id');
            });
        }
    }
};
