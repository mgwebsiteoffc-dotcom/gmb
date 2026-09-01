@extends('layouts.marketing')

@section('title', 'Frequently Asked Questions — Untab Google Business Profile Platform')
@section('meta_description', 'Answers to common questions about Untab — the Google Business Profile management platform for SEO agencies and multi-location brands.')

@section('content')
<section class="py-16 bg-gradient-to-b from-[#f0f4ff] to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">Help Center</span>
            <h1 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-4">Frequently Asked Questions</h1>
            <p class="text-slate-600 text-sm sm:text-base mt-3">Everything you need to know about Untab — the Google Business Profile management platform.</p>
        </div>

        <!-- Category chips -->
        @if($categories->isNotEmpty())
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10" x-data="{ cat: '{{ $category ?? '' }}' }">
            <button @click="cat=''" class="px-4 py-1.5 rounded-full text-xs font-extrabold transition-all {{ empty($category) ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">All</button>
            @foreach($categories as $c)
                <a href="{{ $category === $c ? route('faq') : route('faq', ['category' => $c]) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-extrabold transition-all {{ $category === $c ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">{{ $c }}</a>
            @endforeach
        </div>
        @endif

        <!-- Grouped FAQ accordions -->
        @forelse($grouped as $catTitle => $items)
            <div class="mb-10">
                <h2 class="text-lg font-black font-display text-slate-900 mb-4 flex items-center gap-2">
                    @if(! empty($catTitle))
                        <span class="bg-brand-50 text-brand-700 text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded-full">{{ $catTitle }}</span>
                    @else
                        <span class="bg-brand-50 text-brand-700 text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded-full">General</span>
                    @endif
                </h2>
                <div class="space-y-4">
                    @foreach($items as $i => $faq)
                        <details class="group bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" {{ $i === 0 ? 'open' : '' }}>
                            <summary class="flex items-center justify-between gap-4 px-6 py-5 cursor-pointer font-bold text-slate-900 text-base hover:bg-brand-50/50 transition-colors">
                                <span>{{ $faq->question }}</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform flex-shrink-0"></i>
                            </summary>
                            <div class="px-6 pb-5 text-slate-600 text-sm leading-relaxed">{{ $faq->answer }}</div>
                        </details>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center text-slate-500 text-sm">
                No FAQs available yet. Check back soon!
            </div>
        @endforelse

        <div class="mt-12 text-center bg-brand-50 border border-brand-200 rounded-3xl p-8">
            <h2 class="text-xl font-black font-display text-slate-900">Still have questions?</h2>
            <p class="text-sm text-slate-600 mt-2 mb-6">Jump into the live platform or reach out to our team.</p>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('app.dashboard') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-extrabold px-6 py-3 rounded-xl text-sm shadow-md">Open Live Demo</a>
                <a href="{{ route('pricing') }}" class="bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold px-6 py-3 rounded-xl text-sm">View Pricing</a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>lucide.createIcons();</script>
@endpush
