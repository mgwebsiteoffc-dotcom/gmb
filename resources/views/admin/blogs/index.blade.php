@extends('layouts.admin')

@section('title', 'Blog Management — Untab SaaS Admin')
@section('page_title', 'Blog Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search posts…"
                   class="w-64 rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            <select name="status" class="rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="">All Status</option>
                <option value="published" @selected($status === 'published')>Published</option>
                <option value="draft" @selected($status === 'draft')>Draft</option>
                <option value="scheduled" @selected($status === 'scheduled')>Scheduled</option>
            </select>
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2 rounded-xl transition-all">Filter</button>
            <a href="{{ route('admin.blogs.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">Clear</a>
        </form>
        <a href="{{ route('admin.blogs.create') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-md">
            <i data-lucide="pen-line" class="w-4 h-4"></i> New Post
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left text-[10px] uppercase tracking-wider text-slate-400 font-extrabold">
                    <tr>
                        <th class="px-5 py-3">Post</th>
                        <th class="px-5 py-3">Category</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Featured</th>
                        <th class="px-5 py-3">Published</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($posts as $post)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    @if($post->cover_image)
                                        <img src="{{ $post->cover_image }}" alt="" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-brand-100 text-brand-700 flex items-center justify-center font-black flex-shrink-0">{{ strtoupper($post->title[0]) }}</div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-800 truncate max-w-[260px]">{{ $post->title }}</div>
                                        <div class="text-xs text-slate-400 truncate max-w-[260px]">{{ $post->excerpt }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3"><span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-600">{{ $post->category }}</span></td>
                            <td class="px-5 py-3">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : ($post->status === 'scheduled' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-500') }}">{{ $post->statusLabel() }}</span>
                            </td>
                            <td class="px-5 py-3 text-slate-500">{{ $post->featured ? '★' : '—' }}</td>
                            <td class="px-5 py-3 text-slate-500 text-xs">{{ $post->published_at?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('blog.show', $post) }}" target="_blank" class="p-1.5 text-slate-500 hover:text-brand-600 hover:bg-brand-50 rounded-lg" title="View live">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('admin.blogs.edit', $post) }}" class="p-1.5 text-slate-500 hover:text-brand-600 hover:bg-brand-50 rounded-lg" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.blogs.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400 text-sm">No posts yet. <a href="{{ route('admin.blogs.create') }}" class="text-brand-600 font-bold">Write the first one</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">{{ $posts->links() }}</div>
        @endif
    </div>
</div>
@endsection
