@extends('layouts.admin')

@section('title', 'Add Brand — Untab SaaS Admin')
@section('page_title', 'Add Brand')

@section('content')
<form method="POST" action="{{ route('admin.clients.store') }}" class="max-w-2xl">
    @csrf
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Brand / Client Name</label>
                <input name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Category</label>
                <input name="category" value="{{ old('category') }}" required placeholder="e.g. Dental Clinic Chain" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Logo (emoji)</label>
                <input name="logo" value="{{ old('logo', '🏢') }}" placeholder="🏢" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Brand Color</label>
                <input name="color" type="color" value="{{ old('color', '#2563eb') }}" class="w-full h-[42px] rounded-xl border border-slate-300 px-1 py-1 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Monthly Retainer</label>
                <input name="monthly_retainer" value="{{ old('monthly_retainer', '$1,500/mo') }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Account Manager</label>
                <input name="account_manager" value="{{ old('account_manager') }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Active Since</label>
                <input name="active_since" value="{{ old('active_since', 'Jan 2024') }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-md">Create Brand</button>
            <a href="{{ route('admin.clients.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700">Cancel</a>
        </div>
    </div>
</form>
@endsection
