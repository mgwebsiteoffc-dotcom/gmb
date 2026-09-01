<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('q', ''));

        $clients = Client::with('locations')
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('category', 'like', "%{$search}%"))
            ->withCount('locations')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.clients.index', compact('clients', 'search'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:255'],
            'logo_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:8192'],
            'color' => ['nullable', 'string', 'max:255'],
            'account_manager' => ['nullable', 'string', 'max:255'],
            'monthly_retainer' => ['nullable', 'string', 'max:255'],
            'active_since' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:25'],
            'poc_name' => ['nullable', 'string', 'max:255'],
            'poc_email' => ['nullable', 'email', 'max:255'],
            'poc_mobile' => ['nullable', 'string', 'max:25'],
            'onboarded_at' => ['nullable', 'date'],
        ]);

        $logoUrl = null;
        if ($request->hasFile('logo_image')) {
            $logoUrl = Storage::disk('public')->url($request->file('logo_image')->store('brand-logos', 'public'));
        }

        $client = Client::create([
            'name' => $data['name'],
            'category' => $data['category'],
            'logo' => $data['logo'] ?: '🏢',
            'logo_url' => $logoUrl,
            'color' => $data['color'] ?: '#2563eb',
            'account_manager' => $data['account_manager'] ?? null,
            'monthly_retainer' => $data['monthly_retainer'] ?? '$1,500/mo',
            'active_since' => $data['active_since'] ?? null,
            'mobile' => $data['mobile'] ?? null,
            'poc_name' => $data['poc_name'] ?? null,
            'poc_email' => $data['poc_email'] ?? null,
            'poc_mobile' => $data['poc_mobile'] ?? null,
            'onboarded_at' => $data['onboarded_at'] ?? null,
        ]);

        return redirect()->route('admin.clients.show', $client)
            ->with('success', 'Client "'.$client->name.'" created. Add locations next.');
    }

    public function show(Client $client)
    {
        $client->load('locations.reviews');

        $locations = $client->locations()
            ->withCount('reviews')
            ->orderBy('name')
            ->get();

        $admins = User::where('role', User::ROLE_BRAND_ADMIN)
            ->where('client_id', $client->id)
            ->get();

        $totalReviews = Review::whereIn('location_id', $client->locations()->pluck('id'))->count();
        $totalViews = $client->locations()->sum('monthly_views');
        $avgRating = round($client->locations()->avg('rating'), 1);

        return view('admin.clients.show', compact('client', 'locations', 'admins', 'totalReviews', 'totalViews', 'avgRating'));
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:255'],
            'logo_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:8192'],
            'color' => ['nullable', 'string', 'max:255'],
            'account_manager' => ['nullable', 'string', 'max:255'],
            'monthly_retainer' => ['nullable', 'string', 'max:255'],
            'active_since' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:25'],
            'poc_name' => ['nullable', 'string', 'max:255'],
            'poc_email' => ['nullable', 'email', 'max:255'],
            'poc_mobile' => ['nullable', 'string', 'max:25'],
            'onboarded_at' => ['nullable', 'date'],
        ]);

        // Update the logo image only if a new file is uploaded; otherwise keep it.
        if ($request->hasFile('logo_image')) {
            $data['logo_url'] = Storage::disk('public')->url($request->file('logo_image')->store('brand-logos', 'public'));
        }

        $client->update($data);

        return redirect()->route('admin.clients.show', $client)
            ->with('success', 'Client "'.$client->name.'" updated.');
    }

    public function destroy(Client $client)
    {
        $name = $client->name;
        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client "'.$name.'" and its locations deleted.');
    }
}
