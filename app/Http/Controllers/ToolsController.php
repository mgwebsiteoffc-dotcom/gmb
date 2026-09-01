<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Services\OpenRouterService;

class ToolsController extends Controller
{
    public function auditTool()
    {
        $locations = Location::all();
        return view('tools.gbp-audit-tool', compact('locations'));
    }

    public function reviewLink()
    {
        return view('tools.review-link');
    }

    public function reviewQrCode()
    {
        return view('tools.review-qr-code');
    }

    public function reviewCard()
    {
        return view('tools.review-card');
    }

    public function photoSizeGuide()
    {
        return view('tools.photo-size-guide');
    }

    /**
     * Google Post + Review character-limit counter.
     *
     * GBP posts are capped at 1,500 characters and review replies are best kept
     * under ~220 characters. This tool counts live and flags limits.
     */
    public function characterCounter()
    {
        return view('tools.character-counter');
    }

    /**
     * Local SEO keyword / NAP consistency checklist.
     *
     * A client-side scoring tool that evaluates your local citations for NAP
     * consistency, keyword coverage, and on-page local signals.
     */
    public function localSeoChecklist()
    {
        return view('tools.local-seo-checklist');
    }

    /**
     * Google Business Profile Description writer helper.
     *
     * Generates a 750-character GBP description draft from business details and
     * local keywords (template fallback, plus AI when OPENROUTER is configured).
     */
    public function descriptionWriter()
    {
        return view('tools.description-writer');
    }

    /**
     * AI-enhanced GBP description generator (used by the Description Writer).
     *
     * Uses the OpenRouter brain when configured; otherwise returns a rich
     * template so the tool still works offline.
     */
    public function generateDescription(Request $request)
    {
        $biz = trim($request->input('biz', 'Our business'));
        $service = trim($request->input('service', 'professional services'));
        $city = trim($request->input('city', 'your area'));
        $usps = trim($request->input('usps', 'exceptional service'));

        if (OpenRouterService::configured()) {
            try {
                $system = "You are Untab, an expert local-SEO copywriter. Write a Google Business Profile description. "
                    . "Constraints: exactly 750 characters or fewer, natural and persuasive, first-person-business voice, "
                    . "no hashtags, no markdown. Weave the service and city keyword in naturally. Respond with ONLY the description text.";
                $user = "Business: {$biz}\nPrimary service: {$service}\nCity/location: {$city}\n"
                    . "Unique selling points: {$usps}\nWrite the GBP description now.";

                $result = (new OpenRouterService())->chat($system, $user);
                $desc = trim($result['content']);
                if ($desc !== '') {
                    return response()->json(['description' => mb_substr($desc, 0, 750)]);
                }
            } catch (\Throwable $e) {
                // fall through to template below
            }
        }

        // Offline template (750-char safe, concatenated).
        $points = array_filter(array_map('trim', explode(',', $usps ?: 'exceptional service')));
        $desc = "Welcome to {$biz}! We provide trusted {$service} in {$city}. "
            . implode('. ', $points) . ". "
            . "Our friendly team is here to make every visit easy and stress-free. "
            . "Locals in {$city} trust {$biz} for reliable, high-quality care. "
            . "Call today or book online to get started!";

        return response()->json(['description' => mb_substr($desc, 0, 750)]);
    }
}
