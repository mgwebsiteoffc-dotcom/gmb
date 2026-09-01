@extends('layouts.marketing')

@section('title', 'Features - Google Business Profile Management for Agencies | Untab')
@section('meta_description', 'Explore Untab\'s features: multi-location dashboards, AI review replies, Google Posts scheduling, performance insights, Google Search Console, media & geotagging, white-label reports, and team permissions.')
@section('meta_keywords', 'GBP management features, Google Business Profile tool, local SEO insights, white-label reports, AI review replies')

@php($faqs = [
    ['q' => 'What features does Untab include?', 'a' => 'Untab bundles multi-location dashboards, an AI Review Reply Assistant, a Google Posts scheduler, performance insights, Google Search Console, a media & geotagging library, white-label client reports, and a team & permissions manager.'],
    ['q' => 'Does Untab work for single-location businesses too?', 'a' => 'Yes. Untab is built for scale but works equally well for a single location.'],
    ['q' => 'Can I white-label the platform?', 'a' => 'Yes. Upload your agency logo, set your brand accent color and custom domain, and send reports that carry your brand.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Features', 'url' => route('features')],
    ]),
])

@section('content')
<section class="py-16 bg-gradient-to-b from-brand-50 to-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs font-bold text-brand-600 bg-brand-100/70 px-3 py-1 rounded-full uppercase tracking-wider">
            The Platform
        </span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-slate-900 mt-3 mb-4">
            Every module your GBP work needs, <span class="text-brand-600">in one app.</span>
        </h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
            Reviews, posts, media, insights and white-label reports — across every client and every location, on web, iPhone and Android. No rank tracking, no fluff. Just the work, done in one place.
        </p>
        <div class="mt-6 flex justify-center gap-3">
            <a href="{{ route('app.dashboard') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm px-6 py-3 rounded-xl transition-all shadow-md">
                Get started free →
            </a>
        </div>
    </div>
</section>

<!-- Modules Deep Dive -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
    <!-- Module 1: AI Review Replies -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">
                Reviews + AI
            </span>
            <h2 class="text-3xl font-black font-display text-slate-900 mt-3 mb-4">
                Reply to <span class="text-brand-600">every review</span> with AI
            </h2>
            <p class="text-slate-600 text-sm leading-relaxed mb-6">
                Monitor reviews across all your locations in one feed, draft on-brand replies with AI in seconds, and keep response rates high — the engagement Google rewards. Filter by rating, sentiment and date; reply from web, iPhone or Android.
            </p>
            <div class="space-y-2 text-xs sm:text-sm text-slate-700 mb-6">
                <div class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> AI tones: Professional, Friendly, Empathetic, SEO Keyword Rich</div>
                <div class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> 1-click Bulk AI response engine</div>
                <div class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Automated sentiment analysis</div>
            </div>
            <a href="{{ route('app.reviews') }}" class="bg-brand-600 text-white text-xs font-bold px-5 py-2.5 rounded-xl inline-flex items-center gap-2 shadow-sm">
                Try AI Replies Free →
            </a>
        </div>
        <div class="bg-slate-900 p-4 rounded-2xl shadow-xl border border-slate-800">
            <div class="bg-white rounded-xl p-5 text-xs text-slate-700 space-y-3">
                <div class="flex items-center justify-between border-b pb-2">
                    <span class="font-bold text-slate-900">David K. Miller ⭐⭐⭐⭐⭐</span>
                    <span class="text-[10px] text-slate-400">2 hours ago</span>
                </div>
                <p class="italic text-slate-600">"Dr. James and his entire dental team are outstanding! Best clinic in Austin."</p>
                <div class="bg-brand-50 p-3 rounded-lg border border-brand-200">
                    <span class="text-[10px] font-bold text-brand-800 uppercase block mb-1">AI Generated Reply (Warm & Friendly):</span>
                    <p class="text-[11px] text-brand-900 leading-relaxed">
                        "Hi David! Thank you so much for the glowing 5-star review! The entire team at Apex Dental Care is delighted to know you had such a great experience. See you again soon! ✨"
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Module 2: Google Posts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div class="order-2 md:order-1 bg-slate-900 p-4 rounded-2xl shadow-xl border border-slate-800">
            <div class="bg-white rounded-xl p-5 text-xs text-slate-700 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase bg-amber-100 text-amber-800 px-2 py-0.5 rounded">OFFER POST</span>
                    <span class="text-slate-400 text-[10px]">Broadcast to 4 Locations</span>
                </div>
                <h4 class="font-bold text-slate-900 text-sm">Labor Day Weekend Special: Free Whitening Consultation</h4>
                <p class="text-slate-600 text-[11px]">✨ Get your brightest smile for fall! Book comprehensive exam this week.</p>
                <div class="bg-amber-50 p-2 rounded text-[11px] font-mono font-bold text-amber-900">
                    CODE: FALLSMILE26
                </div>
            </div>
        </div>
        <div class="order-1 md:order-2">
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">
                Google Posts
            </span>
            <h2 class="text-3xl font-black font-display text-slate-900 mt-3 mb-4">
                Updates, offers & events <span class="text-brand-600">at scale</span>
            </h2>
            <p class="text-slate-600 text-sm leading-relaxed mb-6">
                Create and schedule Google Posts across one or many locations without logging into each profile — every client's profile stays fresh and active.
            </p>
            <div class="space-y-2 text-xs sm:text-sm text-slate-700 mb-6">
                <div class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Update, Offer and Event post types</div>
                <div class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Schedule ahead with images & CTA buttons</div>
                <div class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Publish to a single location or 500+ at once</div>
            </div>
            <a href="{{ route('app.posts') }}" class="bg-brand-600 text-white text-xs font-bold px-5 py-2.5 rounded-xl inline-flex items-center gap-2 shadow-sm">
                Open Posts Scheduler →
            </a>
        </div>
    </div>
</section>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Untab Features FAQ', 'faqIntro' => 'Everything you get with the Untab Google Business Profile platform.'])
@endsection
