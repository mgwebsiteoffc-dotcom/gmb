@extends('layouts.app')

@section('title', 'Performance Insights & GBP Analytics - Untab')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    GBP Analytics Engine
                </span>
                <span class="text-xs text-slate-400 font-medium">Native Google Performance API</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 font-display">
                Google Business Performance Insights
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Track customer discovery searches, phone calls, direction requests, and website visits.
            </p>
        </div>

        <!-- Date Range Filter -->
        <div class="flex items-center gap-2">
            <div class="flex bg-slate-100 p-1 rounded-xl text-xs font-bold text-slate-700">
                @foreach(['7d', '30d', '90d', '12m'] as $rng)
                    <a
                        href="{{ route('app.insights', ['location_id' => $selectedLocationId, 'range' => $rng]) }}"
                        class="px-3 py-1.5 rounded-lg transition-all uppercase {{ $dateRange == $rng ? 'bg-white text-brand-700 shadow-sm' : 'hover:text-slate-900' }}"
                    >
                        {{ $rng }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Search & Maps Views</span>
                <i data-lucide="eye" class="w-4 h-4 text-brand-600"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 font-display">{{ number_format($totalViews) }}</div>
            <div class="flex items-center gap-1 mt-1 text-xs text-emerald-600 font-semibold">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> +23.8% MoM
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Direct Phone Calls</span>
                <i data-lucide="phone" class="w-4 h-4 text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 font-display">{{ number_format($totalCalls) }}</div>
            <div class="flex items-center gap-1 mt-1 text-xs text-emerald-600 font-semibold">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> +16.2% MoM
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Direction Requests</span>
                <i data-lucide="navigation" class="w-4 h-4 text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 font-display">{{ number_format($totalDirections) }}</div>
            <div class="flex items-center gap-1 mt-1 text-xs text-emerald-600 font-semibold">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> +28.4% MoM
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Website Clicks</span>
                <i data-lucide="globe" class="w-4 h-4 text-blue-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 font-display">{{ number_format($totalClicks) }}</div>
            <div class="flex items-center gap-1 mt-1 text-xs text-emerald-600 font-semibold">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> +19.1% MoM
            </div>
        </div>
    </div>

    <!-- Charts 2-Col Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
            <div>
                <h3 class="font-bold text-slate-900 text-sm font-display">Maps vs Search Impressions Trend</h3>
                <p class="text-[11px] text-slate-400">Where customers discovered your business profiles</p>
            </div>
            <div class="h-64">
                <canvas id="impressionsChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
            <div>
                <h3 class="font-bold text-slate-900 text-sm font-display">Customer Conversion Actions</h3>
                <p class="text-[11px] text-slate-400">Weekly breakdown of calls, directions, and clicks</p>
            </div>
            <div class="h-64">
                <canvas id="actionsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Location Benchmarks Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-base font-display">Cross-Location Benchmarking & Comparison</h3>
                <p class="text-xs text-slate-500">Side-by-side performance matrix for multi-location auditing</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-4">Location</th>
                        <th class="py-3 px-3">Rating & Reviews</th>
                        <th class="py-3 px-3">Total Views</th>
                        <th class="py-3 px-3">Calls</th>
                        <th class="py-3 px-3">Directions</th>
                        <th class="py-3 px-3">Web Clicks</th>
                        <th class="py-3 px-4">Health Score</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($locations as $loc)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-4 font-bold text-slate-900">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-600"></i>
                                    <span>{{ $loc->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-3 font-semibold text-slate-800">
                                ⭐ {{ $loc->rating }} ({{ $loc->review_count }})
                            </td>
                            <td class="py-3 px-3 font-semibold text-slate-800">{{ number_format($loc->monthly_views) }}</td>
                            <td class="py-3 px-3 text-slate-800">{{ $loc->monthly_calls }}</td>
                            <td class="py-3 px-3 text-slate-800">{{ $loc->monthly_directions }}</td>
                            <td class="py-3 px-3 text-slate-800">{{ $loc->monthly_website_clicks }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $loc->health_score > 90 ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $loc->health_score }}% Optimized
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalViews = {{ $totalViews }};
        const totalClicks = {{ $totalClicks }};
        const totalDirections = {{ $totalDirections }};
        const totalCalls = {{ $totalCalls }};

        // Chart 1: Impressions
        const ctx1 = document.getElementById('impressionsChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [
                    {
                        label: 'Google Maps Impressions',
                        data: [Math.round(totalViews * 0.16), Math.round(totalViews * 0.22), Math.round(totalViews * 0.28), Math.round(totalViews * 0.34)],
                        borderColor: '#6161ff',
                        backgroundColor: 'rgba(97, 97, 255, 0.12)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Google Search Impressions',
                        data: [Math.round(totalViews * 0.12), Math.round(totalViews * 0.15), Math.round(totalViews * 0.18), Math.round(totalViews * 0.22)],
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.08)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } }
            }
        });

        // Chart 2: Actions
        const ctx2 = document.getElementById('actionsChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [
                    {
                        label: 'Website Clicks',
                        data: [Math.round(totalClicks * 0.2), Math.round(totalClicks * 0.25), Math.round(totalClicks * 0.27), Math.round(totalClicks * 0.28)],
                        backgroundColor: '#2563eb'
                    },
                    {
                        label: 'Direction Requests',
                        data: [Math.round(totalDirections * 0.2), Math.round(totalDirections * 0.24), Math.round(totalDirections * 0.26), Math.round(totalDirections * 0.3)],
                        backgroundColor: '#10b981'
                    },
                    {
                        label: 'Phone Calls',
                        data: [Math.round(totalCalls * 0.22), Math.round(totalCalls * 0.24), Math.round(totalCalls * 0.26), Math.round(totalCalls * 0.28)],
                        backgroundColor: '#f59e0b'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } }
            }
        });
    });
</script>
@endpush
@endsection
