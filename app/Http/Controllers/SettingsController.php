<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Concerns\ScopesByClient;
use App\Models\AgencySetting;
use App\Services\OpenRouterService;
use App\Services\GoogleBusinessService;

class SettingsController extends Controller
{
    use ScopesByClient;

    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $clients = $this->scopedClients();
        $allLocations = $this->scopedAllLocations();
        $selectedLocationId = $this->resolveLocationFilter($selectedLocationId, $clients);

        $settings = AgencySetting::workspace($this->scopeClient()?->id);

        return view('app.settings', compact(
            'clients',
            'allLocations',
            'selectedLocationId',
            'settings'
        ))->with([
            'aiConfigured' => OpenRouterService::configured(),
            'aiModel' => (new OpenRouterService())->model(),
            'googleConfigured' => GoogleBusinessService::configured(),
        ]);
    }

    public function update(Request $request)
    {
        $settings = AgencySetting::workspace($this->scopeClient()?->id);

        // Keep existing secret keys when submitted blank.
        $aiKey = $request->input('ai_api_key') ?? '';
        if ($aiKey === '') {
            $aiKey = $settings->ai_api_key;
        }
        $secret = $request->input('payment_secret_key') ?? '';
        if ($secret === '') {
            $secret = $settings->payment_secret_key;
        }

        $settings->update([
            'agency_name' => $request->input('agency_name', $settings->agency_name),
            'custom_domain' => $request->input('custom_domain', $settings->custom_domain),
            'brand_color' => $request->input('brand_color', $settings->brand_color),
            'support_email' => $request->input('support_email', $settings->support_email),

            // AI / OpenRouter
            'ai_model' => $request->input('ai_model', $settings->ai_model),
            'ai_api_key' => $aiKey,
            'ai_reasoning' => $request->boolean('ai_reasoning'),
            'ai_temperature' => (float) ($request->input('ai_temperature') ?? 0.5),
            'ai_max_tokens' => (int) ($request->input('ai_max_tokens') ?? 1024),

            // Payment gateway (brand end for their clients)
            'payment_provider' => $request->input('payment_provider', $settings->payment_provider),
            'payment_mode' => $request->input('payment_mode', $settings->payment_mode),
            'payment_currency' => $request->input('payment_currency', $settings->payment_currency),
            'payment_public_key' => $request->input('payment_public_key') ?? $settings->payment_public_key,
            'payment_secret_key' => $secret,
            'plan_monthly_price' => (float) ($request->input('plan_monthly_price') ?? $settings->plan_monthly_price ?? 0),
            'plan_per_location_price' => (float) ($request->input('plan_per_location_price') ?? $settings->plan_per_location_price ?? 5),
            'plan_trial_days' => (int) ($request->input('plan_trial_days') ?? $settings->plan_trial_days ?? 14),
            'payment_enabled' => $request->boolean('payment_enabled'),

            'email_alerts' => $request->has('email_alerts'),
            'sms_alerts' => $request->has('sms_alerts'),
        ]);

        return back()->with('success', 'Agency white-label, billing & AI settings updated successfully!');
    }

    /**
     * Change the signed-in user's password from the brand panel account menu.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors([
                'current_password' => 'Your current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => $request->input('new_password'),
        ]);

        $request->session()->regenerate();

        return back()->with('success', 'Your password has been updated successfully.');
    }
}
