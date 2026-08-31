<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Location;
use App\Models\Review;
use App\Models\SearchQuery;
use App\Models\AgencySetting;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $clients = Client::with('locations')->get();
        $allLocations = Location::all();
        $settings = AgencySetting::first();

        $selectedClient = $clients->first();
        $locations = $selectedClient ? $selectedClient->locations : $allLocations;

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
