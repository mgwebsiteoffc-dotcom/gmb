@php
    $isEdit = isset($faq) && $faq->exists;
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" class="space-y-6">
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
                <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2"><i data-lucide="help-circle" class="w-4 h-4 text-brand-600"></i> Question</h3>
                <input type="text" name="question" value="{{ old('question', $faq->question ?? '') }}" required placeholder="e.g. How many profiles can I manage?"
                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2 pt-2"><i data-lucide="message-square-text" class="w-4 h-4 text-brand-600"></i> Answer</h3>
                <textarea name="answer" rows="6" required class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('answer', $faq->answer ?? '') }}</textarea>
                <p class="text-xs text-slate-400">These power the public FAQ page and the FAQPage JSON-LD schema for rich results.</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-700">Visibility</h3>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Category</label>
                    <input type="text" name="category" value="{{ old('category', $faq->category ?? 'General') }}" list="faq-cats" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <datalist id="faq-cats">
                        @foreach(['General','Features','Reports','Pricing','Tools','Integrations','Security'] as $c) <option value="{{ $c }}"> @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $faq->is_active ?? true)) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    Visible on the public FAQ page
                </label>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-md">{{ $isEdit ? 'Update FAQ' : 'Add FAQ' }}</button>
                    <a href="{{ route('admin.faqs.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-slate-600 hover:bg-slate-50">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
