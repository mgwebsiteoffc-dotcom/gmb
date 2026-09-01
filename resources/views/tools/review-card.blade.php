@extends('layouts.marketing')

@section('title', 'Google Review NFC Smart Card Configurator | Untab')
@section('meta_description', 'Design a Google review NFC smart card. Tap the card to open your live Google review form — a premium, app-free way to turn happy customers into 5-star reviews.')
@section('meta_keywords', 'NFC review card, tap to review, Google review NFC, smart review card')

@php($faqs = [
    ['q' => 'What is a Google review NFC card?', 'a' => 'An NFC smart card embedded with a tag that, when tapped by a customer\'s phone, opens your Google review form instantly.'],
    ['q' => 'How do I configure the NFC tap card?', 'a' => 'Set your business name, card color, and review link. Untab generates the NFC tag data and a printable card design.'],
    ['q' => 'Why use NFC instead of a QR code?', 'a' => 'NFC requires no app and works with a single tap. It feels premium and removes scanning friction.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'NFC Review Card', 'url' => route('tools.review-card')],
    ]),
])

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6" x-data="nfcCard()">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
            <i data-lucide="credit-card" class="w-3.5 h-3.5"></i> Tap-to-Review NFC Cards
        </div>
        <h1 class="text-3xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">
            Google Review <span class="text-brand-600">NFC Smart Card Configurator</span>
        </h1>
        <p class="text-slate-600 max-w-xl mx-auto mt-2 text-xs sm:text-sm">
            Customers tap their phone to your physical card and instantly open your Google review screen in 1.2 seconds.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
        <!-- Card Controls -->
        <div class="md:col-span-6 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Business Name</label>
                <input
                    type="text"
                    x-model="businessName"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-bold"
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Card Theme Material</label>
                <div class="grid grid-cols-2 gap-2">
                    <button 
                        @click="cardColor = '#0f172a'; textColor = '#ffffff'"
                        class="p-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 flex items-center gap-2 hover:border-brand-500"
                    >
                        <span class="w-4 h-4 rounded-full bg-slate-900 border"></span> Matte Obsidian
                    </button>
                    <button 
                        @click="cardColor = '#1e1b4b'; textColor = '#ffffff'"
                        class="p-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 flex items-center gap-2 hover:border-brand-500"
                    >
                        <span class="w-4 h-4 rounded-full bg-blue-700 border"></span> Royal Navy
                    </button>
                </div>
            </div>

            <div class="space-y-2 pt-2 text-xs text-slate-600">
                <div class="flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> NTAG216 High-Frequency NFC Chip built-in
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Waterproof PVC with scratch-resistant matte finish
                </div>
            </div>

            <a
                href="{{ route('app.dashboard') }}"
                class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs py-3 rounded-xl transition-all shadow-md flex items-center justify-center gap-2"
            >
                <i data-lucide="sparkles" class="w-4 h-4"></i> Link to Untab Location Feed
            </a>
        </div>

        <!-- 3D Card Preview -->
        <div class="md:col-span-6 flex flex-col items-center">
            <div
                class="w-80 h-48 rounded-2xl p-6 shadow-2xl relative overflow-hidden transition-all duration-300 hover:scale-105 flex flex-col justify-between border border-white/20"
                :style="'background: ' + cardColor + '; color: ' + textColor"
            >
                <div class="flex items-center justify-between">
                    <span class="font-extrabold text-sm tracking-tight" x-text="businessName">Apex Dental Care</span>
                    <i data-lucide="wifi" class="w-5 h-5 rotate-90 text-accent-500"></i>
                </div>

                <div class="flex flex-col items-center justify-center text-center py-1">
                    <div class="flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full bg-white/10 backdrop-blur-md mb-1 border border-white/10">
                        <span class="text-blue-400">G</span><span class="text-red-400">o</span><span class="text-yellow-400">o</span><span class="text-blue-400">g</span><span class="text-green-400">l</span><span class="text-red-400">e</span>
                        <span class="text-[9px] ml-1">Reviews</span>
                    </div>
                    <div class="text-[10px] opacity-80">Tap phone here to leave a review</div>
                </div>

                <div class="flex items-center justify-between text-[9px] opacity-75 font-mono">
                    <span>NFC TAP ENABLED</span>
                    <span class="font-bold tracking-widest text-accent-500">UNTAB</span>
                </div>
            </div>
            <span class="text-xs text-slate-400 mt-4 font-medium">Physical Card Mockup • Instant Smartphone Tap Detection</span>
        </div>
    </div>
</div>

<script>
    function nfcCard() {
        return {
            businessName: 'Apex Dental Care',
            cardColor: '#0f172a',
            textColor: '#ffffff'
        }
    }
</script>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'NFC Review Card FAQ', 'faqIntro' => 'How tap-to-review NFC cards get you more Google reviews.'])
@endsection
