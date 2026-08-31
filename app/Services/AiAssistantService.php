<?php

namespace App\Services;

class AiAssistantService
{
    /**
     * Generate an AI review response tailored by tone, rating, and SEO keywords.
     */
    public static function generateReviewReply($review, $tone = 'friendly', $customInstructions = '')
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
                    $kwString = !empty($keywords) ? implode(' and ', array_slice($keywords, 0, 2)) : 'high quality local service';
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
            // 1-2 stars
            if ($tone === 'empathetic' || $tone === 'apologetic') {
                $replyText = "Dear {$author}, we sincerely apologize that your recent visit did not meet your expectations. Providing an exceptional, seamless experience is our top priority, and we regret falling short. Please contact our general manager directly so we can make this right for you.";
            } else {
                $replyText = "Hello {$author}, we take all customer feedback very seriously. We apologize for the frustration caused during your visit to {$location}. Please contact us at your earliest convenience so we can address your concerns directly.";
            }
        }

        if (!empty($customInstructions)) {
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
     * Generate an AI caption for a Google Business post.
     */
    public static function generatePostCaption($type = 'WHATS_NEW', $businessName = 'Our Business')
    {
        switch ($type) {
            case 'OFFER':
                return [
                    'title' => "Special Limited-Time Savings at {$businessName}!",
                    'content' => "🎉 Elevate your local experience this season! For a limited time, enjoy premium services with our exclusive promotional discount. Reserve your spot today before appointments fill up.",
                    'coupon_code' => 'SAVE20PULSE',
                    'terms' => 'Valid while appointments last. Terms apply.',
                    'cta_type' => 'BOOK'
                ];
            case 'EVENT':
                return [
                    'title' => "Upcoming Community Workshop & Q&A at {$businessName}",
                    'content' => "📅 Mark your calendars! Join our specialists for an exclusive interactive session where we share expert tips, live demonstrations, and special giveaways. Free admission!",
                    'cta_type' => 'SIGN_UP'
                ];
            case 'WHATS_NEW':
            default:
                return [
                    'title' => "Exciting New Updates at {$businessName}",
                    'content' => "✨ We are continually upgrading our facilities, services, and team training to provide you with the smoothest local experience. Stop by today or book online!",
                    'cta_type' => 'LEARN_MORE'
                ];
        }
    }
}
