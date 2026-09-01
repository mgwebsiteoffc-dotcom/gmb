<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class EnsureInstalled
{
    /**
     * If the database has not been migrated yet, show a friendly setup screen
     * instead of crashing the exception renderer (which needs framework assets
     * that may also be missing).
     *
     * Skips asset/webhook-style routes so it never blocks static files or CSRF.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        $routeName = $request->route()?->getName();

        // Never block static assets, tools, sitemap, robots, or the health route.
        if ($path === 'up'
            || $path === 'sitemap.xml'
            || $path === 'robots.txt'
            || str_starts_with($path, 'vendor/')
            || str_starts_with($path, 'storage/')
            || str_starts_with($path, 'build/')) {
            return $next($request);
        }

        // Public marketing, tools, auth and SEO pages render without the DB
        // (their controllers are fail-safe). Only guard routes that actually
        // need the database (app.* and admin.*).
        $publicPrefixes = ['tools.', 'reviews-management', 'posts-management', 'white-label-agency',
            'industry-multi-location', 'features', 'home', 'pricing', 'location.show',
            'faq', 'blog.index', 'blog.show', 'seo.sitemap', 'seo.robots', 'login', 'register'];
        if ($routeName && in_array($routeName, $publicPrefixes, true)) {
            return $next($request);
        }

        try {
            $hasUsers = Schema::hasTable('users');
        } catch (\Throwable $e) {
            // A DB connection failure (e.g. missing sqlite file) also means we
            // aren't usable yet — show the setup screen rather than crash.
            $hasUsers = false;
        }

        if (! $hasUsers) {
            return response()->view('partials.setup-needed', [], 503);
        }

        return $next($request);
    }
}
