<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Location;
use App\Models\Review;
use App\Services\AiAssistantService;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $ratingFilter = $request->get('rating', 'all');
        $sentimentFilter = $request->get('sentiment', 'all');
        $statusFilter = $request->get('status', 'all');
        $search = $request->get('search', '');

        $clients = Client::with('locations')->get();
        $allLocations = Location::all();

        $query = Review::with('location');

        if ($selectedLocationId !== 'all') {
            if (str_starts_with($selectedLocationId, 'client-')) {
                $clientId = (int) str_replace('client-', '', $selectedLocationId);
                $query->whereHas('location', function($q) use ($clientId) {
                    $q->where('client_id', $clientId);
                });
            } else {
                $query->where('location_id', $selectedLocationId);
            }
        }

        if ($ratingFilter !== 'all') {
            $query->where('rating', (int)$ratingFilter);
        }

        if ($sentimentFilter !== 'all') {
            $query->where('sentiment', $sentimentFilter);
        }

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('author_name', 'like', "%{$search}%")
                  ->orWhere('snippet', 'like', "%{$search}%");
            });
        }

        $reviews = $query->latest()->get();
        $unansweredCount = Review::where('status', 'unanswered')->count();

        return view('app.reviews', compact(
            'clients',
            'allLocations',
            'reviews',
            'selectedLocationId',
            'ratingFilter',
            'sentimentFilter',
            'statusFilter',
            'search',
            'unansweredCount'
        ));
    }

    public function generateAiReply(Request $request)
    {
        $reviewId = $request->input('review_id');
        $tone = $request->input('tone', 'friendly');
        $customInstructions = $request->input('instructions', '');

        $review = Review::with('location')->findOrFail($reviewId);
        $reply = AiAssistantService::generateReviewReply($review, $tone, $customInstructions);

        return response()->json([
            'success' => true,
            'reply' => $reply
        ]);
    }

    public function storeReply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $review = Review::findOrFail($id);
        $review->update([
            'reply' => $request->input('reply'),
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        // Decrement location unanswered reviews count
        if ($review->location) {
            $review->location->decrement('unanswered_reviews');
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Reply posted successfully!']);
        }

        return back()->with('success', 'Reply published live to Google Business Profile!');
    }

    public function bulkAiReply(Request $request)
    {
        $unrepliedReviews = Review::with('location')->where('status', 'unanswered')->get();
        $count = 0;

        foreach ($unrepliedReviews as $review) {
            $tone = $review->rating >= 4 ? 'friendly' : 'empathetic';
            $reply = AiAssistantService::generateReviewReply($review, $tone);
            $review->update([
                'reply' => $reply,
                'status' => 'replied',
                'replied_at' => now(),
            ]);
            $count++;
        }

        Location::query()->update(['unanswered_reviews' => 0]);

        return back()->with('success', "Successfully drafted and published AI replies for {$count} reviews!");
    }
}
