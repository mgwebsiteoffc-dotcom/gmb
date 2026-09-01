@extends('layouts.marketing')

@section('title', 'Google Review QR Code Generator & Printable Stand | Untab')
@section('meta_description', 'Generate a high-resolution Google review QR code and printable 5"x7" desk stand. Customers scan to leave a review instantly — boost conversions at any location.')
@section('meta_keywords', 'Google review QR code, printable review stand, review QR generator, Google reviews, scan to review')

@php($faqs = [
    ['q' => 'How do I create a Google review QR code?', 'a' => 'Enter your business name and Place ID. Untab generates a high-resolution QR code that links directly to your Google review form — ready to print on a desk stand.'],
    ['q' => 'Where should I place my review QR code?', 'a' => 'Put it at the point of sale, on receipts, at the front desk, or on table tents — wherever a happy customer is most likely to scan it.'],
    ['q' => 'Does the download include the card design?', 'a' => 'Yes. The PNG download and print both export the full branded stand card — Google Reviews wordmark, star rating, business name, tagline, and QR code — not just the bare code.'],
    ['q' => 'Will this QR code increase my review count?', 'a' => 'Yes. A direct review QR code removes friction by skipping the search for your business on Google Maps, dramatically increasing conversion.'],
])
@php($jsonLd = [
    \App\Support\SeoHelper::faqSchema($faqs),
    \App\Support\SeoHelper::breadcrumbSchema([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Review QR Code', 'url' => route('tools.review-qr')],
    ]),
])

