<!-- Sidebar Component -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-[260px] bg-[#222222] text-gray-300 flex flex-col shadow-2xl lg:shadow-none transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:shrink-0 border-r border-[#2b2b2b]">
    
    <!-- Brand Area -->
    <div class="h-[80px] flex items-center px-6 shrink-0 justify-between lg:justify-start">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-md flex items-center justify-center border-2 border-[#9df038] text-[#9df038]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h1 class="text-lg font-bold tracking-tight text-white uppercase">Batam<span class="font-normal text-gray-400">GIS</span></h1>
        </a>
        
        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4 px-4 space-y-1 no-scrollbar">
        
        <!-- DASHBOARD SECTION -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-[1rem] transition-all mb-4 {{ request()->routeIs('dashboard') ? 'bg-[#9df038] text-black font-bold shadow-[0_0_15px_rgba(157,240,56,0.3)]' : 'text-gray-400 hover:bg-[#2b2b2b] hover:text-white' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-black' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[15px]">Dashboard</span>
        </a>
        
        <div class="text-[11px] font-bold text-[#9df038] uppercase tracking-widest mb-3 mt-8 px-4">Database</div>

        <!-- PLACES -->
        <a href="{{ route('admin.places.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-[1rem] transition-all mb-1 {{ request()->routeIs('admin.places.*') ? 'bg-[#9df038] text-black font-bold shadow-[0_0_15px_rgba(157,240,56,0.3)]' : 'text-gray-400 hover:bg-[#2b2b2b] hover:text-white' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.places.*') ? 'text-black' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="text-[15px]">Destinations</span>
        </a>

        <!-- CLUSTERS -->
        <a href="{{ route('admin.clusters.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-[1rem] transition-all mb-1 {{ request()->routeIs('admin.clusters.*') ? 'bg-[#9df038] text-black font-bold shadow-[0_0_15px_rgba(157,240,56,0.3)]' : 'text-gray-400 hover:bg-[#2b2b2b] hover:text-white' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.clusters.*') ? 'text-black' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <span class="text-[15px]">Clusters</span>
        </a>

        <div class="text-[11px] font-bold text-[#9df038] uppercase tracking-widest mb-3 mt-8 px-4">Integration</div>

        <!-- ITINERARY PREVIEW -->
        <a href="{{ route('admin.itinerary-preview.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-[1rem] transition-all mb-1 {{ request()->routeIs('admin.itinerary-preview.*') ? 'bg-[#9df038] text-black font-bold shadow-[0_0_15px_rgba(157,240,56,0.3)]' : 'text-gray-400 hover:bg-[#2b2b2b] hover:text-white' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.itinerary-preview.*') ? 'text-black' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
            <span class="text-[15px]">Trip Planner</span>
        </a>

        <!-- PUBLIC MAP -->
        <a href="/" target="_blank" class="flex items-center gap-4 px-4 py-3.5 rounded-[1rem] transition-all text-gray-400 hover:bg-[#2b2b2b] hover:text-white group">
            <div class="p-1 rounded bg-[#2b2b2b] group-hover:bg-[#333]">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </div>
            <span class="text-[15px]">Public Map</span>
        </a>

    </nav>
    
    <!-- Footer Area / Theme Toggle Dummy -->
    <div class="p-6 shrink-0 flex items-center justify-between border-t border-[#2b2b2b] mt-auto">
        <span class="text-sm font-medium text-gray-500">Light</span>
        <div class="w-12 h-6 bg-[#9df038] rounded-full flex items-center px-1 justify-end cursor-pointer">
            <div class="w-4 h-4 bg-black rounded-full"></div>
        </div>
        <span class="text-sm font-medium text-white">Dark</span>
    </div>
</aside>
