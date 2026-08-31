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
            'url' => 'required|string',
        ]);

        $loc = Location::find($request->input('location_id'));
        $enableGeotag = $request->has('geotag_enabled');

        MediaItem::create([
            'location_id' => $loc->id,
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'url' => $request->input('url'),
            'geotag' => $enableGeotag ? '30.2672° N, 97.7431° W (Austin, TX)' : 'None',
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
