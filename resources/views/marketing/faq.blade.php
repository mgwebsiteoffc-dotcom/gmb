@extends('layouts.marketing')

@section('title', 'Frequently Asked Questions — Untab Google Business Profile Platform')

@section('content')
<section class="py-16 bg-gradient-to-b from-[#eef1ff] to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">Help Center</span>
            <h1 class="text-3xl sm:text-4xl font-black font-display text-slate-900 mt-4">Frequently Asked Questions</h1>
            <p class="text-slate-600 text-sm sm:text-base mt-3">Everything you need to know about Untab — the Google Business Profile management platform.</p>
        </div>

        <div class="space-y-4">
            @foreach($faqs as $index => $faq)
                <details class="group bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" {{ $index === 0 ? 'open' : '' }}>
                    <summary class="flex items-center justify-between gap-4 px-6 py-5 cursor-pointer font-bold text-slate-900 text-base hover:bg-brand-50/50 transition-colors">
                        <span>{{ $faq['q'] }}</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform flex-shrink-0"></i>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 text-sm leading-relaxed">{{ $faq['a'] }}</div>
                </details>
            @endforeach
        </div>

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