@push('styles')
<style>
    /* Print ONLY the stand card — hide nav, footer, controls, FAQ. */
    @media print {
        body { background: #fff !important; }
        .no-print { display: none !important; }
        .print-area {
            display: block !important;
            position: static !important;
            margin: 0 auto !important;
            box-shadow: none !important;
            border: none !important;
            width: auto !important;
            max-width: none !important;
        }
        .print-card {
            border: 1px solid #e2e5f5 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }
        .print-card canvas { width: 100% !important; height: auto !important; }
        @page { size: 5in 7in; margin: 0.2in; }
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6" x-data="qrGen()" x-init="renderQr()">
    <div class="text-center mb-8 no-print">
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
        <div class="md:col-span-6 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 no-print">
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
                    @input="renderQr()"
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

            <div class="pt-4 flex flex-col sm:flex-row gap-3">
                <button
                    @click="downloadQr()"
                    class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs py-3 rounded-xl transition-all shadow-md flex items-center justify-center gap-2"
                >
                    <i data-lucide="download" class="w-4 h-4"></i> Download Stand Card (PNG)
                </button>
                <button
                    @click="window.print()"
                    class="bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-4 py-3 rounded-xl transition-all flex items-center justify-center gap-2"
                >
                    <i data-lucide="printer" class="w-4 h-4"></i> Print Card
                </button>
            </div>
            <p class="text-[11px] text-slate-400">Both actions export the full 5" x 7" branded stand — Google Reviews wordmark, stars, business name, tagline, and QR code.</p>
        </div>

        <!-- Stand Preview (this is exactly what downloads / prints) -->
        <div class="md:col-span-6 flex flex-col items-center justify-center no-print">
            <div class="print-area w-full flex justify-center">
                <div class="print-card w-full max-w-xs bg-white rounded-2xl shadow-xl border-4 border-slate-800 p-3 text-center">
                    <canvas id="standCanvas" class="w-full h-auto"></canvas>
                </div>
            </div>
            <span class="text-xs text-slate-400 mt-3">Live 5" x 7" Printable Desk Stand — download &amp; print match this exactly.</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function qrGen() {
        return {
            businessName: 'Apex Dental Care',
            tagline: 'Scan with camera to leave us a 5-star review!',
            targetUrl: 'https://search.google.com/local/writereview?placeid=ChIJN1t_tDeuEmsRUsoyG83frY4',
            colorDark: '#1a35c8',
            W: 1000,
            H: 1400,
            async renderQr() {
                const draw = async (n) => {
                    const canvas = document.getElementById('standCanvas');
                    if (canvas && typeof QRCode !== 'undefined') {
                        try {
                            const url = await QRCode.toDataURL(this.targetUrl, { width: 620, margin: 2, color: { dark: this.colorDark, light: '#ffffff' } });
                            const img = await this.loadImage(url);
                            this.drawCard(canvas, img);
                            return;
                        } catch (e) { /* fall through to retry */ }
                    }
                    if (n < 30) setTimeout(() => draw(n + 1), 120);
                };
                draw(0);
            },
            loadImage(src) {
                return new Promise((resolve, reject) => { const i = new Image(); i.onload = () => resolve(i); i.onerror = reject; i.src = src; });
            },
            drawCard(canvas, qrImg) {
                canvas.width = this.W; canvas.height = this.H;
                const ctx = canvas.getContext('2d');
                const { W, H } = this;
                ctx.textAlign = 'center'; ctx.textBaseline = 'alphabetic';

                // Outer white card
                ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, W, H);

                // Inner colored frame border
                ctx.strokeStyle = this.colorDark; ctx.lineWidth = 14; ctx.strokeRect(34, 34, W - 68, H - 68);

                // Google Reviews wordmark
                this.googleWordmark(ctx, W / 2, 200, 82);

                // 5 gold stars
                ctx.fillStyle = '#fbbf24'; ctx.font = 'bold 88px "Georgia", serif';
                let starX = W / 2 - 210;
                for (let i = 0; i < 5; i++) { ctx.fillText('★', starX, 300); starX += 105; }
                ctx.fillStyle = '#f59e0b'; ctx.font = 'bold 28px "Plus Jakarta Sans", sans-serif';
                ctx.fillText('LOVED BY OUR CUSTOMERS', W / 2, 352);

                // Business name (up to 2 lines)
                ctx.fillStyle = '#0f172a'; ctx.font = '800 66px "Nunito", "Plus Jakarta Sans", sans-serif';
                this.wrapText(ctx, this.businessName, W / 2, 448, 820, 76, 2);

                // Tagline (up to 2 lines)
                ctx.fillStyle = '#64748b'; ctx.font = '400 30px "Plus Jakarta Sans", sans-serif';
                this.wrapText(ctx, this.tagline, W / 2, 612, 800, 40, 2);

                // QR (sits below all text)
                const qs = 540;
                ctx.drawImage(qrImg, (W - qs) / 2, 688, qs, qs);

                // Instruction pill
                ctx.fillStyle = this.colorDark;
                const pillW = 700, pillH = 80, pillX = (W - pillW) / 2, pillY = 1252;
                this.roundRect(ctx, pillX, pillY, pillW, pillH, 40); ctx.fill();
                ctx.fillStyle = '#ffffff'; ctx.font = 'bold 36px "Plus Jakarta Sans", sans-serif';
                ctx.fillText('⚡ Point Your Camera to Review', W / 2, pillY + 52);

                // Footer
                ctx.fillStyle = '#94a3b8'; ctx.font = '600 24px "Plus Jakarta Sans", sans-serif';
                ctx.fillText('Scan to share your experience', W / 2, 1358);
            },
            googleWordmark(ctx, cx, y, size) {
                const colors = ['#4285F4', '#EA4335', '#FBBC05', '#4285F4', '#34A853', '#EA4335'];
                const word = 'Google';
                ctx.font = '500 ' + size + 'px "Plus Jakarta Sans", sans-serif';
                let total = 0; word.split('').forEach(ch => total += ctx.measureText(ch).width);
                let x = cx - total / 2;
                word.split('').forEach((ch, i) => { ctx.fillStyle = colors[i]; ctx.fillText(ch, x, y); x += ctx.measureText(ch).width; });
                // "Reviews" suffix
                ctx.fillStyle = '#334155'; ctx.font = '700 ' + (size * 0.42) + 'px "Plus Jakarta Sans", sans-serif';
                ctx.fillText('Reviews', cx + total / 2 + 90, y - 4);
            },
            roundRect(ctx, x, y, w, h, r) {
                ctx.beginPath(); ctx.moveTo(x + r, y); ctx.arcTo(x + w, y, x + w, y + h, r); ctx.arcTo(x + w, y + h, x, y + h, r); ctx.arcTo(x, y + h, x, y, r); ctx.arcTo(x, y, x + w, y, r); ctx.closePath();
            },
            wrapText(ctx, text, cx, y, maxWidth, lineHeight, maxLines) {
                const words = String(text || '').split(/\s+/);
                let line = '', lines = [];
                for (let i = 0; i < words.length; i++) {
                    const test = line ? line + ' ' + words[i] : words[i];
                    if (ctx.measureText(test).width > maxWidth && line) { lines.push(line); line = words[i]; if (lines.length === maxLines - 1) break; }
                    else line = test;
                }
                if (line) lines.push(line);
                lines.slice(0, maxLines).forEach((l, i) => ctx.fillText(l, cx, y + i * lineHeight));
            },
            downloadQr() {
                const canvas = document.getElementById('standCanvas');
                if (canvas) {
                    const link = document.createElement('a');
                    link.download = this.businessName.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '') + '-review-stand.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                }
            }
        }
    }
</script>
@endpush

@include('partials.faq', ['faqs' => $faqs, 'faqTitle' => 'Google Review QR Code FAQ', 'faqIntro' => 'How to print a QR code that gets customers to leave reviews fast.'])
@endsection
