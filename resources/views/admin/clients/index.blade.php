@extends('layouts.admin')

@section('title', 'Brands & Clients — Untab SaaS Admin')
@section('page_title', 'Brands & Clients')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search brand or category…"
                   class="w-64 rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2 rounded-xl transition-all">Search</button>
            @if($search)
                <a href="{{ route('admin.clients.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700 px-2">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.clients.create') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-md">
            <i data-lucide="plus" class="w-4 h-4"></i> Add Brand
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($clients as $client)
            <a href="{{ route('admin.clients.show', $client) }}" class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 hover:shadow-md hover:border-brand-200 transition-all">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl" style="background: {{ $client->color }}1a">{{ $client->logo }}</div>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-500">{{ $client->locations_count }} locations</span>
                </div>
                <div class="font-black font-display text-slate-900 group-hover:text-brand-700">{{ $client->name }}</div>
                <div class="text-xs text-slate-400 mt-0.5">{{ $client->category }}</div>
                <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100 text-xs font-bold">
                    <span class="text-slate-500">{{ $client->monthly_retainer }}</span>
                    <span class="text-brand-600 flex items-center gap-1">Manage <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></span>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-200/80 p-10 text-center text-slate-400 text-sm">No brands found.</div>
        @endforelse
    </div>
    @if($clients->hasPages())
        <div>{{ $clients->links() }}</div>
    @endif
</div>
@endsection
