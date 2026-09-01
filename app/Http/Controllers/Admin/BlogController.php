<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = trim($request->get('q', ''));

        $posts = BlogPost::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($search, fn ($q) => $q
                ->where(fn ($qq) => $qq
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")))
            ->orderByDesc('published_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.blogs.index', compact('posts', 'status', 'search'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['tags'] = $request->filled('tags') ? collect(explode(',', $request->tags))->map('trim')->filter()->values()->all() : [];
        $data['reading_time'] = $request->reading_time ?: null;
        $data['published_at'] = $data['status'] === 'published' && empty($request->published_at)
            ? now()
            : ($request->filled('published_at') ? $request->published_at : null);

        $post = BlogPost::create($data);

        return redirect()->route('admin.blogs.edit', $post)
            ->with('success', 'Blog post created.');
    }

    public function edit(BlogPost $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $data = $this->validateData($request, $blog);
        $data['tags'] = $request->filled('tags') ? collect(explode(',', $request->tags))->map('trim')->filter()->values()->all() : [];
        $data['reading_time'] = $request->reading_time ?: null;
        $data['published_at'] = $request->filled('published_at')
            ? $request->published_at
            : ($data['status'] === 'published' ? ($blog->published_at ?? now()) : null);

        $blog->update($data);

        return redirect()->route('admin.blogs.edit', $blog)
            ->with('success', 'Blog post updated.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted.');
    }

    protected function validateData(Request $request, ?BlogPost $blog = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug'.($blog ? ','.$blog->id : '')],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'cover_image' => ['nullable', 'url', 'max:2048'],
            'category' => ['required', 'string', 'max:120'],
            'tags' => ['nullable', 'string'],
            'author' => ['nullable', 'string', 'max:120'],
            'status' => ['required', 'in:published,draft,scheduled'],
            'featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'reading_time' => ['nullable', 'string', 'max:40'],
        ]);
    }
}
