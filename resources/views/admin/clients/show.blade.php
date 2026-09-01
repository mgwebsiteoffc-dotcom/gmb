@extends('layouts.admin')

@section('title', $client->name . ' — Untab SaaS Admin')
@section('page_title', $client->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-3xl overflow-hidden" style="background: {{ $client->color }}1a">
                @if($client->hasLogoImage())
                    <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="w-full h-full object-contain">
                @else
                    {{ $client->logo }}
                @endif
            </div>
            <div>
                <h1 class="text-xl font-black font-display text-slate-900">{{ $client->name }}</h1>
                <p class="text-sm text-slate-400">{{ $client->category }} · {{ $client->monthly_retainer }} · Since {{ $client->active_since }}</p>
                <p class="text-xs text-slate-400 mt-1">Account Manager: {{ $client->account_manager ?? 'Unassigned' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.clients.edit', $client) }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm px-4 py-2 rounded-xl transition-all">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit
            </a>
            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('Delete {{ $client->name }} and all its locations?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-sm px-4 py-2 rounded-xl transition-all">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4">
            <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">Locations</div>
            <div class="text-2xl font-black font-display text-slate-900">{{ $locations->count() }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4">
            <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">Total Reviews</div>
            <div class="text-2xl font-black font-display text-slate-900">{{ number_format($totalReviews) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4">
            <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">Monthly Views</div>
            <div class="text-2xl font-black font-display text-slate-900">{{ number_format($totalViews) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4">
            <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">Avg Rating</div>
            <div class="text-2xl font-black font-display text-slate-900">★ {{ number_format($avgRating, 1) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Locations -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <h2 class="text-sm font-black text-slate-900 font-display mb-4">Locations ({{ $locations->count() }})</h2>
            <div class="space-y-3">
                @forelse($locations as $loc)
                    <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100">
                        <div>
                            <div class="font-bold text-slate-800 text-sm">{{ $loc->name }}</div>
                            <div class="text-xs text-slate-400">{{ $loc->address }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-slate-600">★ {{ $loc->rating }} · {{ $loc->review_count }} reviews</div>
                            <div class="text-[10px] font-extrabold {{ $loc->health_score >= 90 ? 'text-emerald-600' : 'text-amber-600' }}">Health {{ $loc->health_score }}%</div>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-sm text-slate-400">No locations yet. Add via the GBP app.</div>
                @endforelse
            </div>
        </div>

        <!-- Brand Admins -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-black text-slate-900 font-display">Brand Admins ({{ $admins->count() }})</h2>
                <a href="{{ route('admin.users.create') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">+ Add</a>
            </div>
            <div class="space-y-3">
                @forelse($admins as $admin)
                    <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-black text-xs uppercase">{{ $admin->name[0] }}</div>
                            <div>
                                <div class="font-bold text-slate-800 text-sm">{{ $admin->name }}</div>
                                <div class="text-xs text-slate-400">{{ $admin->email }}</div>
                            </div>
                        </div>
                        <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-extrabold border {{ $admin->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }}">{{ $admin->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                @empty
                    <div class="py-8 text-center text-sm text-slate-400">No brand admins assigned. <a href="{{ route('admin.users.create') }}" class="text-brand-600 font-bold">Invite one</a>.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
