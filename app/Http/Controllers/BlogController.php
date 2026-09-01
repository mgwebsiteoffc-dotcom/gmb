<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
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
        ];

        return view('marketing.blog-show', compact('post', 'related', 'jsonLd'));
    }
}
