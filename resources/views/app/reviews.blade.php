@extends('layouts.app')

@section('title', 'Google Reviews & AI Reply Assistant - Untab')

@section('content')
<div class="space-y-6" x-data="reviewsManager()">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Unified Review Inbox
                </span>
                <span class="text-xs text-slate-400 font-medium">Powered by Untab AI Assistant
                    @php($aiOn = \App\Services\OpenRouterService::configured())
                    @if($aiOn)
                        <span class="ml-1 inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Live AI</span>
                    @else
                        <span class="ml-1 inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Demo AI</span>
                    @endif
                </span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 font-display">
                Google Reviews & AI Reply Assistant
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Monitor, filter, and reply to all client reviews in seconds across web, iOS, and Android.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <form action="{{ route('app.reviews.bulk-ai') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-bold px-4 py-2.5 rounded-xl transition-all shadow-md flex items-center gap-2"
                >
                    <i data-lucide="sparkles" class="w-4 h-4 text-accent-500"></i> Bulk AI Reply All Unanswered ({{ $unansweredCount }})
                </button>
            </form>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form method="GET" class="flex flex-wrap items-center justify-between gap-3 text-xs">
            <input type="hidden" name="location_id" value="{{ $selectedLocationId }}">

            <!-- Search -->
            <div class="relative flex-1 min-w-[200px]">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search by customer name, keyword or review content..."
                    class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-500 focus:outline-none"
                />
            </div>

            <!-- Filter Controls -->
            <div class="flex flex-wrap items-center gap-2">
                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 font-semibold text-slate-700"
                >
                    <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="unanswered" {{ $statusFilter == 'unanswered' ? 'selected' : '' }}>🔴 Needs Reply</option>
                    <option value="replied" {{ $statusFilter == 'replied' ? 'selected' : '' }}>🟢 Replied</option>
                </select>

                <select
                    name="rating"
                    onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 font-semibold text-slate-700"
                >
                    <option value="all" {{ $ratingFilter == 'all' ? 'selected' : '' }}>All Ratings</option>
                    <option value="5" {{ $ratingFilter == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars)</option>
                    <option value="4" {{ $ratingFilter == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars)</option>
                    <option value="3" {{ $ratingFilter == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 Stars)</option>
                    <option value="2" {{ $ratingFilter == '2' ? 'selected' : '' }}>⭐⭐ (2 Stars)</option>
                    <option value="1" {{ $ratingFilter == '1' ? 'selected' : '' }}>⭐ (1 Star)</option>
                </select>

                <select
                    name="sentiment"
                    onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 font-semibold text-slate-700"
                >
                    <option value="all" {{ $sentimentFilter == 'all' ? 'selected' : '' }}>All Sentiments</option>
                    <option value="positive" {{ $sentimentFilter == 'positive' ? 'selected' : '' }}>😊 Positive</option>
                    <option value="neutral" {{ $sentimentFilter == 'neutral' ? 'selected' : '' }}>😐 Neutral</option>
                    <option value="negative" {{ $sentimentFilter == 'negative' ? 'selected' : '' }}>😟 Negative</option>
                </select>

                <button type="submit" class="bg-slate-800 text-white px-3 py-2 rounded-xl font-bold">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Reviews Feed List -->
    <div class="space-y-4">
        @forelse($reviews as $rev)
            <div class="bg-white rounded-2xl border transition-all p-5 sm:p-6 shadow-sm {{ $rev->status == 'unanswered' ? 'border-amber-300 ring-1 ring-amber-100' : 'border-slate-200/80' }}">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="flex gap-3.5 flex-1">
                        <img
                            src="{{ $rev->author_photo }}"
                            alt="{{ $rev->author_name }}"
                            class="w-11 h-11 rounded-full object-cover border border-slate-200 flex-shrink-0"
                        />
                        <div class="space-y-1.5 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-bold text-slate-900 text-sm">{{ $rev->author_name }}</span>
                                <span class="text-amber-400 font-bold text-xs">
                                    @for($i = 0; $i < $rev->rating; $i++) ★ @endfor
                                </span>
                                <span class="text-xs text-slate-400 font-medium">{{ $rev->date_text }}</span>
                                <span class="text-[11px] font-semibold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md">
                                    {{ $rev->location->name ?? 'Location' }}
                                </span>
                            </div>

                            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                                "{{ $rev->snippet }}"
                            </p>

                            @if(!empty($rev->keywords))
                                <div class="flex flex-wrap items-center gap-1.5 pt-1">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Keywords:</span>
                                    @foreach($rev->keywords as $kw)
                                        <span class="text-[10px] bg-brand-50 text-brand-700 font-medium px-2 py-0.5 rounded">
                                            #{{ $kw }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            @if($rev->status == 'replied')
                                <div class="mt-3 p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-bold text-slate-800 flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            Response from Owner ({{ explode('-', $rev->location->name ?? '')[0] }})
                                        </span>
                                        <span class="text-[10px] text-slate-400">Live on Google</span>
                                    </div>
                                    <p class="text-slate-600 text-[11px] leading-relaxed">
                                        {{ $rev->reply }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Action Button -->
                    <div class="flex-shrink-0">
                        <button
                            @click="openAiModal({{ $rev->id }}, '{{ addslashes($rev->author_name) }}', {{ $rev->rating }}, '{{ addslashes($rev->snippet) }}', '{{ addslashes($rev->reply ?? '') }}')"
                            class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-md flex items-center gap-1.5"
                        >
                            <i data-lucide="sparkles" class="w-3.5 h-3.5 text-accent-500"></i>
                            <span>{{ $rev->status == 'unanswered' ? 'Draft AI Reply' : 'Edit Reply' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-12 text-center rounded-2xl border border-slate-200 shadow-sm">
                <i data-lucide="message-square" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
                <h3 class="font-bold text-slate-700 text-base">No reviews match your filter</h3>
                <p class="text-xs text-slate-400 mt-1">Try resetting your rating or search query</p>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    </div>

    <!-- AI Reply Modal -->
    <div 
        x-show="isModalOpen" 
        x-transition 
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <div class="bg-white rounded-2xl max-w-xl w-full shadow-2xl border border-slate-200 overflow-hidden" @click.away="isModalOpen = false">
            <div class="bg-gradient-to-r from-brand-700 to-indigo-800 p-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-5 h-5 text-accent-500"></i>
                    <div>
                        <h3 class="font-bold text-base font-display">AI Review Reply Assistant</h3>
                        <p class="text-[11px] text-brand-200" x-text="'Replying to ' + currentAuthor + ' (' + currentRating + ' Stars)'"></p>
                        <p class="text-[10px] text-brand-200 mt-0.5">
                            @if(\App\Services\OpenRouterService::configured())
                                <span class="inline-flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Live AI (OpenRouter)</span>
                            @else
                                <span class="inline-flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Demo AI (template)</span>
                            @endif
                        </p>
                    </div>
                </div>
                <button @click="isModalOpen = false" class="text-white text-xl font-bold leading-none">✕</button>
            </div>

            <form :action="'/app/reviews/' + currentReviewId + '/reply'" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-xs text-slate-700 italic" x-text="'\"' + currentSnippet + '\"'"></div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Select AI Tone Strategy:</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                        <button type="button" @click="fetchAiReply('friendly')" class="p-2 rounded-xl border border-slate-200 text-xs font-bold hover:bg-brand-50">😊 Friendly</button>
                        <button type="button" @click="fetchAiReply('professional')" class="p-2 rounded-xl border border-slate-200 text-xs font-bold hover:bg-brand-50">💼 Professional</button>
                        <button type="button" @click="fetchAiReply('seo')" class="p-2 rounded-xl border border-slate-200 text-xs font-bold hover:bg-brand-50">🎯 SEO Rich</button>
                        <button type="button" @click="fetchAiReply('empathetic')" class="p-2 rounded-xl border border-slate-200 text-xs font-bold hover:bg-brand-50">🤝 Empathetic</button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Generated Response (Editable):</label>
                    <textarea
                        name="reply"
                        rows="4"
                        x-model="draftReply"
                        required
                        class="w-full p-3 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-brand-500 leading-relaxed"
                    ></textarea>
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <button type="button" @click="isModalOpen = false" class="text-xs font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-xl shadow-md flex items-center gap-2">
                        <i data-lucide="send" class="w-4 h-4"></i> Publish Reply to Google
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function reviewsManager() {
        return {
            isModalOpen: false,
            currentReviewId: null,
            currentAuthor: '',
            currentRating: 5,
            currentSnippet: '',
            draftReply: '',
            openAiModal(id, author, rating, snippet, existingReply) {
                this.currentReviewId = id;
                this.currentAuthor = author;
                this.currentRating = rating;
                this.currentSnippet = snippet;
                this.draftReply = existingReply || '';
                this.isModalOpen = true;

                if (!this.draftReply) {
                    this.fetchAiReply(rating < 4 ? 'empathetic' : 'friendly');
                }
            },
            fetchAiReply(tone) {
                fetch('{{ route('app.reviews.ai-reply') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        review_id: this.currentReviewId,
                        tone: tone
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.draftReply = data.reply;
                    }
                });
            }
        }
    }
</script>
@endsection
