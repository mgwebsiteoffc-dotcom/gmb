@extends('layouts.admin')

@section('title', 'Platform Settings — Untab SaaS Admin')
@section('page_title', 'Platform Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-2xl">
    @csrf
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Agency Name</label>
            <input name="agency_name" value="{{ old('agency_name', $settings->agency_name) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Custom Domain</label>
                <input name="custom_domain" value="{{ old('custom_domain', $settings->custom_domain) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Brand Color</label>
                <input name="brand_color" type="color" value="{{ old('brand_color', $settings->brand_color) }}" class="w-full h-[42px] rounded-xl border border-slate-300 px-1 py-1 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Support Email</label>
            <input name="support_email" type="email" value="{{ old('support_email', $settings->support_email) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Default AI Model (OpenRouter)</label>
            <input name="ai_model" value="{{ old('ai_model', $settings->ai_model) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            <p class="text-[11px] text-slate-400 mt-1">Used for AI review replies & post captions. e.g. nvidia/nemotron-3.5-lightning:free</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-4">
            <label class="flex items-center gap-2.5 text-sm font-semibold text-slate-700 flex-1">
                <input type="checkbox" name="email_alerts" value="1" @checked($settings->email_alerts) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500 h-4 w-4">
                Email alerts
            </label>
            <label class="flex items-center gap-2.5 text-sm font-semibold text-slate-700 flex-1">
                <input type="checkbox" name="sms_alerts" value="1" @checked($settings->sms_alerts) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500 h-4 w-4">
                SMS alerts
            </label>
        </div>
        <div class="pt-2">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-md">Save Settings</button>
        </div>
    </div>
</form>
@endsection
