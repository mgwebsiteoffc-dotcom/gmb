<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds brand/client onboarding details: uploadable logo (with emoji
     * fallback), mobile number, point-of-contact (POC) info, and an onboard
     * date (calendar) — filled in when a brand is onboarded.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('logo_url')->nullable();           // uploaded logo (emoji `logo` is the fallback)
            $table->string('mobile')->nullable();             // brand primary mobile number
            $table->string('poc_name')->nullable();           // point of contact name
            $table->string('poc_email')->nullable();          // point of contact email
            $table->string('poc_mobile')->nullable();         // point of contact mobile number
            $table->date('onboarded_at')->nullable();         // brand onboard date (calendar)
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['logo_url', 'mobile', 'poc_name', 'poc_email', 'poc_mobile', 'onboarded_at']);
        });
    }
};
