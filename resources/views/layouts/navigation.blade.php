<!-- Sidebar Component -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white flex flex-col shadow-2xl lg:shadow-none transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:shrink-0 border-r border-slate-800">
    
    <!-- Brand Area -->
    <div class="h-[73px] flex items-center px-6 border-b border-slate-800/80 bg-slate-900 shrink-0 justify-between lg:justify-start">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h1 class="text-lg font-bold tracking-tight text-white">Batam<span class="font-normal text-slate-400">GIS</span></h1>
        </a>
        
        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1 no-scrollbar">
        
        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3 px-3">Overview</div>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'bg-slate-800/80 text-white font-medium border-l-2 border-blue-500' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white border-l-2 border-transparent' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-sm">Dashboard</span>
        </a>
        
        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3 mt-8 px-3">Database</div>

        <a href="{{ route('admin.places.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.places.*') ? 'bg-slate-800/80 text-white font-medium border-l-2 border-blue-500' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white border-l-2 border-transparent' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.places.*') ? 'text-blue-400' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="text-sm">Destinations</span>
        </a>

        <a href="{{ route('admin.clusters.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.clusters.*') ? 'bg-slate-800/80 text-white font-medium border-l-2 border-blue-500' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white border-l-2 border-transparent' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.clusters.*') ? 'text-blue-400' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <span class="text-sm">Clusters</span>
        </a>

        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3 mt-8 px-3">Planning Tools</div>

        <a href="{{ route('admin.itinerary-preview.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.itinerary-preview.*') ? 'bg-slate-800/80 text-white font-medium border-l-2 border-blue-500' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white border-l-2 border-transparent' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.itinerary-preview.*') ? 'text-blue-400' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
            <span class="text-sm">Itinerary Preview</span>
        </a>

        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3 mt-8 px-3">Links</div>

        <a href="/" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all text-slate-400 hover:bg-slate-800/50 hover:text-white border-l-2 border-transparent group">
            <svg class="w-5 h-5 text-slate-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            <span class="text-sm">Public Map View</span>
        </a>

    </nav>
    
    <!-- Footer Area -->
    <div class="p-4 bg-slate-900/50 border-t border-slate-800/80 text-[11px] font-medium text-slate-500 flex justify-between items-center shrink-0">
        <span>&copy; 2026 BatamGIS</span>
        <span class="px-1.5 py-0.5 rounded bg-slate-800 text-slate-400">v2.1</span>
    </div>
</aside>
