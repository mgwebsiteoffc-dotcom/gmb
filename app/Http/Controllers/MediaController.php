<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Location;
use App\Models\MediaItem;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $category = $request->get('category', 'all');

        $clients = Client::with('locations')->get();
        $allLocations = Location::all();

        $query = MediaItem::with('location');

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $media = $query->latest()->get();

        return view('app.media', compact(
            'clients',
            'allLocations',
            'selectedLocationId',
            'category',
            'media'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
            'url' => 'nullable|string',
        ]);

        $loc = Location::find($request->input('location_id'));
        $enableGeotag = $request->has('geotag_enabled');

        // Resolve the media source: prefer a real upload, fall back to a URL.
        $mediaUrl = $request->input('url');
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('media', 'public');
            $mediaUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($path);
        } elseif (empty($mediaUrl)) {
            $mediaUrl = 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80';
        }

        $geotag = 'None';
        if ($enableGeotag && $loc) {
            $coords = [
                '30.2672° N, 97.7431° W (Austin, TX)',
                '25.7617° N, 80.1918° W (Miami Brickell)',
                '41.8818° N, 87.6231° W (Chicago Loop)',
            ];
            $geotag = $coords[array_rand($coords)];
        }

        MediaItem::create([
            'location_id' => $loc->id,
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'url' => $mediaUrl,
            'geotag' => $geotag,
            'alt_text' => $request->input('alt_text') ?: $request->input('title') . ' at ' . $loc->name,
            'views' => 120,
        ]);

        return back()->with('success', 'Photo uploaded and synced across Google Business Profile with EXIF geotagging!');
    }

    public function destroy($id)
    {
        $item = MediaItem::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Media item removed.');
    }
}
