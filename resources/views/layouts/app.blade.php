<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php($seoType = $seoType ?? 'website')
    @php($seoTitle = $seoTitle ?? (trim(View::yieldContent('title')) ?: 'Untab — Google Business App'))
    @php($seoDesc = $seoDesc ?? (trim(View::yieldContent('meta_description')) ?: 'Manage every Google Business Profile from one dashboard. AI review replies, Google Posts, local SEO insights, and white-label client reports.'))
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- QRCode.js -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8faff;
            color: #0f172a;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased selection:bg-brand-500 selection:text-white" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between flex-shrink-0 z-30 transition-all duration-200 hidden md:flex">
            <div>
                <!-- App Logo -->
                <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-brand-500 flex items-center justify-center text-white font-black text-lg shadow-md">
                            ⚡
                        </div>
                        <div>
                            <span class="font-display font-black text-xl text-white tracking-tight">
                                Untab
                            </span>
                            <span class="block text-[8px] font-extrabold tracking-widest text-slate-400 uppercase -mt-0.5">
                                Google Business App
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Client / Location Scope Selector -->
                <div class="p-4 border-b border-slate-800">
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">
                        Current Scope
                    </label>
                    <form method="GET" id="locationFilterForm">
                        <select 
                            name="location_id" 
                            onchange="document.getElementById('locationFilterForm').submit()"
                            class="w-full bg-slate-800 border border-slate-700 text-white text-xs font-semibold rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-500 cursor-pointer"
                        >
                            <option value="all" {{ ($selectedLocationId ?? 'all') == 'all' ? 'selected' : '' }}>
                                🌐 All Locations ({{ isset($allLocations) ? $allLocations->count() : \App\Models\Location::count() }} Profiles)
                            </option>
                            @if(isset($clients))
                                @foreach($clients as $client)
                                    <optgroup label="{{ $client->name }}">
                                        <option value="client-{{ $client->id }}" {{ ($selectedLocationId ?? '') == 'client-'.$client->id ? 'selected' : '' }}>
                                            📁 All {{ $client->name }} ({{ $client->locations->count() }})
                                        </option>
                                        @foreach($client->locations as $loc)
                                            <option value="{{ $loc->id }}" {{ ($selectedLocationId ?? '') == $loc->id ? 'selected' : '' }}>
                                                📍 {{ $loc->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            @endif
                        </select>
                    </form>
                </div>

                <!-- Navigation Links -->
                <nav class="p-3 space-y-1 text-xs font-bold">
                    <a href="{{ route('app.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('app.dashboard') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('app.reviews') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('app.reviews') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <i data-lucide="message-square" class="w-4 h-4"></i>
                            <span>Reviews & AI</span>
                        </div>
                        @php($unanswered = \Illuminate\Support\Facades\Schema::hasTable('reviews') ? \App\Models\Review::where('status', 'unanswered')->count() : 0)
                        @if(($unanswered ?? 0) > 0)
                            <span class="bg-accent-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full">
                                {{ $unanswered }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('app.posts') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('app.posts') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <span>Google Posts</span>
                    </a>

                    <a href="{{ route('app.insights') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('app.insights') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                        <span>GBP Insights</span>
                    </a>

                    <a href="{{ route('app.search-console') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('app.search-console') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        <span>Search Console</span>
                    </a>

                    <a href="{{ route('app.media') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('app.media') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="image" class="w-4 h-4"></i>
                        <span>Media & Geotag</span>
                    </a>

                    <a href="{{ route('app.reports') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('app.reports') ? 'bg-brand-600 text-white shadow-md font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        <span>White-Label Reports</span>
                    </a>

                    <div class="pt-4 mt-2 border-t border-slate-800">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-500 block mb-1">
                            Settings & Access
                        </span>
                        <a href="{{ route('app.team') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('app.team') ? 'bg-brand-600 text-white font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="users" class="w-4 h-4"></i>
                            <span>Team & Permissions</span>
                        </a>
                        <a href="{{ route('app.connect') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('app.connect') ? 'bg-brand-600 text-white font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="link" class="w-4 h-4"></i>
                            <span>Connect Google Accounts</span>
                        </a>
                        <a href="{{ route('app.settings') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('app.settings') ? 'bg-brand-600 text-white font-extrabold' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="settings" class="w-4 h-4"></i>
                            <span>Agency Settings</span>
                        </a>
                    </div>
                </nav>
            </div>

            <!-- Sidebar Bottom Agency Badge -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-brand-700 flex items-center justify-center font-black text-white text-xs">
                            U
                        </div>
                        <div class="truncate">
                            <div class="text-xs font-bold text-white truncate">Untab</div>
                            <div class="text-[10px] text-slate-400">Local Growth Platform</div>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="p-1.5 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800" title="Back to Marketing Site">
                        <i data-lucide="globe" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Global Top Bar -->
            <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger -->
                    <button class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <a href="{{ route('home') }}" class="hover:text-brand-600 flex items-center gap-1">
                            <i data-lucide="home" class="w-3.5 h-3.5"></i> Home
                        </a>
                        <span>/</span>
                        <span class="text-slate-800 font-bold capitalize">
                            {{ str_replace(['app.', '-'], ['', ' '], request()->route()->getName() ?? 'Dashboard') }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isSuperAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold transition-all border border-brand-500 shadow-sm">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Super Admin
                            </a>
                        @endif
                    @endauth
                    <a href="{{ route('tools.audit') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-800 rounded-xl text-xs font-bold transition-all border border-brand-200">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-accent-500"></i> Free SEO Tools
                    </a>
                    <a href="{{ route('home') }}" class="text-xs font-bold text-slate-600 hover:text-brand-700 bg-slate-100 px-3 py-1.5 rounded-xl transition-all flex items-center gap-1">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Marketing Site
                    </a>
                    @auth
                        <!-- Account menu: Change Password + Logout -->
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 rounded-xl pl-1.5 pr-2.5 py-1 transition-all">
                                <span class="w-7 h-7 rounded-full bg-brand-600 text-white text-xs font-black flex items-center justify-center">
                                    {{ strtoupper(auth()->user()->name[0] ?? 'U') }}
                                </span>
                                <span class="hidden sm:block text-xs font-bold text-slate-700 max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                                <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
                            </button>
                            <div x-show="open" x-transition x-cloak class="absolute right-0 top-full mt-2 w-60 bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden z-50">
                                <div class="px-4 py-3 border-b border-slate-100">
                                    <div class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</div>
                                    <div class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email }}</div>
                                </div>
                                <div class="p-1.5">
                                    <button type="button" @click="open = false; $dispatch('open-password-modal')" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-brand-700 transition-colors">
                                        <i data-lucide="key-round" class="w-4 h-4 text-slate-400"></i> Change Password
                                    </button>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-bold text-slate-600 hover:bg-red-50 hover:text-red-600 transition-colors">
                                            <i data-lucide="log-out" class="w-4 h-4 text-slate-400"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Change Password Modal -->
            @auth
            <div x-data="{ open: @json($errors->has('current_password') || $errors->has('new_password') ? true : false) }" @open-password-modal.window="open = true" x-show="open" x-transition class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] flex items-center justify-center p-4" style="display: none;">
                <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl border border-slate-200 overflow-hidden" @click.away="open = false">
                    <div class="bg-gradient-to-r from-brand-700 to-indigo-800 p-5 text-white flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i data-lucide="key-round" class="w-5 h-5 text-accent-500"></i>
                            <div>
                                <h3 class="font-bold text-base font-display">Change Password</h3>
                                <p class="text-[11px] text-brand-200">Update your account password</p>
                            </div>
                        </div>
                        <button @click="open = false" class="text-white text-xl font-bold leading-none">✕</button>
                    </div>
                    <form method="POST" action="{{ route('app.password.update') }}" class="p-6 space-y-4">
                        @csrf
                        @if($errors->has('current_password'))
                            <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-xl px-3 py-2">{{ $errors->first('current_password') }}</div>
                        @endif
                        @if($errors->has('new_password'))
                            <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-xl px-3 py-2">{{ $errors->first('new_password') }}</div>
                        @endif
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Current Password</label>
                            <input type="password" name="current_password" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-brand-500" placeholder="Your current password">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">New Password</label>
                            <input type="password" name="new_password" required minlength="8" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-brand-500" placeholder="At least 8 characters">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" required minlength="8" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-brand-500" placeholder="Repeat new password">
                        </div>
                        <div class="flex gap-2 pt-2">
                            <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-md">Update Password</button>
                            <button type="button" @click="open = false" class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-slate-600 hover:bg-slate-50">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            @endauth

            <!-- Main Scrollable Body with Flash Messages -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <!-- Flash Success Notification -->
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl flex items-center justify-between shadow-sm animate-in fade-in">
                        <div class="flex items-center gap-2.5 text-xs sm:text-sm font-bold">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 flex-shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold text-lg leading-none">
                            ✕
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
