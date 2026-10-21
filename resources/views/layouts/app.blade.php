<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Peta Batam') }} - Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'Segoe UI', 'sans-serif'],
                    },
                    boxShadow: {
                        soft: '0 18px 45px rgba(15, 23, 42, 0.08)',
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; -webkit-font-smoothing: antialiased; }
        .admin-scrollbar::-webkit-scrollbar { width: 8px; height: 8px; }
        .admin-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
        .admin-scrollbar::-webkit-scrollbar-track { background: transparent; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <div class="min-h-screen lg:flex">
        <aside class="hidden lg:fixed lg:inset-y-0 lg:left-0 lg:z-40 lg:flex lg:w-72 lg:flex-col bg-slate-950 text-white shadow-2xl">
            <div class="flex h-20 items-center gap-3 border-b border-white/10 px-7">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-500 shadow-lg shadow-indigo-500/30">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-extrabold tracking-tight">Peta Batam</p>
                    <p class="text-xs text-slate-400">Admin Dashboard</p>
                </div>
            </div>

            <nav class="admin-scrollbar flex-1 space-y-2 overflow-y-auto px-4 py-6">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    </span>
                    Dashboard
                </a>

                <div class="px-4 pt-5 text-[11px] font-bold uppercase tracking-[0.22em] text-slate-500">Database</div>

                <a href="{{ route('admin.places.index') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.places.*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl {{ request()->routeIs('admin.places.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </span>
                    Destinasi Utama
                </a>

                <a href="{{ route('admin.small-destinations.index') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.small-destinations.*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl {{ request()->routeIs('admin.small-destinations.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L22 12l-6.714 2.143L13 21l-2.286-6.857L4 12l6.714-2.143L13 3z" /></svg>
                    </span>
                    Rekomendasi Destinasi
                </a>

                <a href="{{ route('admin.clusters.index') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.clusters.*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl {{ request()->routeIs('admin.clusters.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </span>
                    Cluster
                </a>

                <div class="px-4 pt-5 text-[11px] font-bold uppercase tracking-[0.22em] text-slate-500">Integration</div>

                <a href="{{ route('admin.itinerary-preview.index') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.itinerary-preview.*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl {{ request()->routeIs('admin.itinerary-preview.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>
                    </span>
                    Preview Itinerary
                </a>
            </nav>

            <div class="border-t border-white/10 p-4">
                <a href="{{ url('/') }}" class="flex items-center justify-center rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                    Lihat Halaman Peta
                </a>
            </div>
        </aside>

        <div class="min-w-0 flex-1 lg:pl-72">
            <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
                <div class="flex min-h-20 flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">Admin Panel</p>
                        <div class="mt-1 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                            @isset($header)
                                {{ $header }}
                            @else
                                Dashboard Admin
                            @endisset
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('admin.places.index') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-indigo-200 hover:text-indigo-600">Destinasi</a>
                        <a href="{{ url('/') }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-600">Buka Peta</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-red-200 hover:text-red-600">Logout</button>
                        </form>
                    </div>
                </div>

                <nav class="flex gap-2 overflow-x-auto border-t border-slate-100 bg-white px-4 py-3 lg:hidden">
                    <a href="{{ route('dashboard') }}" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700' }}">Dashboard</a>
                    <a href="{{ route('admin.places.index') }}" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.places.*') ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700' }}">Destinasi</a>
                    <a href="{{ route('admin.small-destinations.index') }}" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.small-destinations.*') ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700' }}">Rekomendasi</a>
                    <a href="{{ route('admin.clusters.index') }}" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.clusters.*') ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700' }}">Cluster</a>
                </nav>
            </header>

            <main class="admin-scrollbar px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
