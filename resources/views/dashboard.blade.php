<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard Overview') }}
    </x-slot>

    <div class="space-y-6">
        
        <!-- Welcome Banner -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative">
            <!-- Subtle Top Gradient Accent -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
            
            <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">Batam Tourism Planning & Management</h3>
                    <p class="text-gray-500 text-sm mt-1.5 max-w-2xl leading-relaxed font-medium">
                        Welcome back, <span class="font-bold text-gray-700">{{ Auth::user()->name }}</span>. Manage destinations, organize geographic clusters, and preview itinerary routing logic seamlessly.
                    </p>
                </div>
                <div class="shrink-0 w-full md:w-auto flex flex-col sm:flex-row items-center gap-3">
                    <div class="w-full sm:w-auto px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-semibold text-gray-600 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ now()->format('M j, Y') }}
                    </div>
                    <a href="{{ route('admin.places.create') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-sm shadow-blue-600/20 hover:bg-blue-700 transition-all focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Destination
                    </a>
                </div>
            </div>
        </div>

        <!-- Compact Statistics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            
            <!-- Stat: Total Places -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col justify-between hover:border-blue-200 transition-colors group">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Total</span>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $totalPlaces ?? 0 }}</p>
                    <p class="text-[13px] font-medium text-gray-500 mt-0.5">Destinations</p>
                </div>
            </div>

            <!-- Stat: Attractions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col justify-between hover:border-blue-200 transition-colors group">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Category</span>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $totalAttractions ?? 0 }}</p>
                    <p class="text-[13px] font-medium text-gray-500 mt-0.5">Attractions</p>
                </div>
            </div>

            <!-- Stat: Culinary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col justify-between hover:border-blue-200 transition-colors group">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center group-hover:bg-orange-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Category</span>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $totalCulinary ?? 0 }}</p>
                    <p class="text-[13px] font-medium text-gray-500 mt-0.5">Culinary</p>
                </div>
            </div>

            <!-- Stat: Lodging -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col justify-between hover:border-blue-200 transition-colors group">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Category</span>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $totalAccommodation ?? 0 }}</p>
                    <p class="text-[13px] font-medium text-gray-500 mt-0.5">Accommodation</p>
                </div>
            </div>

            <!-- Stat: Clusters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col justify-between hover:border-blue-200 transition-colors group sm:col-span-2 lg:col-span-1">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Grouping</span>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $totalClusters ?? 0 }}</p>
                    <p class="text-[13px] font-medium text-gray-500 mt-0.5">Active Clusters</p>
                </div>
            </div>
        </div>

        <!-- Recent Destinations Table Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white">
                <div>
                    <h4 class="text-base font-bold text-gray-900">Recently Added Destinations</h4>
                    <p class="text-xs text-gray-500 mt-0.5 font-medium">The latest locations registered in the database.</p>
                </div>
                <a href="{{ route('admin.places.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">View All &rarr;</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-400 text-[11px] uppercase tracking-widest border-b border-gray-100">
                            <th class="px-6 py-4 font-semibold">Destination</th>
                            <th class="px-6 py-4 font-semibold">Category</th>
                            <th class="px-6 py-4 font-semibold hidden md:table-cell">Cluster</th>
                            <th class="px-6 py-4 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentPlaces ?? [] as $place)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $place->image ?? 'https://via.placeholder.com/40' }}" alt="{{ $place->name }}" class="w-9 h-9 rounded-md border border-gray-200 object-cover shrink-0">
                                    <div class="min-w-0">
                                        <div class="text-sm font-bold text-gray-900 truncate">{{ $place->name }}</div>
                                        <div class="text-[12px] font-medium text-gray-500 truncate max-w-[200px] lg:max-w-xs">{{ $place->address }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[11px] font-bold tracking-wide rounded-md bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ \Illuminate\Support\Str::of($place->category)->replace('_', ' ')->title() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                @if($place->cluster)
                                    <span class="px-2.5 py-1 text-[11px] font-bold tracking-wide rounded-md bg-gray-100 text-gray-700 border border-gray-200">
                                        {{ \Illuminate\Support\Str::of($place->cluster)->replace('_', ' ')->title() }}
                                    </span>
                                @else
                                    <span class="text-[11px] font-medium text-gray-400 italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.places.edit', $place->id) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Edit Destination">
                                    <span class="text-xs font-semibold mr-1 hidden sm:inline-block">Edit</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 bg-gray-50/50">
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700">No destinations found</span>
                                    <p class="text-xs text-gray-500 mt-1">Get started by adding your first location to the database.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</x-app-layout>