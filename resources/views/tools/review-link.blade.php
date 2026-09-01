@extends('layouts.marketing')

@section('title', 'Google Review Link Generator - Direct Review URL | Untab')
@section('meta_description', 'Generate a direct Google review link in one click. Enter your business name and Place ID to get a URL that takes customers straight to your Google review form.')
@section('meta_keywords', 'Google review link, direct review URL, leave a review link, Place ID')

@php($faqs = [
    ['q' => 'How does the Google review link generator work?', 'a' => 'Enter your Business Name and Place ID, and Untab instantly builds a direct Google review URL customers can use to leave a review in seconds.'],
    ['q' => 'What is a Place ID?', 'a' => 'A Place ID is the unique identifier Google assigns to a business location. You can find it in the Google Maps / Business Profile dashboard.'],
    ['q' => 'Can I use this review link on my website or ads?', 'a' => 'Yes. Paste the generated URL behind any button, QR code, or ad. It routes customers straight to your review form.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Review Link Generator', 'url' => route('tools.review-link')],
    ]),
])

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6" x-data="reviewLinkGen()">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
            <i data-lucide="link" class="w-3.5 h-3.5"></i> Direct Review Link Generator
        </div>
        <h1 class="text-3xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">
            Generate Your <span class="text-brand-600">Google Review Link</span>
        </h1>
        <p class="text-slate-600 max-w-xl mx-auto mt-2 text-xs sm:text-sm">
            Send customers directly to the Google 5-star review compose box with one tap, removing 4 friction clicks.
        </p>
    </div>

    <!-- Generator Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Business Name</label>
                <input
                    type="text"
                    x-model="businessName"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 font-semibold"
                />
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Google Place ID</label>
                <input
                    type="text"
                    x-model="placeId"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-brand-500"
                />
            </div>
        </div>

        <!-- Generated Link Box -->
        <div class="bg-brand-50/70 border border-brand-200 rounded-xl p-5 mb-6">
            <span class="text-xs font-bold text-brand-800 uppercase tracking-wider block mb-1">Direct Google Compose URL</span>
            <div class="flex items-center gap-2 bg-white rounded-lg p-2 border border-brand-200">
                <i data-lucide="globe" class="w-4 h-4 text-brand-600 flex-shrink-0"></i>
                <input
                    type="text"
                    readonly
                    :value="directUrl"
                    class="bg-transparent text-xs text-slate-700 flex-1 font-mono focus:outline-none select-all"
                />
                <button
                    @click="copyDirectUrl()"
                    class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-3 py-1.5 rounded-md flex items-center gap-1 transition-all"
                >
                    <span x-text="copiedLink ? 'Copied!' : 'Copy'">Copy</span>
                </button>
            </div>
        </div>

        <!-- Ready to Send Templates -->
        <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center gap-2">
            <i data-lucide="message-square" class="w-4 h-4 text-brand-600"></i> Pre-Written Request Templates
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- WhatsApp / SMS Template -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-emerald-700 block mb-2">💬 WhatsApp / SMS Script</span>
                    <p class="text-xs text-slate-600 leading-relaxed bg-white p-3 rounded-lg border border-slate-200 mb-3" x-text="whatsappScript"></p>
                </div>
                <button
                    @click="copyWhatsApp()"
                    class="w-full bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold py-2 rounded-lg transition-all"
                >
                    <span x-text="copiedWhatsApp ? 'Copied Script!' : 'Copy WhatsApp Script'">Copy WhatsApp Text</span>
                </button>
            </div>

            <!-- Email Template -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-brand-700 block mb-2">✉️ Post-Visit Email Script</span>
                    <p class="text-xs text-slate-600 leading-relaxed bg-white p-3 rounded-lg border border-slate-200 mb-3" x-text="emailScript"></p>
                </div>
                <button
                    @click="copyEmail()"
                    class="w-full bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold py-2 rounded-lg transition-all"
                >
                    <span x-text="copiedEmail ? 'Copied Email!' : 'Copy Email Script'">Copy Email Script</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function reviewLinkGen() {
        return {
            businessName: 'Apex Dental Care',
            placeId: 'ChIJN1t_tDeuEmsRUsoyG83frY4',
            copiedLink: false,
            copiedWhatsApp: false,
            copiedEmail: false,
            get directUrl() {
                return 'https://search.google.com/local/writereview?placeid=' + this.placeId;
            },
            get whatsappScript() {
                return 'Hi! Thank you for choosing ' + this.businessName + '. If you enjoyed your visit today, could you take 30 seconds to rate us on Google? Direct link: ' + this.directUrl;
            },
            get emailScript() {
                return 'Subject: Quick favor for ' + this.businessName + '\n\nHi [Name], thank you for trusting our team! We would appreciate a quick 5-star Google review: ' + this.directUrl;
            },
            copyDirectUrl() {
                navigator.clipboard.writeText(this.directUrl);
                this.copiedLink = true;
                setTimeout(() => this.copiedLink = false, 2000);
            },
            copyWhatsApp() {
                navigator.clipboard.writeText(this.whatsappScript);
                this.copiedWhatsApp = true;
                setTimeout(() => this.copiedWhatsApp = false, 2000);
            },
            copyEmail() {
                navigator.clipboard.writeText(this.emailScript);
                this.copiedEmail = true;
                setTimeout(() => this.copiedEmail = false, 2000);
            }
        }
    }
</script>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Google Review Link FAQ', 'faqIntro' => 'How to get more Google reviews with a direct review link.'])
@endsection
