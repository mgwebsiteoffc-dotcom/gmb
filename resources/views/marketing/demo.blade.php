@extends('layouts.marketing')

@section('title', 'What Untab Offers & How It Helps — Guided Platform Demo | Untab')
@section('meta_description', 'See what Untab offers and how it helps SEO agencies and multi-location brands: manage every Google Business Profile from one dashboard, reply to reviews with AI, schedule Google Posts, and send white-label client reports.')
@section('meta_keywords', 'Untab demo, Google Business Profile platform, GBP management demo, AI review replies demo, Google Posts scheduler, white-label reports, manage multiple Google Business Profiles')

@php($faqs = [
    ['q' => 'What does Untab offer?', 'a' => 'Untab offers a unified Google Business Profile dashboard: AI review replies, Google Posts scheduling, performance insights, Google Search Console, a media & geotagging library, white-label client reports, and team & role permissions — all for one or hundreds of locations.'],
    ['q' => 'How does Untab help SEO agencies?', 'a' => 'Agencies group profiles by client, hand teammates the right permissions, run AI reply and bulk posting workflows, and send branded white-label performance reports that prove value and renew retainers.'],
    ['q' => 'How does Untab help multi-location brands and franchises?', 'a' => 'Franchise operators publish updates, offers and events to 100+ stores at once, keep AI review responses consistent across the network, and compare every location side by side.'],
    ['q' => 'How does the guided demo work?', 'a' => 'The demo walks you through the actual platform modules with sample data — connect a Google profile, manage reviews and posts, view insights and search console data, and generate a white-label report. No credit card required.'],
    ['q' => 'Can I try Untab before purchasing?', 'a' => 'Yes. You can start free and explore every module in the live demo without a credit card.'],
    ['q' => 'Does Untab offer white-label reporting?', 'a' => 'Yes. Generate branded performance PDF reports with your agency logo, custom domain, and accent color so clients see your brand, not ours.'],
])

@php($howToSteps = [
    ['name' => 'Connect your Google Business Profiles', 'text' => 'Securely connect one or many Google Business Profiles via Google OAuth. Untab pulls reviews, posts, and performance data automatically.'],
    ['name' => 'Manage everything from one dashboard', 'text' => 'Reply to reviews with AI, schedule Google Posts, upload media, and monitor insights — across every location without logging into each profile.'],
    ['name' => 'Report and grow', 'text' => 'Generate white-label client reports, benchmark locations, and send branded updates that prove results.'],
])

@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Guided Demo', 'url' => route('demo')],
    ]),
    \App\Support\SeoHelper::softwareApplicationSchema([
        'name' => 'Untab',
        'description' => 'Google Business Profile management platform for SEO agencies and multi-location brands.',
    ]),
    [
        '@context' => 'https://schema.org',
        '@type' => 'HowTo',
        'name' => 'Get started with Untab',
        'description' => 'Three steps to run every Google Business Profile from one dashboard.',
        'step' => collect($howToSteps)->map(fn ($step, $i) => [
            '@type' => 'HowToStep',
            'position' => $i + 1,
            'name' => $step['name'],
            'text' => $step['text'],
        ])->values()->all(),
    ],
])

@section('content')
<!-- Hero -->
<section class="relative bg-gradient-to-b from-[#eef1ff] via-white to-[#f5f7ff] pt-16 pb-20 overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-60 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-xs font-extrabold uppercase tracking-widest mb-6 shadow-sm">
            <i data-lucide="play-circle" class="w-4 h-4"></i>
            Guided Demo
        </span>
        <h1 class="text-4xl sm:text-5xl font-black font-display tracking-tight text-slate-900 max-w-3xl mx-auto leading-[1.08]">
            What Untab offers, <span class="text-brand-600">and how it helps.</span>
        </h1>
        <p class="mt-5 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            A guided tour of the Google Business Profile platform for agencies and multi-location brands — see how reviews, posts, reports, and AI come together in one dashboard.
        </p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('app.dashboard') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-black text-sm sm:text-base px-8 py-4 rounded-2xl transition-all shadow-xl hover:shadow-2xl hover:-translate-y-0.5 flex items-center gap-2">
                <span>Launch the live demo</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
            <a href="{{ route('pricing') }}" class="bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm sm:text-base px-7 py-4 rounded-2xl transition-all border border-slate-200 shadow-sm flex items-center gap-2">
                <span>See pricing</span>
            </a>
        </div>
        <div class="mt-4 text-xs font-semibold text-slate-400">
            Free to start · No credit card required · Web, iOS & Android
        </div>
    </div>
