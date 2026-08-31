@extends('layouts.marketing')

@section('title', 'White-Label GBP Platform for Agencies | Untab')

@php
    $faqs = [
        ['q' => 'What is a white-label GBP platform?', 'a' => 'It\'s a Google Business Profile management tool that runs entirely under your agency\'s brand — your logo, your domain, your reports.'],
        ['q' => 'Can my agency resell Untab under its own brand?', 'a' => 'Yes. Customize your domain, brand color, logo, and report branding so your clients only see your agency.'],
        ['q' => 'Do my clients get their own login?', 'a' => 'Yes. Create client view-only logins so they see only their own locations.'],
    ];
    $jsonLd = [\App\Support\SeoHelper::faqSchema($faqs)];
@endphp

@section('content')
<section class="py-16 bg-gradient-to-r from-brand-800 to-indigo-900 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs font-bold bg-white/10 px-3.5 py-1 rounded-full uppercase tracking-wider border border-white/20">
            For SEO & Local Marketing Agencies
        </span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black font-display mt-4 mb-4">
            Your Brand. Your Domain. <span class="text-accent-400">Our Technology.</span>
        </h1>
        <p class="text-brand-100 text-sm sm:text-base max-w-2xl mx-auto">
            Launch your own branded GBP management platform on your custom subdomain (clients.youragency.com). Send white-label PDF reports that prove ROI and renew retainers.
        </p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('app.reports') }}" class="bg-accent-500 hover:bg-accent-600 text-white font-bold text-sm px-8 py-3.5 rounded-2xl transition-all shadow-xl">
                Test White-Label Report Generator →
            </a>
        </div>
    </div>
</section>

<!-- Features for Agencies -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center font-bold mb-4">
                <i data-lucide="globe" class="w-5 h-5"></i>
            </div>
            <h3 class="font-bold text-slate-900 text-base font-display">Custom Subdomain</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Host the client dashboard under your own domain (e.g. `clients.youragency.com`) with your own logo, favicon, and brand color palette.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold mb-4">
                <i data-lucide="file-text" class="w-5 h-5"></i>
            </div>
            <h3 class="font-bold text-slate-900 text-base font-display">1-Click Client Reports</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Automated monthly PDF reports showing GBP impressions, calls, directions, Search Console keywords, and executive recommendations.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center font-bold mb-4">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <h3 class="font-bold text-slate-900 text-base font-display">Client-Safe Access</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Give clients view-only or limited permissions to see only their specific locations without seeing other clients or agency backend tools.
            </p>
        </div>
    </div>
</section>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'White-Label Agency FAQ', 'faqIntro' => 'How agencies build their own branded GBP product on Untab.'])
@endsection
