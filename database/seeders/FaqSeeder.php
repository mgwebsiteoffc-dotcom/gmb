<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // General
            ['category' => 'General', 'question' => 'What is Untab?', 'answer' => 'Untab is a Google Business Profile management platform that lets SEO agencies, franchise operators, and multi-location brands run every local profile from one dashboard.', 'sort_order' => 1],
            ['category' => 'General', 'question' => 'Do I need to download software to use Untab?', 'answer' => 'No. Untab runs entirely in your browser. We also offer companion iOS and Android apps for on-the-go review replies and post monitoring, but the full platform is web-based.', 'sort_order' => 2],
            ['category' => 'General', 'question' => 'Is Untab free to try?', 'answer' => 'Yes. You can explore the full live demo without a credit card, then upgrade to manage unlimited client profiles when you are ready to scale.', 'sort_order' => 3],
            ['category' => 'General', 'question' => 'Which countries does Untab support?', 'answer' => 'Untab works wherever Google Business Profiles exist — 15+ countries and counting. The interface, review replies, insight dashboards, and Search Console data all localize to your region.', 'sort_order' => 4],

            // Features
            ['category' => 'Features', 'question' => 'How many Google Business Profiles can I manage with Untab?', 'answer' => 'Untab supports 10 to 500+ profiles per organization. You can group locations into client portfolios and filter the entire dashboard to any client, group, or single location.', 'sort_order' => 1],
            ['category' => 'Features', 'question' => 'Does Untab reply to Google reviews automatically?', 'answer' => 'Yes. Untab includes an AI Review Reply Assistant that drafts on-brand responses in seconds based on star rating, customer sentiment, and your chosen tone. You can publish replies one-by-one or in bulk.', 'sort_order' => 2],
            ['category' => 'Features', 'question' => 'Can I schedule Google Posts with Untab?', 'answer' => 'Absolutely. Create and schedule updates, offers with coupon codes, and events across any subset of locations. Untab previews exactly how your post will look on Google before publishing.', 'sort_order' => 3],
            ['category' => 'Features', 'question' => 'Does Untab integrate with Google Search Console?', 'answer' => 'Yes. Untab surfaces your Google Search Console queries, landing pages, clicks, impressions, and average position alongside your GBP metrics in one view.', 'sort_order' => 4],
            ['category' => 'Features', 'question' => 'Can I attach photos and media to my profiles?', 'answer' => 'Yes. The Media Library lets you upload, categorize, and geotag photos so you can post the right visuals to the right locations and keep every profile fresh.', 'sort_order' => 5],

            // Reports
            ['category' => 'Reports', 'question' => 'Can I send white-label reports to my clients?', 'answer' => 'Yes. Generate branded performance PDF reports with your agency logo, accent color, and executive summary notes, then share a client-ready link.', 'sort_order' => 1],
            ['category' => 'Reports', 'question' => 'What metrics appear in the client report?', 'answer' => 'Reports show review growth and response rate, Google Posts performance, profile views/calls/direction requests, and Search Console search-query data — all compared to the previous period.', 'sort_order' => 2],
            ['category' => 'Reports', 'question' => 'Can I compare performance across my locations?', 'answer' => 'Yes. The comparison scorecard ranks locations by a composite health score and highlights your best and worst performers, so you know exactly where to focus.', 'sort_order' => 3],

            // Pricing
            ['category' => 'Pricing', 'question' => 'Is there a free version of Untab?', 'answer' => 'Untab is free to start. You can explore every module in the live demo without a credit card, then upgrade to manage unlimited client profiles.', 'sort_order' => 1],
            ['category' => 'Pricing', 'question' => 'Does Untab offer agency or franchise plans?', 'answer' => 'Yes. We offer agency and franchise plans that scale with the number of client profiles you manage, with bulk tools and white-label reporting built in.', 'sort_order' => 2],
            ['category' => 'Pricing', 'question' => 'How does the founding agency program work?', 'answer' => 'We partner with a limited number of agencies (50 partners) during our launch. Founding partners lock in launch pricing plus priority feature requests and dedicated onboarding.', 'sort_order' => 3],

            // Tools
            ['category' => 'Tools', 'question' => 'What free SEO tools does Untab include?', 'answer' => 'Untab ships with a GBP 16-point audit tool, a direct review link generator, a printable review QR code maker, an NFC tap-to-review card configurator, and a GBP photo sizing guide — all free.', 'sort_order' => 1],
            ['category' => 'Tools', 'question' => 'Do the free tools require an account?', 'answer' => 'No. The audit, review-link, QR code, NFC card, and photo-size tools all work without an account so you can try them instantly.', 'sort_order' => 2],

            // Integrations
            ['category' => 'Integrations', 'question' => 'How do I connect my Google Business Profiles?', 'answer' => 'Use Google OAuth to connect your Google account securely. Untab then lists all the profiles your Google account has access to, and you assign them to clients in a few clicks.', 'sort_order' => 1],
            ['category' => 'Integrations', 'question' => 'Is my Google data safe with Untab?', 'answer' => 'Yes. We use Google\'s standard OAuth scopes, encrypt data in transit, and never store your Google password. Access can be revoked at any time from your Google account.', 'sort_order' => 2],

            // Security
            ['category' => 'Security', 'question' => 'How does Untab handle team permissions?', 'answer' => 'Every team member has a role and granular permissions covering posts, reviews, media, reports, and settings, so staff only access the modules they need.', 'sort_order' => 1],

            // Blog (shown on the article pages & managed in Super Admin)
            ['category' => 'Blog', 'question' => 'What is a Google Business Profile and why does it matter?', 'answer' => 'A Google Business Profile is the free listing that appears in Google Maps and local search with your hours, photos, reviews and a call button. It is the single most important free marketing tool for local businesses because it is where customers find and choose you.'],
            ['category' => 'Blog', 'question' => 'How fast does a Google Business Profile improve my rankings?', 'answer' => 'Most businesses see initial improvements in Google impressions within two to four weeks. Meaningful local-pack ranking gains in competitive markets typically take 60-90 days of consistent work.'],
            ['category' => 'Blog', 'question' => 'Can I manage my own Google Business Profile or do I need an agency?', 'answer' => 'Many businesses successfully manage their own profile with the right tools. Untab is built for business owners too, and for agencies managing many profiles. For multiple locations or highly competitive markets, a specialist can accelerate results.'],
            ['category' => 'Blog', 'question' => 'What is the single most important thing I can do right now?', 'answer' => 'Complete your Google Business Profile 100%: fill every field, choose the correct primary category, add at least ten photos, write a keyword-rich description, and set up a review request system. These fundamentals deliver the biggest ranking improvement fastest.'],
            ['category' => 'Blog', 'question' => 'What is the difference between Google My Business and Google Business Profile?', 'answer' => 'Google My Business was the old name. Google rebranded it to Google Business Profile in 2021 — same product, same features. You now manage it directly in Google Search by searching your business name while logged in.'],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
