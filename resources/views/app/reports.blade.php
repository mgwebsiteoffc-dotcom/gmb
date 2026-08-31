@extends('layouts.app')

@section('title', 'Automated White-Label Client Reports - Ampli5 Pulse')

@section('content')
<div class="space-y-6" x-data="reportBuilder()">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    White-Label Client Reporting
                </span>
                <span class="text-xs text-slate-400 font-medium">1-Click PDF & Live URL</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 font-display">
                Automated Client Performance Reports
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Deliver gorgeous, branded GBP reports with your agency logo that prove ROI and renew retainers.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button
                @click="copyLink()"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5"
            >
                <i data-lucide="share-2" class="w-4 h-4"></i>
                <span x-text="copied ? 'Copied Client Link!' : 'Copy Client Link'">Copy Client Link</span>
            </button>
            <button
                @click="downloadPdf()"
                class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-xl transition-all shadow-md flex items-center gap-2"
            >
                <i data-lucide="download" class="w-4 h-4"></i> Download Branded PDF
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left 4 Cols: Controls -->
        <div class="lg:col-span-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm font-display flex items-center gap-2">
                <i data-lucide="palette" class="w-4 h-4 text-brand-600"></i> Agency White-Label Branding
            </h3>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Agency Brand Name</label>
                <input type="text" x-model="agencyName" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Client Name</label>
                <input type="text" x-model="clientName" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Reporting Period</label>
                <input type="text" x-model="reportPeriod" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Accent Brand Color</label>
                <input type="color" x-model="brandColor" class="w-full h-9 rounded-lg border border-slate-200 cursor-pointer p-0.5">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Executive Summary / Notes</label>
                <textarea rows="4" x-model="executiveSummary" class="w-full p-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed"></textarea>
            </div>
        </div>

        <!-- Right 8 Cols: Live Preview Paper Document -->
        <div class="lg:col-span-8 bg-slate-100 p-4 sm:p-6 rounded-2xl border border-slate-200/80 overflow-hidden">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6 sm:p-8 space-y-6 max-w-2xl mx-auto" id="reportDocument">
                <!-- Header -->
                <div class="flex items-start justify-between border-b pb-6" :style="'border-color: ' + brandColor + '30'">
                    <div>
                        <div class="flex items-center gap-2 font-display font-black text-lg" :style="'color: ' + brandColor">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm font-bold shadow-sm" :style="'background: ' + brandColor">
                                ⚡
                            </span>
                            <span x-text="agencyName">Apex SEO & Growth Agency</span>
                        </div>
                        <h2 class="text-xl font-black text-slate-900 mt-2 font-display">Local Presence & GBP Performance Report</h2>
                        <div class="text-xs text-slate-500 mt-1">Prepared for <strong class="text-slate-800" x-text="clientName">Apex Dental Care</strong></div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-700 px-3 py-1 rounded-full" x-text="reportPeriod">
                            August 2026
                        </span>
                        <div class="text-[11px] text-slate-400 mt-2">Generated via Ampli5 Pulse</div>
                    </div>
                </div>

                <!-- Executive Summary -->
                <div class="p-4 rounded-xl border text-xs leading-relaxed" :style="'background: ' + brandColor + '08; border-color: ' + brandColor + '25'">
                    <strong class="block text-slate-900 font-bold mb-1">Executive Performance Summary:</strong>
                    <p class="text-slate-700" x-text="executiveSummary"></p>
                </div>

                <!-- KPIs -->
                <div class="space-y-3">
                    <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider">
                        Google Business Profile Performance (Month-over-Month)
                    </h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Total Views</span>
                            <div class="text-xl font-black text-slate-900 font-display mt-0.5">{{ number_format($totalViews) }}</div>
                            <span class="text-[10px] text-emerald-600 font-bold">+24.1%</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Phone Calls</span>
                            <div class="text-xl font-black text-slate-900 font-display mt-0.5">{{ number_format($totalCalls) }}</div>
                            <span class="text-[10px] text-emerald-600 font-bold">+18.5%</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Direction Clicks</span>
                            <div class="text-xl font-black text-slate-900 font-display mt-0.5">{{ number_format($totalDirections) }}</div>
                            <span class="text-[10px] text-emerald-600 font-bold">+29.2%</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Website Clicks</span>
                            <div class="text-xl font-black text-slate-900 font-display mt-0.5">{{ number_format($totalClicks) }}</div>
                            <span class="text-[10px] text-emerald-600 font-bold">+14.0%</span>
                        </div>
                    </div>
                </div>

                <!-- Queries -->
                <div class="space-y-2">
                    <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider">
                        Top High-Intent Search Queries
                    </h4>
                    <div class="divide-y divide-slate-100 text-xs">
                        @foreach($topQueries as $q)
                            <div class="py-2 flex items-center justify-between">
                                <span class="font-semibold text-slate-800">{{ $q->query }}</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-slate-500">{{ number_format($q->clicks) }} clicks</span>
                                    <span class="font-bold text-slate-900 bg-slate-100 px-2 py-0.5 rounded text-[11px]">
                                        Rank #{{ $q->position }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                    <span x-text="agencyName + ' • White-Label Local Growth'"></span>
                    <span>Confidential Client Performance Report</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function reportBuilder() {
        return {
            agencyName: 'Apex SEO & Growth Agency',
            clientName: 'Apex Dental Care',
            reportPeriod: 'August 2026',
            brandColor: '#1a35c8',
            executiveSummary: 'During this reporting period, total Google Maps and Search impressions grew by +24.1%, driven by weekly Google Post promotions and rapid 2-hour AI review response times. Top commercial search terms ("emergency dentist downtown austin") now rank firmly in Top 3 Map Pack.',
            copied: false,
            copyLink() {
                navigator.clipboard.writeText('https://reports.youragency.com/share/r-' + Date.now());
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            },
            downloadPdf() {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                doc.setFontSize(18);
                doc.setTextColor(26, 53, 200);
                doc.text(this.agencyName, 20, 20);

                doc.setFontSize(14);
                doc.setTextColor(15, 23, 42);
                doc.text('Local Presence & GBP Performance Report', 20, 30);

                doc.setFontSize(10);
                doc.setTextColor(100, 116, 139);
                doc.text('Client: ' + this.clientName + ' | Period: ' + this.reportPeriod, 20, 38);

                doc.setDrawColor(226, 232, 240);
                doc.line(20, 42, 190, 42);

                doc.setFontSize(12);
                doc.setTextColor(15, 23, 42);
                doc.text('1. Executive Performance Summary', 20, 50);

                doc.setFontSize(9);
                doc.setTextColor(51, 65, 85);
                const splitNotes = doc.splitTextToSize(this.executiveSummary, 170);
                doc.text(splitNotes, 20, 56);

                doc.setFontSize(12);
                doc.setTextColor(15, 23, 42);
                doc.text('2. Core Business Metrics', 20, 80);

                doc.setFontSize(10);
                doc.text('• Total Profile Impressions: {{ number_format($totalViews) }}', 25, 88);
                doc.text('• Direct Phone Calls: {{ number_format($totalCalls) }}', 25, 95);
                doc.text('• Direction Requests: {{ number_format($totalDirections) }}', 25, 102);
                doc.text('• Website Clicks: {{ number_format($totalClicks) }}', 25, 109);

                doc.save(this.clientName.toLowerCase().replace(/\s+/g, '-') + '-report.pdf');
            }
        }
    }
</script>
@endsection
