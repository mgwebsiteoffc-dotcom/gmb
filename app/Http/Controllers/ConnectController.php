<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Location;

class ConnectController extends Controller
{
    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $clients = Client::with('locations')->get();
        $allLocations = Location::all();

        return view('app.connect', compact(
            'clients',
            'allLocations',
            'selectedLocationId'
        ));
    }

    public function connectAccount(Request $request)
    {
        $clientName = $request->input('client_name');
        $category = $request->input('category', 'Local Business');

        $client = Client::create([
            'name' => $clientName,
            'category' => $category,
            'logo' => '🏢',
            'color' => '#6161ff',
            'account_manager' => 'Primary Manager',
            'monthly_retainer' => '$1,500/mo',
            'active_since' => now()->format('M Y')
        ]);

        Location::create([
            'client_id' => $client->id,
            'name' => "{$clientName} - Primary Store",
            'address' => '700 Main St, Suite 100, Austin, TX',
            'phone' => '(512) 555-0100',
            'category' => $category,
            'verified' => true,
            'rating' => 4.9,
            'review_count' => 120,
            'unanswered_reviews' => 0,
            'health_score' => 96,
            'monthly_views' => 12500,
            'monthly_calls' => 180,
            'monthly_directions' => 290,
            'monthly_website_clicks' => 450,
            'sync_status' => 'synced',
            'place_id' => 'ChIJ_new_connected_place_id',
            'cover_image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=600&q=80',
            'primary_manager' => 'Store Manager'
        ]);

        return back()->with('success', "Google Business Profile for '{$clientName}' successfully linked and synced!");
    }
}
