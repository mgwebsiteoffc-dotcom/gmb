@extends('layouts.marketing')

@section('title', $post->meta_title ?: $post->title . ' | Untab Blog')
@section('meta_description', $post->meta_description ?: $post->excerpt)
@section('meta_keywords', $post->keywords ?: 'Google Business Profile, local SEO, GBP tips, review management')

@push('json-ld')
@foreach($jsonLd as $schema)
<script type="application/ld+json">
@json($schema)
</script>
@endforeach
@endpush

@push('styles')
<style>
    .article-body h2 { font-weight: 900; font-size: 1.5rem; line-height: 1.25; color: #0f172a; margin-top: 2rem; margin-bottom: 0.75rem; }
    .article-body h3 { font-weight: 800; font-size: 1.1rem; color: #0f172a; margin-top: 1.5rem; margin-bottom: 0.5rem; }
    .article-body p { color: #475569; line-height: 1.8; margin-bottom: 1rem; }
    .article-body ul { list-style: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    .article-body ol { list-style: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
    .article-body li { color: #475569; line-height: 1.7; margin-bottom: 0.35rem; }
    .article-body a { color: #3d47e0; font-weight: 700; text-decoration: underline; text-decoration-color: #c3d5fb; }
    .article-body blockquote { border-left: 4px solid #3d47e0; background: #f0f4ff; border-radius: 0 1rem 1rem 0; padding: 1rem 1.25rem; margin: 1.5rem 0; font-style: italic; color: #1e293b; }
    .article-body strong { color: #0f172a; }
    .article-body table { width: 100%; border-collapse: collapse; margin: 1.5rem 0; font-size: 0.9rem; }
    .article-body th { background: #f0f4ff; color: #1e1b4b; font-weight: 800; text-align: left; padding: 0.6rem 0.75rem; border: 1px solid #e2e5f5; }
    .article-body td { padding: 0.6rem 0.75rem; border: 1px solid #e2e5f5; color: #475569; }
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<nav class="bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-xs font-bold text-slate-500 flex items-center gap-1.5 flex-wrap">
        <a href="{{ url('/') }}" class="hover:text-brand-600">Home</a>
        <span class="text-slate-300">›</span>
        <a href="{{ route('blog.index') }}" class="hover:text-brand-600">Blog</a>
        <span class="text-slate-300">›</span>
        <a href="{{ route('blog.index', ['category' => $post->category]) }}" class="hover:text-brand-600">{{ $post->category }}</a>
        <span class="text-slate-300">›</span>
        <span class="text-slate-700 truncate">{{ $post->title }}</span>
    </div>
</nav>

<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Category pill -->
    <a href="{{ route('blog.index', ['category' => $post->category]) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-[11px] font-extrabold uppercase tracking-wider">
        <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
        {{ $post->category }}
    </a>

    <!-- Title -->
    <h1 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-tight">{{ $post->title }}</h1>

    <!-- Lead / excerpt -->
    @if($post->excerpt)
        <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed font-medium">{{ $post->excerpt }}</p>
    @endif

    <!-- Byline -->
    <div class="mt-6 flex items-center gap-3 text-sm text-slate-500">
        <div class="w-10 h-10 rounded-full bg-brand-600 text-white flex items-center justify-center font-black flex-shrink-0">{{ strtoupper($post->author[0]) }}</div>
        <div>
            <div class="font-bold text-slate-700">{{ $post->author }}</div>
            <div class="text-xs">
                {{ $post->published_at?->format('F j, Y') }}
                <span class="text-slate-300">•</span>
                {{ $post->reading_time ?: $post->calculateReadingTime() }}
                @if($post->updated_at && $post->updated_at >= $post->published_at?->addDay())
                    <span class="text-slate-300">•</span> Updated {{ $post->updated_at->format('M Y') }}
                @endif
            </div>
        </div>
    </div>

    <!-- Cover -->
    @if($post->cover_image)
        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="mt-8 w-full h-64 sm:h-96 object-cover rounded-2xl shadow-sm" loading="eager">
    @endif

    <!-- Body -->
    <div class="article-body mt-8 prose prose-slate max-w-none">
        {!! $post->content !!}
    </div>

    <!-- Tags -->
    @if(! empty($post->tags))
        <div class="mt-8 flex flex-wrap gap-2">
            @foreach($post->tags as $tag)
                <a href="{{ route('blog.index', ['q' => $tag]) }}" class="px-3 py-1 rounded-full bg-slate-100 text-xs font-bold text-slate-600 hover:bg-brand-50 hover:text-brand-700">#{{ $tag }}</a>
            @endforeach
        </div>
    @endif

    <!-- Inline CTA box -->
    <div class="mt-10 bg-gradient-to-r from-brand-900 via-brand-800 to-indigo-950 rounded-2xl p-8 text-center text-white">
        <h3 class="text-2xl font-black font-display">Manage your Google Business Profile on autopilot.</h3>
        <p class="mt-2 text-brand-100 text-sm sm:text-base max-w-xl mx-auto">AI review replies · Google Post scheduling · Performance insights · Multi-location. Start free — no credit card required.</p>
        <div class="mt-5 flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('app.dashboard') }}" class="bg-accent-500 hover:bg-accent-600 text-white font-extrabold text-sm px-6 py-3 rounded-xl transition-all shadow-xl">Start Free Trial →</a>
            <a href="{{ route('demo') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold text-sm px-6 py-3 rounded-xl transition-all border border-white/20">See the demo</a>
        </div>
    </div>

    <!-- FAQ (Super Admin managed) -->
    <section id="faq" class="mt-12">
        <div class="text-center mb-6">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">FAQ</span>
            <h2 class="text-2xl sm:text-3xl font-black font-display text-slate-900 mt-3">Frequently Asked Questions</h2>
            <p class="text-slate-600 text-sm mt-2">Answers to the questions businesses ask about the Untab Google Business Profile platform.</p>
        </div>
        <div class="space-y-3">
            @foreach($faqs as $index => $faq)
                <details class="group bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden {{ $index === 0 ? 'ring-1 ring-brand-200' : '' }}">
                    <summary class="flex items-center justify-between gap-4 px-5 py-4 cursor-pointer font-bold text-slate-800 text-sm sm:text-base hover:bg-brand-50/50 transition-colors">
                        <span>{{ $faq['q'] }}</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform flex-shrink-0"></i>
                    </summary>
                    <div class="px-5 pb-4 text-slate-600 text-sm leading-relaxed">{{ $faq['a'] }}</div>
                </details>
            @endforeach
        </div>
    </section>

    <!-- Author box -->
    <div class="mt-10 bg-brand-50 border border-brand-100 rounded-2xl p-6 flex flex-col sm:flex-row items-start gap-4">
        <div class="w-12 h-12 rounded-xl bg-brand-600 text-white flex items-center justify-center font-black flex-shrink-0">U</div>
        <div>
            <div class="font-black text-slate-900">About Untab</div>
            <p class="mt-1 text-sm text-slate-600">The all-in-one Google Business Profile management platform for agencies and multi-location brands. Built by a team that managed 4,000+ local profiles across 15+ countries.</p>
            <a href="{{ route('demo') }}" class="inline-flex items-center gap-1.5 mt-3 text-sm font-bold text-brand-600 hover:text-brand-700">Try the live demo <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
        </div>
    </div>
</article>

<!-- Related posts -->
@if($related->isNotEmpty())
<section class="bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-black text-slate-900">Keep reading</h2>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($related as $p)
                <a href="{{ route('blog.show', $p) }}" class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
                    @if($p->cover_image)
                        <div class="h-40 overflow-hidden"><img src="{{ $p->cover_image }}" alt="{{ $p->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy"></div>
                    @endif
                    <div class="p-5">
                        <div class="text-[10px] font-extrabold uppercase tracking-wide text-brand-600">{{ $p->category }}</div>
                        <h3 class="mt-2 font-black text-slate-900 leading-snug group-hover:text-brand-700">{{ $p->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