</section>

<!-- How it helps: 3 steps -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">How it works</span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-3">Three steps from setup to growth.</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($howToSteps as $i => $step)
                <div class="relative bg-[#f8faff] rounded-3xl border border-slate-200/90 p-8 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white flex items-center justify-center font-black text-lg mb-5 shadow-md">
                        {{ $i + 1 }}
                    </div>
                    <h3 class="text-lg font-black font-display text-slate-900 mb-2">{{ $step['name'] }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $step['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- What it helps with: outcomes -->
<section class="py-20 bg-[#f8faff] border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">The outcome</span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-3">How Untab helps you win.</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon' => 'message-square', 'title' => 'Respond faster', 'desc' => 'AI review replies in seconds lift response rates — the engagement Google rewards with local visibility.'],
                ['icon' => 'calendar', 'title' => 'Stay active', 'desc' => 'Schedule Google Posts across many locations to keep every profile fresh without per-profile logins.'],
                ['icon' => 'bar-chart-2', 'title' => 'Prove value', 'desc' => 'Insights, Search Console and white-label reports make your results visible and retainer-ready.'],
                ['icon' => 'users', 'title' => 'Work as a team', 'desc' => 'Give teammates and store managers the right access to only the profiles they own.'],
            ] as $benefit)
                <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:border-brand-400 hover:shadow-lg transition-all">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center mb-4">
                        <i data-lucide="{{ $benefit['icon'] }}" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base font-display">{{ $benefit['title'] }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mt-2">{{ $benefit['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- What's inside: modules recap -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">Inside the platform</span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-3">Everything in one deployment.</h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">Explore each module from the guided demo above, or jump straight into the app.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['route' => 'app.reviews', 'icon' => 'sparkles', 'title' => 'AI Review Replies', 'desc' => 'Unified inbox, AI tone drafts, bulk replies, and sentiment filtering.'],
                ['route' => 'app.posts', 'icon' => 'calendar', 'title' => 'Google Posts Scheduler', 'desc' => 'Updates, offers with coupon codes, and events with live preview.'],
                ['route' => 'app.insights', 'icon' => 'bar-chart-2', 'title' => 'Performance Insights', 'desc' => 'Calls, directions, clicks, and bookings per location over time.'],
                ['route' => 'app.search-console', 'icon' => 'search', 'title' => 'Search Console Built-in', 'desc' => 'Queries, landing pages, clicks, and CTR beside your GBP data.'],
                ['route' => 'app.media', 'icon' => 'image', 'title' => 'Media & Geotagging', 'desc' => 'Organize photos and videos across locations with geo EXIF.'],
                ['route' => 'app.reports', 'icon' => 'file-text', 'title' => 'White-Label Reports', 'desc' => 'Branded PDF client reports in one click, ready to send.'],
            ] as $m)
                <a href="{{ route($m['route']) }}" class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:border-brand-400 hover:shadow-lg transition-all">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                        <i data-lucide="{{ $m['icon'] }}" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base font-display">{{ $m['title'] }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mt-2">{{ $m['desc'] }}</p>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 mt-4">Open module <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA-->
<section class="py-20 bg-gradient-to-r from-brand-900 via-brand-800 to-indigo-950 text-white text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 relative z-10 space-y-6">
        <span class="bg-white/10 text-brand-200 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-white/20">Try the demo</span>
        <h2 class="text-3xl sm:text-5xl font-black font-display tracking-tight">See it work for <span class="text-accent-500">your business.</span></h2>
        <p class="text-brand-100 text-sm sm:text-base max-w-xl mx-auto">Launch the live demo now and manage a real Google Business Profile from one dashboard — no credit card required.</p>
        <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('app.dashboard') }}" class="bg-accent-500 hover:bg-accent-600 text-white font-extrabold text-sm sm:text-base px-8 py-3.5 rounded-2xl transition-all shadow-xl">Open Web Platform Free →</a>
            <a href="{{ route('pricing') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-2xl transition-all border border-white/20">View Pricing</a>
        </div>
    </div>
</section>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Untab Demo & Platform FAQ', 'faqIntro' => 'Answers to what Untab offers and how it helps agencies and multi-location brands.'])
@endsection
