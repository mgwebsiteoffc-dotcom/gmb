@extends('layouts.admin')

@section('title', 'FAQ Management — Untab SaaS Admin')
@section('page_title', 'FAQ Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search questions…"
                   class="w-64 rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            <select name="category" class="rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="">All Categories</option>
                @foreach($categories as $c)
                    <option value="{{ $c }}" @selected($category === $c)>{{ $c }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2 rounded-xl transition-all">Filter</button>
            <a href="{{ route('admin.faqs.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">Clear</a>
        </form>
        <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-md">
            <i data-lucide="plus" class="w-4 h-4"></i> New FAQ
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left text-[10px] uppercase tracking-wider text-slate-400 font-extrabold">
                    <tr>
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Question</th>
                        <th class="px-5 py-3">Category</th>
                        <th class="px-5 py-3">Order</th>
                        <th class="px-5 py-3">Visible</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($faqs as $faq)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-5 py-3 text-slate-400 font-mono">{{ $faq->id }}</td>
                            <td class="px-5 py-3 font-bold text-slate-800">{{ $faq->question }}</td>
                            <td class="px-5 py-3"><span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-600">{{ $faq->category }}</span></td>
                            <td class="px-5 py-3 text-slate-500">{{ $faq->sort_order }}</td>
                            <td class="px-5 py-3">
                                <form method="POST" action="{{ route('admin.faqs.toggle-active', $faq) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 text-[11px] font-extrabold {{ $faq->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                        <span class="w-2 h-2 rounded-full {{ $faq->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                        {{ $faq->is_active ? 'Visible' : 'Hidden' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="p-1.5 text-slate-500 hover:text-brand-600 hover:bg-brand-50 rounded-lg" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Delete this FAQ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400 text-sm">No FAQs yet. <a href="{{ route('admin.faqs.create') }}" class="text-brand-600 font-bold">Add one</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($faqs->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">{{ $faqs->links() }}</div>
        @endif
    </div>
</div>
@endsection
