<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Location;
use App\Models\AgencySetting;
use App\Services\OpenRouterService;
use App\Services\GoogleBusinessService;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $clients = Client::with('locations')->get();
        $allLocations = Location::all();
        $settings = AgencySetting::firstOrCreate([], [
            'agency_name' => 'Untab Local Growth Agency',
            'custom_domain' => 'clients.untab.com',
            'brand_color' => '#1a35c8',
            'support_email' => 'support@untab.com',
            'ai_model' => config('services.openrouter.model', 'nvidia/nemotron-3.5-lightning:free'),
            'email_alerts' => true,
            'sms_alerts' => false,
            'payment_provider' => 'stripe',
            'payment_mode' => 'test',
            'payment_currency' => 'USD',
        ]);

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
        $settings = AgencySetting::firstOrCreate(['id' => 1]);

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
            'agency_name' => $request->input('agency_name'),
            'custom_domain' => $request->input('custom_domain'),
            'brand_color' => $request->input('brand_color'),
            'support_email' => $request->input('support_email'),

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
}
