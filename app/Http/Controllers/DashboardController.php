<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\ScopesByClient;
use App\Models\Review;
use App\Models\Post;

class DashboardController extends Controller
{
    use ScopesByClient;

    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $clients = $this->scopedClients();
        $allLocations = $this->scopedAllLocations();
        $selectedLocationId = $this->resolveLocationFilter($selectedLocationId, $clients);

        $locationsQuery = $this->scopedLocationQuery();
        if ($selectedLocationId !== 'all') {
            if (str_starts_with($selectedLocationId, 'client-')) {
                $clientId = (int) str_replace('client-', '', $selectedLocationId);
                $locationsQuery->where('client_id', $clientId);
            } else {
                $locationsQuery->where('id', $selectedLocationId);
            }
        }
        $locations = $locationsQuery->get();
        $visibleLocationIds = $locations->pluck('id')->all();

        $totalReviews = $locations->sum('review_count');
        $totalViews = $locations->sum('monthly_views');
        $totalCalls = $locations->sum('monthly_calls');
        $totalDirections = $locations->sum('monthly_directions');
        $totalClicks = $locations->sum('monthly_website_clicks');
        $unansweredCount = $locations->sum('unanswered_reviews');

        $avgRating = $locations->count() > 0
            ? round($locations->avg('rating'), 1)
            : 5.0;

        $pendingReviews = Review::with('location')
            ->whereIn('location_id', $visibleLocationIds)
            ->where('status', 'unanswered')
            ->latest()
            ->take(3)
            ->get();

        $recentPosts = Post::query()
            ->where(function ($q) use ($visibleLocationIds) {
                if (! empty($visibleLocationIds)) {
                    foreach ($visibleLocationIds as $id) {
                        $q->orWhereJsonContains('target_locations', $id);
                    }
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->latest()
            ->take(3)
            ->get();

        // Flag an incomplete (new) brand so the dashboard can nudge onboarding.
        $onboardingIncomplete = ! auth()->user()->isSuperAdmin() && $locations->count() === 0;

        return view('app.dashboard', compact(
            'clients',
            'allLocations',
            'locations',
            'selectedLocationId',
            'onboardingIncomplete',
            'totalReviews',
            'totalViews',
            'totalCalls',
            'totalDirections',
            'totalClicks',
            'unansweredCount',
            'avgRating',
            'pendingReviews',
            'recentPosts'
        ));
    }
}
