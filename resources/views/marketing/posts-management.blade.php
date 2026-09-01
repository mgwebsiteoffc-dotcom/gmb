@extends('layouts.marketing')

@section('title', 'Google Posts: Schedule Updates, Offers & Events | Untab')
@section('meta_description', 'Schedule Google Posts across every location with Untab. Create updates, offers with coupon codes, and events with a live Google card preview, then publish to 100+ stores in one click.')
@section('meta_keywords', 'Google Posts, GBP posts scheduler, Google Business Profile posts, schedule Google posts, post offers events')

@php($faqs = [
    ['q' => 'What are Google Posts?', 'a' => 'Google Posts are short updates, offers, events, and product highlights that appear on your Google Business Profile in Maps and Search.'],
    ['q' => 'How do I schedule a Google Post?', 'a' => 'Compose the post, pick the subset of locations (or all of them), choose a publish date, and Untab schedules it automatically. You can also schedule offers with coupon codes and events.'],
    ['q' => 'Can I post to multiple locations at once?', 'a' => 'Yes. Group locations by brand or franchise and publish a single post to any subset — from one store to 500+ profiles — with one click.'],
    ['q' => 'Do Google Posts help my local SEO?', 'a' => 'Yes. Regular, fresh Google Posts signal an active profile and can boost visibility in Maps and local results, especially when combined with offers and events.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Google Posts', 'url' => route('posts-management')],
    ]),
    \App\Support\SeoHelper::softwareApplicationSchema(['name' => 'Untab Google Posts Scheduler', 'category' => 'BusinessApplication']),
])

@section('content')
<!-- Hero -->
<section class="py-16 bg-gradient-to-b from-brand-50 to-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs font-bold text-brand-600 bg-brand-100/80 px-3.5 py-1 rounded-full uppercase tracking-wider">Google Posts Module</span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-slate-900 mt-4 mb-4">
            Schedule Google Posts <span class="text-brand-600">across every location.</span>
        </h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
            Keep profiles active, promote seasonal offers, and announce upcoming webinars or sales without logging in and out of individual accounts.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('app.posts') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-8 py-3.5 rounded-2xl transition-all shadow-md">Open Posts Scheduler →</a>
            <a href="{{ route('demo') }}" class="bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm px-8 py-3.5 rounded-2xl border border-slate-200 shadow-sm">Watch the demo</a>
        </div>
    </div>
</section>

<!-- Value -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div>
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">Keep every profile fresh</span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-3 mb-4">One post. Every store. Zero busywork.</h2>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-4">
                Posting regularly is the most underrated way to keep a Google Business Profile healthy. But when you manage dozens of locations, updating each one by hand simply never happens. Untab lets you compose a post once, watch a live preview of the Google card, and schedule it to every location in your portfolio.
            </p>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                From a weekend sale with a coupon code to a webinar registration or a seasonal holiday greeting — it all goes live on schedule, without touching a single individual account.
            </p>
            <ul class="space-y-2.5 text-xs sm:text-sm text-slate-700 font-medium">
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Live Google card preview before you publish</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Offers with coupon codes and links included</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Calendar scheduling for the whole brand or a franchise</li>
            </ul>
        </div>
        <div class="bg-slate-900 p-4 rounded-2xl shadow-xl border border-slate-800">
            <div class="bg-white rounded-xl p-5 text-xs text-slate-700">
                <div class="flex items-center justify-between border-b pb-2 mb-3">
                    <span class="font-bold text-slate-900">📅 Summer Season Sale</span>
                    <span class="text-[10px] text-slate-400">Scheduled · 9:00 AM</span>
                </div>
                <p class="italic text-slate-600 leading-relaxed">"Beat the heat! ☀️ Get 20% off all AC servicing with code SUMMER20 this weekend. Call now to book!"</p>
                <div class="mt-3 flex items-center justify-between bg-slate-50 p-3 rounded-lg border border-slate-100">
                    <div class="flex -space-x-2">
                        <span class="w-6 h-6 rounded-full bg-brand-600 text-white text-[10px] flex items-center justify-center font-bold">A</span>
                        <span class="w-6 h-6 rounded-full bg-indigo-500 text-white text-[10px] flex items-center justify-center font-bold">B</span>
                        <span class="w-6 h-6 rounded-full bg-emerald-500 text-white text-[10px] flex items-center justify-center font-bold">C</span>
                        <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 text-[10px] flex items-center justify-center font-bold">+12</span>
                    </div>
                    <span class="text-brand-700 font-bold">Publishing to 15 locations →</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Post types -->
<section class="py-16 bg-[#f8faff] border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">Post types</span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-3">Everything Google Posts supports.</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['i' => 'pen-line', 't' => 'Updates', 'd' => 'Share news, product launches, and general announcements with a photo or link.'],
                ['i' => 'tag', 't' => 'Offers', 'd' => 'Promote a discount with a coupon code, a redeemable link, and a clear end date.'],
                ['i' => 'calendar-days', 't' => 'Events', 'd' => 'Announce a webinar, open house, or in-store event with start and end times.'],
                ['i' => 'sparkles', 't' => 'AI Captions', 'd' => 'Draft on-brand post captions from your photos with the Untab AI caption generator.'],
            ] as $pt)
                <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mb-4"><i data-lucide="{{ $pt['i'] }}" class="w-5 h-5"></i></div>
                    <h3 class="font-bold text-slate-900 text-sm font-display">{{ $pt['t'] }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mt-2">{{ $pt['d'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Google Posts FAQ', 'faqIntro' => 'Everything you need to know about scheduling Google Posts with Untab.'])
@endsection
