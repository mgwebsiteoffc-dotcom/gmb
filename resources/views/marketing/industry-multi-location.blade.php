@extends('layouts.marketing')

@section('title', 'Multi-Location GBP Management Software | Untab')

@php
    $faqs = [
        ['q' => 'How does Untab handle hundreds of locations?', 'a' => 'Group locations by brand or franchise, then filter every module by client, group, or a single location. Post to 100+ stores in one click.'],
        ['q' => 'Can store managers see only their own location?', 'a' => 'Yes. Give location managers role-based access so they manage only the profiles they own.'],
        ['q' => 'How do I benchmark my best and worst locations?', 'a' => 'The cross-location comparison matrix shows calls, directions, clicks, and health scores side by side.'],
    ];
    $jsonLd = [\App\Support\SeoHelper::faqSchema($faqs)];
@endphp

@section('content')
<section class="py-16 bg-gradient-to-b from-[#eef1ff] to-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs font-bold text-brand-600 bg-brand-100/80 px-3.5 py-1 rounded-full uppercase tracking-wider">
            Franchise & Multi-Location Brands
        </span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-slate-900 mt-4 mb-4">
            Every location's Google presence, <span class="text-brand-600">one command centre.</span>
        </h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
            Whether you run 10 outlets or 1,000, every location's profile stays active, accurate and on-brand — from one login.
        </p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('app.dashboard') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-8 py-3.5 rounded-2xl transition-all shadow-md">
                Open Multi-Location Dashboard →
            </a>
        </div>
    </div>
</section>

<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base font-display mb-2">One Campaign, Every Location</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Launch holiday promotions, seasonal menu updates, or new store hours to 500+ locations simultaneously.
            </p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base font-display mb-2">Centralized Review Feed</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Keep review response times under 2 hours across all regions with AI templates tailored to your brand voice.
            </p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base font-display mb-2">Spot Underperforming Stores</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Compare calls, directions, and health scores across cities to identify which stores need local SEO attention.
            </p>
        </div>
    </div>
</section>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Multi-Location Management FAQ', 'faqIntro' => 'Franchise and multi-location brands running 10 to 500+ Google Business Profiles.'])
@endsection
