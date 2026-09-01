@extends('layouts.marketing')

@section('title', 'Google Post & Review Character Limit Counter | Untab')
@section('meta_description', 'Live character counter for Google Business Profile posts and review replies. Google Posts max out at 1,500 characters — check yours instantly before publishing.')
@section('meta_keywords', 'Google post character limit, GBP character counter, review reply length, Google Posts 1500 characters')

@php($faqs = [
    ['q' => 'What is the character limit for Google Posts?', 'a' => 'Google Business Profile posts allow up to 1,500 characters of descriptive text. Keeping them concise and CTA-driven improves engagement.'],
    ['q' => 'How long should a Google review reply be?', 'a' => 'Aim for 2-4 sentences and under 220 characters. Short, personal, and keyword-natural replies read best and convert better.'],
    ['q' => 'How do I use this character counter?', 'a' => 'Type or paste your draft into the box. The tool counts characters live and flags when you approach or exceed the Google Posts limit.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Character Counter', 'url' => route('tools.character-counter')],
    ]),
])

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6" x-data="charCounter()">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
            <i data-lucide="type" class="w-3.5 h-3.5"></i> Live Character Counter
        </div>
        <h1 class="text-3xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">
            Google Post & Review <span class="text-brand-600">Character Counter</span>
        </h1>
        <p class="text-slate-600 max-w-xl mx-auto mt-2 text-xs sm:text-sm">
            Check Google Posts (1,500 char limit) and review-reply length before you publish.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Your Draft</label>
            <textarea x-model="text" x-ref="ta" rows="10" @input="count()" placeholder="Type your Google Post or review reply here…" class="w-full px-3.5 py-3 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-brand-500"></textarea>
            <div class="mt-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <button @click="text=''; count();" class="text-xs font-bold text-slate-500 hover:text-slate-700 border border-slate-200 rounded-lg px-3 py-1.5 transition-colors">Clear</button>
                    <button @click="insertSample()" class="text-xs font-bold text-brand-600 hover:bg-brand-50 border border-brand-200 rounded-lg px-3 py-1.5 transition-colors">Load Sample</button>
                </div>
                <span class="text-sm font-black font-mono" :class="chars > 1500 ? 'text-red-600' : (chars > 1300 ? 'text-amber-600' : 'text-emerald-600')" x-text="chars + ' chars'"></span>
            </div>
            <div class="mt-2">
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-amber-500 transition-all" :style="'width:' + Math.min(100, (chars / 1500) * 100) + '%'"></div>
                </div>
                <div class="flex justify-between text-[10px] text-slate-400 font-bold mt-1"><span>0</span><span>1,500 Google Posts limit</span></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h2 class="font-bold text-slate-900 text-sm">Limits Cheat Sheet</h2>
            <div class="grid grid-cols-1 gap-3 text-xs">
                <div class="p-3 rounded-xl border border-slate-100 flex items-center justify-between">
                    <div><div class="font-bold text-slate-800">Google Posts (Update)</div><div class="text-[10px] text-slate-500">Descriptive text</div></div>
                    <span class="font-black text-brand-600">1,500</span>
                </div>
                <div class="p-3 rounded-xl border border-slate-100 flex items-center justify-between">
                    <div><div class="font-bold text-slate-800">Offer Post</div><div class="text-[10px] text-slate-500">Coupon + terms</div></div>
                    <span class="font-black text-brand-600">1,500</span>
                </div>
                <div class="p-3 rounded-xl border border-slate-100 flex items-center justify-between">
                    <div><div class="font-bold text-slate-800">Review Reply</div><div class="text-[10px] text-slate-500">Recommended max</div></div>
                    <span class="font-black text-amber-600">~220</span>
                </div>
                <div class="p-3 rounded-xl border border-slate-100 flex items-center justify-between">
                    <div><div class="font-bold text-slate-800">Product / Service Description</div><div class="text-[10px] text-slate-500">Recommended</div></div>
                    <span class="font-black text-brand-600">750</span>
                </div>
                <div class="p-3 rounded-xl border border-amber-50 bg-amber-50/40 flex items-start gap-2 text-amber-800">
                    <i data-lucide="info" class="w-4 h-4 flex-shrink-0"></i>
                    <div><strong>Tip:</strong> Google truncates long descriptions. Put your CTA and key keyword in the first 80 characters.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function charCounter() {
        return {
            text: '',
            chars: 0,
            count() {
                this.chars = (this.text || '').length;
            },
            insertSample() {
                this.text = '✨ Welcome to Apex Dental Care! Looking for a friendly, experienced dentist in downtown Austin? Book your cleaning today and enjoy 20% off your first visit. Call or book online — we accept most insurance plans!';
                this.count();
            }
        }
    }
</script>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Character Limit FAQ', 'faqIntro' => 'Google Posts and review reply length rules, explained.'])
@endsection
