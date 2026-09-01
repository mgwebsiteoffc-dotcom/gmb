<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php($seoType = $seoType ?? 'website')
    @php($seoTitle = $seoTitle ?? (trim(View::yieldContent('title')) ?: 'Untab — Google Business App for SEO Agencies & Multi-Location Brands'))
    @php($seoDesc = $seoDesc ?? (trim(View::yieldContent('meta_description')) ?: 'Run every Google Business Profile from one dashboard. AI review replies, Google Posts scheduling, local insights, and white-label client reports.'))
    @php($seoKeywords = $seoKeywords ?? trim(View::yieldContent('meta_keywords')))
    @php($seoRobots = ($seoRobots ?? trim(View::yieldContent('meta_robots'))) ?: 'index, follow')
    @include('partials.seo')

    @stack('json-ld')

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef1ff',
                            100: '#e0e7ff',
                            200: '#c5d0ff',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6161ff',
                            600: '#4b4be0',
                            700: '#2547e0',
                            800: '#1a35c8',
                            900: '#0f1f8a',
                        },
                        accent: {
                            500: '#f97316',
                            600: '#ea580c',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Nunito"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- QR Code generator (used by the QR Code + Review Link tools) -->
    <script src="{{ asset('vendor/qrcode.bundle.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons();
            }
        });
    </script>

    <style>
        :root {
            --b: #1a35c8;
            --b2: #2547e0;
            --o: #f97316;
            --bg: #f5f7ff;
            --bd: #e2e5f5;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: #0f172a;
        }
        .bg-grid {
            background-image: radial-gradient(rgba(97, 97, 255, 0.12) 1px, transparent 0);
            background-size: 24px 24px;
        }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="antialiased selection:bg-brand-500 selection:text-white" x-data="{ mobileMenu: false }">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-brand-900 via-brand-800 to-indigo-900 text-white text-xs font-semibold py-2 px-4 text-center flex items-center justify-center gap-2">
        <span class="bg-accent-500 text-white text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full">New</span>
        <span>Google Business App for iOS, Android & Web. Manage 500+ GBP locations without tab-switching.</span>
        <a href="{{ route('app.dashboard') }}" class="underline font-bold hover:text-accent-300 ml-1">Open Live App →</a>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition-all" @click.away="mobileMenu = false">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-800 to-brand-500 flex items-center justify-center text-white font-black text-xl shadow-md">
                    ⚡
                </div>
                <div>
                    <span class="font-display font-black text-2xl tracking-tight text-brand-800">
                        Untab
                    </span>
                    <span class="block text-[9px] font-extrabold tracking-widest text-slate-400 uppercase -mt-1">
                        Google Business Platform
                    </span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden lg:flex items-center gap-0.5 font-semibold text-sm text-slate-600">
                <a href="{{ route('features') }}" class="px-3.5 py-2 rounded-lg hover:text-brand-700 hover:bg-brand-50 transition-colors {{ request()->routeIs('features') ? 'text-brand-700 bg-brand-50 font-bold' : '' }}">
                    Features
                </a>

                <!-- Solutions dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.away="open = false">
                    <button @click="open = true" class="px-3.5 py-2 rounded-lg hover:text-brand-700 hover:bg-brand-50 transition-colors flex items-center gap-1.5 {{ request()->routeIs('white-label-agency','industry-multi-location','reviews-management','posts-management') ? 'text-brand-700 bg-brand-50 font-bold' : '' }}">
                        Solutions
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition.opacity.duration.150ms x-cloak class="absolute top-full left-0 pt-2 w-72 bg-white rounded-2xl shadow-xl border border-slate-200/80 px-2 pb-2 space-y-1 z-50">
                        @foreach([
                            ['route' => 'white-label-agency', 'label' => 'For SEO Agencies', 'desc' => 'White-label client reporting & bulk tools'],
                            ['route' => 'industry-multi-location', 'label' => 'Multi-Location Brands', 'desc' => 'Franchises & chains running 10-500+ profiles'],
                            ['route' => 'reviews-management', 'label' => 'AI Review Management', 'desc' => 'Reply to every review in seconds'],
                            ['route' => 'posts-management', 'label' => 'Google Posts Scheduler', 'desc' => 'Offers, events & updates at scale'],
                        ] as $s)
                            <a href="{{ route($s['route']) }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="{{ $loop->first ? 'building-2' : ($loop->index === 1 ? 'layers' : ($loop->index === 2 ? 'message-square' : 'calendar')) }}" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-xs text-slate-800">{{ $s['label'] }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $s['desc'] }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Industries dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.away="open = false">
                    <button @click="open = true" class="px-3.5 py-2 rounded-lg hover:text-brand-700 hover:bg-brand-50 transition-colors flex items-center gap-1.5 {{ request()->routeIs('industries','industry.show') ? 'text-brand-700 bg-brand-50 font-bold' : '' }}">
                        Industries
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition.opacity.duration.150ms x-cloak class="absolute top-full left-1/2 -translate-x-1/2 pt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-200/80 px-2 pb-2 space-y-1 z-50">
                        <div class="px-2.5 pb-1 text-[10px] font-extrabold uppercase tracking-widest text-slate-400">By Industry</div>
                        <a href="{{ route('industries') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center flex-shrink-0"><i data-lucide="layout-grid" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">All Industries</div><div class="text-[10px] text-slate-500">Every vertical, in one place</div></div>
                        </a>
                        <div class="h-px bg-slate-100 my-1"></div>
                        @foreach(\App\Support\Industries::all() as $industry)
                            <a href="{{ route('industry.show', $industry['slug']) }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center flex-shrink-0"><i data-lucide="{{ $industry['icon'] }}" class="w-4 h-4"></i></div>
                                <div><div class="font-bold text-xs text-slate-800">{{ $industry['name'] }}</div><div class="text-[10px] text-slate-500">{{ $industry['eyebrow'] }}</div></div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('pricing') }}" class="px-3.5 py-2 rounded-lg hover:text-brand-700 hover:bg-brand-50 transition-colors {{ request()->routeIs('pricing') ? 'text-brand-700 bg-brand-50 font-bold' : '' }}">
                    Pricing
                </a>

                <!-- Resources dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.away="open = false">
                    <button @click="open = true" class="px-3.5 py-2 rounded-lg hover:text-brand-700 hover:bg-brand-50 transition-colors flex items-center gap-1.5 {{ request()->routeIs('blog.*','faq','tools.*') ? 'text-brand-700 bg-brand-50 font-bold' : '' }}">
                        Resources
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition.opacity.duration.150ms x-cloak class="absolute top-full right-0 pt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-200/80 px-2 pb-2 space-y-1 z-50">
                        <a href="{{ route('blog.index') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center flex-shrink-0"><i data-lucide="newspaper" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">Blog & Insights</div><div class="text-[10px] text-slate-500">Local SEO & GBP playbooks</div></div>
                        </a>
                        <a href="{{ route('faq') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center flex-shrink-0"><i data-lucide="help-circle" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">FAQs</div><div class="text-[10px] text-slate-500">Answers to common questions</div></div>
                        </a>
                        <div class="h-px bg-slate-100 my-1"></div>
                        <div class="px-2.5 pb-1 text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Free Tools</div>
                        <a href="{{ route('tools.audit') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center flex-shrink-0"><i data-lucide="sparkles" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">GBP Audit Checklist</div><div class="text-[10px] text-slate-500">16-point health score check</div></div>
                        </a>
                        <a href="{{ route('tools.review-link') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center flex-shrink-0"><i data-lucide="link" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">Direct Review Link</div><div class="text-[10px] text-slate-500">1-click compose review URL</div></div>
                        </a>
                        <a href="{{ route('tools.review-qr') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center flex-shrink-0"><i data-lucide="qr-code" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">Review QR Code</div><div class="text-[10px] text-slate-500">Printable desk stand flyers</div></div>
                        </a>
                        <a href="{{ route('tools.review-card') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center flex-shrink-0"><i data-lucide="credit-card" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">NFC Smart Card</div><div class="text-[10px] text-slate-500">Tap-to-review digital card</div></div>
                        </a>
                        <a href="{{ route('tools.photo-size') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0"><i data-lucide="image" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">GBP Photo Size Guide</div><div class="text-[10px] text-slate-500">2026 specs & dimensions</div></div>
                        </a>
                        <a href="{{ route('tools.character-counter') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center flex-shrink-0"><i data-lucide="type" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">Post Character Counter</div><div class="text-[10px] text-slate-500">1,500-char GBP limit checker</div></div>
                        </a>
                        <a href="{{ route('tools.local-seo') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-700 flex items-center justify-center flex-shrink-0"><i data-lucide="map-pin" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">Local SEO Checklist</div><div class="text-[10px] text-slate-500">NAP & keyword health score</div></div>
                        </a>
                        <a href="{{ route('tools.description-writer') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center flex-shrink-0"><i data-lucide="edit-3" class="w-4 h-4"></i></div>
                            <div><div class="font-bold text-xs text-slate-800">GBP Description Writer</div><div class="text-[10px] text-slate-500">750-char AI description</div></div>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <button @click="mobileMenu = !mobileMenu" class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors" aria-label="Toggle menu">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                @auth
                    <a href="{{ route('app.dashboard') }}" class="bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-extrabold px-5 py-2.5 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                        <span>Go to Dashboard</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-red-600 hover:bg-slate-100 transition-all border border-slate-200">
                            <i data-lucide="log-out" class="w-3.5 h-3.5"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-brand-700 hover:bg-brand-50 transition-all border border-brand-200">
                        <i data-lucide="log-in" class="w-3.5 h-3.5"></i> Sign In
                    </a>
                    <a href="{{ route('app.dashboard') }}" class="bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-extrabold px-5 py-2.5 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                        <span>Launch Platform</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div x-show="mobileMenu" x-transition x-cloak class="lg:hidden border-t border-slate-200 bg-white shadow-lg">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 py-4 space-y-1 text-sm font-semibold text-slate-700">
                <a href="{{ route('features') }}" class="block px-4 py-3 rounded-xl hover:bg-brand-50 hover:text-brand-700 {{ request()->routeIs('features') ? 'bg-brand-50 text-brand-700 font-bold' : '' }}">Features</a>
                <a href="{{ route('white-label-agency') }}" class="block px-4 py-3 rounded-xl hover:bg-brand-50 hover:text-brand-700 {{ request()->routeIs('white-label-agency') ? 'bg-brand-50 text-brand-700 font-bold' : '' }}">For SEO Agencies</a>
                <a href="{{ route('industry-multi-location') }}" class="block px-4 py-3 rounded-xl hover:bg-brand-50 hover:text-brand-700 {{ request()->routeIs('industry-multi-location') ? 'bg-brand-50 text-brand-700 font-bold' : '' }}">Multi-Location Brands</a>
                <a href="{{ route('industries') }}" class="block px-4 py-3 rounded-xl hover:bg-brand-50 hover:text-brand-700 {{ request()->routeIs('industries','industry.show') ? 'bg-brand-50 text-brand-700 font-bold' : '' }}">Industries</a>
                <a href="{{ route('pricing') }}" class="block px-4 py-3 rounded-xl hover:bg-brand-50 hover:text-brand-700 {{ request()->routeIs('pricing') ? 'bg-brand-50 text-brand-700 font-bold' : '' }}">Pricing</a>
                <a href="{{ route('blog.index') }}" class="block px-4 py-3 rounded-xl hover:bg-brand-50 hover:text-brand-700 {{ request()->routeIs('blog.*') ? 'bg-brand-50 text-brand-700 font-bold' : '' }}">Blog & Insights</a>
                <a href="{{ route('faq') }}" class="block px-4 py-3 rounded-xl hover:bg-brand-50 hover:text-brand-700 {{ request()->routeIs('faq') ? 'bg-brand-50 text-brand-700 font-bold' : '' }}">FAQs</a>
                <div class="pt-2 mt-2 border-t border-slate-100">
                    <div class="px-4 pb-2 text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Free Tools</div>
                    <a href="{{ route('tools.audit') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-50">GBP Audit Checklist</a>
                    <a href="{{ route('tools.review-link') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-50">Direct Review Link</a>
                    <a href="{{ route('tools.review-qr') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-50">Review QR Code</a>
                    <a href="{{ route('tools.review-card') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-50">NFC Smart Card</a>
                    <a href="{{ route('tools.photo-size') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-50">Photo Size Guide</a>
                    <a href="{{ route('tools.character-counter') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-50">Character Counter</a>
                    <a href="{{ route('tools.local-seo') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-50">Local SEO Checklist</a>
                    <a href="{{ route('tools.description-writer') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-50">Description Writer</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Body Content -->
    <main>
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="bg-slate-900 text-white pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
                <!-- Col 1: Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center text-white font-black">
                            ⚡
                        </div>
                        <span class="font-display font-black text-2xl tracking-tight text-white">
                            Untab
                        </span>
                    </div>
                    <p class="text-slate-400 text-xs sm:text-sm leading-relaxed max-w-sm">
                        The Google Business Profile management platform for SEO agencies and multi-location brands. Built by a team that managed 4,000+ local profiles across 15+ countries.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="{{ route('app.dashboard') }}" class="text-xs bg-slate-800 hover:bg-slate-700 text-slate-300 px-3 py-1.5 rounded-lg border border-slate-700 font-semibold">
                            Web Dashboard
                        </a>
                        <span class="text-xs text-slate-500">iOS & Android Compatible</span>
                    </div>
                </div>

                <!-- Col 2: Platform Modules -->
                <div>
                    <h4 class="font-bold text-xs uppercase tracking-widest text-slate-400 mb-4 font-display">
                        Platform Modules
                    </h4>
                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li><a href="{{ route('reviews-management') }}" class="hover:text-white transition-colors">AI Review Replies</a></li>
                        <li><a href="{{ route('posts-management') }}" class="hover:text-white transition-colors">Google Posts Scheduler</a></li>
                        <li><a href="{{ route('app.insights') }}" class="hover:text-white transition-colors">Performance Insights</a></li>
                        <li><a href="{{ route('app.search-console') }}" class="hover:text-white transition-colors">Google Search Console</a></li>
                        <li><a href="{{ route('app.media') }}" class="hover:text-white transition-colors">Media & Photo Geotagging</a></li>
                        <li><a href="{{ route('app.reports') }}" class="hover:text-white transition-colors">White-Label Client Reports</a></li>
                    </ul>
                </div>

                <!-- Col 3: Solutions -->
                <div>
                    <h4 class="font-bold text-xs uppercase tracking-widest text-slate-400 mb-4 font-display">
                        Solutions
                    </h4>
                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li><a href="{{ route('white-label-agency') }}" class="hover:text-white transition-colors">For SEO Agencies</a></li>
                        <li><a href="{{ route('industry-multi-location') }}" class="hover:text-white transition-colors">Multi-Location Brands</a></li>
                        <li><a href="{{ route('industries') }}" class="hover:text-white transition-colors">Industries</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-white transition-colors">Franchise Management</a></li>
                        <li><a href="{{ route('app.team') }}" class="hover:text-white transition-colors">Team & Role Permissions</a></li>
                        <li><a href="{{ route('app.connect') }}" class="hover:text-white transition-colors">Google OAuth Connect</a></li>
                    </ul>
                </div>

                <!-- Col 4: Free Tools -->
                <div>
                    <h4 class="font-bold text-xs uppercase tracking-widest text-slate-400 mb-4 font-display">
                        Free SEO Tools
                    </h4>
                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li><a href="{{ route('tools.audit') }}" class="hover:text-white transition-colors">GBP Audit Health Score</a></li>
                        <li><a href="{{ route('tools.review-link') }}" class="hover:text-white transition-colors">Direct Review Link Gen</a></li>
                        <li><a href="{{ route('tools.review-qr') }}" class="hover:text-white transition-colors">Review QR Code Maker</a></li>
                        <li><a href="{{ route('tools.review-card') }}" class="hover:text-white transition-colors">NFC Tap Card Configurator</a></li>
                        <li><a href="{{ route('tools.photo-size') }}" class="hover:text-white transition-colors">Photo Size & Aspect Ratio</a></li>
                        <li><a href="{{ route('tools.character-counter') }}" class="hover:text-white transition-colors">Post Character Counter</a></li>
                        <li><a href="{{ route('tools.local-seo') }}" class="hover:text-white transition-colors">Local SEO Checklist</a></li>
                        <li><a href="{{ route('tools.description-writer') }}" class="hover:text-white transition-colors">GBP Description Writer</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <div>© {{ date('Y') }} Untab. Built with Laravel 12 & Tailwind CSS. All rights reserved.</div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('app.dashboard') }}" class="hover:text-white">Web App</a>
                    <a href="{{ route('tools.audit') }}" class="hover:text-white">Audit Tool</a>
                    <a href="{{ route('white-label-agency') }}" class="hover:text-white">White Label</a>
                    <a href="{{ route('industries') }}" class="hover:text-white">Industries</a>
                    <a href="{{ route('pricing') }}" class="hover:text-white">Pricing</a>
                    <a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a>
                    <a href="{{ route('faq') }}" class="hover:text-white">FAQ</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
