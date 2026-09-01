<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\ScopesByClient;
use App\Models\Client;
use App\Models\Location;
use App\Models\GoogleAccount;
use App\Services\GoogleBusinessService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ConnectController extends Controller
{
    use ScopesByClient;

    /**
     * The Connect page: linked Google accounts, client portfolios, and a
     * real "Connect with Google" entry point (OAuth) when configured.
     */
    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $clients = $this->scopedClients();
        $allLocations = $this->scopedAllLocations();
        $selectedLocationId = $this->resolveLocationFilter($selectedLocationId, $clients);

        $accountsQuery = GoogleAccount::query();
        if ($this->seesAllBrands()) {
            // Super admin sees every connected account.
        } elseif ($accountClientId = $this->scopeClientId()) {
            $accountsQuery->where('client_id', $accountClientId);
        } else {
            $accountsQuery->whereRaw('1 = 0');
        }
        $googleAccounts = $accountsQuery->orderBy('display_name')->get();
        $googleConfigured = GoogleBusinessService::configured();

        return view('app.connect', compact(
            'clients',
            'allLocations',
            'selectedLocationId',
            'googleAccounts',
            'googleConfigured'
        ));
    }

    /**
     * Kick off the Google OAuth 2.0 authorization-code flow.
     */
    public function redirectToGoogle()
    {
        if (! GoogleBusinessService::configured()) {
            return back()->with('error', 'Google is not connected. Add GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET to your .env file, then run: php artisan config:clear');
        }

        $service = new GoogleBusinessService();
        $state = GoogleBusinessService::stateToken();
        session(['google_oauth_state' => $state]);

        return redirect()->away($service->authorizationUrl($state, true));
    }

    /**
     * Handle the Google OAuth callback: exchange the code, import accounts +
     * their locations, and refresh the Connect page.
     */
    public function handleGoogleCallback(Request $request)
    {
        if ($request->has('error') || ! $request->has('code')) {
            return redirect()->route('app.connect')->with('error', 'Google authorization was cancelled or failed.');
        }

        if (! $request->filled('state') || ! hash_equals((string) session('google_oauth_state'), (string) $request->input('state'))) {
            return redirect()->route('app.connect')->with('error', 'Authorization state mismatch. Please try again.');
        }

        session()->forget('google_oauth_state');

        $service = new GoogleBusinessService();

        try {
            $tokens = $service->fetchTokens($request->input('code'));
        } catch (\Throwable $e) {
            return redirect()->route('app.connect')->with('error', $e->getMessage());
        }

        $accessToken = $tokens['access_token'];
        $accounts = $service->fetchAccounts($accessToken);

        if (empty($accounts)) {
            return redirect()->route('app.connect')->with('error', 'No Google Business Profile accounts were found for this user.');
        }

        $imported = 0;

        foreach ($accounts as $account) {
            $locations = $service->fetchLocations($accessToken, $account['name']);

            $acct = GoogleAccount::updateOrCreate(
                ['account_name' => $account['name']],
                [
                    'client_id' => $this->scopeClientId(),
                    'display_name' => $account['displayName'],
                    'type' => $account['type'],
                    'access_token' => $accessToken,
                    'refresh_token' => $tokens['refresh_token'] ?? null,
                    'expires_in' => (int) ($tokens['expires_in'] ?? 3600),
                    'token_expires_at' => now()->addSeconds((int) ($tokens['expires_in'] ?? 3600)),
                    'status' => 'connected',
                    'location_count' => count($locations),
                    'last_synced_at' => now(),
                ]
            );

            // Import each verified location, grouping into a client portfolio
            // keyed by the account display name.
            $client = Client::firstOrCreate(
                ['name' => $account['displayName']],
                [
                    'category' => 'Google Business Profile',
                    'logo' => '🏢',
                    'color' => '#1a35c8',
                    'account_manager' => auth()->user()->name ?? 'Primary Manager',
                    'monthly_retainer' => '$1,500/mo',
                    'active_since' => now()->format('M Y'),
                ]
            );

            foreach ($locations as $loc) {
                if (empty($loc['name'])) {
                    continue;
                }

                $placeId = $loc['placeId'] ?? $loc['metadata']['placeId'] ?? null;
                $name = $loc['locationName'] ?? $this->titled($loc['name']);

                Location::updateOrCreate(
                    ['place_id' => $placeId ?: Str::slug($name)],
                    [
                        'client_id' => $client->id,
                        'name' => $name,
                        'address' => $this->address($loc),
                        'phone' => $loc['primaryPhone'] ?? ($loc['phoneNumbers'] ?? null),
                        'category' => $this->primaryCategory($loc),
                        'verified' => (bool) ($loc['metadata']['verified'] ?? true),
                        'rating' => (float) ($loc['rating'] ?? 4.8),
                        'review_count' => (int) ($loc['totalRatingCount'] ?? 0),
                        'unanswered_reviews' => 0,
                        'health_score' => 90,
                        'monthly_views' => 0,
                        'monthly_calls' => 0,
                        'monthly_directions' => 0,
                        'monthly_website_clicks' => 0,
                        'sync_status' => 'synced',
                        'primary_manager' => $placeId ? 'Google Sync' : 'Imported',
                    ]
                );

                $imported++;
            }
        }

        return redirect()->route('app.connect')->with('success', "Linked Google Business Profile and imported {$imported} location(s).");
    }

    /**
     * Manual connect fallback (used when Google OAuth is not configured). Keeps
     * the demo fully working offline.
     */
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

    /**
     * Build a short human address from the Google location payload.
     */
    private function address(array $loc): string
    {
        $a = $loc['address'] ?? [];
        $parts = [
            $a['line1'] ?? null,
            $a['line2'] ?? null,
            $a['city'] ?? null,
            $a['region'] ?? null,
            $a['postalCode'] ?? null,
            'US',
        ];
        return implode(', ', array_filter($parts));
    }

    /**
     * Resolve the primary category name from the Google location payload.
     */
    private function primaryCategory(array $loc): string
    {
        if (! empty($loc['primaryCategory'])) {
            return $loc['primaryCategory']['displayName'] ?? 'Local Business';
        }
        if (! empty($loc['categories'][0]['displayName'])) {
            return $loc['categories'][0]['displayName'];
        }
        return 'Local Business';
    }

    /**
     * Title-case a resource name like "locations/1234567890".
     */
    private function titled(string $name): string
    {
        $base = strpos($name, '/') !== false ? substr($name, strrpos($name, '/') + 1) : $name;
        return 'Location '.$base;
    }
}
