@extends('layouts.admin')

@section('title', 'SEO Guidelines — Untab SaaS Admin')
@section('page_title', 'SEO Guidelines')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500 max-w-2xl">Manage the SEO/AEO rules and best-practice templates the Untab team follows across each page type. These guidelines power on-page optimization and search-engine best practices.</p>
        </div>
        <a href="{{ route('admin.seo.create') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-md">
            <i data-lucide="plus" class="w-4 h-4"></i> New Guideline
        </a>
    </div>

    <form method="GET" class="flex flex-wrap items-center gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search guidelines…"
               class="w-64 rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
        <select name="page_type" class="rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            <option value="">All Page Types</option>
            @foreach($types as $t)
                <option value="{{ $t }}" @selected($type === $t)>{{ $t }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2 rounded-xl transition-all">Filter</button>
        <a href="{{ route('admin.seo.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">Clear</a>
    </form>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($guidelines as $g)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 flex flex-col gap-3">
                <div class="flex items-start justify-between gap-2">
                    <h3 class="font-bold text-slate-800 leading-snug">{{ $g->title }}</h3>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $g->is_active ? 'bg-brand-50 text-brand-700' : 'bg-slate-100 text-slate-400' }} flex-shrink-0">{{ $g->is_active ? 'Active' : 'Draft' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-600">{{ $g->page_type }}</span>
                    @if($g->page_path)
                        <code class="text-[10px] text-slate-400 bg-slate-50 px-1.5 py-0.5 rounded">{{ $g->page_path }}</code>
                    @endif
                </div>
                <p class="text-sm text-slate-500 line-clamp-3 flex-1">{{ $g->description }}</p>
                @if($g->seo_title_template)
                    <div class="text-xs text-slate-400"><span class="font-bold text-slate-500">Title:</span> {{ $g->seo_title_template }}</div>
                @endif
                <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                    <a href="{{ route('admin.seo.edit', $g) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-700"><i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit</a>
                    <form method="POST" action="{{ route('admin.seo.destroy', $g) }}" onsubmit="return confirm('Delete this guideline?')" class="inline-flex">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-500 hover:text-red-600"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 xl:col-span-3 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-10 text-center text-slate-400 text-sm">
                No SEO guidelines yet. <a href="{{ route('admin.seo.create') }}" class="text-brand-600 font-bold">Create one</a>.
            </div>
        @endforelse
    </div>

    @if($guidelines->hasPages())
        <div class="mt-4">{{ $guidelines->links() }}</div>
    @endif
</div>
@endsection
