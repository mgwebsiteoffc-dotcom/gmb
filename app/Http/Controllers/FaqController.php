<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Support\SeoHelper;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Central FAQ hub page, driven by the faqs table (managed in Super Admin),
     * with a hardcoded fallback so the page renders even before seeding.
     */
    public function index(Request $request)
    {
        $category = $request->get('category');

        // Try the database first; fall back to a static list if empty/unseeded.
        $faqs = $this->faqsFromDatabase();

        if ($faqs->isEmpty()) {
            $faqs = collect($this->defaultFaqs())->map(fn ($f) => (object) $f);
            $grouped = $faqs->groupBy('category');
        } else {
            $grouped = $category
                ? $faqs->where('category', $category)->groupBy('category')
                : $faqs->groupBy('category');
        }

        $flattened = $grouped->flatten(1);
        $categories = $faqs->pluck('category')->unique()->filter()->values();

        $jsonLd = [
            SeoHelper::faqSchema(
                $flattened->map(fn ($f) => ['q' => $f->question, 'a' => $f->answer])->values()->all()
            ),
            SeoHelper::breadcrumbSchema([
                ['name' => 'Home', 'url' => route('home')],
                ['name' => 'FAQs', 'url' => route('faq')],
            ]),
        ];

        return view('marketing.faq', compact('grouped', 'categories', 'category', 'jsonLd'));
    }

    protected function faqsFromDatabase()
    {
        try {
            if (! \Illuminate\Support\Facades\Schema::hasTable('faqs')) {
                return collect();
            }

            return Faq::visible()
                ->get()
                ->map(fn ($f) => (object) [
                    'question' => $f->question,
                    'answer' => $f->answer,
                    'category' => $f->category ?: 'General',
                ]);
        } catch (\Throwable $e) {
            // Never let a missing/empty faqs table break the marketing page.
            return collect();
        }
    }

    /**
     * Fallback FAQ content used before the faqs table is seeded.
     */
    protected function defaultFaqs(): array
    {
        return [
            ['category' => 'General', 'question' => 'What is Untab?', 'answer' => 'Untab is a Google Business Profile management platform that lets SEO agencies, franchise operators, and multi-location brands run every local profile from a single dashboard.'],
            ['category' => 'Features', 'question' => 'How many Google Business Profiles can I manage with Untab?', 'answer' => 'Untab supports 10 to 500+ profiles per organization. You can group locations into client portfolios and filter the entire dashboard to any client, group, or single location.'],
            ['category' => 'Features', 'question' => 'Does Untab reply to Google reviews automatically?', 'answer' => 'Yes. Untab includes an AI Review Reply Assistant that drafts on-brand responses in seconds based on star rating, customer sentiment, and your chosen tone. You can publish replies one-by-one or in bulk.'],
            ['category' => 'Features', 'question' => 'Can I schedule Google Posts with Untab?', 'answer' => 'Absolutely. Create and schedule updates, offers with coupon codes, and events across any subset of locations. Untab previews exactly how your post will look on Google before publishing.'],
            ['category' => 'Features', 'question' => 'Does Untab integrate with Google Search Console?', 'answer' => 'Yes. Untab surfaces your Google Search Console queries, landing pages, clicks, impressions, and average position alongside your GBP metrics in one view.'],
            ['category' => 'Reports', 'question' => 'Can I send white-label reports to my clients?', 'answer' => 'Yes. Generate branded performance PDF reports with your agency logo, accent color, and executive summary notes, then share a client-ready link.'],
            ['category' => 'Pricing', 'question' => 'Is there a free version of Untab?', 'answer' => 'Untab is free to start. You can explore every module in the live demo without a credit card, then upgrade to manage unlimited client profiles.'],
            ['category' => 'Tools', 'question' => 'What free SEO tools does Untab include?', 'answer' => 'Untab ships with a GBP 16-point audit tool, a direct review link generator, a printable review QR code maker, an NFC tap-to-review card configurator, and a GBP photo sizing guide — all free.'],
        ];
    }
}
