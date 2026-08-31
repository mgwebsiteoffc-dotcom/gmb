@extends('layouts.marketing')

@php
    $jsonLd = [[
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => 'Untab',
        'description' => 'Google Business Profile management platform for agencies and multi-location brands.',
        'offers' => [
            '@type' => 'AggregateOffer',
            'lowPrice' => '0',
            'highPrice' => '349',
            'priceCurrency' => 'USD',
            'offerCount' => '3',
        ],
    ]];
@endphp

@section('title', 'Pricing — Start free with Untab, Google Business Profile Platform')

@section('content')
<section class="py-20 bg-gradient-to-b from-[#eef1ff] to-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">Pricing</span>
            <h1 class="text-3xl sm:text-5xl font-black font-display text-slate-900 mt-4">Simple, transparent pricing.</h1>
            <p class="text-slate-600 text-sm sm:text-base mt-3">Start free. Scale as your local client roster grows. No credit card required.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <h3 class="text-sm font-extrabold uppercase tracking-widest text-slate-500">Starter</h3>
                <div class="mt-4"><span class="text-4xl font-black font-display text-slate-900">$0</span><span class="text-slate-500 text-sm">/mo</span></div>
                <p class="text-sm text-slate-600 mt-2">For agencies testing local SEO workflows.</p>
                <ul class="mt-6 space-y-3 text-xs text-slate-700">
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Up to 10 profiles</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> AI review replies</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Google Posts scheduling</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Free SEO tools</li>
                </ul>
                <a href="{{ route('app.dashboard') }}" class="mt-8 block text-center bg-brand-50 hover:bg-brand-100 text-brand-700 font-extrabold py-3 rounded-xl text-sm border border-brand-200">Start Free</a>
            </div>

            <div class="bg-slate-900 rounded-3xl border border-slate-800 p-8 shadow-xl relative">
                <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-accent-500 text-white text-[10px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full">Most Popular</span>
                <h3 class="text-sm font-extrabold uppercase tracking-widest text-brand-300">Growth</h3>
                <div class="mt-4"><span class="text-4xl font-black font-display text-white">$149</span><span class="text-slate-400 text-sm">/mo</span></div>
                <p class="text-sm text-slate-400 mt-2">For agencies & franchises at scale.</p>
                <ul class="mt-6 space-y-3 text-xs text-slate-300">
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> Up to 100 profiles</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> Bulk AI reply engine</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> White-label reports</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> Team & permissions</li>
                </ul>
                <a href="{{ route('app.dashboard') }}" class="mt-8 block text-center bg-accent-500 hover:bg-accent-600 text-white font-extrabold py-3 rounded-xl text-sm">Try Growth Free</a>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <h3 class="text-sm font-extrabold uppercase tracking-widest text-slate-500">Enterprise</h3>
                <div class="mt-4"><span class="text-4xl font-black font-display text-slate-900">Custom</span></div>
                <p class="text-sm text-slate-600 mt-2">For 500+ location networks.</p>
                <ul class="mt-6 space-y-3 text-xs text-slate-700">
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Unlimited profiles</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Dedicated support</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Custom domain (white label)</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> API & integrations</li>
                </ul>
                <a href="{{ route('app.dashboard') }}" class="mt-8 block text-center bg-slate-100 hover:bg-slate-200 text-slate-800 font-extrabold py-3 rounded-xl text-sm">Talk to Sales</a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>lucide.createIcons();</script>
@endpush
