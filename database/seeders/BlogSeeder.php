<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Local SEO in 2026: The Complete Google Business Profile Playbook',
                'slug' => 'local-seo-2026-google-business-profile-playbook',
                'excerpt' => 'Google review count, response time, and profile completeness now drive more local rankings than ever. Here is the exact playbook the top agencies use to win the map pack.',
                'category' => 'Local SEO',
                'author' => 'Untab Team',
                'featured' => true,
                'status' => 'published',
                'tags' => ['local-seo', 'gbp', 'google-business-profile'],
                'keywords' => 'local SEO 2026, Google Business Profile optimization, map pack ranking, GBP ranking factors',
                'meta_title' => 'Local SEO in 2026: The Google Business Profile Playbook | Untab',
                'meta_description' => 'The exact Google Business Profile ranking playbook top agencies use in 2026: review counts, response time, completeness, and profile signals that win the map pack.',
                'cover_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Local search is no longer a side channel. For service-area businesses, franchises, and multi-location brands, the Google Business Profile (GBP) map pack is where customers are won.</p><h2>Why reviews still reign</h2><p>Google has never said exactly how rankings work, but year after year the same three signals correlate with top map-pack positions: review volume, average rating, and response rate.</p><blockquote>Businesses that reply to 100% of their reviews see 1.7x more review engagement and a measurable lift in local rankings.</blockquote><h2>The customer journey is not linear</h2><p>29% of local searches result in a purchase within the hour. Shoppers alternate between discovery, research, and decision — so your GBP must be complete, current, and consistently managed at every touchpoint.</p><h2>Profile completeness matters</h2><ul><li>Add all categories, services, and attributes</li><li>Upload geotagged, category-tagged photos weekly</li><li>Keep hours, phone, and website in sync</li><li>Publish offers and events so the profile stays fresh</li></ul><h2>How Untab helps</h2><p>Untab centralizes review replies, Google Posts, and Search Console data so you can manage 500+ profiles without switching tabs. The built-in AI Review Reply Assistant drafts on-brand responses in seconds.</p>',
            ],
            [
                'title' => 'How to Reply to Negative Reviews Without Losing the Customer',
                'slug' => 'how-to-reply-to-negative-reviews',
                'excerpt' => 'A negative review is not a disaster — it is an invitation. Learn the 4-step framework to turn unhappy customers into loyal advocates, and when to craft a reply offline.',
                'category' => 'Review Management',
                'author' => 'Untab Team',
                'featured' => true,
                'status' => 'published',
                'tags' => ['reviews', 'review-management', 'reputation'],
                'keywords' => 'reply to negative reviews, review response template, reputation management, online reviews',
                'meta_title' => 'How to Reply to Negative Reviews (4-Step Framework) | Untab',
                'meta_description' => 'A 4-step framework for replying to negative Google reviews: acknowledge, apologize, offer a fix, and move the conversation offline — without sounding scripted.',
                'cover_image' => 'https://images.unsplash.com/photo-1552581234-26160f608093?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Negative reviews happen to every business. What separates a reputation that grows from one that shrinks is how you respond.</p><h2>The 4-step framework</h2><ol><li><strong>Acknowledge.</strong> Name the specific issue the customer raised.</li><li><strong>Apologize genuinely.</strong> No caveats, no blaming the customer.</li><li><strong>Offer a fix.</strong> Describe the concrete next step, even if it is just to talk.</li><li><strong>Take it offline.</strong> Provide a contact point so the real resolution happens privately.</li></ol><h2>What to avoid</h2><ul><li>Don\'t copy-paste the same reply for everyone</li><li>Don\'t argue or get defensive in public</li><li>Don\'t reveal personal data in the response</li></ul><blockquote>72% of consumers say a thoughtful response to a negative review improves their opinion of a business.</blockquote><h2>Automate the draft, not the empathy</h2><p>Untab\'s AI Review Reply Assistant understands sentiment and your brand voice. It drafts a tailored response you can edit in one click — so empathy stays human and the workflow stays fast.</p>',
            ],
            [
                'title' => 'Google Posts at Scale: A Franchise Content Strategy',
                'slug' => 'google-posts-at-scale-franchise-strategy',
                'excerpt' => 'Franchises publish 10x the content of a single brand. Here is how to schedule offers, events, and updates across every location without ballooning your content team.',
                'category' => 'Google Posts',
                'author' => 'Untab Team',
                'featured' => false,
                'status' => 'published',
                'tags' => ['google-posts', 'franchise', 'content'],
                'keywords' => 'Google Posts scheduling, franchise content strategy, Google Posts offers, bulk Google Posts',
                'meta_title' => 'Google Posts at Scale: A Franchise Content Strategy | Untab',
                'meta_description' => 'How multi-location franchises and brands schedule Google Posts offers, events, and updates across every profile without tripling their content workload.',
                'cover_image' => 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Google Posts are one of the cheapest, highest-impact ranking and engagement levers in local search — and the most underused.</p><h2>Why franchises benefit the most</h2><p>A single head-office post can be pushed to every location in seconds. Coupon codes, seasonal offers, and events stay consistent across the brand, while each profile continuously shows freshness signals to Google.</p><h2>Build a content pyramid</h2><ul><li><strong>Brand layer:</strong> National campaigns that publish to all locations</li><li><strong>Regional layer:</strong> Market-specific offers for a subset of locations</li><li><strong>Local layer:</strong> Store-level events and UGC from individual managers</li></ul><h2>Best practices</h2><p>Include a clear CTA (Book, Order, Call, Learn More), a valid coupon code, and a square 1200x1200 image. Preview your post exactly as it appears on Google before it goes live.</p><blockquote>Profiles that publish Google Posts regularly see an average 25% increase in profile clicks.</blockquote><h2>Do it at scale with Untab</h2><p>Untab lets you create, schedule, and publish posts to any combination of locations — from one to 500+ — with full preview and click tracking.</p>',
            ],
            [
                'title' => 'Multi-Location Google Business Profile Management: The No-Tab-Switch Workflow',
                'slug' => 'multi-location-gbp-management-workflow',
                'excerpt' => 'Managing 50+ locations? Stop juggling browser tabs. This is the workflow that keeps reviews, posts, insights, and search data in one place.',
                'category' => 'Multi-Location',
                'author' => 'Untab Team',
                'featured' => true,
                'status' => 'published',
                'tags' => ['multi-location', 'gbp', 'franchise'],
                'keywords' => 'manage multiple Google Business Profiles, multi-location GBP, franchise local SEO',
                'meta_title' => 'Multi-Location GBP Management: The No-Tab-Switch Workflow | Untab',
                'meta_description' => 'The workflow for managing reviews, posts, insights, and search data across 50+ Google Business Profiles in one dashboard instead of switching tabs.',
                'cover_image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Every new location multiplies your Google Business Profile workload. Reviews need replies, posts need scheduling, insights need reporting — and each one sits behind a separate browser tab.</p><h2>The one-dashboard math</h2><p>With 20 locations and 5 daily tasks, that is 100 tab-switches a day. Managing 100 locations is 500. Tab-switching does not scale — a centralized dashboard does.</p><h2>What a true multi-location workflow needs</h2><ul><li>See every location\'s key health metric on one screen</li><li>Filter the whole dashboard to any client, group, or location</li><li>Bulk-apply actions (reply, publish, schedule) across locations</li></ul><h2>The scorecard</h2><p>Rank locations by a composite health score, spot your best and worst performers, and get a data-backed recommendation on where to focus next.</p><h2>Untab keeps it all in one place</h2><p>Reviews, Google Posts, performance insights, and Google Search Console data live side by side in Untab — so you work on the business, not the tab bar.</p>',
            ],
            [
                'title' => 'How to Get More Google Reviews (Without Breaking the Rules)',
                'slug' => 'how-to-get-more-google-reviews',
                'excerpt' => 'The right way to ask for reviews is specific, timely, and frictionless. Learn proven tactics plus the review-generation tools that stay 100% compliant.',
                'category' => 'Review Management',
                'author' => 'Untab Team',
                'featured' => false,
                'status' => 'published',
                'tags' => ['reviews', 'review-generation', 'local-seo'],
                'keywords' => 'get more Google reviews, review generation, review link, QR code reviews',
                'meta_title' => 'How to Get More Google Reviews (Compliant & Effective) | Untab',
                'meta_description' => 'Proven, policy-compliant ways to get more Google reviews: the right ask at the right time, direct review links, and QR codes that remove friction.',
                'cover_image' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Reviews are the highest-leverage local SEO signal you control. But the ask matters as much as the volume.</p><h2>Ask at the moment of delight</h2><p>Right after a purchase, appointment, or delivery — when satisfaction peaks — is when a customer is most likely to leave a review.</p><h2>Reduce friction to one tap</h2><p>A direct review link that drops the customer straight into Google\'s review form removes every step that causes abandonment. A printable QR code on the counter turns a foot-traffic visit into a review with no typing.</p><h2>Stay compliant</h2><ul><li>Never buy reviews or incentivize a specific star rating</li><li>Do not gate reviews behind a positive survey</li><li>Only ask customers for a review when you genuinely served them</li></ul><h2>Free tools from Untab</h2><p>Use Untab\'s <strong>Review Link Generator</strong> and <strong>Review QR Code Maker</strong> to create compliant, one-tap asks — then monitor incoming reviews and reply with AI-generated drafts.</p>',
            ],
            [
                'title' => 'White-Label Reporting: How Local SEO Agencies Retain More Clients',
                'slug' => 'white-label-reporting-agency-retention',
                'excerpt' => 'Clients do not leave agencies over rankings — they leave over unclear value. White-label reporting proves your work and locks in renewals.',
                'category' => 'Agency Growth',
                'author' => 'Untab Team',
                'featured' => false,
                'status' => 'draft',
                'tags' => ['agency', 'white-label', 'client-reports'],
                'keywords' => 'white label reporting, agency client retention, local SEO reporting',
                'meta_title' => 'White-Label Reporting: How Agencies Retain More Clients | Untab',
                'meta_description' => 'How local SEO agencies use white-label reporting to prove value, reduce churn, and retain more clients — with branded PDF reports in minutes.',
                'cover_image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Most agencies lose clients not because the work is bad, but because the client cannot see the value.</p><h2>Reporting is retention</h2><p>Regular, branded reports turn an opaque service into a transparent partnership. When a client sees their reviews grow and their map-pack position climb, they renew.</p><h2>Make it white-label</h2><ul><li>Your logo, your colors, your contact details</li><li>Executive summary in plain language</li><li>Before/after metrics the client actually cares about</li></ul><h2>Automate the grind</h2><p>Manually building reports eats hours every month. Centralize review, post, insight, and Search Console data and generate a polished client-ready report in one click.</p>',
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }

        // An extra evergreen post to guarantee the listing has at least one
        // published, non-featured live article on a fresh install.
        BlogPost::updateOrCreate(
            ['slug' => 'complete-gbp-checklist-16-point-audit'],
            [
                'title' => 'The 16-Point Google Business Profile Audit Checklist',
                'slug' => 'complete-gbp-checklist-16-point-audit',
                'excerpt' => 'Run the same 16-point health audit the pros use. Score your profile against the factors that actually move the map pack.',
                'category' => 'Tips & Tricks',
                'author' => 'Untab Team',
                'featured' => false,
                'status' => 'published',
                'tags' => ['gbp', 'audit', 'checklist'],
                'keywords' => 'GBP audit checklist, Google Business Profile audit, profile health score',
                'meta_title' => 'The 16-Point Google Business Profile Audit Checklist | Untab',
                'meta_description' => 'A 16-point Google Business Profile audit covering NAP consistency, categories, photos, reviews, posts, and more — with a free health scoring tool.',
                'cover_image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Quick, repeatable audits are the backbone of any local SEO campaign. Use this 16-point checklist to find the gaps in any profile.</p><h2>Core profile</h2><ul><li>1. Business name matches the real world</li><li>2. Primary + secondary categories set</li><li>3. NAP consistent across the web</li><li>4. Phone with a trackable number</li></ul><h2>Content & activity</h2><ul><li>5. Photos uploaded with categories & geotags</li><li>6. Google Posts published in the last 14 days</li><li>7. Offers & coupons valid</li><li>8. Q&A answered</li></ul><h2>Reviews & engagement</h2><ul><li>9. Review response rate at 100%</li><li>10. Average rating improving</li><li>11. Keywords naturally in reviews</li><li>12. No spammy or policy-violating reviews</li></ul><h2>Insights & measurement</h2><ul><li>13. Profile clicks tracked</li><li>14. Direction requests monitored</li><li>15. Phone calls & website clicks counted</li><li>16. Search Console connected</li></ul><p>Run it free with Untab\'s <strong>GBP Audit Health Score</strong> tool and get a 0-100 score in seconds.</p>',
            ]
        );
    }
}
