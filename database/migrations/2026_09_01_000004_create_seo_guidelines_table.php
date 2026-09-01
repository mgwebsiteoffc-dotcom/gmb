<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_guidelines', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('page_path')->nullable();   // e.g. /blog, /pricing
            $table->string('page_type')->default('General'); // Home, Blog, Pricing, Location, FAQ
            $table->text('description')->nullable();
            $table->text('content')->nullable();       // the actual guideline / checklist
            $table->json('recommended_keywords')->nullable();
            $table->string('seo_title_template')->nullable();
            $table->string('meta_description_template')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index('is_active');
            $table->index('page_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_guidelines');
    }
};
