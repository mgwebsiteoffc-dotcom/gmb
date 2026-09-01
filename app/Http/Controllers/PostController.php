<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use App\Models\Location;
use App\Models\Post;
use App\Services\AiAssistantService;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'all');
        $selectedLocationId = $request->get('location_id', 'all');

        $clients = Client::with('locations')->get();
        $allLocations = Location::all();

        $query = Post::query();

        if ($tab === 'published') {
            $query->where('status', 'PUBLISHED');
        } elseif ($tab === 'scheduled') {
            $query->where('status', 'SCHEDULED');
        }

        $posts = $query->latest()->get();

        return view('app.posts', compact(
            'clients',
            'allLocations',
            'posts',
            'tab',
            'selectedLocationId'
        ));
    }

    public function generateAiCaption(Request $request)
    {
        $type = $request->input('type', 'WHATS_NEW');
        $businessName = $request->input('business_name', 'Our Business');
        $data = AiAssistantService::generatePostCaption($type, $businessName);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:WHATS_NEW,OFFER,EVENT',
            'cta_type' => 'nullable|string',
            'cta_url' => 'nullable|url',
            'media_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
            'media_url' => 'nullable|string',
        ]);

        $locations = $request->input('target_locations', []);
        $allLocs = Location::all();

        $locNames = count($locations) === $allLocs->count() || empty($locations)
            ? "All Locations ({$allLocs->count()})"
            : count($locations) . ' Selected Locations';

        $isScheduled = $request->has('is_scheduled') && $request->input('is_scheduled') == '1';

        // Resolve the post image: prefer a real upload, otherwise the URL field, otherwise a default.
        $mediaUrl = $request->input('media_url');
        if ($request->hasFile('media_image')) {
            $path = $request->file('media_image')->store('posts', 'public');
            $mediaUrl = Storage::disk('public')->url($path);
        }
        if (empty($mediaUrl)) {
            $mediaUrl = 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80';
        }

        Post::create([
            'title' => $request->input('title'),
            'type' => $request->input('type'),
            'target_locations' => $locations,
            'target_location_names' => $locNames,
            'content' => $request->input('content'),
            'coupon_code' => $request->input('coupon_code'),
            'terms' => $request->input('terms'),
            'event_start' => $request->input('event_start'),
            'event_end' => $request->input('event_end'),
            'cta_type' => $request->input('cta_type', 'BOOK'),
            'cta_url' => $request->input('cta_url', 'https://untab.com'),
            'media_url' => $mediaUrl,
            'status' => $isScheduled ? 'SCHEDULED' : 'PUBLISHED',
            'publish_date' => $isScheduled ? $request->input('scheduled_at', now()->addDays(2)->format('Y-m-d H:i')) : now()->format('Y-m-d H:i'),
            'views' => $isScheduled ? 0 : 120,
            'clicks' => $isScheduled ? 0 : 12,
        ]);

        return back()->with('success', $isScheduled ? 'Google Post scheduled successfully across locations!' : 'Google Post published live across profiles!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return back()->with('success', 'Post removed successfully.');
    }
}
