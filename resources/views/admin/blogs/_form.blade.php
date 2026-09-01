@php($blog = $blog ?? null)
@php($isEdit = isset($blog) && $blog->exists)
@php($tagsString = ($blog?->tags ?? []) ? implode(', ', $blog->tags) : '')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
<style>
    #blog-content-editor .ql-toolbar { border-radius: 12px 12px 0 0; border-color: #e2e8f0; background: #f8fafc; }
    #blog-content-editor .ql-container { border-color: #e2e8f0; font-family: 'Plus Jakarta Sans', sans-serif; border-radius: 0 0 12px 12px; }
    #blog-content-editor .ql-editor { min-height: 300px; font-size: 14px; line-height: 1.7; }
    #blog-content-editor .ql-editor img { max-width: 100%; height: auto; border-radius: 8px; margin: 0.5rem 0; }
    #blog-content-editor .ql-editor h2, #blog-content-editor .ql-editor h3 { font-weight: 800; }
</style>
@endpush

<form method="POST" id="blog-form" action="{{ $isEdit ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}" enctype="multipart/form-data" class="space-y-6">
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
                <div id="blog-content-editor" class="rounded-xl border border-slate-300"></div>
                <textarea name="content" id="blog-content-input" style="display:none;">{{ old('content', $blog->content ?? '') }}</textarea>
                <p class="text-xs text-slate-400 mt-1">Rich text editor. Use the toolbar to format headings, lists and quotes. The <b>image</b> button uploads an image (JPEG / PNG / WebP / GIF) and inserts it automatically.</p>
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
                    <label class="block text-sm font-bold text-slate-700 mb-1">Cover Image</label>
                    <label for="blog-cover-input" class="cursor-pointer inline-flex items-center gap-2 bg-brand-50 text-brand-700 border border-brand-200 rounded-xl px-4 py-2.5 text-sm font-bold hover:bg-brand-100 transition-colors">
                        <i data-lucide="upload" class="w-4 h-4"></i> Upload Cover Image
                        <input type="file" id="blog-cover-input" name="cover_image" accept="image/*" class="hidden" onchange="untabBlogCoverPreview(this)">
                    </label>
                    <div id="blog-cover-preview" class="mt-3">
                        @if(!empty($blog->cover_image))
                            <div class="relative inline-block w-full">
                                <img src="{{ $blog->cover_image }}" alt="Cover preview" class="w-full h-40 object-cover rounded-xl border border-slate-200">
                                <button type="button" onclick="untabBlogCoverRemove()" class="absolute top-2 right-2 w-7 h-7 rounded-full bg-slate-900/70 text-white text-xs font-bold hover:bg-red-600">✕</button>
                            </div>
                        @endif
                    </div>
                    <input type="hidden" name="remove_cover" id="blog-cover-remove" value="0">
                    <p class="text-[11px] text-slate-400 mt-1">JPEG, PNG, WebP or GIF up to 8MB. Only image files are accepted. The current cover stays unless you upload a new one.</p>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    function untabBlogCoverPreview(input) {
        const file = input.files && input.files[0];
        if (!file) return;
        const wrap = document.getElementById('blog-cover-preview');
        const url = URL.createObjectURL(file);
        const remove = document.getElementById('blog-cover-remove');
        if (remove) remove.value = '0'; // a fresh upload wins over "remove"
        wrap.innerHTML = '<div class="relative inline-block w-full">' +
            '<img src="' + url + '" class="w-full h-40 object-cover rounded-xl border border-slate-200">' +
            '<button type="button" onclick="untabBlogCoverRemove()" class="absolute top-2 right-2 w-7 h-7 rounded-full bg-slate-900/70 text-white text-xs font-bold hover:bg-red-600">&#10005;</button>' +
            '</div>';
    }
    function untabBlogCoverRemove() {
        const input = document.getElementById('blog-cover-input');
        if (input) input.value = '';
        const remove = document.getElementById('blog-cover-remove');
        if (remove) remove.value = '1';
        const wrap = document.getElementById('blog-cover-preview');
        if (wrap) wrap.innerHTML = '';
    }
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('blog-content-editor');
        if (!el || typeof Quill === 'undefined') return;
        const ta = document.getElementById('blog-content-input');
        const quill = new Quill(el, {
            theme: 'snow',
            placeholder: 'Write your blog post…',
            modules: {
                toolbar: [
                    [{ header: [2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ color: [] }, { background: [] }],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    [{ align: [] }],
                    ['blockquote', 'code-block', 'link', 'image'],
                    ['clean'],
                ]
            }
        });
        // Prefill existing HTML when editing.
        if (ta.value) {
            quill.root.innerHTML = ta.value;
        }
        // Publish the editor HTML into the hidden textarea before submitting.
        const form = document.getElementById('blog-form');
        if (form) {
            form.addEventListener('submit', function () { ta.value = quill.root.innerHTML; });
        }
        // Replace Quill's base64 "image" embed with a real image upload.
        const toolbar = quill.getModule('toolbar');
        toolbar.addHandler('image', function () {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function () {
                const file = input.files && input.files[0];
                if (!file) return;
                const fd = new FormData();
                fd.append('image', file);
                fetch('{{ route('admin.blogs.editor-image') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: fd
                })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.success && data.url) {
                        const range = quill.getSelection(true);
                        quill.insertEmbed(range.index, 'image', data.url, 'user');
                        quill.setSelection(range.index + 1);
                    } else {
                        alert(data.message || 'Image upload failed.');
                    }
                })
                .catch(function () { alert('Image upload failed.'); });
            };
            input.click();
        });
    });
</script>
@endpush
