@extends('layouts.admin')

@section('title', 'Super Admin Dashboard — Untab SaaS')
@section('page_title', 'Super Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome banner -->
    <div class="bg-gradient-to-r from-brand-800 via-brand-600 to-brand-500 rounded-3xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background: radial-gradient(circle at 80% 20%, #fff 0%, transparent 60%)"></div>
        <div class="relative">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 border border-white/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                            {{ $settings?->agency_name ?? 'Untab Local Growth Agency' }} — Live
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black font-display">Welcome back, {{ auth()->user()->name }} 👋</h1>
                    <p class="text-sm text-brand-100 mt-1">You're running the entire {{ $settings?->custom_domain ?? 'clients.untab.com' }} SaaS platform.</p>
                </div>
                <a href="{{ route('app.dashboard') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 font-bold text-sm px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all self-start">
                    <i data-lucide="arrow-right" class="w-4 h-4"></i> Open GBP App
                </a>
            </div>
        </div>
    </div>

    <!-- KPI cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
        @php($kpis = [
            ['label' => 'Clients / Brands', 'value' => $totalClients, 'icon' => 'building-2', 'accent' => 'text-brand-600 bg-brand-50'],
            ['label' => 'Locations', 'value' => $totalLocations, 'icon' => 'map-pin', 'accent' => 'text-violet-600 bg-violet-50'],
            ['label' => 'Total Users', 'value' => $totalUsers, 'icon' => 'users', 'accent' => 'text-emerald-600 bg-emerald-50'],
            ['label' => 'Reviews', 'value' => $totalReviews, 'icon' => 'star', 'accent' => 'text-amber-600 bg-amber-50'],
            ['label' => 'Unanswered', 'value' => $unansweredReviews, 'icon' => 'message-square', 'accent' => 'text-accent-600 bg-accent-50'],
            ['label' => 'Google Posts', 'value' => $totalPosts, 'icon' => 'calendar', 'accent' => 'text-sky-600 bg-sky-50'],
        ])
        @foreach($kpis as $kpi)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 flex flex-col gap-1">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">{{ $kpi['label'] }}</span>
                    <span class="w-8 h-8 rounded-lg {{ $kpi['accent'] }} flex items-center justify-center"><i data-lucide="{{ $kpi['icon'] }}" class="w-4 h-4"></i></span>
                </div>
                <div class="text-2xl font-black font-display text-slate-900">{{ number_format($kpi['value']) }}</div>
            </div>
        @endforeach
    </div>

    <!-- Content engine (blogs, FAQs, SEO guidelines) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-black text-slate-900 font-display flex items-center gap-2"><i data-lucide="newspaper" class="w-4 h-4 text-brand-600"></i> Content Engine</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.blogs.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">Manage Blogs →</a>
                <a href="{{ route('admin.seo.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">SEO Guidelines →</a>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="rounded-xl bg-brand-50 border border-brand-100 p-4">
                <div class="flex items-center gap-2 text-brand-700 text-[10px] font-extrabold uppercase tracking-wider"><i data-lucide="file-text" class="w-4 h-4"></i> Blog Posts</div>
                <div class="mt-1 text-2xl font-black font-display text-slate-900">{{ number_format($totalBlogPosts) }}</div>
                <div class="text-[10px] text-slate-400 font-bold mt-0.5">{{ number_format($publishedBlogPosts) }} published</div>
            </div>
            <div class="rounded-xl bg-violet-50 border border-violet-100 p-4">
                <div class="flex items-center gap-2 text-violet-700 text-[10px] font-extrabold uppercase tracking-wider"><i data-lucide="help-circle" class="w-4 h-4"></i> FAQs</div>
                <div class="mt-1 text-2xl font-black font-display text-slate-900">{{ number_format($totalFaqs) }}</div>
                <div class="text-[10px] text-slate-400 font-bold mt-0.5">{{ number_format($activeFaqs) }} visible</div>
            </div>
            <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-4">
                <div class="flex items-center gap-2 text-emerald-700 text-[10px] font-extrabold uppercase tracking-wider"><i data-lucide="search" class="w-4 h-4"></i> SEO Guidelines</div>
                <div class="mt-1 text-2xl font-black font-display text-slate-900">{{ number_format($totalSeoGuidelines) }}</div>
                <div class="text-[10px] text-slate-400 font-bold mt-0.5">{{ number_format($activeSeoGuidelines) }} active</div>
            </div>
            <div class="rounded-xl bg-amber-50 border border-amber-100 p-4">
                <div class="flex items-center gap-2 text-amber-700 text-[10px] font-extrabold uppercase tracking-wider"><i data-lucide="users" class="w-4 h-4"></i> Team Members</div>
                <div class="mt-1 text-2xl font-black font-display text-slate-900">{{ number_format($teamMembers) }}</div>
                <div class="text-[10px] text-slate-400 font-bold mt-0.5">in the agency</div>
            </div>
        </div>
    </div>

    <!-- Engagement row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php($engagement = [
            ['label' => 'Monthly Views', 'value' => $monthlyViews, 'icon' => 'eye', 'format' => 'short'],
            ['label' => 'Monthly Calls', 'value' => $monthlyCalls, 'icon' => 'phone', 'format' => 'short'],
            ['label' => 'Directions', 'value' => $monthlyDirections, 'icon' => 'navigation', 'format' => 'short'],
            ['label' => 'Website Clicks', 'value' => $monthlyClicks, 'icon' => 'mouse-pointer-click', 'format' => 'short'],
        ])
        @foreach($engagement as $e)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4">
                <div class="flex items-center gap-2 text-slate-400 mb-1">
                    <i data-lucide="{{ $e['icon'] }}" class="w-4 h-4"></i>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider">{{ $e['label'] }}</span>
                </div>
                <div class="text-2xl font-black font-display text-slate-900">
                    @if($e['format'] === 'short')
                        {{ $e['value'] >= 1000000 ? number_format($e['value'] / 1000000, 1) . 'm' : number_format($e['value'] / 1000, $e['value'] >= 10000 ? 0 : 1) . 'k' }}
                    @else
                        {{ number_format($e['value']) }}
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts + roles -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-black text-slate-900 font-display">Platform Growth — Monthly Views</h2>
                <span class="text-[10px] text-slate-400 font-bold uppercase">Trailing 9 months</span>
            </div>
            <canvas id="adminGrowthChart" height="140"></canvas>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <h2 class="text-sm font-black text-slate-900 font-display mb-4">Role Distribution</h2>
            <div class="space-y-4">
                @foreach($roleDistribution as $role => $count)
                    @php($meta = [
                        'super_admin' => ['label' => 'Super Admins', 'color' => 'bg-brand-600', 'class' => 'text-brand-700'],
                        'brand_admin' => ['label' => 'Brand Admins', 'color' => 'bg-violet-500', 'class' => 'text-violet-700'],
                        'user' => ['label' => 'Users / Staff', 'color' => 'bg-slate-400', 'class' => 'text-slate-700'],
                    ][$role] ?? ['label' => ucfirst($role), 'color' => 'bg-slate-400', 'class' => 'text-slate-700'])
                    @php($pct = $totalUsers > 0 ? round($count / $totalUsers * 100) : 0)
                    <div>
                        <div class="flex items-center justify-between text-xs font-bold mb-1.5">
                            <span class="{{ $meta['class'] }}">{{ $meta['label'] }}</span>
                            <span class="text-slate-500">{{ $count }} ({{ $pct }}%)</span>
                        </div>
                        <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $meta['color'] }} rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 pt-5 border-t border-slate-100 grid grid-cols-2 gap-3 text-center">
                <div>
                    <div class="text-xl font-black font-display text-slate-900">{{ $avgHealth }}<span class="text-xs text-slate-400">%</span></div>
                    <div class="text-[10px] uppercase tracking-wider font-bold text-slate-400">Avg Health</div>
                </div>
                <div>
                    <div class="text-xl font-black font-display text-slate-900">★ {{ $avgRating }}</div>
                    <div class="text-[10px] uppercase tracking-wider font-bold text-slate-400">Avg Rating</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent users + clients -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-black text-slate-900 font-display">Recent Users</h2>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">View all →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentUsers as $u)
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-black text-xs uppercase">{{ $u->name[0] }}</div>
                            <div>
                                <div class="text-sm font-bold text-slate-800">{{ $u->name }}</div>
                                <div class="text-xs text-slate-400">{{ $u->email }}</div>
                            </div>
                        </div>
                        <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-extrabold border {{ $u->roleBadgeClass() }}">{{ $u->roleLabel() }}</span>
                    </div>
                @empty
                    <div class="py-8 text-center text-sm text-slate-400">No users yet.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-black text-slate-900 font-display">Recent Brands / Clients</h2>
                <a href="{{ route('admin.clients.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">View all →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentClients as $client)
                    <a href="{{ route('admin.clients.show', $client) }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-brand-200 hover:bg-brand-50/40 transition-all">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl" style="background: {{ $client->color }}1a">{{ $client->logo }}</div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-bold text-slate-800 truncate">{{ $client->name }}</div>
                            <div class="text-xs text-slate-400">{{ $client->category }} · {{ $client->locations->count() }} locations</div>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
                    </a>
                @empty
                    <div class="py-8 text-center text-sm text-slate-400">No clients yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('adminGrowthChart');
    if (ctx && window.Chart) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($trend['labels']),
                datasets: [
                    {
                        label: 'Views',
                        data: @json($trend['views']),
                        borderColor: '#4b4be0',
                        backgroundColor: 'rgba(75,75,224,0.08)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 0,
                    },
                    {
                        label: 'Calls',
                        data: @json($trend['calls']),
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249,115,22,0.05)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 0,
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, font: { weight: 'bold', size: 11 } } } },
                scales: {
                    y: { ticks: { callback: v => (v/1000).toFixed(0) + 'k' }, grid: { color: '#f1f5f9' }, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                }
            }
        });
    }
</script>
@endpush
