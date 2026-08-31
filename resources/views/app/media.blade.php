@extends('layouts.app')

@section('title', 'Media Asset Manager & EXIF Geotagging - Untab')

@section('content')
<div class="space-y-6" x-data="{ isUploadOpen: false }">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Media Asset Manager
                </span>
                <span class="text-xs text-slate-400 font-medium">Automatic EXIF & Geotag Optimization</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 font-display">
                Google Profile Photos & Video Library
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Keep all locations visually fresh and on-brand from a single centralized media command screen.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button
                @click="isUploadOpen = true"
                class="bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-bold px-4 py-2.5 rounded-xl transition-all shadow-md flex items-center gap-2"
            >
                <i data-lucide="upload" class="w-4 h-4"></i> Upload & Geotag Photo
            </button>
        </div>
    </div>

    <!-- Category Filters -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-2">
        @foreach(['all', 'Interior', 'Exterior', 'Team & Staff', 'Food / Product', 'Cover'] as $cat)
            <a
                href="{{ route('app.media', ['category' => $cat, 'location_id' => $selectedLocationId]) }}"
                class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $category == $cat ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                {{ $cat == 'all' ? 'All Media Photos' : $cat }}
            </a>
        @endforeach
    </div>

    <!-- Media Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($media as $item)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-all group">
                <div class="relative h-48 bg-slate-100 overflow-hidden">
                    <img
                        src="{{ $item->url }}"
                        alt="{{ $item->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    />
                    <div class="absolute top-2.5 left-2.5 flex items-center gap-1.5">
                        <span class="text-[10px] font-bold uppercase bg-slate-900/80 text-white px-2 py-0.5 rounded backdrop-blur-sm">
                            {{ $item->category }}
                        </span>
                    </div>
                </div>

                <div class="p-4 space-y-2 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs line-clamp-1">{{ $item->title }}</h4>
                        <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-1 truncate">
                            <i data-lucide="map-pin" class="w-3 h-3 text-brand-600 flex-shrink-0"></i>
                            <span class="truncate">{{ $item->location->name ?? 'Location' }}</span>
                        </div>
                        @if($item->geotag && $item->geotag !== 'None')
                            <div class="text-[10px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-mono font-bold mt-1 inline-block">
                                📍 Geotag: {{ $item->geotag }}
                            </div>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span class="flex items-center gap-1 font-semibold text-slate-600">
                            <i data-lucide="eye" class="w-3.5 h-3.5 text-brand-600"></i> {{ number_format($item->views) }} views
                        </span>
                        <form action="{{ route('app.media.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-slate-300 hover:text-rose-600 transition-colors" title="Remove photo">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Upload Photo Modal -->
    <div
        x-show="isUploadOpen"
        x-transition
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-200 overflow-hidden" @click.away="isUploadOpen = false">
            <div class="bg-gradient-to-r from-brand-700 to-indigo-800 p-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="upload" class="w-5 h-5 text-accent-500"></i>
                    <div>
                        <h3 class="font-bold text-base font-display">Upload to Google Business Profile</h3>
                        <p class="text-[11px] text-brand-200">Broadcast and geotag across client locations</p>
                    </div>
                </div>
                <button @click="isUploadOpen = false" class="text-white text-xl font-bold leading-none">✕</button>
            </div>

            <form action="{{ route('app.media.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Target Location</label>
                    <select name="location_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 bg-white">
                        @foreach($allLocations as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Photo Title / Caption</label>
                    <input type="text" name="title" required placeholder="e.g. Modern Dental Reception Suite" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Upload Photo</label>
                    <input type="file" name="photo" accept="image/*" class="w-full text-xs font-medium text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    <p class="text-[10px] text-slate-400 mt-1">JPG, PNG, or WebP up to 8MB. Leave image URL blank to use your upload.</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Category</label>
                        <select name="category" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold bg-white">
                            <option value="Interior">Interior</option>
                            <option value="Exterior">Exterior</option>
                            <option value="Team & Staff">Team & Staff</option>
                            <option value="Food / Product">Food / Product</option>
                            <option value="Cover">Cover Photo</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Image URL (optional)</label>
                        <input type="text" name="url" value="" placeholder="or paste an https:// image URL" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">SEO Alt Text</label>
                    <input type="text" name="alt_text" placeholder="Describe with local keywords for visual search..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                </div>

                <div class="p-3 bg-brand-50 rounded-xl border border-brand-200 flex items-center justify-between">
                    <label class="text-xs font-bold text-brand-900 flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="geotag_enabled" checked class="w-4 h-4 rounded text-brand-600">
                        <span>Automatically inject GPS Lat/Long Geotag metadata</span>
                    </label>
                    <i data-lucide="sparkles" class="w-4 h-4 text-brand-600"></i>
                </div>

                <div class="pt-3 flex justify-between items-center border-t border-slate-100">
                    <button type="button" @click="isUploadOpen = false" class="text-xs font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md">
                        Publish Photo to Google
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
