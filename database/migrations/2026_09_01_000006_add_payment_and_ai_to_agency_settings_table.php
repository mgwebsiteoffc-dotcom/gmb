<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Extends the single agency_settings row with the payment-gateway and AI
     * configuration that the brand/agency uses for its clients, and that the
     * Super Admin manages from the marketing-site Platform Settings page.
     */
    public function up(): void
    {
        Schema::table('agency_settings', function (Blueprint $table) {
            // Payment gateway configuration
            $table->string('payment_provider')->default('stripe');       // stripe | razorpay | paypal | offline
            $table->string('payment_mode')->default('test');             // test | live
            $table->string('payment_currency')->default('USD');
            $table->string('payment_public_key')->nullable();
            $table->text('payment_secret_key')->nullable();
            $table->decimal('plan_monthly_price', 10, 2)->default(0.00); // per-brand base plan
            $table->decimal('plan_per_location_price', 10, 2)->default(5.00);
            $table->integer('plan_trial_days')->default(14);
            $table->boolean('payment_enabled')->default(true);

            // AI / OpenRouter configuration
            $table->string('ai_provider')->default('openrouter');
            $table->string('ai_api_key')->nullable();                     // OpenRouter key (secret)
            $table->boolean('ai_reasoning')->default(true);
            $table->decimal('ai_temperature', 3, 2)->default(0.50);
            $table->integer('ai_max_tokens')->default(1024);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agency_settings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_provider', 'payment_mode', 'payment_currency',
                'payment_public_key', 'payment_secret_key', 'plan_monthly_price',
                'plan_per_location_price', 'plan_trial_days', 'payment_enabled',
                'ai_provider', 'ai_api_key', 'ai_reasoning', 'ai_temperature', 'ai_max_tokens',
            ]);
        });
    }
};
