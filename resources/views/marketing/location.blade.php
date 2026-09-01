@extends('layouts.marketing')

@php($jsonLd = [
    [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => $location->name,
        'image' => $location->cover_image,
        'telephone' => $location->phone,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $location->address,
            'addressCountry' => 'US',
        ],
        'aggregateRating' => [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) $location->rating,
            'reviewCount' => (string) $location->review_count,
        ],
        'url' => url()->current(),
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Locations', 'item' => route('location.show', \Illuminate\Support\Str::slug($location->name))],
        ],
    ],
])

@section('title', $location->name.' — Untab Local SEO Profile')
@section('meta_description', 'Learn about '.$location->name.' — '.$location->category.' reviews, services, and local SEO visibility managed with Untab.')
@section('meta_keywords', $location->name.', '.$location->category.', local SEO, Google Business Profile, location management')

@section('content')
<section class="py-16 bg-gradient-to-b from-[#f0f4ff] to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs font-bold text-slate-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-brand-700">Home</a> <span class="mx-1">/</span>
            <span class="text-slate-800">{{ $location->name }}</span>
        </nav>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            <div class="h-52 sm:h-64 bg-gradient-to-tr from-brand-800 to-brand-500 bg-cover bg-center" style="background-image:url('{{ $location->cover_image }}')"></div>
            <div class="p-6 sm:p-10">
                <div class="flex items-center gap-3 mb-4">
                    <h1 class="text-2xl sm:text-3xl font-black font-display text-slate-900">{{ $location->name }}</h1>
                    @if($location->verified)
                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-extrabold uppercase tracking-wider px-2 py-1 rounded-full border border-emerald-200">Verified</span>
                    @endif
                </div>
                <div class="space-y-3 text-sm text-slate-600 max-w-2xl">
                    <div class="flex items-center gap-2"><i data-lucide="map-pin" class="w-4 h-4 text-brand-600"></i> {{ $location->address }}</div>
                    @if($location->phone)<div class="flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4 text-brand-600"></i> {{ $location->phone }}</div>@endif
                    <div class="flex items-center gap-2"><i data-lucide="star" class="w-4 h-4 text-amber-500"></i> <strong>{{ number_format($location->rating, 1) }}</strong> ({{ $location->review_count }} reviews)</div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8">
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Monthly Views</div>
                        <div class="text-xl font-extrabold text-slate-900 font-display">{{ number_format($location->monthly_views) }}</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Calls</div>
                        <div class="text-xl font-extrabold text-slate-900 font-display">{{ number_format($location->monthly_calls) }}</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Directions</div>
                        <div class="text-xl font-extrabold text-slate-900 font-display">{{ number_format($location->monthly_directions) }}</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Website Clicks</div>
                        <div class="text-xl font-extrabold text-slate-900 font-display">{{ number_format($location->monthly_website_clicks) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>lucide.createIcons();</script>
@endpush
