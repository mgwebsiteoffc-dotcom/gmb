@extends('layouts.app')

@section('title', 'Multi-Location Command Center - Ampli5 Pulse')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Synced with Google Business API
                </span>
                <span class="text-xs text-slate-400 font-medium">Updated 3 mins ago</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 font-display">
                Multi-Location Command Center
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Managing <strong class="text-slate-800">{{ $locations->count() }} locations</strong> across {{ $clients->count() }} client portfolios.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a
                href="{{ route('app.posts') }}"
                class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition-all shadow-md flex items-center gap-2"
            >
                <i data-lucide="plus" class="w-4 h-4"></i> Create Google Post
            </a>
            <a
                href="{{ route('app.reports') }}"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition-all flex items-center gap-2"
            >
                <i data-lucide="file-text" class="w-4 h-4 text-brand-600"></i> Export Client Report
            </a>
        </div>
    </div>

    <!-- Top KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Views -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Profile Views</span>
                <i data-lucide="eye" class="w-4 h-4 text-brand-600"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900 font-display">
                {{ number_format($totalViews) }}
            </div>
            <div class="flex items-center gap-1 mt-1 text-xs text-emerald-600 font-semibold">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> +21.4% vs last month
            </div>
        </div>

        <!-- Customer Actions -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Customer Actions</span>
                <i data-lucide="phone-call" class="w-4 h-4 text-indigo-600"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900 font-display">
                {{ number_format($totalCalls + $totalDirections + $totalClicks) }}
            </div>
            <div class="flex items-center gap-3 mt-1 text-[11px] text-slate-500 font-medium">
                <span>📞 {{ $totalCalls }} calls</span>
                <span>🧭 {{ $totalDirections }} dir</span>
                <span>🌐 {{ $totalClicks }} web</span>
            </div>
        </div>

        <!-- Overall Rating -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Average Rating</span>
                <i data-lucide="star" class="w-4 h-4 text-amber-500 fill-amber-400"></i>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-2xl sm:text-3xl font-black text-slate-900 font-display">{{ $avgRating }}</div>
                <div class="text-xs text-slate-500 font-semibold">({{ number_format($totalReviews) }} reviews)</div>
            </div>
            <div class="flex items-center gap-1 mt-1 text-xs text-emerald-600 font-semibold">
                <i data-lucide="check" class="w-3.5 h-3.5"></i> 98.6% response rate
            </div>
        </div>

        <!-- Review Queue -->
        <div class="p-5 rounded-2xl border shadow-sm transition-all {{ $unansweredCount > 0 ? 'bg-amber-50/70 border-amber-300' : 'bg-white border-slate-200/80' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Reviews Queue</span>
                <i data-lucide="message-square" class="w-4 h-4 {{ $unansweredCount > 0 ? 'text-amber-600' : 'text-emerald-600' }}"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900 font-display">
                {{ $unansweredCount }} <span class="text-xs font-normal text-slate-500">pending</span>
            </div>
            <div class="mt-1">
                @if($unansweredCount > 0)
                    <a href="{{ route('app.reviews') }}" class="text-xs font-bold text-amber-800 hover:text-amber-900 flex items-center gap-1">
                        <i data-lucide="sparkles" class="w-3 h-3 text-amber-600"></i> Reply with AI Assistant →
                    </a>
                @else
                    <span class="text-xs text-emerald-600 font-semibold flex items-center gap-1">
                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> All reviews answered!
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Grid: Location Matrix & Feeds -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left 8 Cols: Locations Table -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between flex-wrap gap-2">
                <div>
                    <h2 class="font-extrabold text-slate-900 text-base font-display">Connected Google Business Profiles</h2>
                    <p class="text-xs text-slate-500">Live health score, verification, and performance status per location</p>
                </div>
                <a href="{{ route('app.connect') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">
                    + Connect New Profile
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase tracking-wider font-bold text-[10px]">
                        <tr>
                            <th class="py-3 px-4">Location & Client</th>
                            <th class="py-3 px-3">Rating</th>
                            <th class="py-3 px-3">Views (30d)</th>
                            <th class="py-3 px-3">Actions</th>
                            <th class="py-3 px-3">Health</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($locations as $loc)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <img
                                            src="{{ $loc->cover_image }}"
                                            alt="{{ $loc->name }}"
                                            class="w-10 h-10 rounded-lg object-cover border border-slate-200 flex-shrink-0"
                                        />
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-900 truncate max-w-[220px] flex items-center gap-1.5">
                                                {{ $loc->name }}
                                                @if($loc->verified)
                                                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-blue-500 flex-shrink-0"></i>
                                                @endif
                                            </div>
                                            <div class="text-[11px] text-slate-500 truncate max-w-[200px]">{{ $loc->address }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap">
                                    <div class="font-bold text-slate-900">
                                        ⭐ {{ $loc->rating }} <span class="text-slate-400 font-normal">({{ $loc->review_count }})</span>
                                    </div>
                                    @if($loc->unanswered_reviews > 0)
                                        <span class="text-[10px] text-amber-600 font-bold bg-amber-50 px-1.5 py-0.5 rounded">
                                            {{ $loc->unanswered_reviews }} unreplied
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3 font-semibold text-slate-800 whitespace-nowrap">
                                    {{ number_format($loc->monthly_views) }}
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap">
                                    <div class="font-semibold text-slate-800">
                                        {{ number_format($loc->monthly_calls + $loc->monthly_directions + $loc->monthly_website_clicks) }}
                                    </div>
                                    <div class="text-[10px] text-slate-400">{{ $loc->monthly_calls }} calls</div>
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-800">{{ $loc->health_score }}%</span>
                                        <div class="w-12 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                            <div 
                                                class="h-full rounded-full {{ $loc->health_score > 90 ? 'bg-emerald-500' : 'bg-amber-500' }}"
                                                style="width: {{ $loc->health_score }}%"
                                            ></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <a
                                        href="{{ route('app.insights', ['location_id' => $loc->id]) }}"
                                        class="text-xs font-bold text-brand-600 hover:text-brand-800 bg-brand-50 hover:bg-brand-100 px-2.5 py-1 rounded-lg transition-all"
                                    >
                                        Insights →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right 4 Cols: Quick AI Queue & Recent Posts -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Unanswered Reviews -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <i data-lucide="sparkles" class="w-4 h-4 text-brand-600"></i>
                        <h3 class="font-bold text-slate-900 text-sm font-display">Pending Reviews</h3>
                    </div>
                    <a href="{{ route('app.reviews') }}" class="text-xs font-bold text-brand-600 hover:underline">
                        View all
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($pendingReviews as $rev)
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-800">{{ $rev->author_name }}</span>
                                <span class="text-amber-500 font-bold">⭐ {{ $rev->rating }}</span>
                            </div>
                            <p class="text-slate-600 text-[11px] line-clamp-2">"{{ $rev->snippet }}"</p>
                            <div class="flex items-center justify-between pt-1 border-t border-slate-200">
                                <span class="text-[10px] text-slate-400 truncate max-w-[140px]">{{ $rev->location->name ?? 'Location' }}</span>
                                <a href="{{ route('app.reviews') }}" class="bg-brand-600 text-white font-bold text-[10px] px-2.5 py-1 rounded-lg">
                                    AI Reply
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">
                            <i data-lucide="check-circle-2" class="w-8 h-8 text-emerald-500 mx-auto mb-2"></i>
                            All reviews answered!
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-brand-600"></i>
                        <h3 class="font-bold text-slate-900 text-sm font-display">Recent Google Posts</h3>
                    </div>
                    <a href="{{ route('app.posts') }}" class="text-xs font-bold text-brand-600 hover:underline">
                        Manage
                    </a>
                </div>

                <div class="space-y-3">
                    @foreach($recentPosts as $post)
                        <div class="flex gap-3 p-2.5 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                            <img
                                src="{{ $post->media_url }}"
                                alt="{{ $post->title }}"
                                class="w-12 h-12 rounded-lg object-cover flex-shrink-0"
                            />
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-bold uppercase bg-brand-50 text-brand-700 px-1.5 py-0.5 rounded">
                                        {{ str_replace('_', ' ', $post->type) }}
                                    </span>
                                    <span class="text-[10px] text-slate-400">{{ $post->status }}</span>
                                </div>
                                <h4 class="font-bold text-slate-800 truncate text-[11px] mt-1">{{ $post->title }}</h4>
                                <div class="text-[10px] text-slate-500 mt-0.5">
                                    {{ $post->views > 0 ? number_format($post->views) . ' views • ' . $post->clicks . ' clicks' : 'Scheduled' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
