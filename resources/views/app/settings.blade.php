@extends('layouts.app')

@section('title', 'Agency White-Label Settings - Untab')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Agency Configuration
                </span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 font-display">
                Agency White-Label & System Settings
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Customize your agency custom domain, email branding, and AI model parameters.
            </p>
        </div>
    </div>

    <!-- Settings Form -->
    <form action="{{ route('app.settings.update') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Agency Name</label>
                <input
                    type="text"
                    name="agency_name"
                    value="{{ $settings->agency_name }}"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-semibold focus:ring-2 focus:ring-brand-500"
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">White-Label Custom Subdomain</label>
                <input
                    type="text"
                    name="custom_domain"
                    value="{{ $settings->custom_domain }}"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-mono focus:ring-2 focus:ring-brand-500"
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Support Email</label>
                <input
                    type="email"
                    name="support_email"
                    value="{{ $settings->support_email }}"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:ring-2 focus:ring-brand-500"
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Brand Accent Color</label>
                <div class="flex items-center gap-3">
                    <input
                        type="color"
                        name="brand_color"
                        value="{{ $settings->brand_color }}"
                        class="w-10 h-10 rounded-xl border border-slate-200 cursor-pointer p-0.5"
                    />
                    <span class="text-xs font-mono font-bold text-slate-700">{{ $settings->brand_color }}</span>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 space-y-3">
            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Automated Notification Alerts</h4>
            <label class="flex items-center gap-2.5 text-xs text-slate-700 cursor-pointer">
                <input type="checkbox" name="email_alerts" value="1" {{ $settings->email_alerts ? 'checked' : '' }} class="rounded text-brand-600">
                <span>Send instant email alerts when a customer leaves a 1, 2, or 3-star negative review</span>
            </label>
            <label class="flex items-center gap-2.5 text-xs text-slate-700 cursor-pointer">
                <input type="checkbox" name="sms_alerts" value="1" {{ $settings->sms_alerts ? 'checked' : '' }} class="rounded text-brand-600">
                <span>Send weekly executive summary report digests to account managers</span>
            </label>
        </div>

        <div class="pt-4 flex justify-end">
            <button
                type="submit"
                class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm px-6 py-2.5 rounded-xl transition-all shadow-md"
            >
                Save White-Label Settings
            </button>
        </div>
    </form>
</div>
@endsection
