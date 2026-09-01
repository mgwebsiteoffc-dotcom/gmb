@extends('layouts.app')

@section('title', 'Connect Google Business Accounts - Untab')

@section('content')
@if(session('error'))
    <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-xl p-3 text-xs font-semibold">{{ session('error') }}</div>
@endif
@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-3 text-xs font-semibold">{{ session('success') }}</div>
@endif

<div class="space-y-6" x-data="{ isConnectModalOpen: false }">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Google Business Profile API
                </span>
                <span class="text-xs text-slate-400 font-medium">Real OAuth 2.0 sync</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 font-display">
                Connected Google Accounts & Client Portfolios
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Link real Google Business Profiles with one click and import every verified location.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-2">
            @if($googleConfigured)
                <a
                    href="{{ route('app.connect.google') }}"
                    class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition-all shadow-md flex items-center gap-2"
                >
                    <i data-lucide="link" class="w-4 h-4"></i> Connect with Google
                </a>
            @endif
            <button
                @click="isConnectModalOpen = true"
                class="bg-white hover:bg-slate-50 text-brand-700 border-2 border-brand-600 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition-all flex items-center gap-2"
            >
                <i data-lucide="plus" class="w-4 h-4"></i> Manual Add
            </button>
        </div>
    </div>

    @if(! $googleConfigured)
        <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl p-4 text-xs">
            <strong>Google not configured yet.</strong> To enable one-click Google sync, add
            <code class="bg-white px-1.5 py-0.5 rounded border border-amber-300 font-mono">GOOGLE_CLIENT_ID</code> and
            <code class="bg-white px-1.5 py-0.5 rounded border border-amber-300 font-mono">GOOGLE_CLIENT_SECRET</code> to your <code class="font-mono">.env</code>,
            set the OAuth redirect to <code class="font-mono">{{ rtrim(config('app.url'), '/').'/app/connect/google/callback' }}</code>,
            then run <code class="bg-white px-1.5 py-0.5 rounded border border-amber-300 font-mono">php artisan config:clear</code>. Until then, use "Manual Add" below.
        </div>
    @endif

    <!-- Linked Google Accounts -->
    @if($googleAccounts->count())
        <div class="space-y-3">
            <h2 class="text-sm font-black text-slate-900 font-display uppercase tracking-wider">Linked Google Accounts</h2>
            @foreach($googleAccounts as $acct)
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i data-lucide="link" class="w-5 h-5"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="font-bold text-slate-900 text-sm truncate">{{ $acct->display_name ?: $acct->account_name }}</div>
                            <div class="text-[11px] text-slate-500">{{ $acct->location_count }} locations · synced {{ $acct->last_synced_at ? $acct->last_synced_at->diffForHumans() : '-' }}</div>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold {{ $acct->status === 'connected' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }} px-2.5 py-1 rounded-full uppercase">{{ $acct->status }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Client Accounts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($clients as $client)
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-2xl border border-slate-200">
                            {{ $client->logo }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-base font-display">{{ $client->name }}</h3>
                            <span class="text-xs text-slate-500">{{ $client->category }}</span>
                        </div>
                    </div>
                    <span class="text-xs font-bold bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Live Synced
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                    <div>
                        <span class="text-slate-400 uppercase text-[10px] font-bold block">Locations:</span>
                        <strong class="text-slate-800 text-sm">{{ $client->locations->count() }} Stores</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 uppercase text-[10px] font-bold block">Account Lead:</span>
                        <strong class="text-slate-800">{{ $client->account_manager ?? 'Sarah Jenkins' }}</strong>
                    </div>
                </div>

                <div class="space-y-2">
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Connected Profiles:</h4>
                    @foreach($client->locations as $loc)
                        <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50/70 border border-slate-100 text-xs">
                            <span class="font-semibold text-slate-800 truncate max-w-[200px]">{{ $loc->name }}</span>
                            <span class="text-emerald-600 font-bold text-[10px]">Google Verified</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center p-10 bg-white rounded-2xl border border-dashed border-slate-300 text-slate-500 text-sm">
                No portfolios yet. Connect Google or add a brand manually to get started.
            </div>
        @endforelse
    </div>

    <!-- Manual Link Modal -->
    <div
        x-show="isConnectModalOpen"
        x-transition
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        style="display: none;"
        @keydown.escape.window="isConnectModalOpen = false"
    >
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden" @click.away="isConnectModalOpen = false">
            <div class="bg-gradient-to-r from-brand-700 to-indigo-800 p-5 text-white flex items-center justify-between">
                <h3 class="font-bold text-base font-display">Add Brand Manually</h3>
                <button @click="isConnectModalOpen = false" class="text-white text-xl font-bold leading-none">✕</button>
            </div>

            <form action="{{ route('app.connect.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Client / Business Brand Name</label>
                    <input type="text" name="client_name" required placeholder="e.g. Metro Health Partners" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Business Category</label>
                    <input type="text" name="category" placeholder="e.g. Medical Clinic Chain" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium">
                </div>

                <div class="p-3.5 bg-brand-50 rounded-xl border border-brand-200 text-xs text-brand-900 space-y-1">
                    <strong>Manual import:</strong>
                    <p class="text-[11px] text-brand-700">Adds a demo portfolio with a sample location. Configure Google OAuth to import real profiles, photos, and reviews automatically.</p>
                </div>

                <div class="pt-3 flex justify-between items-center border-t border-slate-100">
                    <button type="button" @click="isConnectModalOpen = false" class="text-xs font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md">
                        Add Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
