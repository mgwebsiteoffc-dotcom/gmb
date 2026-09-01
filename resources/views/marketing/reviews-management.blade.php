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
<section class="py-16 bg-gradient-to-b from-brand-50 to-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs font-bold text-brand-600 bg-brand-100/80 px-3.5 py-1 rounded-full uppercase tracking-wider">
            AI Review Assistant
        </span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-slate-900 mt-4 mb-4">
            Reply to every Google review <span class="text-brand-600">with AI.</span>
        </h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
            One unified feed for reviews across all your locations. Draft on-brand replies with AI, filter by sentiment, and never leave a client's customer unanswered again.
        </p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('app.reviews') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-8 py-3.5 rounded-2xl transition-all shadow-md">
                Try AI Replies in App →
            </a>
        </div>
    </div>
</section>
@endsection
