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
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef1ff', 100: '#e0e7ff', 200: '#c5d0ff', 300: '#a5b4fc',
                            400: '#818cf8', 500: '#6161ff', 600: '#4b4be0', 700: '#2547e0',
                            800: '#1a35c8', 900: '#0f1f8a',
                        },
                        accent: { 500: '#f97316', 600: '#ea580c' }
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
    <!-- Chart.js (for admin dashboard charts) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => { if (window.lucide) lucide.createIcons(); });
    </script>
</head>
<body class="bg-slate-100 text-slate-900 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-950 text-white flex-col flex-shrink-0 hidden md:flex sticky top-0 h-screen overflow-y-auto">
            <div class="p-5 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-brand-500 flex items-center justify-center text-white font-black text-lg shadow-md">⚡</div>
                    <div>
                        <span class="font-display font-black text-xl text-white tracking-tight">Untab</span>
                        <span class="block text-[8px] font-extrabold tracking-widest text-brand-300 uppercase">SaaS Admin</span>
                    </div>
                </a>
            </div>

            @php
                $adminNav = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'pattern' => 'admin.dashboard'],
                    ['route' => 'admin.clients.index', 'label' => 'Brands & Clients', 'icon' => 'building-2', 'pattern' => 'admin.clients.*'],
                    ['route' => 'admin.users.index', 'label' => 'Users & Roles', 'icon' => 'users', 'pattern' => 'admin.users.*'],
                    ['route' => 'admin.blogs.index', 'label' => 'Blog Management', 'icon' => 'newspaper', 'pattern' => 'admin.blogs.*'],
                    ['route' => 'admin.faqs.index', 'label' => 'FAQ Management', 'icon' => 'help-circle', 'pattern' => 'admin.faqs.*'],
                    ['route' => 'admin.seo.index', 'label' => 'SEO Guidelines', 'icon' => 'search', 'pattern' => 'admin.seo.*'],
                    ['route' => 'admin.settings', 'label' => 'Platform Settings', 'icon' => 'settings', 'pattern' => 'admin.settings'],
                ];
            @endphp
            <nav class="p-3 space-y-1 text-xs font-bold">
                <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-500 block mb-1">Platform</span>
                @foreach($adminNav ?? [] as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs($item['pattern']) ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach

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
                    <div class="md:hidden w-9 h-9 rounded-xl bg-brand-500 flex items-center justify-center text-white font-black text-lg">⚡</div>
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
