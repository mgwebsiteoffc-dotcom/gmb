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
            ['id' => 1],
            [
                'agency_name' => 'Untab Local Growth Agency',
                'custom_domain' => 'clients.untab.com',
                'brand_color' => '#1a35c8',
                'support_email' => 'support@untab.com',
                'ai_model' => 'nvidia/nemotron-3.5-lightning:free',
                'email_alerts' => true,
                'sms_alerts' => false,
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
            'ai_model' => ['required', 'string', 'max:255'],
            'email_alerts' => ['nullable', 'boolean'],
            'sms_alerts' => ['nullable', 'boolean'],
        ]);

        $settings = AgencySetting::firstOrCreate(['id' => 1]);

        $settings->update([
            'agency_name' => $data['agency_name'],
            'custom_domain' => $data['custom_domain'] ?? $settings->custom_domain,
            'brand_color' => $data['brand_color'] ?? $settings->brand_color,
            'support_email' => $data['support_email'],
            'ai_model' => $data['ai_model'],
            'email_alerts' => $request->boolean('email_alerts'),
            'sms_alerts' => $request->boolean('sms_alerts'),
        ]);

        return back()->with('success', 'Platform settings updated.');
    }
}
