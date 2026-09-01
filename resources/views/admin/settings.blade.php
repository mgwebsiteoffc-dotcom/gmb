@extends('layouts.admin')

@section('title', 'Platform Settings — Untab SaaS Admin')
@section('page_title', 'Platform Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6" x-data="{ tab: 'general' }">
    @csrf

    <div class="flex flex-wrap gap-2">
        <button type="button" @click="tab = 'general'"
            :class="tab === 'general' ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 border border-slate-200'"
            class="px-4 py-2 text-sm font-bold rounded-xl transition-all">General</button>
        <button type="button" @click="tab = 'billing'"
            :class="tab === 'billing' ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 border border-slate-200'"
            class="px-4 py-2 text-sm font-bold rounded-xl transition-all">Billing & Payments</button>
        <button type="button" @click="tab = 'ai'"
            :class="tab === 'ai' ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 border border-slate-200'"
            class="px-4 py-2 text-sm font-bold rounded-xl transition-all">AI & Automation</button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold rounded-xl px-4 py-3">{{ session('success') }}</div>
    @endif

    {{-- ============================= GENERAL ============================= --}}
    <div x-show="tab === 'general'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
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

    {{-- ============================= BILLING & PAYMENTS ============================= --}}
    <div x-show="tab === 'billing'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
        <div class="flex items-start gap-3 bg-slate-50 border border-slate-200 rounded-xl p-4">
            <div class="text-xl">💳</div>
            <div class="text-sm text-slate-600">
                <span class="font-bold text-slate-800">Payment gateway & plans.</span>
                These settings power the brand/agency checkout that your clients see, and are managed here by the platform Super Admin. The current provider is
                <span class="font-bold text-brand-600">{{ $settings->paymentProviderLabel() }}</span>
                in <span class="font-bold">{{ strtoupper($settings->payment_mode) }}</span> mode.
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Payment Provider</label>
                <select name="payment_provider" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    @foreach(['stripe' => 'Stripe', 'razorpay' => 'Razorpay', 'paypal' => 'PayPal', 'offline' => 'Offline / Manual'] as $provider => $label)
                        <option value="{{ $provider }}" @selected(old('payment_provider', $settings->payment_provider) === $provider)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Mode</label>
                <select name="payment_mode" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="test" @selected(old('payment_mode', $settings->payment_mode) === 'test')>Test / Sandbox</option>
                    <option value="live" @selected(old('payment_mode', $settings->payment_mode) === 'live')>Live</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Currency</label>
                <input name="payment_currency" value="{{ old('payment_currency', $settings->payment_currency) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" maxlength="3">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Trial Days</label>
                <input name="plan_trial_days" type="number" value="{{ old('plan_trial_days', $settings->plan_trial_days) }}" min="0" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Public / Publishable Key</label>
            <input name="payment_public_key" value="{{ old('payment_public_key', $settings->payment_public_key) }}" placeholder="pk_test_..." class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            <p class="text-[11px] text-slate-400 mt-1">Leave blank to keep the existing key. Never share this in public code.</p>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Secret Key</label>
            <input name="payment_secret_key" type="password" value="" placeholder="sk_test_...  (leave blank to keep existing)" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
        </div>

        <div class="border-t border-slate-100 pt-5">
            <h4 class="text-sm font-bold text-slate-800 mb-3">Plan Pricing</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Base Monthly (per brand)</label>
                    <input name="plan_monthly_price" type="number" step="0.01" value="{{ old('plan_monthly_price', $settings->plan_monthly_price) }}" min="0" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Per Location / Month</label>
                    <input name="plan_per_location_price" type="number" step="0.01" value="{{ old('plan_per_location_price', $settings->plan_per_location_price) }}" min="0" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
            </div>
        </div>

        <label class="flex items-center gap-2.5 text-sm font-semibold text-slate-700">
            <input type="checkbox" name="payment_enabled" value="1" @checked($settings->payment_enabled) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500 h-4 w-4">
            Enable online payments at checkout
        </label>

        <div class="pt-2">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-md">Save Billing Settings</button>
        </div>
    </div>

    {{-- ============================= AI & AUTOMATION ============================= --}}
    <div x-show="tab === 'ai'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
        <div class="flex items-start gap-3 bg-slate-50 border border-slate-200 rounded-xl p-4">
            <div class="text-xl">🧠</div>
            <div class="text-sm text-slate-600">
                <span class="font-bold text-slate-800">AI brain.</span> The Untab AI uses OpenRouter to draft review replies, Google Post captions and descriptions. Configure the default model and behaviour here — clients inherit these unless overridden at the brand end.
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Default AI Model (OpenRouter)</label>
            <input name="ai_model" value="{{ old('ai_model', $settings->ai_model) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            <p class="text-[11px] text-slate-400 mt-1">e.g. nvidia/nemotron-3.5-lightning:free</p>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">OpenRouter API Key</label>
            <input name="ai_api_key" type="password" value="" placeholder="sk-or-...  (leave blank to keep existing)" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            <p class="text-[11px] text-slate-400 mt-1">Stored server-side. Leave blank to keep the current key.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Temperature</label>
                <input name="ai_temperature" type="number" step="0.01" value="{{ old('ai_temperature', $settings->ai_temperature) }}" min="0" max="2" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Max Tokens</label>
                <input name="ai_max_tokens" type="number" value="{{ old('ai_max_tokens', $settings->ai_max_tokens) }}" min="128" max="8192" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>

        <label class="flex items-center gap-2.5 text-sm font-semibold text-slate-700">
            <input type="checkbox" name="ai_reasoning" value="1" @checked($settings->ai_reasoning) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500 h-4 w-4">
            Use AI reasoning (better answers, slightly slower)
        </label>

        <div class="pt-2">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-md">Save AI Settings</button>
        </div>
    </div>
</form>
@endsection
