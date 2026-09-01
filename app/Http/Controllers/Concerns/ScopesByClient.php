<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Client;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

/**
 * Isolates the brand (app) panel to the signed-in user's own client/brand.
 *
 * Super admins get full, cross-brand access. Brand admins / staff users who are
 * assigned a `client_id` only ever see their own brand's clients and locations —
 * so a freshly-created brand never inherits the shared seed data of another brand.
 */
trait ScopesByClient
{
    /**
     * The single client/brand currently in scope for the signed-in user.
     * Returns null for super admins (full access) and for unassigned users.
     */
    protected function scopeClient(): ?Client
    {
        $user = Auth::user();

        if (! $user || $user->isSuperAdmin() || empty($user->client_id)) {
            return null;
        }

        return Client::find($user->client_id);
    }

    /**
     * Clients the signed-in user is allowed to manage. Super admins see every
     * brand; everyone else sees only their own (or nothing if unassigned).
     */
    protected function scopedClients()
    {
        $client = $this->scopeClient();

        if ($client) {
            return Client::with('locations')->where('id', $client->id)->get();
        }

        if (Auth::check() && Auth::user()->isSuperAdmin()) {
            return Client::with('locations')->orderBy('name')->get();
        }

        return collect();
    }

    /**
     * All locations visible to the signed-in user (within their brand).
     */
    protected function scopedAllLocations()
    {
        $client = $this->scopeClient();

        if ($client) {
            return $client->locations()->get();
        }

        if (Auth::check() && Auth::user()->isSuperAdmin()) {
            return Location::all();
        }

        return collect();
    }

    /**
     * A fresh Location query already restricted to the signed-in user's scope.
     */
    protected function scopedLocationQuery()
    {
        $query = Location::query();
        $client = $this->scopeClient();

        if ($client) {
            return $query->where('client_id', $client->id);
        }

        if (Auth::check() && Auth::user()->isSuperAdmin()) {
            return $query;
        }

        // Unassigned users see no locations (they aren't tied to a brand yet).
        return $query->whereRaw('1 = 0');
    }

    /**
     * Normalize a requested `location_id` filter so users can only ever filter
     * inside their own scope. Anything outside scope falls back to 'all'.
     */
    protected function resolveLocationFilter(?string $selectedLocationId, $scopedClients)
    {
        if ($selectedLocationId === null || $selectedLocationId === '' || $selectedLocationId === 'all') {
            return 'all';
        }

        if (str_starts_with($selectedLocationId, 'client-')) {
            $clientId = (int) substr($selectedLocationId, 7);
            return $scopedClients->contains('id', $clientId) ? $selectedLocationId : 'all';
        }

        if (is_numeric($selectedLocationId)) {
            $allowedIds = $this->scopedAllLocations()->pluck('id')->all();

            return in_array((int) $selectedLocationId, $allowedIds, true) ? $selectedLocationId : 'all';
        }

        return 'all';
    }
}
