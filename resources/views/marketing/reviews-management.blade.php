@extends('layouts.marketing')

@section('title', 'Google Review Management With AI Replies | Untab')
@section('meta_description', 'Manage every Google review from one dashboard. The Untab AI Review Reply Assistant drafts on-brand responses in seconds, and you can publish replies individually or in bulk.')
@section('meta_keywords', 'Google review management, AI review replies, reply to Google reviews, review response tool, GBP review strategy')

@php($faqs = [
    ['q' => 'How does the AI Review Reply Assistant work?', 'a' => 'Untab reads each review\'s star rating, sentiment, and keywords, then drafts an on-brand reply matching your chosen tone — friendly, professional, SEO-rich, or empathetic.'],
    ['q' => 'Can I reply to reviews in bulk?', 'a' => 'Yes. Generate AI replies for every unanswered review in one click, review them, then publish individually or approve them all.'],
    ['q' => 'Does replying to reviews help my ranking?', 'a' => 'Yes. Responding to reviews signals an engaged, credible business and Google favors profiles that reply promptly.'],
    ['q' => 'Can I control the tone and keywords?', 'a' => 'Absolutely. Choose a tone per reply and add custom instructions, and Untab naturally weaves in your local service keywords.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Review Management', 'url' => route('reviews-management')],
    ]),
    \App\Support\SeoHelper::softwareApplicationSchema(['name' => 'Untab AI Review Assistant', 'category' => 'BusinessApplication']),
])

@section('content')
<!-- Hero -->
<section class="py-16 bg-gradient-to-b from-brand-50 to-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs font-bold text-brand-600 bg-brand-100/80 px-3.5 py-1 rounded-full uppercase tracking-wider">AI Review Assistant</span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-slate-900 mt-4 mb-4">
            Reply to every Google review <span class="text-brand-600">with AI.</span>
        </h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
            One unified feed for reviews across all your locations. Draft on-brand replies with AI, filter by sentiment, and never leave a client's customer unanswered again.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('app.reviews') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-8 py-3.5 rounded-2xl transition-all shadow-md">Try AI Replies in App →</a>
            <a href="{{ route('demo') }}" class="bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm px-8 py-3.5 rounded-2xl border border-slate-200 shadow-sm">See the demo</a>
        </div>
    </div>
</section>

<!-- Why reviews matter -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div>
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">Why it matters</span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-3 mb-4">Reviews are the #1 local ranking signal.</h2>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-4">
                Reviews aren't just social proof — they directly influence where your business shows up in the Google Maps local pack. A profile that responds to every review signals a trustworthy, active business, and Google rewards it with better visibility.
            </p>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                But with dozens or hundreds of profiles, manually replying to each review is impossible. That's exactly where Untab's AI Review Reply Assistant takes over — reading sentiment and intent, then drafting replies that sound like you, not a robot.
            </p>
            <ul class="space-y-2.5 text-xs sm:text-sm text-slate-700 font-medium">
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Boost response rate and local ranking</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Keep a consistent brand voice across every location</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Turn negative reviews into loyalty-building moments</li>
            </ul>
        </div>
        <div class="bg-slate-900 p-4 rounded-2xl shadow-xl border border-slate-800">
            <div class="bg-white rounded-xl p-5 text-xs text-slate-700 space-y-3">
                <div class="flex items-center justify-between border-b pb-2">
                    <span class="font-bold text-slate-900">David K. Miller ⭐⭐⭐⭐⭐</span>
                    <span class="text-[10px] text-slate-400">2 hours ago</span>
                </div>
                <p class="italic text-slate-600">"Dr. James and his entire dental team are outstanding! Best clinic in Austin."</p>
                <div class="bg-brand-50 p-3 rounded-lg border border-brand-200">
                    <span class="text-[10px] font-bold text-brand-800 uppercase block mb-1">AI Generated Reply (Warm &amp; Friendly):</span>
                    <p class="text-[11px] text-brand-900 leading-relaxed">"Hi David! Thank you so much for the glowing 5-star review! The entire team at Apex Dental Care is delighted to know you had such a great experience. See you again soon! ✨"</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How it works -->
<section class="py-16 bg-[#f8faff] border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">Workflow</span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-3">From unread review to reply in seconds.</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['n' => '1', 't' => 'See every review', 'd' => 'A single, filterable feed of reviews across all your locations — sort by rating, sentiment, date, or unanswered status.', 'i' => 'inbox'],
                ['n' => '2', 't' => 'AI drafts the reply', 'd' => 'Untab reads the review, picks the right tone, and writes an on-brand reply you can edit in one click.', 'i' => 'sparkles'],
                ['n' => '3', 't' => 'Publish or bulk-approve', 'd' => 'Approve individually or generate replies for every unanswered review and publish them all at once.', 'i' => 'send'],
            ] as $step)
                <div class="bg-white rounded-2xl border border-slate-200/90 p-7 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center font-black">{{ $step['n'] }}</div>
                        <i data-lucide="{{ $step['i'] }}" class="w-5 h-5 text-brand-600"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base font-display">{{ $step['t'] }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mt-2">{{ $step['d'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Review Management FAQ', 'faqIntro' => 'How Untab AI review replies help you respond faster and rank higher.'])
@endsection
