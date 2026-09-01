@php($blog = $blog ?? null)
@php($isEdit = isset($blog) && $blog->exists)
@php($tagsString = ($blog?->tags ?? []) ? implode(', ', $blog->tags) : '')

<form method="POST" action="{{ $isEdit ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if($isEdit) @method('PUT') @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
            <ul class="list-disc pl-4 space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Main column -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
                <label class="block text-sm font-bold text-slate-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $blog->title ?? '') }}" required
                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                
                <label class="block text-sm font-bold text-slate-700 mb-1 mt-4">Slug <span class="font-normal text-slate-400">(leave blank to auto-generate)</span></label>
                <input type="text" name="slug" value="{{ old('slug', $blog->slug ?? '') }}"
                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">

                <label class="block text-sm font-bold text-slate-700 mb-1 mt-4">Excerpt <span class="font-normal text-slate-400">(short summary for cards & meta)</span></label>
                <textarea name="excerpt" rows="2" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>

                <label class="block text-sm font-bold text-slate-700 mb-1 mt-4">Content</label>
                <textarea name="content" rows="16" required class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('content', $blog->content ?? '') }}</textarea>
                <p class="text-xs text-slate-400 mt-1">Supports HTML. Use <code class="bg-slate-100 px-1.5 py-0.5 rounded">&lt;h2&gt;</code>, <code class="bg-slate-100 px-1.5 py-0.5 rounded">&lt;p&gt;</code>, <code class="bg-slate-100 px-1.5 py-0.5 rounded">&lt;blockquote&gt;</code>, <code class="bg-slate-100 px-1.5 py-0.5 rounded">&lt;ul&gt;</code>.</p>
            </div>

            <!-- SEO fields -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2"><i data-lucide="search" class="w-4 h-4 text-brand-600"></i> SEO / AEO Settings</h3>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $blog->meta_title ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <p class="text-[10px] text-slate-400 mt-1">Max ~60 chars. Leave blank to use the title.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="2" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Keywords</label>
                        <input type="text" name="keywords" value="{{ old('keywords', $blog->keywords ?? '') }}" placeholder="local seo, gbp, google business profile" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Reading Time</label>
                        <input type="text" name="reading_time" value="{{ old('reading_time', $blog->reading_time ?? '') }}" placeholder="e.g. 5 min read (auto if blank)" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-700">Publish</h3>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Status</label>
                    <select name="status" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="published" @selected(old('status', $blog->status ?? 'published') === 'published')>Published</option>
                        <option value="draft" @selected(old('status', $blog->status ?? '') === 'draft')>Draft</option>
                        <option value="scheduled" @selected(old('status', $blog->status ?? '') === 'scheduled')>Scheduled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Publish Date</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', $blog?->published_at?->format('Y-m-d\TH:i') ?? '') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Featured</label>
                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                        <input type="checkbox" name="featured" value="1" @checked(old('featured', $blog->featured ?? false)) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        Show in featured spotlight
                    </label>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-md">{{ $isEdit ? 'Update Post' : 'Create Post' }}</button>
                    <a href="{{ route('admin.blogs.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-slate-600 hover:bg-slate-50">Cancel</a>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-700">Details</h3>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Category</label>
                    <input type="text" name="category" value="{{ old('category', $blog->category ?? 'Local SEO') }}" list="blog-cats" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <datalist id="blog-cats">
                        @foreach(['Local SEO','Google Business Profile','Review Management','Agency Growth','Multi-Location','Online Reputation','Tips & Tricks','Product Updates'] as $c) <option value="{{ $c }}"> @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Tags <span class="font-normal text-slate-400">(comma-separated)</span></label>
                    <input type="text" name="tags" value="{{ old('tags', $tagsString) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Author</label>
                    <input type="text" name="author" value="{{ old('author', $blog->author ?? 'Untab Team') }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Cover Image URL</label>
                    <input type="url" name="cover_image" value="{{ old('cover_image', $blog->cover_image ?? '') }}" placeholder="https://…" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    @if(!empty($blog->cover_image))
                        <img src="{{ $blog->cover_image }}" alt="" class="mt-2 w-full h-32 object-cover rounded-xl">
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
