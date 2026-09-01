@extends('layouts.marketing')

@section('title', 'Google Review QR Code Generator & Printable Stand | Untab')
@section('meta_description', 'Generate a high-resolution Google review QR code and printable desk stand. Customers scan to leave a review instantly — boost conversions at any location.')
@section('meta_keywords', 'Google review QR code, printable review stand, review QR generator, Google reviews')

@php($faqs = [
    ['q' => 'How do I create a Google review QR code?', 'a' => 'Enter your business name and Place ID. Untab generates a high-resolution QR code that links directly to your Google review form — ready to print.'],
    ['q' => 'Where should I place my review QR code?', 'a' => 'Put it at the point of sale, on receipts, at the front desk, or on table tents — wherever a happy customer is most likely to scan it.'],
    ['q' => 'Will this QR code increase my review count?', 'a' => 'Yes. A direct review QR code removes friction by skipping the search for your business on Google Maps, dramatically increasing conversion.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Review QR Code', 'url' => route('tools.review-qr')],
    ]),
])

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6" x-data="qrGen()" x-init="renderQr()">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
            <i data-lucide="qr-code" class="w-3.5 h-3.5"></i> High-Resolution QR Code & Stand Card
        </div>
        <h1 class="text-3xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">
            Google Review <span class="text-brand-600">QR Code Generator</span>
        </h1>
        <p class="text-slate-600 max-w-xl mx-auto mt-2 text-xs sm:text-sm">
            Create high-converting printable counter stand cards and receipt QR codes for your storefronts.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        <!-- Controls Column -->
        <div class="md:col-span-6 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Business Name</label>
                <input
                    type="text"
                    x-model="businessName"
                    @input="renderQr()"
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm font-semibold focus:ring-2 focus:ring-brand-500"
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Card Heading / Tagline</label>
                <input
                    type="text"
                    x-model="tagline"
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-brand-500"
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Google Review URL</label>
                <input
                    type="text"
                    x-model="targetUrl"
                    @input="renderQr()"
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-mono focus:ring-2 focus:ring-brand-500"
                />
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Brand Color</label>
                    <input
                        type="color"
                        x-model="colorDark"
                        @input="renderQr()"
                        class="w-full h-9 rounded-lg border border-slate-200 cursor-pointer p-0.5"
                    />
                </div>
            </div>

            <div class="pt-4 flex gap-3">
                <button
                    @click="downloadQr()"
                    class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs py-3 rounded-xl transition-all shadow-md flex items-center justify-center gap-2"
                >
                    <i data-lucide="download" class="w-4 h-4"></i> Download QR (PNG)
                </button>
                <button
                    @click="window.print()"
                    class="bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-4 py-3 rounded-xl transition-all flex items-center justify-center gap-2"
                >
                    <i data-lucide="printer" class="w-4 h-4"></i> Print Stand Flyer
                </button>
            </div>
        </div>

        <!-- Stand Preview -->
        <div class="md:col-span-6 flex flex-col items-center justify-center">
            <div class="w-full max-w-xs bg-white rounded-2xl shadow-xl border-4 border-slate-800 p-6 text-center flex flex-col items-center">
                <div class="flex items-center justify-center gap-1 mb-2 font-black text-sm">
                    <span class="text-blue-600">G</span>
                    <span class="text-red-500">o</span>
                    <span class="text-amber-500">o</span>
                    <span class="text-blue-600">g</span>
                    <span class="text-emerald-500">l</span>
                    <span class="text-red-500">e</span>
                    <span class="text-xs font-bold text-slate-600 ml-1">Reviews</span>
                </div>

                <div class="text-amber-400 text-sm mb-2">★★★★★</div>
                <h2 class="font-display font-black text-slate-900 text-base mb-1" x-text="businessName">Apex Dental Care</h2>
                <p class="text-xs text-slate-500 mb-4 max-w-[200px]" x-text="tagline">Scan to rate us 5 stars!</p>

                <!-- Canvas QR -->
                <div class="bg-white p-2 rounded-xl border-2 border-dashed border-slate-200 mb-4">
                    <canvas id="qrCanvas" class="w-40 h-40"></canvas>
                </div>

                <div class="bg-brand-50 text-brand-800 text-[10px] font-bold py-1 px-3 rounded-full border border-brand-200">
                    ⚡ Point Phone Camera to Review
                </div>
            </div>
            <span class="text-xs text-slate-400 mt-3">Live Printable Desk Stand Preview (5" x 7")</span>
        </div>
    </div>
</div>

<script>
    function qrGen() {
        return {
            businessName: 'Apex Dental Care',
            tagline: 'Scan with camera to leave us a 5-star review!',
            targetUrl: 'https://search.google.com/local/writereview?placeid=ChIJN1t_tDeuEmsRUsoyG83frY4',
            colorDark: '#1a35c8',
            renderQr() {
                const draw = (n) => {
                    const canvas = document.getElementById('qrCanvas');
                    if (canvas && typeof QRCode !== 'undefined') {
                        QRCode.toCanvas(canvas, this.targetUrl, {
                            width: 160,
                            margin: 1,
                            color: { dark: this.colorDark, light: '#ffffff' }
                        });
                    } else if (n < 20) {
                        // Library may still be loading — retry shortly.
                        setTimeout(() => draw(n + 1), 100);
                    }
                };
                draw(0);
            },
            downloadQr() {
                const canvas = document.getElementById('qrCanvas');
                if (canvas) {
                    const link = document.createElement('a');
                    link.download = this.businessName.toLowerCase().replace(/\s+/g, '-') + '-review-qr.png';
                    link.href = canvas.toDataURL();
                    link.click();
                }
            }
        }
    }
</script>

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Google Review QR Code FAQ', 'faqIntro' => 'How to print a QR code that gets customers to leave reviews fast.'])
@endsection
