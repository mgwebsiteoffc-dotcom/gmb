<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->string('logo')->default('🏢');
            $table->string('color')->default('#2563eb');
            $table->string('account_manager')->nullable();
            $table->string('monthly_retainer')->default('$1,500/mo');
            $table->string('active_since')->nullable();
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('category');
            $table->boolean('verified')->default(true);
            $table->decimal('rating', 2, 1)->default(4.8);
            $table->integer('review_count')->default(0);
            $table->integer('unanswered_reviews')->default(0);
            $table->integer('health_score')->default(95);
            $table->integer('monthly_views')->default(0);
            $table->integer('monthly_calls')->default(0);
            $table->integer('monthly_directions')->default(0);
            $table->integer('monthly_website_clicks')->default(0);
            $table->string('sync_status')->default('synced');
            $table->string('place_id')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('primary_manager')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('author_name');
            $table->string('author_photo')->nullable();
            $table->integer('rating')->default(5);
            $table->string('date_text')->default('Recently');
            $table->text('snippet');
            $table->string('sentiment')->default('positive'); // positive, neutral, negative
            $table->string('status')->default('unanswered'); // unanswered, replied
            $table->text('reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->json('keywords')->nullable();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('WHATS_NEW'); // WHATS_NEW, OFFER, EVENT
            $table->json('target_locations')->nullable();
            $table->string('target_location_names')->default('All Locations');
            $table->text('content');
            $table->string('coupon_code')->nullable();
            $table->string('terms')->nullable();
            $table->string('event_start')->nullable();
            $table->string('event_end')->nullable();
            $table->string('cta_type')->default('LEARN_MORE'); // BOOK, ORDER, BUY, LEARN_MORE, SIGN_UP, CALL_NOW
            $table->string('cta_url')->nullable();
            $table->string('media_url')->nullable();
            $table->string('status')->default('PUBLISHED'); // PUBLISHED, SCHEDULED, DRAFT
            $table->string('publish_date')->nullable();
            $table->integer('views')->default(0);
            $table->integer('clicks')->default(0);
            $table->timestamps();
        });

        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('category')->default('Interior'); // Interior, Exterior, Team & Staff, Food / Product, Cover
            $table->string('url');
            $table->string('geotag')->nullable();
            $table->string('alt_text')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });

        Schema::create('search_queries', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->integer('clicks')->default(0);
            $table->integer('impressions')->default(0);
            $table->string('ctr')->default('5.0%');
            $table->decimal('position', 3, 1)->default(1.5);
            $table->timestamps();
        });

        Schema::create('search_pages', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->integer('clicks')->default(0);
            $table->integer('impressions')->default(0);
            $table->string('ctr')->default('5.0%');
            $table->decimal('position', 3, 1)->default(1.5);
            $table->timestamps();
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->default('Local SEO Specialist');
            $table->json('assigned_clients')->nullable();
            $table->json('permissions')->nullable();
            $table->string('avatar')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        Schema::create('agency_settings', function (Blueprint $table) {
            $table->id();
            $table->string('agency_name')->default('Untab Local Growth Agency');
            $table->string('custom_domain')->default('clients.untab.com');
            $table->string('brand_color')->default('#1a35c8');
            $table->string('support_email')->default('support@agency.com');
            $table->string('ai_model')->default('gpt-4o-mini');
            $table->boolean('email_alerts')->default(true);
            $table->boolean('sms_alerts')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agency_settings');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('search_pages');
        Schema::dropIfExists('search_queries');
        Schema::dropIfExists('media_items');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('clients');
    }
};
