@extends('layouts.marketing')

@section('title', 'Local SEO Keyword & NAP Consistency Checklist | Untab')
@section('meta_description', 'Run a free local SEO checklist: NAP consistency, primary/secondary categories, review signals, Google Posts velocity, and on-page local keywords — with an instant score.')
@section('meta_keywords', 'local SEO checklist, NAP consistency, local citations, Google Business Profile optimisation, local keyword checklist')

@php($faqs = [
    ['q' => 'What is NAP consistency?', 'a' => 'NAP stands for Name, Address, and Phone. When your business name, address, and phone number match exactly across your website, Google Business Profile, Facebook, Yelp, and directories, Google trusts you more.'],
    ['q' => 'Why does local keyword coverage matter?', 'a' => 'Weaving your city, service, and nearby-neighborhood keywords naturally into your GBP description, posts, and Q&A helps Google connect your profile to the right local searches.'],
    ['q' => 'How often should I run this checklist?', 'a' => 'Run it monthly, and always after a rebrand, a change of address, or opening a new location.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Local SEO Checklist', 'url' => route('tools.local-seo')],
    ]),
])

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6" x-data="localSeo()">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
            <i data-lucide="map-pin" class="w-3.5 h-3.5"></i> Local Search Health
        </div>
        <h1 class="text-3xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">
            Local SEO <span class="text-brand-600">Checklist</span>
        </h1>
        <p class="text-slate-600 max-w-xl mx-auto mt-2 text-xs sm:text-sm">
            Score NAP consistency, category targeting, review signals, and on-page local keywords.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm md:col-span-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><label class="text-xs font-bold text-slate-700 uppercase block">Primary Keyword / Service</label><input x-model="kws.service" placeholder="e.g. emergency dentist" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></div>
                <div><label class="text-xs font-bold text-slate-700 uppercase block">City / Neighborhood</label><input x-model="kws.city" placeholder="e.g. Austin, TX" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></div>
                <div><label class="text-xs font-bold text-slate-700 uppercase block">Business Address</label><input x-model="kws.address" placeholder="e.g. 401 Congress Ave" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></div>
                <div><label class="text-xs font-bold text-slate-700 uppercase block">Phone Number</label><input x-model="kws.phone" placeholder="e.g. (512) 555-0100" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></div>
            </div>
        </div>

        <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h2 class="font-bold text-slate-900 text-sm mb-4">N.A.P. Consistency + Local Signals</h2>
            <div class="space-y-2">
                <template x-for="item in items" :key="item.id">
                    <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors">
                        <input type="checkbox" x-model="item.done" class="mt-0.5 rounded text-brand-600 focus:ring-brand-500" @change="score()">
                        <span class="flex-1">
                            <span class="block text-xs font-bold text-slate-800" x-text="item.title"></span>
                            <span class="block text-[10px] text-slate-500" x-text="item.hint"></span>
                        </span>
                    </label>
                </template>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center font-black text-xl" :class="score >= 80 ? 'bg-emerald-50 text-emerald-600' : (score >= 50 ? 'bg-amber-50 text-amber-600' : 'bg-rose-50 text-rose-600')" x-text="score + '%'"></div>
            <div>
                <div class="font-bold text-slate-900 text-sm">Local SEO Health Score</div>
                <div class="text-xs text-slate-500" x-text="verdict"></div>
            </div>
        </div>
        <button @click="copyReport()" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md flex items-center gap-2">
            <i data-lucide="copy" class="w-4 h-4"></i> Copy Summary
        </button>
    </div>
</div>

<script>
    function localSeo() {
        return {
            kws: { service: '', city: '', address: '', phone: '' },
            items: [
                { id: 1, title: 'Business name exact & consistent everywhere', hint: 'Same N.A.P. on GBP, website, Facebook, Yelp & directories', done: false },
                { id: 2, title: 'Primary category matches top search intent', hint: 'Most relevant, highest-volume category selected', done: false },
                { id: 3, title: '3-5 secondary categories added', hint: 'Cover specialities & services', done: false },
                { id: 4, title: 'Address + phone in website footer & contact page', hint: 'Matches GBP exactly', done: false },
                { id: 5, title: 'City + service keyword in GBP description', hint: 'e.g. "emergency dentist in Austin"', done: false },
                { id: 6, title: 'City + service keyword in a Google Post', hint: 'Published in the last 14 days', done: false },
                { id: 7, title: 'Neighborhood/nearby keyword in Q&A', hint: 'Owner-answered questions include location', done: false },
                { id: 8, title: 'Reviews mention service + city keywords', hint: 'Encourage it in review follow-up messages', done: false },
                { id: 9, title: 'Geotagged photos with EXIF location', hint: 'Photos reinforce local relevance', done: false },
                { id: 10, title: 'Local citations NAP consistent (3+ directories)', hint: 'Bing, Apple, Yelp, Foursquare', done: false },
            ],
            get score() {
                const total = this.items.length || 1;
                const done = this.items.filter(i => i.done).length;
                return Math.round((done / total) * 100);
            },
            get verdict() {
                const s = this.score;
                if (s >= 80) return 'Excellent — strong local signals.';
                if (s >= 50) return 'Good — fix the unchecked items to rank higher locally.';
                return 'Needs work — focus on NAP consistency and local keywords.';
            },
            score() { /* reactive getters update automatically */ },
            copyReport() {
                const lines = ['Local SEO Checklist — Untab',
                    'Primary: ' + (this.kws.service || '—') + ' in ' + (this.kws.city || '—'),
                    'Score: ' + this.score + '% (' + this.verdict + ')',
                    '',
                    ...this.items.map(i => (i.done ? '[x] ' : '[ ] ') + i.title)];
                const txt = lines.join('\n');
                if (navigator.clipboard && navigator.clipboard.writeText) navigator.clipboard.writeText(txt);
                toast && toast('Local SEO summary copied!');
            }
        }
    }
</script>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Local SEO Checklist FAQ', 'faqIntro' => 'NAP consistency, local keywords, and local ranking signals, explained.'])
@endsection
