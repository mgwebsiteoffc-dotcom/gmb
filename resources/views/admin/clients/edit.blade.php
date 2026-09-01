@extends('layouts.admin')

@section('title', 'Edit Brand — Untab SaaS Admin')
@section('page_title', 'Edit ' . $client->name)

@section('content')
<form method="POST" action="{{ route('admin.clients.update', $client) }}" enctype="multipart/form-data" class="max-w-2xl">
    @csrf @method('PUT')
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Brand / Client Name</label>
                <input name="name" value="{{ old('name', $client->name) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Category</label>
                <input name="category" value="{{ old('category', $client->category) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Brand Logo</label>
                <div class="flex items-center gap-3">
                    <label class="cursor-pointer inline-flex items-center gap-2 bg-brand-50 text-brand-700 border border-brand-200 rounded-xl px-4 py-2.5 text-sm font-bold hover:bg-brand-100 transition-colors">
                        <i data-lucide="upload" class="w-4 h-4"></i> Upload Logo
                        <input type="file" name="logo_image" accept="image/*" class="hidden" onchange="document.getElementById('logo-preview').src = window.URL.createObjectURL(this.files[0]); document.getElementById('logo-name').textContent = this.files[0].name;">
                    </label>
                    <span id="logo-name" class="text-xs text-slate-500 truncate max-w-[160px]"></span>
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Upload a logo (JPEG/PNG/SVG/WebP, up to 8MB). If none, the emoji below is used.</p>
                <div id="logo-preview" class="mt-2 w-14 h-14 rounded-2xl flex items-center justify-center text-3xl bg-slate-100 border border-slate-200">
                    @if($client->hasLogoImage())
                        <img src="{{ $client->logo_url }}" alt="Logo" class="w-full h-full object-contain rounded-2xl">
                    @else
                        {{ $client->logo }}
                    @endif
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Logo Emoji (fallback)</label>
                    <input name="logo" value="{{ old('logo', $client->logo) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Brand Color</label>
                <input name="color" type="color" value="{{ old('color', $client->color) }}" class="w-full h-[42px] rounded-xl border border-slate-300 px-1 py-1 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Monthly Retainer</label>
                <input name="monthly_retainer" value="{{ old('monthly_retainer', $client->monthly_retainer) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Brand Mobile</label>
                <input name="mobile" value="{{ old('mobile', $client->mobile) }}" placeholder="+91 98xxxxxxx0" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Account Manager</label>
                <input name="account_manager" value="{{ old('account_manager', $client->account_manager) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Onboarded Date (calendar)</label>
                <input name="onboarded_at" type="date" value="{{ old('onboarded_at', $client->onboarded_at?->format('Y-m-d')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>

        <div>
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wide block mb-2">Primary Contact (POC) — set up later once onboarded</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 mb-1">POC Name</label>
                    <input name="poc_name" value="{{ old('poc_name', $client->poc_name) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 mb-1">POC Email</label>
                    <input name="poc_email" type="email" value="{{ old('poc_email', $client->poc_email) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 mb-1">POC Mobile</label>
                    <input name="poc_mobile" value="{{ old('poc_mobile', $client->poc_mobile) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-md">Save Changes</button>
            <a href="{{ route('admin.clients.show', $client) }}" class="text-sm font-bold text-slate-500 hover:text-slate-700">Cancel</a>
        </div>
    </div>
</form>
@endsection
