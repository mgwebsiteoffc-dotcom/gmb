@extends('layouts.marketing')

@section('title', 'Google Posts: Schedule Updates, Offers, Events | Untab')

@section('content')
<section class="py-16 bg-gradient-to-b from-brand-50 to-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs font-bold text-brand-600 bg-brand-100/80 px-3.5 py-1 rounded-full uppercase tracking-wider">
            Google Posts Module
        </span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-slate-900 mt-4 mb-4">
            Schedule Google Posts <span class="text-brand-600">across every location.</span>
        </h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
            Keep profiles active, promote seasonal offers, and announce upcoming webinars or sales without logging in and out of individual accounts.
        </p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('app.posts') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-8 py-3.5 rounded-2xl transition-all shadow-md">
                Open Posts Scheduler →
            </a>
        </div>
    </div>
</section>
@endsection
