<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Support\SeoHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * Public blog. Fail-safe: if the `blog_posts` table hasn't been migrated yet
 * (common on a pre-existing installed DB), the pages render without crashing
 * so the marketing site never breaks.
 */
class BlogController extends Controller
{
    /**
     * Blog index — paginated list with category filter & search.
     */
    public function index(Request $request)
    {
        $category = $request->get('category');
        $search = trim($request->get('q', ''));

        // If the blog table isn't migrated yet, render a safe empty blog page.
        if (! Schema::hasTable('blog_posts')) {
            $posts = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 9);

            return view('marketing.blog-index', [
                'posts' => $posts,
                'featured' => collect(),
                'categories' => [],
                'category' => $category,
                'search' => $search,
            ]);
        }

        $posts = BlogPost::published()
            ->category($category)
            ->when($search, fn ($q) => $q
                ->where(fn ($qq) => $qq
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $featured = BlogPost::published()->featured()->take(3)->get();
        $categories = BlogPost::published()->distinct()->orderBy('category')->pluck('category')->all();

        return view('marketing.blog-index', compact('posts', 'featured', 'categories', 'category', 'search'));
    }

    /**
     * Single blog post with JSON-LD BlogPosting + BreadcrumbList.
     */
    public function show(BlogPost $post)
    {
        // Route-model binding by slug; if the table hasn't been migrated yet,
        // the binding would already 404 — just be defensive & consistent.
        if (! Schema::hasTable('blog_posts')) {
            abort(404);
        }

        if ($post->status !== 'published') {
            abort(404);
        }

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($related->isEmpty()) {
            $related = BlogPost::published()->where('id', '!=', $post->id)->latest('published_at')->take(3)->get();
        }

        // FAQs driven by the Super Admin-managed `faqs` table. Falls back to a
        // small static list only if the DB has no active FAQs (e.g. pre-seed).
        $faqs = $this->faqsForArticle();

        $jsonLd = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $post->title,
                'description' => $post->meta_description ?? $post->excerpt,
                'image' => $post->cover_image,
                'datePublished' => optional($post->published_at)->toIso8601String(),
                'dateModified' => optional($post->updated_at)->toIso8601String(),
                'author' => ['@type' => 'Person', 'name' => $post->author],
                'publisher' => ['@type' => 'Organization', 'name' => 'Untab'],
                'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => url()->current()],
            ],
            SeoHelper::breadcrumbSchema([
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'Blog', 'url' => route('blog.index')],
                ['name' => $post->title, 'url' => route('blog.show', $post)],
            ]),
            SeoHelper::faqSchema(
                collect($faqs)->map(fn ($f) => ['q' => $f['q'], 'a' => $f['a']])->all()
            ),
        ];

        return view('marketing.blog-show', compact('post', 'related', 'jsonLd', 'faqs'));
    }

    /**
     * Active FAQs for the article, surfaced from the Super Admin-managed
     * `faqs` table. Prefers a "Blog" category if present, otherwise uses all
     * visible FAQs; falls back only when the table is empty or unmigrated.
     *
     * @return array<int, array{q:string, a:string}>
     */
    protected function faqsForArticle(): array
    {
        try {
            if (Schema::hasTable('faqs')) {
                $blogFaqs = Faq::visible('Blog')->get();
                $all = $blogFaqs->isNotEmpty() ? $blogFaqs : Faq::visible()->get();

                $mapped = $all->map(fn ($f) => ['q' => $f->question, 'a' => $f->answer])->values()->all();
                if (! empty($mapped)) {
                    return array_slice($mapped, 0, 6);
                }
            }
        } catch (\Throwable $e) {
            // Fall through to the static defaults below.
        }

        return [
            ['q' => 'What is Untab and who is it for?', 'a' => 'Untab is a Google Business Profile management platform built for SEO agencies, franchise operators, and multi-location brands that need to run many local profiles from one dashboard.'],
            ['q' => 'How many Google Business Profiles can I manage?', 'a' => 'Untab supports 10 to 500+ profiles per organization. You can group locations into client portfolios and filter every module by client, group, or a single location.'],
            ['q' => 'Can Untab reply to Google reviews for me?', 'a' => 'Yes. The AI Review Reply Assistant drafts on-brand responses in seconds based on star rating, sentiment, and tone, and you can publish replies individually or in bulk.'],
            ['q' => 'Does Untab schedule Google Posts?', 'a' => 'Yes. Create and schedule updates, offers with coupon codes, and events across any subset of locations with a live Google card preview.'],
            ['q' => 'Can I send white-label reports to clients?', 'a' => 'Yes. Generate branded performance PDF reports with your agency logo and a client-ready link.'],
            ['q' => 'Is Untab free to start?', 'a' => 'Yes. Start free and explore every module in the live demo without a credit card.'],
        ];
    }
    }
}
