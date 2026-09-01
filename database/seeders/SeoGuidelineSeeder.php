<?php

namespace Database\Seeders;

use App\Models\SeoGuideline;
use Illuminate\Database\Seeder;

class SeoGuidelineSeeder extends Seeder
{
    public function run(): void
    {
        $guidelines = [
            [
                'title' => 'Homepage SEO & AEO guidelines',
                'page_path' => '/',
                'page_type' => 'Home',
                'description' => 'Best practices for the Untab homepage to capture branded + category local SEO queries and earn featured snippets.',
                'seo_title_template' => 'Untab — Google Business Profile Management for Agencies & Multi-Location Brands',
                'meta_description_template' => 'Run every Google Business Profile from one dashboard. AI review replies, Google Posts scheduling, local insights, and white-label client reports.',
                'recommended_keywords' => ['google business profile management', 'gbp tool', 'local seo platform', 'review management software', 'multi-location seo'],
                'content' => '<h3>Title</h3><ul><li>Keep under 60 chars</li><li>Lead with the brand, then the value</li></ul><h3>Meta description</h3><ul><li>150-160 chars, include the primary keyword</li><li>End with a clear call-to-action</li></ul><h3>H1</h3><ul><li>One H1 only, contains the target keyword</li><li>Support with H2/H3 subheadings</li></ul><h3>JSON-LD</h3><ul><li>Organization + WebSite + SoftwareApplication schema on every page</li><li>Include FAQPage when a visible FAQ section is present</li><li>Add BreadcrumbList on all inner pages</li></ul><h3>Performance</h3><ul><li>LCP under 2.5s</li><li>Use responsive images with explicit dimensions</li></ul>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Blog index & blog post SEO',
                'page_path' => '/blog',
                'page_type' => 'Blog',
                'description' => 'On-page SEO guidelines for the blog index and individual articles, including BlogPosting structured data.',
                'seo_title_template' => '{Article Title} | Untab Blog',
                'meta_description_template' => '{150-char excerpt of the article, including the primary keyword}',
                'recommended_keywords' => ['local seo', 'google business profile', 'review management', 'franchise seo', 'gbp tips'],
                'content' => '<h3>Blog index</h3><ul><li>Include a <strong>Blog</strong> schema with publisher Organization</li><li>Keep categories as clean, keyword-bearing URLs</li></ul><h3>Blog post</h3><ul><li>Meta title max 60 chars from the article headline</li><li>Meta description 150-160 chars, unique per post</li><li>Add <strong>BlogPosting</strong> JSON-LD with author, publisher, datePublished, dateModified, and an image</li><li>Set a featured image ≥ 1200x630</li><li>Internal-link to at least 2 related posts</li><li>Use descriptive H2/H3 headings and a table of contents for long posts</li></ul>',
                'sort_order' => 2,
            ],
            [
                'title' => 'Pricing page SEO',
                'page_path' => '/pricing',
                'page_type' => 'Pricing',
                'description' => 'Target high-intent commercial keywords and use Offer/Product structured data where possible.',
                'seo_title_template' => 'Pricing | Untab Google Business Profile Management',
                'meta_description_template' => 'Simple, scalable pricing for Google Business Profile management. Start free and upgrade to manage unlimited client profiles with white-label reports.',
                'recommended_keywords' => ['gbp pricing', 'google business profile management cost', 'local seo agency pricing', 'white label seo pricing'],
                'content' => '<h3>Best practices</h3><ul><li>Answer pricing questions directly (AQ for featured snippets)</li><li>Use a comparison table</li><li>Clearly state what is included in each plan</li><li>Add a FAQ section with a FAQPage schema</li></ul><h3>Schema</h3><ul><li>Use <strong>Product</strong> or <strong>Offer</strong> schema with price and currency where a single product is sold</li></ul>',
                'sort_order' => 3,
            ],
            [
                'title' => 'Location / GBP profile page',
                'page_path' => '/location/{slug}',
                'page_type' => 'Location',
                'description' => 'Local SEO guidelines for location landing pages so each business can rank in its own map pack.',
                'seo_title_template' => '{Business Name} — {City} | Untab',
                'meta_description_template' => '{Business Name} in {City}. See reviews, photos, and how it ranks for local SEO.',
                'recommended_keywords' => ['{city} {business category}', 'near me', '{category} in {city}'],
                'content' => '<h3>Local page essentials</h3><ul><li>Unique title + meta description per location</li><li>Include NAP (name, address, phone) consistently</li><li>Embed the review schema (AggregateRating / LocalBusiness)</li><li>Add geo meta tags and Geo coordinates</li><li>Link to the associated Google Business Profile</li></ul>',
                'sort_order' => 4,
            ],
            [
                'title' => 'FAQ page SEO & AEO',
                'page_path' => '/faq',
                'page_type' => 'FAQ',
                'description' => 'Maximize featured-snippet and voice-search visibility from the central FAQ page.',
                'seo_title_template' => 'Frequently Asked Questions | Untab',
                'meta_description_template' => 'Answers to common questions about Untab — the Google Business Profile management platform for agencies and multi-location brands.',
                'recommended_keywords' => ['untab faq', 'gbp questions', 'google business profile help'],
                'content' => '<h3>Optimization</h3><ul><li>Use a single <strong>FAQPage</strong> schema containing all visible Q&amp;A pairs</li><li>Question should be a full, natural-language question (primary question-form keyword)</li><li>Answer concisely in 40-60 words — the answer is what Google pulls for snippets</li><li>Duplicate the exact question in the H3 and the JSON-LD</li></ul>',
                'sort_order' => 5,
            ],
            [
                'title' => 'Free tools pages',
                'page_path' => '/google-business-profile-audit-tool',
                'page_type' => 'Tools',
                'description' => 'Guidelines for the free interactive tools to earn long-tail tool-style searches and backlinks.',
                'seo_title_template' => '{Tool Name} — Free Google Business Profile Tool | Untab',
                'meta_description_template' => 'Free {tool} for Google Business Profiles. No signup required.',
                'recommended_keywords' => ['free gbp audit tool', 'google review link generator', 'review qr code maker', 'gbp photo size'],
                'content' => '<h3>Best practices</h3><ul><li>Target <em>tool + service</em> long-tail queries</li><li>Add a <strong>WebApplication</strong> or <strong>SoftwareApplication</strong> schema</li><li>Include an FAQ section (FAQPage schema)</li><li>Link back to the main product conversion page</li></ul>',
                'sort_order' => 6,
            ],
            [
                'title' => 'Agency & white-label pages',
                'page_path' => '/white-label-agency',
                'page_type' => 'Agency',
                'description' => 'Reach SEO agencies looking for white-label tools and private-label reporting.',
                'seo_title_template' => 'White-Label Google Business Profile Management for Agencies | Untab',
                'meta_description_template' => 'The white-label GBP platform for SEO agencies. Branded client reports, bulk review replies, and post scheduling under your own brand.',
                'recommended_keywords' => ['white label gbp', 'seo agency white label', 'private label local seo', 'agency reporting tool'],
                'content' => '<h3>Optimization</h3><ul><li>Speak directly to agency pain points (retention, reporting)</li><li>Add a FAQ section with FAQPage schema</li><li>Include social proof and a clear CTA</li><li>Use <strong>Organization</strong> schema with a <em>makesOffer</em> where relevant</li></ul>',
                'sort_order' => 7,
            ],
        ];

        foreach ($guidelines as $g) {
            SeoGuideline::updateOrCreate(
                ['title' => $g['title']],
                $g
            );
        }
    }
}
