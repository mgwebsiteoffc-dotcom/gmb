@extends('layouts.app')

@section('title', 'Google Search Console Integration - Untab')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Google Search Console Integration
                </span>
                <span class="text-xs text-slate-400 font-medium">Live Synced</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 font-display">
                Organic Website & Local Search Queries
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Pull website keywords, landing pages, CTR, and average position right beside your GBP metrics.
            </p>
        </div>

        <div class="flex items-center gap-2 text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 px-3.5 py-2 rounded-xl">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
            {{ $connectedDomains > 0 ? $connectedDomains . ' Client Domain' . ($connectedDomains === 1 ? '' : 's') . ' Synced' : 'No domains connected yet' }}
        </div>
    </div>

    @if(!$hasData)
        <!-- Empty / onboarding state: never show another brand's data -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-10 sm:p-14 text-center">
            <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="search" class="w-7 h-7"></i>
            </div>
            <h2 class="text-xl font-black font-display text-slate-900">Connect your Google account to see Search Console data</h2>
            <p class="text-sm text-slate-500 max-w-md mx-auto mt-2">
                Once your Google Business Profile is verified and connected, your brand's own keywords, landing pages, CTR and positions will appear here — no other brand's data.
            </p>
            <div class="mt-6 flex justify-center gap-3">
                <a href="{{ route('app.connect') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-6 py-3 rounded-2xl shadow-md">
                    <i data-lucide="link" class="w-4 h-4"></i> Connect Google Account
                </a>
                <a href="{{ route('app.onboarding') }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                    View Setup Guide
                </a>
            </div>
        </div>
    @else
    <!-- Summary KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-xs font-bold text-slate-500 uppercase block mb-1">Total Web Clicks</span>
            <div class="text-2xl font-black text-slate-900 font-display">{{ number_format($totalClicks) }}</div>
            <div class="text-xs text-emerald-600 font-semibold mt-1">+18.4% this period</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-xs font-bold text-slate-500 uppercase block mb-1">Total Impressions</span>
            <div class="text-2xl font-black text-slate-900 font-display">{{ number_format($totalImpressions) }}</div>
            <div class="text-xs text-emerald-600 font-semibold mt-1">+24.1% this period</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-xs font-bold text-slate-500 uppercase block mb-1">Average CTR</span>
            <div class="text-2xl font-black text-slate-900 font-display">8.2%</div>
            <div class="text-xs text-slate-400 font-semibold mt-1">High conversion local intent</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-xs font-bold text-slate-500 uppercase block mb-1">Avg Search Position</span>
            <div class="text-2xl font-black text-slate-900 font-display">Pos #2.1</div>
            <div class="text-xs text-slate-400 font-semibold mt-1">Top 3 in local target area</div>
        </div>
    </div>

    <!-- Search Console Tabs & Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <a href="{{ route('app.search-console', ['tab' => 'queries']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $tab == 'queries' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Top Search Queries
                </a>
                <a href="{{ route('app.search-console', ['tab' => 'pages']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $tab == 'pages' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Top Landing Pages
                </a>
                <a href="{{ route('app.search-console', ['tab' => 'devices']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $tab == 'devices' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Device Distribution
                </a>
            </div>
        </div>

        @if($tab == 'queries')
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4">Search Query / Keyword</th>
                            <th class="py-3 px-3">Clicks</th>
                            <th class="py-3 px-3">Impressions</th>
                            <th class="py-3 px-3">CTR</th>
                            <th class="py-3 px-4 text-right">Avg Position</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($queries as $idx => $q)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3.5 px-4 font-semibold text-slate-900">
                                    <span class="text-slate-400 font-mono text-[11px] mr-1">#{{ $idx + 1 }}</span>
                                    <span>{{ $q->query }}</span>
                                </td>
                                <td class="py-3.5 px-3 font-bold text-brand-700">{{ number_format($q->clicks) }}</td>
                                <td class="py-3.5 px-3 text-slate-600">{{ number_format($q->impressions) }}</td>
                                <td class="py-3.5 px-3 font-semibold text-emerald-600">{{ $q->ctr }}</td>
                                <td class="py-3.5 px-4 text-right">
                                    <span class="inline-block font-bold text-slate-800 bg-slate-100 px-2.5 py-0.5 rounded">
                                        #{{ $q->position }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($tab == 'pages')
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4">Landing Page URL</th>
                            <th class="py-3 px-3">Clicks</th>
                            <th class="py-3 px-3">Impressions</th>
                            <th class="py-3 px-3">CTR</th>
                            <th class="py-3 px-4 text-right">Avg Position</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($pages as $p)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3.5 px-4 font-mono font-medium text-slate-900">{{ $p->url }}</td>
                                <td class="py-3.5 px-3 font-bold text-brand-700">{{ number_format($p->clicks) }}</td>
                                <td class="py-3.5 px-3 text-slate-600">{{ number_format($p->impressions) }}</td>
                                <td class="py-3.5 px-3 font-semibold text-emerald-600">{{ $p->ctr }}</td>
                                <td class="py-3.5 px-4 text-right">
                                    <span class="inline-block font-bold text-slate-800 bg-slate-100 px-2.5 py-0.5 rounded">
                                        #{{ $p->position }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($tab == 'devices')
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($devices as $d)
                    <div class="p-5 rounded-xl border border-slate-200 bg-slate-50/70 text-center">
                        <div class="w-12 h-12 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center mx-auto mb-3 font-black text-lg">
                            @if($d['name'] == 'Mobile') 📱 @elseif($d['name'] == 'Desktop') 💻 @else 📟 @endif
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm">{{ $d['name'] }} Users</h3>
                        <div class="text-3xl font-black font-display text-brand-700 my-1">{{ $d['share'] }}</div>
                        <p class="text-xs text-slate-500">
                            {{ number_format($d['clicks']) }} clicks • {{ number_format($d['impressions']) }} imp
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    @endif
</div>
@endsection
