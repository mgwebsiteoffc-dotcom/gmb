<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Location;

class InsightController extends Controller
{
    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $dateRange = $request->get('range', '30d');

        $clients = Client::with('locations')->get();
        $allLocations = Location::all();

        $query = Location::query();
        if ($selectedLocationId !== 'all') {
            if (str_starts_with($selectedLocationId, 'client-')) {
                $clientId = (int) str_replace('client-', '', $selectedLocationId);
                $query->where('client_id', $clientId);
            } else {
                $query->where('id', $selectedLocationId);
            }
        }
        $locations = $query->get();

        $totalViews = $locations->sum('monthly_views');
        $totalCalls = $locations->sum('monthly_calls');
        $totalDirections = $locations->sum('monthly_directions');
        $totalClicks = $locations->sum('monthly_website_clicks');

        // Chart Data calculations
        $mapsViews = (int)($totalViews * 0.65);
        $searchViews = (int)($totalViews * 0.35);

        return view('app.insights', compact(
            'clients',
            'allLocations',
            'locations',
            'selectedLocationId',
            'dateRange',
            'totalViews',
            'totalCalls',
            'totalDirections',
            'totalClicks',
            'mapsViews',
            'searchViews'
        ));
    }
}
