@php($isEdit = isset($guideline) && $guideline->exists)
@php($keywords = ($guideline->recommended_keywords ?? []) ? implode(', ', $guideline->recommended_keywords) : '')

<form method="POST" action="{{ $isEdit ? route('admin.seo.update', $guideline) : route('admin.seo.store') }}" class="space-y-6">
    @csrf
    @if($isEdit) @method('PUT') @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
            <ul class="list-disc pl-4 space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2"><i data-lucide="file-text" class="w-4 h-4 text-brand-600"></i> Guideline</h3>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title', $guideline->title ?? '') }}" required placeholder="e.g. Location Page Meta Title" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Short Description</label>
                    <textarea name="description" rows="2" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('description', $guideline->description ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Guideline / Checklist Content</label>
                    <textarea name="content" rows="10" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('content', $guideline->content ?? '') }}</textarea>
                    <p class="text-xs text-slate-400 mt-1">Step-by-step SEO/AEO guidance, JSON-LD requirements, and checklists. Supports HTML.</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2"><i data-lucide="search" class="w-4 h-4 text-brand-600"></i> Templates & Keywords</h3>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">SEO Title Template</label>
                    <input type="text" name="seo_title_template" value="{{ old('seo_title_template', $guideline->seo_title_template ?? '') }}" placeholder="e.g. {Location} | Untab GBP" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Meta Description Template</label>
                    <textarea name="meta_description_template" rows="2" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('meta_description_template', $guideline->meta_description_template ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Recommended Keywords <span class="font-normal text-slate-400">(comma-separated)</span></label>
                    <input type="text" name="recommended_keywords" value="{{ old('recommended_keywords', $keywords) }}" placeholder="local seo, gbp, reviews" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-700">Publish</h3>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Page Type</label>
                    <input type="text" name="page_type" value="{{ old('page_type', $guideline->page_type ?? 'General') }}" list="seo-types" placeholder="e.g. Home, Blog, Pricing" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <datalist id="seo-types">
                        @foreach(['General','Home','Features','Pricing','Blog','Blog Post','Location','FAQ','Reviews','Posts','Tools','Agency'] as $t) <option value="{{ $t }}"> @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Page Path</label>
                    <input type="text" name="page_path" value="{{ old('page_path', $guideline->page_path ?? '') }}" placeholder="/blog" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $guideline->sort_order ?? 0) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $guideline->is_active ?? true)) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    Active
                </label>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-md">{{ $isEdit ? 'Update' : 'Create' }}</button>
                    <a href="{{ route('admin.seo.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-slate-600 hover:bg-slate-50">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
