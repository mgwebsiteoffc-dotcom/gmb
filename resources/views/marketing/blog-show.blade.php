@extends('layouts.marketing')

@section('title', $post->meta_title ?: $post->title . ' | Untab Blog')
@section('meta_description', $post->meta_description ?: $post->excerpt)

@push('json-ld')
@foreach($jsonLd as $schema)
<script type="application/ld+json">
@json($schema)
</script>
@endforeach
@endpush

@section('content')
<!-- Breadcrumb -->
<nav class="bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-xs font-bold text-slate-500 flex items-center gap-1.5">
        <a href="{{ url('/') }}" class="hover:text-brand-600">Home</a>
        <span class="text-slate-300">/</span>
        <a href="{{ route('blog.index') }}" class="hover:text-brand-600">Blog</a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-700 truncate">{{ $post->title }}</span>
    </div>
</nav>

<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-wide text-brand-600">
        <a href="{{ route('blog.index', ['category' => $post->category]) }}">{{ $post->category }}</a>
        <span class="text-slate-300">•</span>
        <span class="text-slate-400">{{ $post->reading_time ?: $post->calculateReadingTime() }}</span>
    </div>

    <h1 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-tight">{{ $post->title }}</h1>

    <div class="mt-4 flex items-center gap-3 text-sm text-slate-500">
        <div class="w-9 h-9 rounded-full bg-brand-600 text-white flex items-center justify-center font-black">{{ strtoupper($post->author[0]) }}</div>
        <div>
            <div class="font-bold text-slate-700">{{ $post->author }}</div>
            <div class="text-xs">Published {{ $post->published_at?->format('F j, Y') }} • {{ $post->calculateReadingTime() }}</div>
        </div>
    </div>

    @if($post->cover_image)
        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="mt-8 w-full h-64 sm:h-96 object-cover rounded-2xl shadow-sm" loading="eager">
    @endif

    @if($post->excerpt)
        <p class="mt-8 text-lg text-slate-600 leading-relaxed font-medium">{{ $post->excerpt }}</p>
    @endif

    <div class="prose prose-slate max-w-none mt-6 prose-lg prose-headings:font-black prose-headings:text-slate-900 prose-a:text-brand-600">
        {!! $post->content !!}
    </div>

    @if(! empty($post->tags))
        <div class="mt-8 flex flex-wrap gap-2">
            @foreach($post->tags as $tag)
                <span class="px-3 py-1 rounded-full bg-slate-100 text-xs font-bold text-slate-600">#{{ $tag }}</span>
            @endforeach
        </div>
    @endif

    <!-- Author CTA -->
    <div class="mt-10 bg-brand-50 border border-brand-100 rounded-2xl p-6 flex flex-col sm:flex-row items-start gap-4">
        <div class="w-12 h-12 rounded-xl bg-brand-600 text-white flex items-center justify-center font-black flex-shrink-0">U</div>
        <div>
            <div class="font-black text-slate-900">About Untab</div>
            <p class="mt-1 text-sm text-slate-600">The all-in-one Google Business Profile management platform for agencies and multi-location brands.</p>
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
