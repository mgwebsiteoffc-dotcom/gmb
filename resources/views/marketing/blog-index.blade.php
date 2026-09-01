@extends('layouts.marketing')

@section('title', 'Blog — Local SEO & Google Business Profile Insights | Untab')
@section('meta_description', 'Practical guides on Google Business Profile management, local SEO, review generation, and multi-location marketing from the Untab team.')

@php($blogIndexSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Blog',
    'name' => 'Untab Blog',
    'url' => route('blog.index'),
    'description' => 'Practical guides on Google Business Profile management, local SEO, review generation, and multi-location marketing.',
    'publisher' => ['@type' => 'Organization', 'name' => 'Untab'],
])

@push('json-ld')
<script type="application/ld+json">
@json($blogIndexSchema)
</script>
@endpush

@section('content')
<!-- Hero -->
<section class="bg-brand-600 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 text-center">
        <p class="inline-flex items-center gap-2 text-brand-100 text-sm font-bold tracking-wide uppercase bg-white/10 rounded-full px-4 py-1.5">Untab Insights</p>
        <h1 class="text-3xl sm:text-5xl font-black text-white mt-6 leading-tight">The Local SEO &amp; GBP Playbook</h1>
        <p class="mt-5 text-lg text-brand-100 max-w-2xl mx-auto">Actionable guides to rank higher, win more reviews, and run every Google Business Profile from one dashboard.</p>
        <form method="GET" action="{{ route('blog.index') }}" class="mt-8 max-w-xl mx-auto flex flex-col sm:flex-row gap-2">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search articles…"
                   class="flex-1 rounded-xl bg-white/95 border border-white/20 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-white">
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm px-6 py-3 rounded-xl transition-all">Search</button>
        </form>
    </div>
</section>

<!-- Categories chip bar -->
<section class="border-b border-slate-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-wrap items-center gap-2 overflow-x-auto">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold {{ empty($category) ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">All</a>
        @foreach($categories as $c)
            <a href="{{ route('blog.index', ['category' => $c]) }}" class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold {{ $category === $c ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">{{ $c }}</a>
        @endforeach
    </div>
</section>

<!-- Featured -->
@if($featured->isNotEmpty() && ! $category && ! $search)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid gap-6 lg:grid-cols-3">
        @foreach($featured as $i => $post)
            <a href="{{ route('blog.show', $post) }}" class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden {{ $i === 0 ? 'lg:col-span-2' : '' }}">
                @if($post->cover_image)
                    <div class="{{ $i === 0 ? 'h-64 sm:h-80' : 'h-44' }} overflow-hidden">
                        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </div>
                @else
                    <div class="{{ $i === 0 ? 'h-64 sm:h-80' : 'h-44' }} bg-gradient-to-br from-brand-600 to-brand-800 flex items-center justify-center">
                        <span class="text-brand-100 font-black text-5xl">{{ strtoupper($post->title[0]) }}</span>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-wide text-brand-600">
                        <span>{{ $post->category }}</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-slate-400">{{ $post->reading_time ?: $post->calculateReadingTime() }}</span>
                    </div>
                    <h2 class="mt-3 text-xl font-black text-slate-900 leading-snug group-hover:text-brand-700">{{ $post->title }}</h2>
                    <p class="mt-2 text-sm text-slate-500 line-clamp-3">{{ $post->excerpt }}</p>
                    <div class="mt-4 text-xs font-bold text-slate-500">{{ $post->author }} • {{ $post->published_at?->format('M d, Y') }}</div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

<!-- All posts -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 pb-20">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($posts as $post)
            <a href="{{ route('blog.show', $post) }}" class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
                @if($post->cover_image)
                    <div class="h-44 overflow-hidden">
                        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </div>
                @else
                    <div class="h-44 bg-gradient-to-br from-brand-600 to-brand-800 flex items-center justify-center">
                        <span class="text-brand-100 font-black text-5xl">{{ strtoupper($post->title[0]) }}</span>
                    </div>
                @endif
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-wide text-brand-600">
                        <span>{{ $post->category }}</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-slate-400">{{ $post->reading_time ?: $post->calculateReadingTime() }}</span>
                    </div>
                    <h2 class="mt-3 text-lg font-black text-slate-900 leading-snug group-hover:text-brand-700">{{ $post->title }}</h2>
                    <p class="mt-2 text-sm text-slate-500 line-clamp-3 flex-1">{{ $post->excerpt }}</p>
                    <div class="mt-4 text-xs font-bold text-slate-500">{{ $post->author }} • {{ $post->published_at?->format('M d, Y') }}</div>
                </div>
            </a>
        @empty
            <div class="sm:col-span-2 lg:col-span-3 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-14 text-center">
                <p class="text-slate-400 text-sm">No articles found{{ $search ? ' for “'.$search.'”' : '' }}.</p>
                <a href="{{ route('blog.index') }}" class="mt-3 inline-block text-sm font-bold text-brand-600 hover:text-brand-700">← Back to all posts</a>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $posts->links() }}
    </div>
</section>

<!-- CTA band -->
<section class="bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 text-center">
        <h2 class="text-2xl sm:text-3xl font-black text-white">Want these wins for your clients?</h2>
        <p class="mt-3 text-slate-300 max-w-xl mx-auto">See how Untab makes Google Business Profile management effortless for agencies and multi-location brands.</p>
        <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}#demo" class="bg-brand-600 hover:bg-brand-500 text-white font-bold px-6 py-3 rounded-xl transition-all">Try the Live Demo</a>
            <a href="{{ route('pricing') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold px-6 py-3 rounded-xl transition-all">View Pricing</a>
        </div>
    </div>
</section>
@endsection
