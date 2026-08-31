@extends('layouts.marketing')

@section('title', 'Free Google Business Profile Audit Tool & Checklist | Untab')

@php
    $faqs = [
        ['q' => 'What is a Google Business Profile audit?', 'a' => 'A GBP audit checks 16 points across your profile — from verification and categories to photos, posts, reviews, and NAP consistency — and gives you an actionable health score.'],
        ['q' => 'How is my GBP health score calculated?', 'a' => 'The score is based on completing each best-practice checklist item. Verified, complete, and actively-maintained profiles score highest.'],
        ['q' => 'Is this audit tool free?', 'a' => 'Yes. Untab\'s 16-point GBP audit tool is completely free to use with no account required.'],
    ];
    $jsonLd = [\App\Support\SeoHelper::faqSchema($faqs)];
@endphp

@section('content')
<div class="max-w-5xl mx-auto py-12 px-4 sm:px-6" x-data="auditCalculator()">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-brand-800 via-brand-700 to-indigo-900 rounded-3xl p-8 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-xs font-semibold tracking-wider uppercase mb-4 border border-white/20">
                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-accent-500"></i> Free Interactive GBP Audit Checklist
            </div>
            <h1 class="text-3xl sm:text-4xl font-black font-display leading-tight mb-3">
                Google Business Profile <span class="text-accent-500">Audit & Health Score</span>
            </h1>
            <p class="text-brand-100 max-w-2xl text-xs sm:text-sm leading-relaxed">
                Audit your local business profile against 16 key ranking factors Google's algorithm prioritizes in 2026. Spot missing revenue opportunities and boost Map Pack rankings.
            </p>

            <div class="mt-6 flex flex-wrap gap-4 items-center">
                <div class="flex bg-white/10 backdrop-blur-md rounded-xl p-1.5 border border-white/20 gap-2 flex-1 min-w-[280px]">
                    <input
                        type="text"
                        x-model="businessName"
                        placeholder="Enter Business Name"
                        class="bg-transparent px-3 py-2 text-white placeholder-brand-200 text-xs sm:text-sm focus:outline-none flex-1"
                    />
                </div>
                <a
                    href="{{ route('app.dashboard') }}"
                    class="bg-white text-brand-800 hover:bg-brand-50 text-xs sm:text-sm font-bold px-5 py-3 rounded-xl transition-all shadow-lg flex items-center gap-2"
                >
                    Fix in Untab App <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Score Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col items-center justify-center text-center">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Overall Profile Health</span>
            <div class="text-5xl font-black font-display text-brand-700" x-text="score + '%'">92%</div>
            <div class="w-full bg-slate-100 h-2 rounded-full mt-3 overflow-hidden">
                <div 
                    class="h-full rounded-full transition-all duration-500 bg-emerald-500"
                    :style="'width: ' + score + '%'"
                ></div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xl flex-shrink-0">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-800" x-text="passCount + ' Factors'">14 Factors</div>
                <div class="text-xs text-slate-500">Fully Optimized</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xl flex-shrink-0">
                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-800" x-text="warningCount + ' Warnings'">2 Warnings</div>
                <div class="text-xs text-slate-500">Needs Attention</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xl flex-shrink-0">
                <i data-lucide="x-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-800" x-text="failCount + ' Critical'">0 Critical</div>
                <div class="text-xs text-slate-500">Missing Elements</div>
            </div>
        </div>
    </div>

    <!-- Checklist Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-8">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800 text-base font-display">16-Point GBP Ranking Factor Checklist</h3>
                <p class="text-xs text-slate-500">Click any status button to toggle your audit score</p>
            </div>
            <span class="text-xs bg-brand-50 text-brand-700 font-bold px-3 py-1 rounded-full" x-text="businessName">
                Apex Dental Care
            </span>
        </div>

        <div class="divide-y divide-slate-100">
            <template x-for="item in items" :key="item.id">
                <div class="p-4 sm:p-5 hover:bg-slate-50/70 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                            <span class="text-xs font-bold text-slate-400" x-text="'#' + item.id"></span>
                            <span class="font-semibold text-slate-800 text-sm" x-text="item.title"></span>
                            <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-600" x-text="item.category"></span>
                            <span 
                                class="text-[10px] font-bold uppercase px-1.5 py-0.5 rounded"
                                :class="item.impact === 'Critical' ? 'bg-rose-100 text-rose-700' : (item.impact === 'High' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600')"
                                x-text="item.impact + ' Impact'"
                            ></span>
                        </div>
                        <p class="text-xs text-slate-500 pl-6" x-text="item.tip"></p>
                    </div>

                    <div class="flex items-center gap-3 self-end sm:self-center">
                        <button
                            @click="toggleItem(item.id)"
                            class="px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5 transition-all"
                            :class="{
                                'bg-emerald-100 text-emerald-800 hover:bg-emerald-200': item.status === 'pass',
                                'bg-amber-100 text-amber-800 hover:bg-amber-200': item.status === 'warning',
                                'bg-rose-100 text-rose-800 hover:bg-rose-200': item.status === 'fail'
                            }"
                        >
                            <span x-show="item.status === 'pass'">✓ Pass</span>
                            <span x-show="item.status === 'warning'">⚠️ Warning</span>
                            <span x-show="item.status === 'fail'">✕ Needs Fix</span>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    function auditCalculator() {
        return {
            businessName: 'Apex Dental Care',
            items: [
                { id: 1, title: 'Primary Category Exact Match', category: 'Core Info', status: 'pass', impact: 'High', tip: 'Primary category chosen matches the highest-volume relevant search intent.' },
                { id: 2, title: 'Secondary Categories (3-5 added)', category: 'Core Info', status: 'pass', impact: 'Medium', tip: 'Secondary categories cover specialized services like Cosmetic Dentist and Teeth Whitening.' },
                { id: 3, title: 'Business Name Compliance (No keyword stuffing)', category: 'Core Info', status: 'pass', impact: 'Critical', tip: 'Compliant with Google guidelines to prevent automated suspension.' },
                { id: 4, title: 'Consistent NAP (Name, Address, Phone)', category: 'Core Info', status: 'pass', impact: 'High', tip: 'Address and phone number match website footer and directories identically.' },
                { id: 5, title: 'Review Velocity (New reviews in last 14 days)', category: 'Reviews', status: 'pass', impact: 'High', tip: 'Recent steady stream of verified customer reviews signal high freshness.' },
                { id: 6, title: 'Review Response Rate (> 95%)', category: 'Reviews', status: 'warning', impact: 'High', tip: 'You have unanswered reviews. Google favors profiles that respond within 24 hours.' },
                { id: 7, title: 'Owner Review Responses Include Keywords', category: 'Reviews', status: 'warning', impact: 'Medium', tip: 'AI-assisted replies can weave in local service phrases naturally.' },
                { id: 8, title: 'Weekly Google Posts Frequency', category: 'Posts', status: 'pass', impact: 'Medium', tip: 'Active post published in the last 7 days.' },
                { id: 9, title: 'Offer & Event Posts Utilization', category: 'Posts', status: 'pass', impact: 'Medium', tip: 'Active promotional offer post with CTA button configured.' },
                { id: 10, title: 'High-Resolution Cover & Exterior Photo', category: 'Media', status: 'pass', impact: 'High', tip: 'Crisp 1200x900px cover photo visible on Google Maps.' },
                { id: 11, title: 'Geotagged & Categorized Photos (> 20 photos)', category: 'Media', status: 'pass', impact: 'Medium', tip: 'Regular weekly photo uploads keep photos tab fresh.' },
                { id: 12, title: 'Google Q&A Pre-Populated FAQs', category: 'Content', status: 'pass', impact: 'Medium', tip: 'Owner-answered FAQs found in Q&A to answer search intent.' },
                { id: 13, title: 'Complete Services / Menu Catalog with Prices', category: 'Content', status: 'pass', impact: 'High', tip: 'Services catalog fully filled with comprehensive descriptions.' },
                { id: 14, title: 'Special Holiday Hours Configured', category: 'Core Info', status: 'pass', impact: 'Medium', tip: 'Upcoming holiday hours have been confirmed.' },
                { id: 15, title: 'Booking / Appointment Direct Link Enabled', category: 'Conversion', status: 'pass', impact: 'High', tip: 'Direct booking CTA configured and driving conversion.' },
                { id: 16, title: 'Google Search Console Synced', category: 'Analytics', status: 'pass', impact: 'High', tip: 'Search Console property connected to monitor discovery terms.' }
            ],
            get passCount() {
                return this.items.filter(i => i.status === 'pass').length;
            },
            get warningCount() {
                return this.items.filter(i => i.status === 'warning').length;
            },
            get failCount() {
                return this.items.filter(i => i.status === 'fail').length;
            },
            get score() {
                return Math.round((this.passCount * 100 + this.warningCount * 50) / this.items.length);
            },
            toggleItem(id) {
                const item = this.items.find(i => i.id === id);
                if (item) {
                    item.status = item.status === 'pass' ? 'warning' : (item.status === 'warning' ? 'fail' : 'pass');
                }
            }
        }
    }
</script>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'GBP Audit Tool FAQ', 'faqIntro' => 'Common questions about Google Business Profile audits and health scores.'])
@endsection
