@extends('layouts.marketing')

@section('title', 'Create your free Untab account — Google Business Profile Platform')
@section('meta_description', 'Create a free Untab account and manage every Google Business Profile from one dashboard with AI review replies, Google Posts, and white-label client reports.')
@section('meta_robots', 'noindex, follow')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-[#f0f4ff] to-white flex items-center justify-center py-16 px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-brand-800 to-brand-500 flex items-center justify-center shadow-md">@include('partials.brand-mark', ['class' => 'w-7 h-7'])</div>
            </div>
            <h1 class="text-3xl font-black font-display text-slate-900">Start free with <span class="text-brand-600">Untab</span></h1>
            <p class="text-sm text-slate-500 mt-2">No credit card required. Free to explore every module.</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide" for="name">Full Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="Jane Smith">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide" for="email">Work Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="you@agency.com">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide" for="password">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="At least 8 characters">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide" for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="Repeat password">
                </div>
                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-extrabold py-3 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <i data-lucide="rocket" class="w-4 h-4"></i> Create Free Account
                </button>
            </form>

            <p class="text-center text-xs text-slate-500 mt-6">
                Already have an account? <a href="{{ route('login') }}" class="font-bold text-brand-700 hover:underline">Sign in</a>
            </p>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('app.dashboard') }}" class="text-xs font-bold text-slate-500 hover:text-brand-700 inline-flex items-center gap-1">
                <i data-lucide="eye" class="w-3.5 h-3.5"></i> Continue to live demo without login
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>lucide.createIcons();</script>
@endpush
