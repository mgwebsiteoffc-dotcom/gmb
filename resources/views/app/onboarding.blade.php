@extends('layouts.app')

@section('title', 'Setup Your Workspace — Untab')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-brand-800 via-brand-600 to-brand-500 rounded-3xl p-7 sm:p-9 text-white shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background: radial-gradient(circle at 80% 20%, #fff 0%, transparent 60%)"></div>
        <div class="relative">
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 border border-white/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span> Welcome to Untab
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black font-display">Finish setting up your brand 👋</h1>
            <p class="text-sm text-brand-100 mt-1 max-w-xl">
                A few quick steps get your Google Business Profiles running — connect your Google account, add a location, publish a post, invite your team and customize your branding.
            </p>

            <!-- Progress -->
            <div class="mt-6 max-w-xl">
                <div class="flex items-center justify-between text-xs font-bold mb-1.5">
                    <span>{{ $completed }} of {{ count($steps) }} steps complete</span>
                    <span>{{ $percent }}%</span>
                </div>
                <div class="h-2.5 bg-white/20 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-400 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Steps -->
    <div class="grid grid-cols-1 gap-4">
        @foreach($steps as $step)
            <div class="bg-white rounded-2xl border {{ $step['done'] ? 'border-emerald-200' : 'border-slate-200/80' }} shadow-sm p-5 flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex-shrink-0">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center {{ $step['done'] ? 'bg-emerald-50 text-emerald-600' : 'bg-brand-50 text-brand-600' }}">
                        @if($step['done'])
                            <i data-lucide="check" class="w-5 h-5"></i>
                        @else
                            <i data-lucide="{{ ['connect' => 'link', 'location' => 'map-pin', 'post' => 'calendar', 'team' => 'users', 'settings' => 'settings'][$step['key']] ?? 'circle' }}" class="w-5 h-5"></i>
                        @endif
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-slate-900 text-sm font-display">{{ $step['label'] }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mt-0.5">{{ $step['desc'] }}</p>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    @if($step['done'])
                        <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600"><i data-lucide="check-circle-2" class="w-4 h-4"></i> Done</span>
                    @else
                        <a href="{{ route($step['action']['route']) }}" class="inline-flex items-center gap-1.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-md">
                            {{ $step['action']['label'] }} <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Footer actions -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
        <p class="text-xs text-slate-500">
            You can come back to this checklist anytime from the <b>Settings</b> area.
        </p>
        <div class="flex items-center gap-3">
            <a href="{{ route('app.connect') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">Connect Google</a>
            <a href="{{ route('app.dashboard') }}" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-all shadow-md">
                Go to Dashboard →
            </a>
        </div>
    </div>
</div>
@endsection
