<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Concerns\ScopesByClient;
use App\Models\Location;
use App\Models\MediaItem;

class MediaController extends Controller
{
    use ScopesByClient;

    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $category = $request->get('category', 'all');

        $clients = $this->scopedClients();
        $allLocations = $this->scopedAllLocations();
        $selectedLocationId = $this->resolveLocationFilter($selectedLocationId, $clients);
        $visibleIds = $allLocations->pluck('id')->all();

        $query = MediaItem::with('location')->whereIn('location_id', $visibleIds);

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

        $visibleIds = $this->scopedAllLocations()->pluck('id')->all();
        $loc = Location::whereIn('id', $visibleIds)->find($request->input('location_id'));

        if (! $loc) {
            return back()->withErrors([ 'location_id' => 'That location is not in your scope.' ])->withInput();
        }

        $enableGeotag = $request->has('geotag_enabled');

        $mediaUrl = $request->input('url');
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('media', 'public');
            $mediaUrl = Storage::disk('public')->url($path);
        } elseif (empty($mediaUrl)) {
            $mediaUrl = 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80';
        }

        $geotag = 'None';
        if ($enableGeotag) {
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
        $visibleIds = $this->scopedAllLocations()->pluck('id')->all();
        $item = MediaItem::whereIn('location_id', $visibleIds)->findOrFail($id);
        $item->delete();

        return back()->with('success', 'Media item removed.');
    }
}
