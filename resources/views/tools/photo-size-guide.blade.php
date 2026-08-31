@extends('layouts.marketing')

@section('title', 'Google Business Profile Photo Size Guide 2026 | Ampli5 Pulse')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
            <i data-lucide="image" class="w-3.5 h-3.5"></i> 2026 Official Dimensions & Guidelines
        </div>
        <h1 class="text-3xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">
            Google Business Profile <span class="text-brand-600">Photo Size Guide</span>
        </h1>
        <p class="text-slate-600 max-w-xl mx-auto mt-2 text-xs sm:text-sm">
            Official resolution, aspect ratios, file size limits, and local SEO geotagging guidelines.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">Cover Photo</h3>
                <span class="text-xs font-mono font-bold bg-brand-50 text-brand-700 px-2 py-0.5 rounded">1024 x 576 px (16:9)</span>
            </div>
            <div class="text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-100 space-y-1">
                <div><strong>Min Size:</strong> 480 x 270 px</div>
                <div><strong>Max File Size:</strong> 5 MB</div>
                <div><strong>Format:</strong> JPG or PNG</div>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed">
                The most important photo on your profile. Shows front-and-center on Google Maps and Search results.
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">Profile Logo</h3>
                <span class="text-xs font-mono font-bold bg-brand-50 text-brand-700 px-2 py-0.5 rounded">720 x 720 px (1:1)</span>
            </div>
            <div class="text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-100 space-y-1">
                <div><strong>Min Size:</strong> 250 x 250 px</div>
                <div><strong>Max File Size:</strong> 5 MB</div>
                <div><strong>Format:</strong> PNG or JPG</div>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed">
                Appears when you reply to customer reviews and publish Google Posts across search and maps.
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">Google Post Images</h3>
                <span class="text-xs font-mono font-bold bg-brand-50 text-brand-700 px-2 py-0.5 rounded">1200 x 900 px (4:3)</span>
            </div>
            <div class="text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-100 space-y-1">
                <div><strong>Min Size:</strong> 400 x 300 px</div>
                <div><strong>Max File Size:</strong> 10 MB</div>
                <div><strong>Format:</strong> JPG or PNG</div>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed">
                Keep crucial text and faces centered. Google crops slightly on mobile feeds.
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">Interior & Exterior Photos</h3>
                <span class="text-xs font-mono font-bold bg-brand-50 text-brand-700 px-2 py-0.5 rounded">1280 x 720 px</span>
            </div>
            <div class="text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-100 space-y-1">
                <div><strong>Min Size:</strong> 720 x 720 px</div>
                <div><strong>Max File Size:</strong> 10 MB</div>
                <div><strong>Format:</strong> High-res JPG</div>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed">
                Bright natural lighting. Geotagging EXIF metadata helps local relevancy on Google Maps.
            </p>
        </div>
    </div>
</div>
@endsection
