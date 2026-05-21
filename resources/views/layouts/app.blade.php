<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Batam Tourism Management</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Alpine (if needed for components) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            body { font-family: 'Inter', sans-serif; }
            /* Hide scrollbar for cleaner look but keep functionality */
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             style="display: none;"
             class="fixed inset-0 z-40 bg-gray-900/60 backdrop-blur-sm lg:hidden" 
             @click="sidebarOpen = false" 
             x-transition:enter="transition-opacity ease-linear duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0"></div>

        <!-- Sidebar -->
        @include('layouts.navigation')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden bg-gray-50/50">
            <!-- Topbar -->
            <header class="bg-white/80 backdrop-blur-md border-b border-gray-200/80 px-6 sm:px-8 py-4 flex justify-between items-center z-10 shrink-0">
                <div class="flex items-center gap-4">
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-900 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <!-- Page Header Title -->
                    @isset($header)
                        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 tracking-tight hidden sm:block">
                            {{ $header }}
                        </h2>
                    @endisset
                </div>

                <!-- User Menu -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-sm border border-blue-100">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:flex flex-col">
                            <span class="text-sm font-semibold text-gray-800 leading-none">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-gray-500 font-medium tracking-wide uppercase mt-1">Administrator</span>
                        </div>
                    </div>
                    
                    <div class="h-6 w-px bg-gray-200 mx-1"></div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600 transition-colors flex items-center gap-2" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Scrollable Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
