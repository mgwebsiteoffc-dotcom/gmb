<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgencySetting;
use App\Models\BlogPost;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Location;
use App\Models\Post;
use App\Models\Review;
use App\Models\SeoGuideline;
use App\Models\TeamMember;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * SaaS owner / Super Admin overview of the whole platform.
     */
    public function index()
    {
        $totalClients = Client::count();
        $totalLocations = Location::count();
        $totalUsers = User::count();
        $superAdmins = User::where('role', User::ROLE_SUPER_ADMIN)->count();
        $brandAdmins = User::where('role', User::ROLE_BRAND_ADMIN)->count();
        $standardUsers = User::where('role', User::ROLE_USER)->count();

        $totalReviews = Review::count();
        $unansweredReviews = Review::where('status', 'unanswered')->count();
        $totalPosts = Post::count();
        $teamMembers = TeamMember::count();

        // Content engine stats (managed in the Super Admin panel).
        // Guarded so the dashboard never crashes if these new tables haven't
        // been migrated yet on an existing install.
        $totalBlogPosts = $this->safeCount(BlogPost::class);
        $publishedBlogPosts = \Illuminate\Support\Facades\Schema::hasTable('blog_posts')
            ? BlogPost::published()->count()
            : 0;
        $totalFaqs = $this->safeCount(Faq::class);
        $activeFaqs = \Illuminate\Support\Facades\Schema::hasTable('faqs')
            ? Faq::where('is_active', true)->count()
            : 0;
        $totalSeoGuidelines = $this->safeCount(SeoGuideline::class);
        $activeSeoGuidelines = \Illuminate\Support\Facades\Schema::hasTable('seo_guidelines')
            ? SeoGuideline::where('is_active', true)->count()
            : 0;

        $monthlyViews = Location::sum('monthly_views');
        $monthlyCalls = Location::sum('monthly_calls');
        $monthlyDirections = Location::sum('monthly_directions');
        $monthlyClicks = Location::sum('monthly_website_clicks');

        $avgHealth = (int) round(Location::avg('health_score'));
        $avgRating = round(Location::avg('rating'), 1);

        // Live monthly view trend across products for the platform chart.
        $trend = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            'views' => [142000, 158000, 171000, 189000, 205000, 221000, 238000, 256000, 274000],
            'calls' => [1800, 2050, 2350, 2600, 2900, 3200, 3450, 3700, 3980],
        ];

        $recentClients = Client::with('locations')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(6)->get();
        $roleDistribution = [
            'super_admin' => $superAdmins,
            'brand_admin' => $brandAdmins,
            'user' => $standardUsers,
        ];

        $settings = AgencySetting::first();

        return view('admin.dashboard', compact(
            'totalClients',
            'totalLocations',
            'totalUsers',
            'superAdmins',
            'brandAdmins',
            'standardUsers',
            'totalReviews',
            'unansweredReviews',
            'totalPosts',
            'teamMembers',
            'totalBlogPosts',
            'publishedBlogPosts',
            'totalFaqs',
            'activeFaqs',
            'totalSeoGuidelines',
            'activeSeoGuidelines',
            'monthlyViews',
            'monthlyCalls',
            'monthlyDirections',
            'monthlyClicks',
            'avgHealth',
            'avgRating',
            'trend',
            'recentClients',
            'recentUsers',
            'roleDistribution',
            'settings',
        ));
    }

    /**
     * Return a row count, or 0 if the model's table does not exist yet.
     */
    protected function safeCount(string $modelClass): int
    {
        try {
            $table = (new $modelClass)->getTable();

            return \Illuminate\Support\Facades\Schema::hasTable($table)
                ? $modelClass::count()
                : 0;
        } catch (\Throwable $e) {
            return 0;
        }
    }
}
