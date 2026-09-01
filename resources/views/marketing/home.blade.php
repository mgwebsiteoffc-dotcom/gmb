@extends('layouts.marketing')

@section('title', 'Untab — Run every Google Business Profile from one dashboard')
@section('meta_description', 'Run every Google Business Profile from one dashboard. Untab gives SEO agencies and multi-location brands AI review replies, Google Posts scheduling, local SEO insights, and white-label client reports.')
@section('meta_keywords', 'Google Business Profile management, GBP tool, GMB management, local SEO, multi-location, AI review replies, white-label reports')

@php($faqs = [
    ['q' => 'What is Untab and who is it for?', 'a' => 'Untab is a Google Business Profile management platform built for SEO agencies, franchise operators, and multi-location brands that need to manage many local profiles from one dashboard.'],
    ['q' => 'How many Google Business Profiles can I manage?', 'a' => 'Untab supports 10 to 500+ profiles per organization. Group locations into client portfolios and filter every module by client, group, or a single location.'],
    ['q' => 'Can Untab reply to Google reviews for me?', 'a' => 'Yes. The AI Review Reply Assistant drafts on-brand responses in seconds based on star rating, sentiment, and tone. Publish replies individually or in bulk.'],
    ['q' => 'Does Untab schedule Google Posts?', 'a' => 'Yes. Create and schedule updates, offers with coupon codes, and events across any subset of locations, with a live Google card preview.'],
    ['q' => 'Can I send white-label reports to clients?', 'a' => 'Yes. Generate branded performance PDF reports with your agency logo and a client-ready link.'],
    ['q' => 'Is Untab free to start?', 'a' => 'Yes. Start free and explore every module in the live demo without a credit card.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::softwareApplicationSchema(['name' => 'Untab']),
])

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-[#eef1ff] via-white to-[#f5f7ff] pt-16 pb-20 overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <!-- Audience Pill -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-xs font-extrabold uppercase tracking-widest mb-6 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
            Built for SEO agencies & franchise brands
        </div>

        <!-- Main Headline -->
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black font-display tracking-tight text-slate-900 max-w-4xl mx-auto leading-[1.08]">
            Run every Google Business Profile from <span class="text-brand-600">one dashboard.</span>
        </h1>

        <!-- Subtitle -->
        <p class="mt-5 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Untab is the Google Business app for teams that manage local presence at scale — reviews, posts, reports and insights for every client and every location, without logging into each profile.
        </p>

        <!-- CTA Buttons -->
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('app.dashboard') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-black text-sm sm:text-base px-8 py-4 rounded-2xl transition-all shadow-xl hover:shadow-2xl hover:-translate-y-0.5 flex items-center gap-2">
                <span>Get started free</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
            <a href="{{ route('features') }}" class="bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm sm:text-base px-7 py-4 rounded-2xl transition-all border border-slate-200 shadow-sm flex items-center gap-2">
                <i data-lucide="play-circle" class="w-4 h-4 text-brand-600"></i>
                <span>Explore Platform</span>
            </a>
        </div>

        <div class="mt-4 text-xs font-semibold text-slate-400">
            Free to start · No credit card required · Web, iOS & Android
        </div>

        <!-- Live Dashboard Mockup Window -->
        <div class="mt-12 max-w-5xl mx-auto bg-slate-900 rounded-2xl p-2 sm:p-3 shadow-2xl border border-slate-800">
            <div class="bg-slate-800 rounded-xl px-4 py-2.5 flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                </div>
                <div class="text-[11px] font-mono text-slate-400 bg-slate-900 px-4 py-1 rounded-md border border-slate-700">
                    app.untab.com/dashboard
                </div>
                <div class="text-[10px] text-emerald-400 font-bold flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Live Connected
                </div>
            </div>

            <!-- Preview Card Content inside Browser -->
            <div class="bg-slate-50 rounded-xl p-4 sm:p-6 text-left border border-slate-200">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Total GBP Views</div>
                        <div class="text-xl font-extrabold text-slate-900 font-display">124,500</div>
                        <div class="text-[10px] font-bold text-emerald-600">+24.1% MoM</div>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Customer Calls</div>
                        <div class="text-xl font-extrabold text-slate-900 font-display">1,840</div>
                        <div class="text-[10px] font-bold text-emerald-600">+18.5% MoM</div>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Directions</div>
                        <div class="text-xl font-extrabold text-slate-900 font-display">3,250</div>
                        <div class="text-[10px] font-bold text-emerald-600">+29.2% MoM</div>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">AI Review Reply Rate</div>
                        <div class="text-xl font-extrabold text-brand-600 font-display">99.2%</div>
                        <div class="text-[10px] font-bold text-emerald-600">&lt; 2h response</div>
                    </div>
                </div>

                <div class="flex items-center justify-between bg-brand-50 p-3 rounded-xl border border-brand-200 text-xs text-brand-900">
                    <div class="flex items-center gap-2">
                        <i data-lucide="sparkles" class="w-4 h-4 text-brand-600"></i>
                        <span><strong>Multi-Location Command Center:</strong> 4 Clients, 18 Verified Locations connected.</span>
                    </div>
                    <a href="{{ route('app.dashboard') }}" class="font-extrabold text-brand-700 hover:underline">Launch App →</a>
                </div>
            </div>
        </div>

        <!-- Trust Stats Banner -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto text-center border-t border-slate-200/80 pt-10">
            <div>
                <div class="text-3xl sm:text-4xl font-black font-display text-brand-800">4,000+</div>
                <div class="text-xs font-bold text-slate-500 mt-1">Profiles managed by team</div>
            </div>
            <div>
                <div class="text-3xl sm:text-4xl font-black font-display text-accent-500">15+</div>
                <div class="text-xs font-bold text-slate-500 mt-1">Countries active in</div>
            </div>
            <div>
                <div class="text-3xl sm:text-4xl font-black font-display text-brand-800">20-500+</div>
                <div class="text-xs font-bold text-slate-500 mt-1">Profiles per login</div>
            </div>
            <div>
                <div class="text-3xl sm:text-4xl font-black font-display text-emerald-600">3 Apps</div>
                <div class="text-xs font-bold text-slate-500 mt-1">Web, iOS & Android</div>
            </div>
        </div>
    </div>
</section>

<!-- Two Audiences Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">
                Who it's for
            </span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-3">
                Two audiences. <span class="text-brand-600">One platform.</span>
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">
                Untab is built specifically for the two teams that manage Google Business Profiles at serious scale.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Audience 1: SEO Agencies -->
            <div class="bg-gradient-to-br from-[#f7f9ff] to-white p-8 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xl mb-6">
                        <i data-lucide="briefcase" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xs font-bold text-brand-600 uppercase tracking-wider">For SEO Agencies</span>
                    <h3 class="text-2xl font-black font-display text-slate-900 mt-1 mb-3">
                        Every client's profiles under one roof
                    </h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">
                        Group locations by client, hand teammates the right permissions, and send white-label performance reports with your agency logo that renew retainers every month.
                    </p>

                    <ul class="space-y-3 text-xs sm:text-sm text-slate-700 mb-8 font-medium">
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> White-label performance reports generated in 1 click
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Unlimited profiles organized into groups per client
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Role-based access control for team & clients
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> GBP metrics and Search Console in one single view
                        </li>
                    </ul>
                </div>

                <a href="{{ route('white-label-agency') }}" class="text-xs sm:text-sm font-bold text-brand-700 hover:text-brand-900 flex items-center gap-1.5">
                    See how agencies use Untab <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <!-- Audience 2: Franchise Brands -->
            <div class="bg-gradient-to-br from-[#fff8f5] to-white p-8 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xl mb-6">
                        <i data-lucide="store" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">For Franchise Brands</span>
                    <h3 class="text-2xl font-black font-display text-slate-900 mt-1 mb-3">
                        Every location on-brand and up to date
                    </h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">
                        Post updates to hundreds of locations at once, keep AI review responses consistent, and compare location performance side by side without logging into each profile.
                    </p>

                    <ul class="space-y-3 text-xs sm:text-sm text-slate-700 mb-8 font-medium">
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Publish updates, offers & events to 100+ stores at once
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Monitor & answer reviews across the whole network
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Cross-location benchmarking comparison matrix
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Give store managers access to only their local profiles
                        </li>
                    </ul>
                </div>

                <a href="{{ route('industry-multi-location') }}" class="text-xs sm:text-sm font-bold text-accent-600 hover:text-accent-700 flex items-center gap-1.5">
                    See how franchises use Untab <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Platform Features Grid -->
<section class="py-20 bg-[#f8faff] border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">
                The Platform
            </span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-3">
                Everything local presence needs, <span class="text-brand-600">in one place.</span>
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">
                Each module works across one location or a thousand — no per-profile logins, no browser-tab juggling.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Feature 1: Google Posts -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:border-brand-400 hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold mb-4">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base font-display">Google Posts at Scale</h3>
                <p class="text-xs text-slate-500 leading-relaxed mt-2">
                    Create and schedule updates, offers with coupon codes, and events across any subset of locations with live preview.
                </p>
                <a href="{{ route('app.posts') }}" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 mt-4 hover:underline">
                    Manage Posts →
                </a>
            </div>

            <!-- Feature 2: AI Review Replies -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:border-brand-400 hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold mb-4">
                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base font-display">AI Review Management</h3>
                <p class="text-xs text-slate-500 leading-relaxed mt-2">
                    Unified inbox for every review. Generate on-brand replies with AI in seconds, filter by sentiment, and never leave customers unanswered.
                </p>
                <a href="{{ route('app.reviews') }}" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 mt-4 hover:underline">
                    Try AI Replies →
                </a>
            </div>

            <!-- Feature 3: Performance Insights -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:border-brand-400 hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold mb-4">
                    <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base font-display">Performance Insights</h3>
                <p class="text-xs text-slate-500 leading-relaxed mt-2">
                    Calls, directions, clicks, and bookings tracked per location and over time with Maps vs Search discovery trends.
                </p>
                <a href="{{ route('app.insights') }}" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 mt-4 hover:underline">
                    View Insights →
                </a>
            </div>

            <!-- Feature 4: Search Console -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:border-brand-400 hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold mb-4">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base font-display">Search Console Built-in</h3>
                <p class="text-xs text-slate-500 leading-relaxed mt-2">
                    Pull website queries, landing pages, clicks, and CTR right next to your GBP metrics without switching tools.
                </p>
                <a href="{{ route('app.search-console') }}" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 mt-4 hover:underline">
                    Search Analytics →
                </a>
            </div>

            <!-- Feature 5: Media Library -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:border-brand-400 hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold mb-4">
                    <i data-lucide="image" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base font-display">Media & Geotagging</h3>
                <p class="text-xs text-slate-500 leading-relaxed mt-2">
                    Upload and categorize photos and videos across all locations with simulated GPS EXIF geotagging for SEO advantage.
                </p>
                <a href="{{ route('app.media') }}" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 mt-4 hover:underline">
                    Open Media Gallery →
                </a>
            </div>

            <!-- Feature 6: White-Label Reports -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:border-brand-400 hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold mb-4">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base font-display">White-Label Reports</h3>
                <p class="text-xs text-slate-500 leading-relaxed mt-2">
                    Generate branded, automated performance PDF reports for each client with your agency's name on them, not ours.
                </p>
                <a href="{{ route('app.reports') }}" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 mt-4 hover:underline">
                    Generate Report →
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-20 bg-gradient-to-r from-brand-900 via-brand-800 to-indigo-950 text-white text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 relative z-10 space-y-6">
        <span class="bg-white/10 text-brand-200 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-white/20">
            Start Free Today
        </span>
        <h2 class="text-3xl sm:text-5xl font-black font-display tracking-tight">
            All your Google Business work, <span class="text-accent-500">in one app.</span>
        </h2>
        <p class="text-brand-100 text-sm sm:text-base max-w-xl mx-auto">
            Manage your Google Business Profiles from web, iPhone or Android. No credit card required.
        </p>
        <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('app.dashboard') }}" class="bg-accent-500 hover:bg-accent-600 text-white font-extrabold text-sm sm:text-base px-8 py-3.5 rounded-2xl transition-all shadow-xl">
                Open Web Platform Free →
            </a>
            <a href="{{ route('tools.audit') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-2xl transition-all border border-white/20">
                Run Free GBP Audit
            </a>
        </div>
    </div>
</section>

<!-- FAQ Section -->
@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Untab Frequently Asked Questions', 'faqIntro' => 'Answers to the questions agencies and franchises ask most about our Google Business Profile platform.'])
@endsection
