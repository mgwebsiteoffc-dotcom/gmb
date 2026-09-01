@extends('layouts.app')

@section('title', 'Google Posts Scheduler & Multi-Location Publisher - Untab')

@section('content')
<div class="space-y-6" x-data="postsManager()">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Google Posts at Scale
                </span>
                <span class="text-xs text-slate-400 font-medium">Updates • Offers • Events</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 font-display">
                Google Posts Scheduler & Multi-Location Publisher
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Broadcast promotional updates and seasonal events across 10 to 500+ locations in a single click.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button
                @click="openCreateModal()"
                class="bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-bold px-4 py-2.5 rounded-xl transition-all shadow-md flex items-center gap-2"
            >
                <i data-lucide="plus" class="w-4 h-4"></i> Create & Schedule Post
            </button>
        </div>
    </div>

    <!-- Tabs Bar -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
        <a href="{{ route('app.posts', ['tab' => 'all']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $tab == 'all' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            All Posts ({{ $posts->count() }})
        </a>
        <a href="{{ route('app.posts', ['tab' => 'published']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $tab == 'published' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Published
        </a>
        <a href="{{ route('app.posts', ['tab' => 'scheduled']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $tab == 'scheduled' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Scheduled
        </a>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-all">
                <div class="relative h-44 bg-slate-100 overflow-hidden">
                    <img
                        src="{{ $post->media_url }}"
                        alt="{{ $post->title }}"
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute top-3 left-3 flex items-center gap-1.5">
                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-md shadow-sm {{ $post->type == 'OFFER' ? 'bg-amber-500 text-white' : ($post->type == 'EVENT' ? 'bg-purple-600 text-white' : 'bg-brand-600 text-white') }}">
                            {{ str_replace('_', ' ', $post->type) }}
                        </span>
                        <span class="text-[10px] font-semibold bg-slate-900/80 text-white px-2 py-0.5 rounded-md">
                            {{ $post->status }}
                        </span>
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="text-[11px] text-slate-400 font-semibold flex items-center gap-1">
                            <i data-lucide="map-pin" class="w-3 h-3 text-brand-500"></i>
                            <span>{{ $post->target_location_names }}</span>
                        </div>

                        <h3 class="font-bold text-slate-900 text-sm line-clamp-1">{{ $post->title }}</h3>
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                            {{ $post->content }}
                        </p>

                        @if($post->coupon_code)
                            <div class="p-2 bg-amber-50 rounded-lg border border-amber-200 text-xs text-amber-800 font-mono font-bold flex items-center justify-between">
                                <span>CODE: {{ $post->coupon_code }}</span>
                                <span class="text-[10px] font-normal font-sans">Coupon</span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3 text-xs text-slate-500 font-semibold">
                            <span class="flex items-center gap-1">
                                <i data-lucide="eye" class="w-3.5 h-3.5 text-brand-600"></i> {{ $post->views }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="mouse-pointer" class="w-3.5 h-3.5 text-indigo-600"></i> {{ $post->clicks }}
                            </span>
                        </div>

                        <form action="{{ route('app.posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg transition-colors" title="Delete post">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Create / Schedule Post Modal -->
    <div
        x-show="isCreateModalOpen"
        x-transition
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto"
        style="display: none;"
    >
        <div class="bg-white rounded-2xl max-w-4xl w-full shadow-2xl border border-slate-200 overflow-hidden my-8 animate-in fade-in zoom-in" @click.away="isCreateModalOpen = false">
            <div class="bg-gradient-to-r from-brand-700 to-indigo-800 p-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="plus" class="w-5 h-5 text-accent-500"></i>
                    <div>
                        <h3 class="font-bold text-base font-display">Create Google Business Post</h3>
                        <p class="text-[11px] text-brand-200">Publish or schedule across multi-location Google Business Profiles</p>
                    </div>
                </div>
                <button @click="isCreateModalOpen = false" class="text-white text-xl font-bold leading-none">✕</button>
            </div>

            <form action="{{ route('app.posts.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-6 p-6 max-h-[75vh] overflow-y-auto">
                @csrf
                <!-- Left 7 Cols: Form inputs -->
                <div class="md:col-span-7 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Post Type:</label>
                        <div class="grid grid-cols-3 gap-2">
                            <button type="button" @click="postType = 'WHATS_NEW'" :class="postType === 'WHATS_NEW' ? 'bg-brand-50 border-brand-500 text-brand-800' : 'bg-white border-slate-200 text-slate-600'" class="py-2 px-3 rounded-xl text-xs font-bold border">
                                📢 What's New
                            </button>
                            <button type="button" @click="postType = 'OFFER'" :class="postType === 'OFFER' ? 'bg-brand-50 border-brand-500 text-brand-800' : 'bg-white border-slate-200 text-slate-600'" class="py-2 px-3 rounded-xl text-xs font-bold border">
                                🏷️ Offer / Deal
                            </button>
                            <button type="button" @click="postType = 'EVENT'" :class="postType === 'EVENT' ? 'bg-brand-50 border-brand-500 text-brand-800' : 'bg-white border-slate-200 text-slate-600'" class="py-2 px-3 rounded-xl text-xs font-bold border">
                                📅 Event
                            </button>
                        </div>
                        <input type="hidden" name="type" :value="postType">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Post Title:</label>
                        <input
                            type="text"
                            name="title"
                            x-model="postTitle"
                            required
                            placeholder="e.g. Labor Day Weekend Special Offer"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm font-semibold focus:ring-2 focus:ring-brand-500"
                        />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Post Content:</label>
                            <button type="button" @click="generateAiPostCopy()" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1 bg-brand-50 px-2 py-0.5 rounded">
                                <i data-lucide="sparkles" class="w-3 h-3 text-accent-500"></i> AI Write Post
                                @if(\App\Services\OpenRouterService::configured())
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                @endif
                            </button>
                        </div>
                        <textarea
                            name="content"
                            rows="4"
                            x-model="postContent"
                            required
                            placeholder="Describe your promotion or update..."
                            class="w-full p-3 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-brand-500 leading-relaxed"
                        ></textarea>
                    </div>

                    <div x-show="postType === 'OFFER'" class="grid grid-cols-2 gap-3 p-3 bg-amber-50/60 rounded-xl border border-amber-200">
                        <div>
                            <label class="block text-[11px] font-bold text-amber-900 uppercase mb-1">Coupon Code</label>
                            <input type="text" name="coupon_code" x-model="couponCode" placeholder="e.g. SAVE20" class="w-full px-3 py-1.5 rounded-lg border border-amber-300 text-xs font-mono font-bold uppercase">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-amber-900 uppercase mb-1">Terms / Expiry</label>
                            <input type="text" name="terms" x-model="terms" placeholder="Valid until Sept 30" class="w-full px-3 py-1.5 rounded-lg border border-amber-300 text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">CTA Action Button</label>
                            <select name="cta_type" x-model="ctaType" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white">
                                <option value="BOOK">Book Appointment</option>
                                <option value="ORDER">Order Online</option>
                                <option value="BUY">Buy</option>
                                <option value="LEARN_MORE">Learn More</option>
                                <option value="SIGN_UP">Sign Up</option>
                                <option value="CALL_NOW">Call Now</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Button Destination URL</label>
                            <input type="url" name="cta_url" x-model="ctaUrl" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Image</label>
                        <div class="flex items-center gap-3">
                            <label class="cursor-pointer inline-flex items-center gap-2 bg-brand-50 text-brand-700 border border-brand-200 rounded-xl px-4 py-2 text-xs font-bold hover:bg-brand-100 transition-colors">
                                <i data-lucide="upload" class="w-4 h-4"></i>
                                Upload Image
                                <input type="file" name="media_image" accept="image/*" class="hidden" @change="handleMediaFile($event)">
                            </label>
                            <span x-show="mediaFileName" x-text="mediaFileName" class="text-xs text-slate-500 truncate max-w-[200px]"></span>
                            <button type="button" x-show="mediaFile" @click="clearMediaFile()" class="text-xs font-bold text-rose-500 hover:text-rose-600">Remove</button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Upload a JPEG, PNG or WebP up to 8MB. No image? A default is used.</p>
                        <input type="hidden" name="media_url" :value="mediaUrl">
                    </div>

                    <div class="pt-2 border-t border-slate-200">
                        <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5 cursor-pointer">
                            <input type="checkbox" name="is_scheduled" value="1" x-model="isScheduled" class="w-4 h-4 rounded text-brand-600">
                            <span>Schedule for future date & time</span>
                        </label>
                        <div x-show="isScheduled" class="mt-2">
                            <input type="text" name="scheduled_at" value="{{ now()->addDays(2)->format('Y-m-d 10:00') }}" class="text-xs font-mono border border-slate-200 rounded-lg px-3 py-1.5 w-full">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-between items-center">
                        <button type="button" @click="isCreateModalOpen = false" class="text-xs font-bold text-slate-500">Cancel</button>
                        <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm px-6 py-2.5 rounded-xl shadow-md">
                            <span x-text="isScheduled ? 'Schedule Across Locations' : 'Publish to Google Now'"></span>
                        </button>
                    </div>
                </div>

                <!-- Right 5 Cols: Live Preview Card -->
                <div class="md:col-span-5 bg-slate-50 p-4 rounded-2xl border border-slate-200 flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-3 text-center">Live Google Maps Preview</span>
                        <div class="bg-white rounded-xl border border-slate-200 shadow-md overflow-hidden max-w-xs mx-auto">
                            <img :src="mediaPreview || mediaUrl" alt="Preview" class="w-full h-36 object-cover">
                            <div class="p-4 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-bold uppercase bg-brand-50 text-brand-700 px-2 py-0.5 rounded" x-text="postType.replace('_', ' ')"></span>
                                    <span class="text-[10px] text-slate-400">Google Business</span>
                                </div>
                                <h4 class="font-bold text-slate-900 text-xs" x-text="postTitle || 'Post Headline'"></h4>
                                <p class="text-[11px] text-slate-600 leading-normal" x-text="postContent || 'Post content will appear here...'"></p>
                                <button type="button" class="w-full bg-blue-600 text-white font-bold text-[11px] py-1.5 rounded-lg" x-text="ctaType.replace('_', ' ')"></button>
                            </div>
                        </div>
                    </div>
                    <div class="text-[11px] text-slate-400 text-center mt-3">Updates live as you type.</div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function postsManager() {
        return {
            isCreateModalOpen: false,
            postType: 'WHATS_NEW',
            postTitle: '',
            postContent: '',
            couponCode: '',
            terms: '',
            ctaType: 'BOOK',
            ctaUrl: 'https://untab.com/book',
            mediaUrl: 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80',
            mediaFile: null,
            mediaPreview: '',
            mediaFileName: '',
            isScheduled: false,
            openCreateModal() {
                this.isCreateModalOpen = true;
                if (!this.postContent) {
                    this.generateAiPostCopy();
                }
            },
            handleMediaFile(event) {
                const file = event.target.files[0];
                if (!file) return;
                this.mediaFile = file;
                this.mediaFileName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => { this.mediaPreview = e.target.result; };
                reader.readAsDataURL(file);
            },
            clearMediaFile() {
                this.mediaFile = null;
                this.mediaFileName = '';
                this.mediaPreview = '';
                const input = document.querySelector('input[name="media_image"]');
                if (input) input.value = '';
            },
            generateAiPostCopy() {
                fetch('{{ route('app.posts.ai-caption') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        type: this.postType,
                        business_name: 'Our Business'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.postTitle = data.data.title;
                        this.postContent = data.data.content;
                        if (data.data.coupon_code) this.couponCode = data.data.coupon_code;
                        if (data.data.terms) this.terms = data.data.terms;
                        if (data.data.cta_type) this.ctaType = data.data.cta_type;
                    }
                });
            }
        }
    }
</script>
@endsection
