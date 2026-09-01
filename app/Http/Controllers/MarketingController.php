<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Location;

class MarketingController extends Controller
{
    public function index()
    {
        // Fail-safe: the marketing site must render even before the DB is seeded.
        $locationsCount = $this->safeCount(Location::class);
        $clientsCount = $this->safeCount(Client::class);
        return view('marketing.home', compact('locationsCount', 'clientsCount'));
    }

    public function features()
    {
        return view('marketing.features');
    }

    public function whiteLabelAgency()
    {
        return view('marketing.white-label-agency');
    }

    public function multiLocation()
    {
        return view('marketing.industry-multi-location');
    }

    public function reviewsManagement()
    {
        return view('marketing.reviews-management');
    }

    public function postsManagement()
    {
        return view('marketing.posts-management');
    }

    public function pricing()
    {
        return view('marketing.pricing');
    }

    /**
     * The "What we offer / how this helps" details page, reachable only
     * through a "demo" CTA. Bundles SEO + AEO (FAQ, HowTo, Breadcrumb,
     * SoftwareApplication) structured data.
     */
    public function demo()
    {
        return view('marketing.demo');
    }

    public function location($slug)
    {
        $location = Location::with('client', 'reviews')
            ->get()
            ->first(function ($loc) use ($slug) {
                return Str::slug($loc->name) === $slug;
            });

        if (! $location) {
            abort(404);
        }

        return view('marketing.location', compact('location'));
    }

    /**
     * Return a row count, or 0 if the model's table doesn't exist yet,
     * so the marketing pages never fatal on a fresh (pre-migrate) install.
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
