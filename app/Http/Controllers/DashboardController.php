<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Location;
use App\Models\Review;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $clients = Client::with('locations')->get();
        $allLocations = Location::all();

        $locationsQuery = Location::query();
        if ($selectedLocationId !== 'all') {
            if (str_starts_with($selectedLocationId, 'client-')) {
                $clientId = (int) str_replace('client-', '', $selectedLocationId);
                $locationsQuery->where('client_id', $clientId);
            } else {
                $locationsQuery->where('id', $selectedLocationId);
            }
        }
        $locations = $locationsQuery->get();

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
            ->where('status', 'unanswered')
            ->latest()
            ->take(3)
            ->get();

        $recentPosts = Post::latest()->take(3)->get();

        return view('app.dashboard', compact(
            'clients',
            'allLocations',
            'locations',
            'selectedLocationId',
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
