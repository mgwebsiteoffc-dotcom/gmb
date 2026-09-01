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
use App\Http\Controllers\SeoController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\SeoGuidelineController as AdminSeoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 0. SEO / Sitemap / Robots
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');

// 1. Marketing Website Pages
Route::get('/', [MarketingController::class, 'index'])->name('home');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/pricing', [MarketingController::class, 'pricing'])->name('pricing');
Route::get('/location/{slug}', [MarketingController::class, 'location'])->name('location.show');

// 1a. Blog (publicly viewable, managed in Super Admin)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

// 1b. Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
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
Route::get('/google-review-character-limit', [ToolsController::class, 'characterCounter'])->name('tools.character-counter');
Route::get('/local-seo-keywords-checklist', [ToolsController::class, 'localSeoChecklist'])->name('tools.local-seo');
Route::get('/google-business-profile-description-writer', [ToolsController::class, 'descriptionWriter'])->name('tools.description-writer');
Route::post('/google-business-profile-description-writer/ai', [ToolsController::class, 'generateDescription'])->name('tools.description-writer.ai');

// 3. SaaS Web Application (`app.untab.com`)
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
    Route::get('/connect/google', [ConnectController::class, 'redirectToGoogle'])->name('connect.google');
    Route::get('/connect/google/callback', [ConnectController::class, 'handleGoogleCallback'])->name('connect.google.callback');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// 4. Super Admin / SaaS Owner Panel (`untab.com/admin`)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users (super admins, brand admins, staff)
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Clients / Brands
    Route::get('/clients', [AdminClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [AdminClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [AdminClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}', [AdminClientController::class, 'show'])->name('clients.show');
    Route::get('/clients/{client}/edit', [AdminClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [AdminClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [AdminClientController::class, 'destroy'])->name('clients.destroy');

    // Blog management
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [AdminBlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{blog}/edit', [AdminBlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [AdminBlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('blogs.destroy');

    // FAQ management
    Route::get('/faqs', [AdminFaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/create', [AdminFaqController::class, 'create'])->name('faqs.create');
    Route::post('/faqs', [AdminFaqController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/{faq}/edit', [AdminFaqController::class, 'edit'])->name('faqs.edit');
    Route::put('/faqs/{faq}', [AdminFaqController::class, 'update'])->name('faqs.update');
    Route::patch('/faqs/{faq}/toggle-active', [AdminFaqController::class, 'toggleActive'])->name('faqs.toggle-active');
    Route::delete('/faqs/{faq}', [AdminFaqController::class, 'destroy'])->name('faqs.destroy');

    // SEO guidelines management
    Route::get('/seo', [AdminSeoController::class, 'index'])->name('seo.index');
    Route::get('/seo/create', [AdminSeoController::class, 'create'])->name('seo.create');
    Route::post('/seo', [AdminSeoController::class, 'store'])->name('seo.store');
    Route::get('/seo/{guideline}/edit', [AdminSeoController::class, 'edit'])->name('seo.edit');
    Route::put('/seo/{guideline}', [AdminSeoController::class, 'update'])->name('seo.update');
    Route::delete('/seo/{guideline}', [AdminSeoController::class, 'destroy'])->name('seo.destroy');

    // Platform settings
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
});
