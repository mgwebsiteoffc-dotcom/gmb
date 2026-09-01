<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Concerns\ScopesByClient;
use App\Models\AgencySetting;
use App\Models\SearchQuery;

class ReportController extends Controller
{
    use ScopesByClient;

    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $clients = $this->scopedClients();
        $allLocations = $this->scopedAllLocations();
        $selectedLocationId = $this->resolveLocationFilter($selectedLocationId, $clients);

        $client = $this->scopeClient();
        $settings = AgencySetting::workspace($client?->id);

        $selectedClient = $clients->first();
        $locations = $selectedClient && $selectedClient->relationLoaded('locations')
            ? $selectedClient->locations
            : $allLocations;

        $totalViews = $locations->sum('monthly_views');
        $totalCalls = $locations->sum('monthly_calls');
        $totalDirections = $locations->sum('monthly_directions');
        $totalClicks = $locations->sum('monthly_website_clicks');
        $totalReviews = $locations->sum('review_count');

        $topQueries = SearchQuery::orderBy('clicks', 'desc')->take(4)->get();

        return view('app.reports', compact(
            'clients',
            'allLocations',
            'selectedLocationId',
            'selectedClient',
            'settings',
            'totalViews',
            'totalCalls',
            'totalDirections',
            'totalClicks',
            'totalReviews',
            'topQueries'
        ));
    }
}
