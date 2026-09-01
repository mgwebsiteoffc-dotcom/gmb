<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgencySetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = AgencySetting::firstOrCreate(
            ['client_id' => null],
            [
                'agency_name' => 'Untab Local Growth Agency',
                'custom_domain' => 'clients.untab.com',
                'brand_color' => '#1a35c8',
                'support_email' => 'support@untab.com',
                'ai_model' => 'nvidia/nemotron-3.5-lightning:free',
                'email_alerts' => true,
                'sms_alerts' => false,
                'payment_provider' => 'stripe',
                'payment_mode' => 'test',
                'payment_currency' => 'USD',
            ]
        );

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'agency_name' => ['required', 'string', 'max:255'],
            'custom_domain' => ['nullable', 'string', 'max:255'],
            'brand_color' => ['nullable', 'string', 'max:255'],
            'support_email' => ['required', 'email'],

            // AI / OpenRouter
            'ai_model' => ['required', 'string', 'max:255'],
            'ai_api_key' => ['nullable', 'string', 'max:255'],
            'ai_reasoning' => ['nullable', 'boolean'],
            'ai_temperature' => ['nullable', 'numeric', 'between:0,2'],
            'ai_max_tokens' => ['nullable', 'integer', 'min:128', 'max:8192'],

            // Payment gateway
            'payment_provider' => ['required', 'string', 'in:stripe,razorpay,paypal,offline'],
            'payment_mode' => ['required', 'string', 'in:test,live'],
            'payment_currency' => ['required', 'string', 'max:3'],
            'payment_public_key' => ['nullable', 'string'],
            'payment_secret_key' => ['nullable', 'string'],
            'plan_monthly_price' => ['nullable', 'numeric', 'min:0'],
            'plan_per_location_price' => ['nullable', 'numeric', 'min:0'],
            'plan_trial_days' => ['nullable', 'integer', 'min:0'],
            'payment_enabled' => ['nullable', 'boolean'],

            'email_alerts' => ['nullable', 'boolean'],
            'sms_alerts' => ['nullable', 'boolean'],
        ]);

        $settings = AgencySetting::firstOrCreate(['client_id' => null]);

        // Keep the existing secret key when the field is submitted blank.
        $aiKey = $data['ai_api_key'] ?? '';
        if ($aiKey === '') {
            $aiKey = $settings->ai_api_key;
        }
        $secret = $data['payment_secret_key'] ?? '';
        if ($secret === '') {
            $secret = $settings->payment_secret_key;
        }

        $settings->update([
            'agency_name' => $data['agency_name'],
            'custom_domain' => $data['custom_domain'] ?? $settings->custom_domain,
            'brand_color' => $data['brand_color'] ?? $settings->brand_color,
            'support_email' => $data['support_email'],
            'ai_model' => $data['ai_model'],
            'ai_api_key' => $aiKey,
            'ai_reasoning' => $request->boolean('ai_reasoning'),
            'ai_temperature' => (float) ($data['ai_temperature'] ?? 0.5),
            'ai_max_tokens' => (int) ($data['ai_max_tokens'] ?? 1024),
            'payment_provider' => $data['payment_provider'],
            'payment_mode' => $data['payment_mode'],
            'payment_currency' => $data['payment_currency'],
            'payment_public_key' => $data['payment_public_key'] ?? $settings->payment_public_key,
            'payment_secret_key' => $secret,
            'plan_monthly_price' => (float) ($data['plan_monthly_price'] ?? 0),
            'plan_per_location_price' => (float) ($data['plan_per_location_price'] ?? 5),
            'plan_trial_days' => (int) ($data['plan_trial_days'] ?? 14),
            'payment_enabled' => $request->boolean('payment_enabled'),
            'email_alerts' => $request->boolean('email_alerts'),
            'sms_alerts' => $request->boolean('sms_alerts'),
        ]);

        return back()->with('success', 'Platform, billing & AI settings updated.');
    }
}
