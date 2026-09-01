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
<section class="py-16 bg-gradient-to-b from-brand-50 to-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs font-bold text-brand-600 bg-brand-100/80 px-3.5 py-1 rounded-full uppercase tracking-wider">
            Google Posts Module
        </span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-slate-900 mt-4 mb-4">
            Schedule Google Posts <span class="text-brand-600">across every location.</span>
        </h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
            Keep profiles active, promote seasonal offers, and announce upcoming webinars or sales without logging in and out of individual accounts.
        </p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('app.posts') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-8 py-3.5 rounded-2xl transition-all shadow-md">
                Open Posts Scheduler →
            </a>
        </div>
    </div>
</section>
@endsection
