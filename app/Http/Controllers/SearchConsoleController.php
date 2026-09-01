<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\ScopesByClient;
use App\Models\SearchQuery;
use App\Models\SearchPage;

class SearchConsoleController extends Controller
{
    use ScopesByClient;

    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $tab = $request->get('tab', 'queries');
        $search = $request->get('search', '');

        $clients = $this->scopedClients();
        $allLocations = $this->scopedAllLocations();
        $selectedLocationId = $this->resolveLocationFilter($selectedLocationId, $clients);

        $queriesQuery = SearchQuery::query();
        if (!empty($search)) {
            $queriesQuery->where('query', 'like', "%{$search}%");
        }
        $queries = $queriesQuery->orderBy('clicks', 'desc')->get();

        $pages = SearchPage::orderBy('clicks', 'desc')->get();

        $totalClicks = $queries->sum('clicks');
        $totalImpressions = $queries->sum('impressions');

        $devices = [
            ['name' => 'Mobile', 'share' => '74.2%', 'clicks' => 18312, 'impressions' => 360000],
            ['name' => 'Desktop', 'share' => '22.8%', 'clicks' => 5627, 'impressions' => 110600],
            ['name' => 'Tablet', 'share' => '3.0%', 'clicks' => 741, 'impressions' => 14600],
        ];

        return view('app.search-console', compact(
            'clients',
            'allLocations',
            'selectedLocationId',
            'tab',
            'search',
            'queries',
            'pages',
            'totalClicks',
            'totalImpressions',
            'devices'
        ));
    }
}
