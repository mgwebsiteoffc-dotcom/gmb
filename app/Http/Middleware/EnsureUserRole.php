<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Guard a route by the authenticated user's role.
     *
     * Usage: ->middleware('role:super_admin')        (one role)
     *        ->middleware('role:super_admin,brand_admin') (any of these roles)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isActive()) {
            abort(403, 'Your account is inactive. Please contact your administrator.');
        }

        if (! $user->hasRole($roles)) {
            abort(403, 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}
