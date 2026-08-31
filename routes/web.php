<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\SearchConsoleController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Marketing Website Pages
Route::get('/', [MarketingController::class, 'index'])->name('home');
Route::get('/features', [MarketingController::class, 'features'])->name('features');
Route::get('/white-label-agency', [MarketingController::class, 'whiteLabelAgency'])->name('white-label-agency');
Route::get('/industry-multi-location', [MarketingController::class, 'multiLocation'])->name('industry-multi-location');
Route::get('/google-reviews-management', [MarketingController::class, 'reviewsManagement'])->name('reviews-management');
Route::get('/google-business-profile-posts', [MarketingController::class, 'postsManagement'])->name('posts-management');

// 2. Free Interactive SEO Tools
Route::get('/google-business-profile-audit-tool', [ToolsController::class, 'auditTool'])->name('tools.audit');
Route::get('/google-review-link', [ToolsController::class, 'reviewLink'])->name('tools.review-link');
Route::get('/google-review-qr-code', [ToolsController::class, 'reviewQrCode'])->name('tools.review-qr');
Route::get('/google-review-card', [ToolsController::class, 'reviewCard'])->name('tools.review-card');
Route::get('/google-business-profile-photo-size', [ToolsController::class, 'photoSizeGuide'])->name('tools.photo-size');

// 3. SaaS Web Application (`app.ampli5pulse.com`)
Route::prefix('app')->name('app.')->group(function () {
    Route::get('/', function() {
        return redirect()->route('app.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
    Route::post('/reviews/ai-reply', [ReviewController::class, 'generateAiReply'])->name('reviews.ai-reply');
    Route::post('/reviews/{id}/reply', [ReviewController::class, 'storeReply'])->name('reviews.store-reply');
    Route::post('/reviews/bulk-ai-reply', [ReviewController::class, 'bulkAiReply'])->name('reviews.bulk-ai');

    // Posts
    Route::get('/posts', [PostController::class, 'index'])->name('posts');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/ai-caption', [PostController::class, 'generateAiCaption'])->name('posts.ai-caption');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Insights & Search Console
    Route::get('/insights', [InsightController::class, 'index'])->name('insights');
    Route::get('/search-console', [SearchConsoleController::class, 'index'])->name('search-console');

    // Media
    Route::get('/media', [MediaController::class, 'index'])->name('media');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');

    // Team, Connect, Settings
    Route::get('/team', [TeamController::class, 'index'])->name('team');
    Route::post('/team', [TeamController::class, 'store'])->name('team.store');

    Route::get('/connect', [ConnectController::class, 'index'])->name('connect');
    Route::post('/connect', [ConnectController::class, 'connectAccount'])->name('connect.store');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
