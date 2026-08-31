<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Central FAQ hub page with FAQPage structured data.
     */
    public function index(Request $request)
    {
        $faqs = [
            [
                'q' => 'What is Untab?',
                'a' => 'Untab is a Google Business Profile management platform that lets SEO agencies, franchise operators, and multi-location brands run every local profile from a single dashboard.',
            ],
            [
                'q' => 'How many Google Business Profiles can I manage with Untab?',
                'a' => 'Untab supports 10 to 500+ profiles per organization. You can group locations into client portfolios and filter the entire dashboard to any client, group, or single location.',
            ],
            [
                'q' => 'Does Untab reply to Google reviews automatically?',
                'a' => 'Yes. Untab includes an AI Review Reply Assistant that drafts on-brand responses in seconds based on star rating, customer sentiment, and your chosen tone. You can publish replies one-by-one or in bulk.',
            ],
            [
                'q' => 'Can I schedule Google Posts with Untab?',
                'a' => 'Absolutely. Create and schedule updates, offers with coupon codes, and events across any subset of locations. Untab previews exactly how your post will look on Google before publishing.',
            ],
            [
                'q' => 'Does Untab integrate with Google Search Console?',
                'a' => 'Yes. Untab surfaces your Google Search Console queries, landing pages, clicks, impressions, and average position alongside your GBP metrics in one view.',
            ],
            [
                'q' => 'Can I send white-label reports to my clients?',
                'a' => 'Yes. Generate branded performance PDF reports with your agency logo, accent color, and executive summary notes, then share a client-ready link.',
            ],
            [
                'q' => 'Is there a free version of Untab?',
                'a' => 'Untab is free to start. You can explore every module in the live demo without a credit card, then upgrade to manage unlimited client profiles.',
            ],
            [
                'q' => 'What free SEO tools does Untab include?',
                'a' => 'Untab ships with a GBP 16-point audit tool, a direct review link generator, a printable review QR code maker, an NFC tap-to-review card configurator, and a GBP photo sizing guide — all free.',
            ],
        ];

        $jsonLd = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => collect($faqs)->map(function ($faq) {
                    return [
                        '@type' => 'Question',
                        'name' => $faq['q'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
                    ];
                })->all(),
            ],
        ];

        return view('marketing.faq', compact('faqs', 'jsonLd'));
    }
}
