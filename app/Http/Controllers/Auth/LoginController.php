<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Fail-safe: if the `is_active` column isn't present (migration not
            // yet run), defaults to active so login never throws.
            if (! $user->isActive()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => __('This account has been deactivated. Please contact support.'),
                ])->onlyInput('email');
            }

            // SaaS owners go to the Super Admin panel; everyone else to the app.
            // isSuperAdmin() reads `role`; if the column is absent it is null and
            // resolves to false, so we safely fall through to the normal app.
            if ($user->isSuperAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            // A brand with no locations yet is new: send them through onboarding
            // (connect a Google account, add a location, publish a post, etc.)
            $locationCount = $user->client_id
                ? Location::where('client_id', $user->client_id)->count()
                : 0;

            if ($locationCount === 0) {
                return redirect()->route('app.onboarding');
            }

            return redirect()->intended(route('app.dashboard'));
        }

        return back()->withErrors([
            'email' => __('The provided credentials do not match our records.'),
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
