<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php($seoType = $seoType ?? 'website')
    @php($seoTitle = $seoTitle ?? (trim(View::yieldContent('title')) ?: 'Untab — SaaS Admin Panel'))
    @php($seoDesc = $seoDesc ?? (trim(View::yieldContent('meta_description')) ?: 'Super Admin panel for the Untab Google Business Profile SaaS platform.'))
    @php($seoRobots = $seoRobots ?? 'noindex, nofollow')
    @include('partials.seo')

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f4ff', 100: '#e0eaff', 200: '#c3d5fb', 300: '#a5b4fc',
                            400: '#7a8cf5', 500: '#5666e8', 600: '#3d47e0', 700: '#2c36ad',
                            800: '#1e1b4b', 900: '#0f172a',
                        },
                        accent: { 50: '#e8fbff', 300: '#7dd3fc', 400: '#5ecbfa', 500: '#38bdf8', 600: '#0ea5e9', 700: '#0284c7' }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Poppins"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Chart.js (for admin dashboard charts) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => { if (window.lucide) lucide.createIcons(); });
    </script>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-900 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-950 text-white flex-col flex-shrink-0 hidden md:flex sticky top-0 h-screen overflow-y-auto">
            <div class="p-5 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-brand-500 flex items-center justify-center shadow-md">@include('partials.brand-mark', ['class' => 'w-6 h-6'])</div>
                    <div>
                        <span class="font-display font-black text-xl text-white tracking-tight">Untab</span>
                        <span class="block text-[8px] font-extrabold tracking-widest text-brand-300 uppercase">One dashboard. Zero tabs.</span>
                    </div>
                </a>
            </div>

            <nav class="p-3 space-y-1 text-xs font-bold">
                <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-500 block mb-1">Platform</span>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('admin.clients.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.clients.*') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="building-2" class="w-4 h-4"></i><span>Brands &amp; Clients</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="users" class="w-4 h-4"></i><span>Users &amp; Roles</span>
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.blogs.*') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="newspaper" class="w-4 h-4"></i><span>Blog Management</span>
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.faqs.*') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="help-circle" class="w-4 h-4"></i><span>FAQ Management</span>
                </a>
                <a href="{{ route('admin.seo.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.seo.*') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="search" class="w-4 h-4"></i><span>SEO Guidelines</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.settings') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="settings" class="w-4 h-4"></i><span>Platform Settings</span>
                </a>

                <div class="pt-4 mt-2 border-t border-slate-800">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-500 block mb-1">Back to App</span>
                    <a href="{{ route('app.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition-all hover:bg-slate-800 hover:text-white">
                        <i data-lucide="arrow-left-right" class="w-4 h-4"></i><span>Go to GBP App</span>
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition-all hover:bg-slate-800 hover:text-white">
                        <i data-lucide="globe" class="w-4 h-4"></i><span>Marketing Site</span>
                    </a>
                </div>
            </nav>

            <div class="p-4 mt-auto border-t border-slate-800 bg-slate-950/50">
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-brand-700 flex items-center justify-center font-black text-white text-xs uppercase">
                        {{ auth()->user()->name[0] ?? 'U' }}
                    </div>
                    <div class="truncate">
                        <div class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-brand-300 font-bold uppercase">{{ auth()->user()->roleLabel() }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="md:hidden w-9 h-9 rounded-xl bg-brand-500 flex items-center justify-center">@include('partials.brand-mark', ['class' => 'w-6 h-6'])</div>
                    <div>
                        <h1 class="text-lg font-black font-display text-slate-900">@yield('page_title', 'SaaS Admin Panel')</h1>
                        @hasSection('page_subtitle')
                            <p class="text-xs text-slate-400 font-bold mt-0.5">@yield('page_subtitle')</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-50 text-brand-800 rounded-xl text-xs font-bold border border-brand-200">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Super Admin
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-slate-600 hover:text-red-600 bg-slate-100 px-3 py-1.5 rounded-xl transition-all flex items-center gap-1">
                            <i data-lucide="log-out" class="w-3.5 h-3.5"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-2.5 text-xs sm:text-sm font-bold">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 flex-shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold text-lg leading-none">✕</button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-2xl text-xs sm:text-sm font-bold">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
