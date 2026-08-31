<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Location;

class SeoController extends Controller
{
    /**
     * Generate a dynamic XML sitemap for all public marketing, tools, and app routes.
     */
    public function sitemap()
    {
        $baseUrl = rtrim(config('app.url'), '/');

        $staticRoutes = [
            '/' => '1.0',
            '/features' => '0.9',
            '/white-label-agency' => '0.9',
            '/industry-multi-location' => '0.9',
            '/google-reviews-management' => '0.9',
            '/google-business-profile-posts' => '0.9',
            '/faq' => '0.8',
            '/pricing' => '0.8',
            '/google-business-profile-audit-tool' => '0.7',
            '/google-review-link' => '0.7',
            '/google-review-qr-code' => '0.7',
            '/google-review-card' => '0.7',
            '/google-business-profile-photo-size' => '0.7',
        ];

        $urls = collect($staticRoutes)->map(function ($priority, $path) use ($baseUrl) {
            return [
                'loc' => $baseUrl.$path,
                'lastmod' => date('Y-m-d'),
                'priority' => $priority,
                'changefreq' => $path === '/' ? 'daily' : 'monthly',
            ];
        });

        // Add every Google Business Profile location as a local-SEO landing URL.
        $urls = $urls->merge(Location::query()->get()->map(function ($location) use ($baseUrl) {
            return [
                'loc' => $baseUrl.'/location/'.Str::slug($location->name),
                'lastmod' => $location->updated_at ? $location->updated_at->toDateString() : date('Y-m-d'),
                'priority' => '0.6',
                'changefreq' => 'weekly',
            ];
        }));

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Serve a search-engine friendly robots.txt.
     */
    public function robots()
    {
        $content = "User-agent: *\n"
            . "Allow: /\n"
            . "Disallow: /app\n"
            . "Disallow: /storage\n"
            . "Sitemap: " . rtrim(config('app.url'), '/') . "/sitemap.xml\n";

        return response($content)->header('Content-Type', 'text/plain');
    }
}
