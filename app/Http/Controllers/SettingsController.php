<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Location;
use App\Models\AgencySetting;

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
            'ai_model' => 'gpt-4o-mini',
            'email_alerts' => true,
            'sms_alerts' => false
        ]);

        return view('app.settings', compact(
            'clients',
            'allLocations',
            'selectedLocationId',
            'settings'
        ));
    }

    public function update(Request $request)
    {
        $settings = AgencySetting::first();
        $settings->update([
            'agency_name' => $request->input('agency_name'),
            'custom_domain' => $request->input('custom_domain'),
            'brand_color' => $request->input('brand_color'),
            'support_email' => $request->input('support_email'),
            'ai_model' => $request->input('ai_model', 'gpt-4o-mini'),
            'email_alerts' => $request->has('email_alerts'),
            'sms_alerts' => $request->has('sms_alerts'),
        ]);

        return back()->with('success', 'Agency white-label settings updated successfully!');
    }
}
