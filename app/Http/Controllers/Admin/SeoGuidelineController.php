<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoGuideline;
use Illuminate\Http\Request;

class SeoGuidelineController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('page_type');
        $search = trim($request->get('q', ''));

        $guidelines = SeoGuideline::query()
            ->when($type, fn ($q) => $q->where('page_type', $type))
            ->when($search, fn ($q) => $q
                ->where(fn ($qq) => $qq
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")))
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        $types = SeoGuideline::distinct()->orderBy('page_type')->pluck('page_type')->all();

        return view('admin.seo.index', compact('guidelines', 'types', 'type', 'search'));
    }

    public function create()
    {
        return view('admin.seo.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['recommended_keywords'] = $request->filled('recommended_keywords')
            ? collect(explode(',', $request->recommended_keywords))->map('trim')->filter()->values()->all()
            : [];

        SeoGuideline::create($data);

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO guideline created.');
    }

    public function edit(SeoGuideline $guideline)
    {
        return view('admin.seo.edit', compact('guideline'));
    }

    public function update(Request $request, SeoGuideline $guideline)
    {
        $data = $this->validateData($request);
        $data['recommended_keywords'] = $request->filled('recommended_keywords')
            ? collect(explode(',', $request->recommended_keywords))->map('trim')->filter()->values()->all()
            : [];

        $guideline->update($data);

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO guideline updated.');
    }

    public function destroy(SeoGuideline $guideline)
    {
        $guideline->delete();

        return back()->with('success', 'SEO guideline deleted.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'page_path' => ['nullable', 'string', 'max:255'],
            'page_type' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'recommended_keywords' => ['nullable', 'string'],
            'seo_title_template' => ['nullable', 'string', 'max:255'],
            'meta_description_template' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }
}
