<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AiAssistantService
{
    /**
     * Generate an AI review response tailored by tone, rating, and SEO keywords.
     *
     * Uses OpenRouter (LLM) when an API key is configured; otherwise falls
     * back to the offline template generator so the demo keeps working.
     */
    public static function generateReviewReply($review, $tone = 'friendly', $customInstructions = '')
    {
        // Prefer a real LLM reply when available.
        $llmReply = self::tryOpenRouterReviewReply($review, $tone, $customInstructions);
        if ($llmReply !== null) {
            return $llmReply;
        }

        return self::templateReviewReply($review, $tone, $customInstructions);
    }

    /**
     * Generate an AI caption for a Google Business post via OpenRouter.
     */
    public static function generatePostCaption($type = 'WHATS_NEW', $businessName = 'Our Business')
    {
        if (OpenRouterService::configured()) {
            try {
                $system = "You are Untab, an expert local-marketing copywriter. Write a short, high-converting, "
                    . "SEO-friendly Google Business Profile post. Respond with strict JSON using ONLY these keys: "
                    . "title, content, coupon_code, terms, cta_type. cta_type must be one of "
                    . "BOOK, ORDER, BUY, LEARN_MORE, SIGN_UP, CALL_NOW. No markdown, no extra text.";

                $kind = match ($type) {
                    'OFFER' => 'a limited-time promotional offer',
                    'EVENT' => 'an upcoming community event',
                    default => 'a "what\'s new" update',
                };

                $user = "Create {$kind} for the business \"{$businessName}\". "
                    . "Include a clear call-to-action and make the copy persuasive. "
                    . "Return only the JSON object.";

                $result = (new OpenRouterService())->chat($system, $user);
                $data = json_decode($result['content'], true);

                if (is_array($data) && isset($data['title'], $data['content'])) {
                    if (empty($data['coupon_code']) && $type === 'OFFER') {
                        $data['coupon_code'] = 'SAVE' . strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $businessName) ?: 'UNTAB', 0, 4));
                    }
                    if (empty($data['terms'])) {
                        $data['terms'] = 'Valid while appointments last. Terms apply.';
                    }
                    if (empty($data['cta_type'])) {
                        $data['cta_type'] = self::defaultCta($type);
                    }

                    return $data;
                }
            } catch (\Throwable $e) {
                Log::warning('OpenRouter post caption failed; using template.', ['error' => $e->getMessage()]);
            }
        }

        return self::templatePostCaption($type, $businessName);
    }

    /**
     * Resolve a sensible default CTA for a post type.
     */
    private static function defaultCta(string $type): string
    {
        return match ($type) {
            'OFFER' => 'BOOK',
            'EVENT' => 'SIGN_UP',
            default => 'LEARN_MORE',
        };
    }

    /**
     * Attempt a real LLM reply via OpenRouter. Returns null when unavailable.
     */
    private static function tryOpenRouterReviewReply($review, $tone, $customInstructions): ?string
    {
        if (! OpenRouterService::configured()) {
            return null;
        }

        try {
            $author = explode(' ', $review->author_name)[0] ?? 'there';
            $location = $review->location->name ?? 'our location';
            $rating = (int) ($review->rating ?? 5);
            $keywords = $review->keywords ?? [];

            $tonePrompt = match ($tone) {
                'professional' => 'Professional, courteous, and reassuring.',
                'seo' => 'SEO keyword-rich, naturally mentioning local search terms and services.',
                'casual' => 'Casual, warm, and friendly.',
                'empathetic', 'apologetic' => 'Empathetic and apologetic if the rating is low; grateful if it is high.',
                default => 'Warm, friendly, and appreciative.',
            };

            $system = "You are Untab, representing {$location}. You reply to Google Business Profile reviews "
                . "on behalf of the business owner. Match the review's sentiment. Tone: {$tonePrompt} "
                . "Keep it 2-4 sentences, under 220 characters, no hashtags, and on brand. "
                . "Reply directly to the customer only. Do not include any preface or explanation.";

            $user = "Author: {$author}\nStar rating: {$rating}/5\n"
                . "Review: \"{$review->snippet}\"\n"
                . "Local keywords to weave in naturally if relevant: " . implode(', ', array_slice($keywords, 0, 4)) . "\n";

            if (! empty($customInstructions)) {
                $user .= "Additional instructions: {$customInstructions}\n";
            }

            if ($rating >= 4) {
                $user .= "This is a positive review — thank the customer sincerely and invite them to return.\n";
            } elseif ($rating === 3) {
                $user .= "This is a mixed review — acknowledge the feedback politely, apologize for any shortfall, and offer to make it right.\n";
            } else {
                $user .= "This is a negative review — apologize genuinely, take responsibility, and offer to resolve the issue offline (no defensive tone).\n";
            }

            $result = (new OpenRouterService())->chat($system, $user);
            $reply = trim($result['content']);

            // Strip any accidental JSON wrapper / quotes if the model wrapped it.
            $reply = trim($reply, "\" \n");

            return $reply !== '' ? $reply : null;
        } catch (\Throwable $e) {
            Log::warning('OpenRouter review reply failed; using template.', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Offline template fallback (original generator).
     */
    private static function templateReviewReply($review, $tone = 'friendly', $customInstructions = '')
    {
        $author = explode(' ', $review->author_name)[0] ?? 'there';
        $location = $review->location->name ?? 'our location';
        $rating = $review->rating ?? 5;
        $keywords = $review->keywords ?? [];

        $replyText = '';

        if ($rating >= 4) {
            switch ($tone) {
                case 'professional':
                    $replyText = "Thank you for taking the time to share your feedback, {$author}. We appreciate your trust in {$location} and remain dedicated to delivering exceptional service. We look forward to your next visit.";
                    break;
                case 'seo':
                    $kwString = ! empty($keywords) ? implode(' and ', array_slice($keywords, 0, 2)) : 'high quality local service';
                    $replyText = "Thank you {$author}! We take great pride in providing the best {$kwString} in the area. Your support for {$location} means everything to our local team!";
                    break;
                case 'casual':
                    $replyText = "Thanks a bunch, {$author}! So glad you enjoyed your visit with us at {$location}. Can't wait to welcome you back!";
                    break;
                case 'friendly':
                default:
                    $replyText = "Hi {$author}! Thank you so much for the glowing 5-star review! The entire team at {$location} is delighted to know you had such a great experience. See you again soon! ✨";
                    break;
            }
        } elseif ($rating === 3) {
            if ($tone === 'empathetic' || $tone === 'apologetic') {
                $replyText = "Hi {$author}, thank you for your honest feedback. We are glad you enjoyed parts of your experience, but we apologize that certain aspects did not meet our usual high standards. We would love the opportunity to make things right—please reach out directly to our management team.";
            } else {
                $replyText = "Dear {$author}, thank you for bringing this to our attention. We strive for excellence across all visits and take your comments regarding wait times and service seriously. Our team is actively reviewing this.";
            }
        } else {
            if ($tone === 'empathetic' || $tone === 'apologetic') {
                $replyText = "Dear {$author}, we sincerely apologize that your recent visit did not meet your expectations. Providing an exceptional, seamless experience is our top priority, and we regret falling short. Please contact our general manager directly so we can make this right for you.";
            } else {
                $replyText = "Hello {$author}, we take all customer feedback very seriously. We apologize for the frustration caused during your visit to {$location}. Please contact us at your earliest convenience so we can address your concerns directly.";
            }
        }

        if (! empty($customInstructions)) {
            if (stripos($customInstructions, 'discount') !== false || stripos($customInstructions, 'coupon') !== false) {
                $replyText .= " Please mention this note on your next visit for 10% off as our token of appreciation.";
            }
            if (stripos($customInstructions, 'phone') !== false || stripos($customInstructions, 'call') !== false) {
                $replyText .= " You can reach our manager directly at our front desk line anytime.";
            }
        }

        return $replyText;
    }

    /**
     * Offline template fallback for post captions (original generator).
     */
    private static function templatePostCaption($type = 'WHATS_NEW', $businessName = 'Our Business')
    {
        switch ($type) {
            case 'OFFER':
                return [
                    'title' => "Special Limited-Time Savings at {$businessName}!",
                    'content' => "🎉 Elevate your local experience this season! For a limited time, enjoy premium services with our exclusive promotional discount. Reserve your spot today before appointments fill up.",
                    'coupon_code' => 'SAVE20PULSE',
                    'terms' => 'Valid while appointments last. Terms apply.',
                    'cta_type' => 'BOOK',
                ];
            case 'EVENT':
                return [
                    'title' => "Upcoming Community Workshop & Q&A at {$businessName}",
                    'content' => "📅 Mark your calendars! Join our specialists for an exclusive interactive session where we share expert tips, live demonstrations, and special giveaways. Free admission!",
                    'cta_type' => 'SIGN_UP',
                ];
            case 'WHATS_NEW':
            default:
                return [
                    'title' => "Exciting New Updates at {$businessName}",
                    'content' => "✨ We are continually upgrading our facilities, services, and team training to provide you with the smoothest local experience. Stop by today or book online!",
                    'cta_type' => 'LEARN_MORE',
                ];
        }
    }
}
