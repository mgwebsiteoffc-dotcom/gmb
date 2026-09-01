<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\ScopesByClient;
use App\Models\Location;
use App\Models\Review;
use App\Services\AiAssistantService;

class ReviewController extends Controller
{
    use ScopesByClient;

    public function index(Request $request)
    {
        $selectedLocationId = $request->get('location_id', 'all');
        $ratingFilter = $request->get('rating', 'all');
        $sentimentFilter = $request->get('sentiment', 'all');
        $statusFilter = $request->get('status', 'all');
        $search = $request->get('search', '');

        $clients = $this->scopedClients();
        $allLocations = $this->scopedAllLocations();
        $selectedLocationId = $this->resolveLocationFilter($selectedLocationId, $clients);

        $visibleLocationIds = $allLocations->pluck('id')->all();

        $query = Review::with('location')->whereIn('location_id', $visibleLocationIds);

        if ($selectedLocationId !== 'all') {
            if (str_starts_with($selectedLocationId, 'client-')) {
                $clientId = (int) str_replace('client-', '', $selectedLocationId);
                $query->whereHas('location', function ($q) use ($clientId) {
                    $q->where('client_id', $clientId);
                });
            } else {
                $query->where('location_id', $selectedLocationId);
            }
        }

        if ($ratingFilter !== 'all') {
            $query->where('rating', (int) $ratingFilter);
        }

        if ($sentimentFilter !== 'all') {
            $query->where('sentiment', $sentimentFilter);
        }

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('author_name', 'like', "%{$search}%")
                  ->orWhere('snippet', 'like', "%{$search}%");
            });
        }

        $reviews = $query->latest()->paginate(20)->withQueryString();
        $unansweredCount = Review::whereIn('location_id', $visibleLocationIds)
            ->where('status', 'unanswered')
            ->count();

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

        $visibleIds = $this->scopedAllLocations()->pluck('id')->all();
        $review = Review::with('location')->whereIn('location_id', $visibleIds)->findOrFail($reviewId);
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

        $visibleIds = $this->scopedAllLocations()->pluck('id')->all();
        $review = Review::whereIn('location_id', $visibleIds)->findOrFail($id);
        $review->update([
            'reply' => $request->input('reply'),
            'status' => 'replied',
            'replied_at' => now(),
        ]);

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
        $visibleIds = $this->scopedAllLocations()->pluck('id')->all();
        $unrepliedReviews = Review::with('location')
            ->whereIn('location_id', $visibleIds)
            ->where('status', 'unanswered')
            ->get();
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

        Location::whereIn('id', $visibleIds)->update(['unanswered_reviews' => 0]);

        return back()->with('success', "Successfully drafted and published AI replies for {$count} reviews!");
    }
}
