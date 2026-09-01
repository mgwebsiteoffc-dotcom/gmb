@extends('layouts.marketing')

@section('title', $industry['seoTitle'])
@section('meta_description', $industry['seoDesc'])
@section('meta_keywords', $industry['keywords'])

@php($faqs = $industry['faqs'])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Industries', 'url' => route('industries')],
        ['name' => $industry['name'], 'url' => route('industry.show', $industry['slug'])],
    ]),
    \App\Support\SeoHelper::softwareApplicationSchema(['name' => 'Untab']),
])

@section('content')
<!-- Hero -->
<section class="relative bg-gradient-to-b from-brand-50 to-white py-16 overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-60 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-xs font-extrabold uppercase tracking-widest mb-6 shadow-sm">
            <i data-lucide="{{ $industry['icon'] }}" class="w-4 h-4"></i>
            {{ $industry['eyebrow'] }}
        </span>
        <h1 class="text-4xl sm:text-5xl font-black font-display tracking-tight text-slate-900 max-w-3xl mx-auto leading-[1.08]">
            {{ $industry['h1'] }}
        </h1>
        <p class="mt-5 text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed">
            {{ $industry['intro'] }}
        </p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('app.dashboard') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-black text-sm sm:text-base px-8 py-4 rounded-2xl transition-all shadow-xl flex items-center gap-2">
                <span>Start free</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
            <a href="{{ route('demo') }}" class="bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm sm:text-base px-7 py-4 rounded-2xl transition-all border border-slate-200 shadow-sm flex items-center gap-2">
                <i data-lucide="play-circle" class="w-4 h-4 text-brand-600"></i>
                <span>See how it helps</span>
            </a>
        </div>
    </div>
</section>

<!-- Metrics -->
@if(! empty($industry['metrics']))
<section class="border-b border-slate-200 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-3 gap-6 text-center">
        @foreach($industry['metrics'] as $m)
            <div>
                <div class="text-2xl sm:text-4xl font-black font-display text-brand-800">{{ $m['value'] }}</div>
                <div class="text-[11px] sm:text-xs font-bold text-slate-500 mt-1">{{ $m['label'] }}</div>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- Hero features -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($industry['heroFeatures'] as $feature)
                <div class="flex items-center gap-3 bg-[#f8faff] rounded-2xl border border-slate-200/90 p-5">
                    <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="check" class="w-5 h-5"></i>
                    </div>
                    <p class="text-sm font-semibold text-slate-700">{{ $feature }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Pain points / benefits -->
<section class="py-16 bg-[#f8faff] border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">The problem</span>
                <h2 class="text-2xl sm:text-3xl font-black font-display text-slate-900 mt-3 mb-5">Where {{ \Illuminate\Support\Str::lower($industry['name']) }} lose the local search.</h2>
                <ul class="space-y-3">
                    @foreach($industry['painPoints'] as $p)
                        <li class="flex items-start gap-2.5 text-sm text-slate-600">
                            <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                            <span>{{ $p }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">The fix</span>
                <h2 class="text-2xl sm:text-3xl font-black font-display text-slate-900 mt-3 mb-5">How Untab helps {{ \Illuminate\Support\Str::lower($industry['name']) }}.</h2>
                <div class="space-y-4">
                    @foreach($industry['benefits'] as $b)
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-sm">
                            <h3 class="font-bold text-slate-900 text-sm font-display">{{ $b['title'] }}</h3>
                            <p class="text-xs text-slate-500 leading-relaxed mt-1.5">{{ $b['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-gradient-to-r from-brand-900 via-brand-800 to-indigo-950 text-white text-center">
    <div class="max-w-3xl mx-auto px-4 space-y-5">
        <h2 class="text-3xl sm:text-4xl font-black font-display tracking-tight">See it work for <span class="text-accent-500">{{ $industry['name'] }}</span>.</h2>
        <p class="text-brand-100 text-sm sm:text-base max-w-xl mx-auto">Launch the demo today and manage a real Google Business Profile from one dashboard. Start free — no credit card required.</p>
        <a href="{{ route('app.dashboard') }}" class="inline-block bg-accent-500 hover:bg-accent-600 text-white font-extrabold text-sm sm:text-base px-8 py-3.5 rounded-2xl transition-all shadow-xl">Start free →</a>
    </div>
</section>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => $industry['name'].' FAQ', 'faqIntro' => 'How Untab helps '.\Illuminate\Support\Str::lower($industry['name']).' win on Google Maps.'])
@endsection
