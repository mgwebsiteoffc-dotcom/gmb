<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\ScopesByClient;
use App\Models\TeamMember;

class TeamController extends Controller
{
    use ScopesByClient;

    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $clients = $this->scopedClients();
        $allLocations = $this->scopedAllLocations();
        $selectedLocationId = $this->resolveLocationFilter($selectedLocationId, $clients);
        $team = TeamMember::all();

        return view('app.team', compact(
            'clients',
            'allLocations',
            'selectedLocationId',
            'team'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:team_members,email',
            'role' => 'required|string',
        ]);

        TeamMember::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'assigned_clients' => $request->input('assigned_clients', []),
            'permissions' => [
                'posts' => $request->has('perm_posts'),
                'reviews' => $request->has('perm_reviews'),
                'media' => $request->has('perm_media'),
                'reports' => $request->has('perm_reports'),
                'settings' => $request->has('perm_settings'),
            ],
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
            'status' => 'Active'
        ]);

        return back()->with('success', 'New team member invited with role-based permissions!');
    }
}
