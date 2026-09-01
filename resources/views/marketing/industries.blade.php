@extends('layouts.marketing')

@section('title', 'Industries — Google Business Profile Management by Vertical | Untab')
@section('meta_description', 'See how Untab helps every local business vertical win on Google Maps — dental clinics, restaurants, real estate, doctors, salons, law firms, coaching institutes, gyms, auto services and hotels.')
@section('meta_keywords', 'Google Business Profile by industry, local SEO vertical, dental clinic GBP, restaurant local SEO, multi-location marketing')

@php($faqs = [
    ['q' => 'Does Untab work for my industry?', 'a' => 'Yes. Untab is built for any business with a Google Business Profile — from a single location to a 500+ branch franchise. Choose your industry to see the specific benefits, or start the demo to see it in action.'],
    ['q' => 'How do I pick the right industry page?', 'a' => 'Select the vertical that best matches your business. Each page highlights the exact workflows — reviews, posts, offers and insights — that matter most for that industry.'],
    ['q' => 'Can Untab manage a multi-location franchise?', 'a' => 'Yes. Untab is built for scale and works for franchise brands, chains and agency-managed networks running 10 to 500+ profiles.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Industries', 'url' => route('industries')],
    ]),
])

@section('content')
<section class="py-16 bg-gradient-to-b from-brand-50 to-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs font-bold text-brand-600 bg-brand-100/70 px-3 py-1 rounded-full uppercase tracking-wider">By Industry</span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-slate-900 mt-3 mb-4">
            How Untab helps <span class="text-brand-600">your business</span> win on Google Maps.
        </h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
            Every local business has a different playbook. Pick your vertical to see the reviews, offers, posts and insights that move the needle for you.
        </p>
    </div>
</section>

<!-- Industry grid -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($industries as $industry)
            <a href="{{ route('industry.show', $industry['slug']) }}" class="group bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:border-brand-400 hover:shadow-lg transition-all">
                <div class="w-11 h-11 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center mb-4">
                    <i data-lucide="{{ $industry['icon'] }}" class="w-5 h-5"></i>
                </div>
                <h2 class="font-bold text-slate-900 text-base font-display">{{ $industry['name'] }}</h2>
                <p class="text-xs text-slate-500 leading-relaxed mt-2 line-clamp-3">{{ $industry['intro'] }}</p>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 mt-4">View how it helps <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></span>
            </a>
        @endforeach
    </div>
</section>

<section class="py-16 bg-slate-900 text-white text-center">
    <div class="max-w-3xl mx-auto px-4 space-y-4">
        <h2 class="text-2xl sm:text-3xl font-black font-display">Don't see your industry?</h2>
        <p class="text-slate-300 text-sm sm:text-base">Untab works for any business with a Google Business Profile. Launch the demo and see how it fits your workflow.</p>
        <a href="{{ route('demo') }}" class="inline-block bg-accent-500 hover:bg-accent-600 text-white font-extrabold text-sm sm:text-base px-8 py-3.5 rounded-2xl transition-all shadow-xl">Launch the live demo →</a>
    </div>
</section>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Industries FAQ', 'faqIntro' => 'Answers about how Untab adapts to your industry.'])
@endsection
