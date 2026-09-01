<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\ScopesByClient;
use App\Models\AgencySetting;
use App\Models\GoogleAccount;
use App\Models\Post;
use App\Models\TeamMember;

class OnboardingController extends Controller
{
    use ScopesByClient;

    /**
     * First-run setup guide for a new brand. Super admins don't onboard, and
     * users with no brand yet are guided to connect their business first.
     */
    public function index(Request $request)
    {
        if (auth()->user()->isSuperAdmin()) {
            return redirect()->route('app.dashboard');
        }

        $clients = $this->scopedClients();
        $allLocations = $this->scopedAllLocations();
        $selectedLocationId = $request->get('location_id', 'all');
        $selectedLocationId = $this->resolveLocationFilter($selectedLocationId, $clients);

        $clientId = $this->scopeClientId();
        $visibleIds = $allLocations->pluck('id')->all();

        // Google account connected?
        $connectedAccounts = $this->seesAllBrands()
            ? GoogleAccount::count()
            : GoogleAccount::where('client_id', $clientId)->count();

        // Locations & posts for this brand.
        $locationCount = $allLocations->count();

        $postCount = Post::where(function ($q) use ($visibleIds) {
            if (! empty($visibleIds)) {
                foreach ($visibleIds as $id) {
                    $q->orWhereJsonContains('target_locations', $id);
                }
            } else {
                $q->whereRaw('1 = 0');
            }
        })->count();

        $teamCount = $this->seesAllBrands()
            ? TeamMember::count()
            : ($clientId ? TeamMember::whereJsonContains('assigned_clients', $clientId)->count() : 0);

        $settings = AgencySetting::workspace($clientId);
        $settingsDone = ! empty($settings->agency_name);

        $steps = [
            ['key' => 'connect',   'label' => 'Connect your Google account', 'desc' => 'Link your Google Business Profile(s) so we can import locations, reviews and insights.', 'done' => $connectedAccounts > 0,         'action' => ['route' => 'app.connect', 'label' => 'Connect Google']],
            ['key' => 'location',  'label' => 'Add your business location',   'desc' => 'Your verified business profiles become the locations you manage in Untab.',        'done' => $locationCount > 0,             'action' => ['route' => 'app.connect', 'label' => 'Add Location']],
            ['key' => 'post',      'label' => 'Publish your first Google Post','desc' => 'Keep profiles active with offers, updates and events across every location.',       'done' => $postCount > 0,                 'action' => ['route' => 'app.posts', 'label' => 'Create Post']],
            ['key' => 'team',      'label' => 'Invite your team',             'desc' => 'Add teammates with role-based access to posts, reviews, media and reports.',         'done' => $teamCount > 0,                 'action' => ['route' => 'app.team', 'label' => 'Invite Team']],
            ['key' => 'settings',  'label' => 'Customize your branding & AI', 'desc' => 'Set your domain, brand color, support email and the AI model behind your workflows.',   'done' => $settingsDone,                  'action' => ['route' => 'app.settings', 'label' => 'Open Settings']],
        ];

        $completed = count(array_filter($steps, fn ($s) => $s['done']));
        $percent = (int) round($completed / count($steps) * 100);

        return view('app.onboarding', compact(
            'clients',
            'allLocations',
            'selectedLocationId',
            'steps',
            'completed',
            'percent'
        ));
    }
}
