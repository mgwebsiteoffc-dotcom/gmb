@extends('layouts.marketing')

@section('title', 'Google Business Profile Description Writer (750 chars) | Untab')
@section('meta_description', 'Write a polished 750-character Google Business Profile description. Add your business details and local keywords, then refine with the AI writer or an instant template.')
@section('meta_keywords', 'GBP description writer, business profile description, Google Business Profile 750 characters, local description generator')

@php($faqs = [
    ['q' => 'How long should a Google Business Profile description be?', 'a' => 'Google allows up to 750 characters in the business description. Aim for a concise, keyword-natural summary that includes your primary service and location.'],
    ['q' => 'What should I include in my GBP description?', 'a' => 'Lead with your primary service and city, mention 2-3 differentiators, include a call-to-action, and weave in relevant local keywords naturally.'],
    ['q' => 'Does the description affect local SEO?', 'a' => 'Yes. A well-written description helps Google understand what you do and where, improving relevance for local searches. Avoid keyword stuffing.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Description Writer', 'url' => route('tools.description-writer')],
    ]),
])

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6" x-data="descWriter()">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> 750-Character Builder
        </div>
        <h1 class="text-3xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">
            GBP <span class="text-brand-600">Description Writer</span>
        </h1>
        <p class="text-slate-600 max-w-xl mx-auto mt-2 text-xs sm:text-sm">
            Generate a polished Google Business Profile description that fits the 750-character limit.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div><label class="text-xs font-bold text-slate-700 uppercase block">Business Name</label><input x-model="biz" placeholder="e.g. Apex Dental Care" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></div>
            <div><label class="text-xs font-bold text-slate-700 uppercase block">Primary Service</label><input x-model="service" placeholder="e.g. emergency & cosmetic dentistry" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></div>
            <div><label class="text-xs font-bold text-slate-700 uppercase block">City / Location</label><input x-model="city" placeholder="e.g. Austin, TX" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></div>
            <div><label class="text-xs font-bold text-slate-700 uppercase block">Unique Selling Point</label><input x-model="usps" placeholder="e.g. same-day appointments, family friendly, 4.9★ rated" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></div>
            <div class="flex gap-2 pt-1">
                <button @click="generate()" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs py-2.5 rounded-xl shadow-md">✨ Generate</button>
                <button @click="aiEnhance()" id="aiEnhanceBtn" class="px-4 bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold text-xs py-2.5 rounded-xl border border-brand-200">🧠 AI Enhance</button>
            </div>
            <button @click="copyOut()" class="w-full border border-slate-200 text-slate-700 font-bold text-xs py-2.5 rounded-xl hover:bg-slate-50 flex items-center justify-center gap-2">
                <i data-lucide="copy" class="w-4 h-4"></i> Copy Description
            </button>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <label class="text-xs font-bold text-slate-700 uppercase">Your Description</label>
                <span class="text-xs font-black font-mono" :class="out.length > 750 ? 'text-red-600' : 'text-emerald-600'" x-text="out.length + ' / 750'"></span>
            </div>
            <textarea x-model="out" rows="16" class="w-full px-3.5 py-3 rounded-xl border border-slate-200 text-xs font-medium focus:ring-2 focus:ring-brand-500"></textarea>
            <div class="mt-2">
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 via-amber-500 to-rose-500 transition-all" :style="'width:' + Math.min(100, (out.length / 750) * 100) + '%'"></div>
                </div>
                <div class="text-[10px] text-slate-400 font-bold mt-1" x-text="out.length > 750 ? 'Over the 750-character limit — trim it.' : (out.length > 650 ? 'Nearly full — great length.' : '')"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function descWriter() {
        return {
            biz: 'Apex Dental Care',
            service: 'emergency & cosmetic dentistry',
            city: 'Austin, TX',
            usps: 'same-day appointments, family friendly, 4.9-star rated',
            out: '',
            get isAi() { return document.getElementById('aiEnhanceBtn') && document.getElementById('aiEnhanceBtn').dataset.ai === '1'; },
            generate() {
                const b = this.biz || 'Our business', s = this.service || 'professional services', c = this.city || 'your area', u = this.usps || 'exceptional service';
                this.out = `Welcome to ${b}! We provide trusted ${s} in ${c}. ${u.split(',').map(x => x.trim()).filter(Boolean).join(', ')}. Our friendly team is here to make every visit easy and stress-free. ${c.charAt(0)} locals trust ${b} for reliable, high-quality care. Call today or book online to get started!`;
            },
            async aiEnhance() {
                const btn = document.getElementById('aiEnhanceBtn'); if (!btn) return;
                btn.disabled = true; btn.textContent = 'Thinking…';
                try {
                    const res = await fetch('{{ route('tools.description-writer.ai') }}', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: JSON.stringify({ biz: this.biz, service: this.service, city: this.city, usps: this.usps })
                    });
                    if (res.ok) { const d = await res.json(); if (d && d.description) { this.out = d.description; return; } }
                } catch (e) {}
                // fallback to enhanced template when AI unavailable
                const b = this.biz || 'Our business', s = this.service || 'professional services', c = this.city || 'your area', u = this.usps || 'exceptional service';
                this.out = `${b} is your trusted choice for ${s} in ${c}. ${u.split(',').map(x => x.trim()).filter(Boolean).join(', ')}. We're committed to ${c} — visit ${b} today for an experience you'll recommend. Call now or book online!`;
                btn.textContent = '🧠 AI Enhance';
            },
            copyOut() {
                if (navigator.clipboard && navigator.clipboard.writeText) navigator.clipboard.writeText(this.out);
                toast && toast('Description copied!');
            }
        }
    }
</script>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'GBP Description Writer FAQ', 'faqIntro' => 'How to write a great Google Business Profile description.'])
@endsection
