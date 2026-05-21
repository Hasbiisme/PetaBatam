<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{ __('Cluster Management') }}
            <a href="{{ route('admin.places.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition-colors shadow-sm">
                View All Destinations
            </a>
        </div>
    </x-slot>

    <div class="mb-6 bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Geographic Clusters</h3>
            <p class="text-sm text-gray-500 mt-1">Clusters group destinations together to help the Trip Planner create efficient, logical itineraries without excessive travel time.</p>
        </div>
        <div class="text-right">
            <div class="text-2xl font-bold text-indigo-600">{{ $clusters->count() }}</div>
            <div class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Active Clusters</div>
        </div>
    </div>

    @if($unassignedCount > 0)
    <div class="mb-6 bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-4">
        <div class="p-2 bg-amber-100 text-amber-600 rounded-lg shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <h4 class="text-sm font-bold text-amber-800">Unassigned Destinations</h4>
            <p class="text-sm text-amber-700 mt-1">There are <strong>{{ $unassignedCount }}</strong> destinations without an assigned cluster. Edit these destinations in the <a href="{{ route('admin.places.index') }}" class="underline font-semibold hover:text-amber-900">Destinations page</a> to include them in the Trip Planner logic.</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($clusters as $clusterName => $group)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h4 class="text-lg font-bold text-indigo-900 capitalize flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ \Illuminate\Support\Str::of($clusterName)->replace('_', ' ')->title() }}
                    </h4>
                    <span class="px-2.5 py-1 text-xs font-bold bg-indigo-100 text-indigo-700 rounded-full">{{ $group->count() }} places</span>
                </div>
                
                <div class="p-0 flex-1 overflow-y-auto max-h-80">
                    <ul class="divide-y divide-gray-50">
                        @foreach($group as $place)
                        <li class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $place->name }}</p>
                                    <div class="flex gap-2 mt-1 flex-wrap">
                                        <span class="text-[10px] uppercase tracking-wider font-semibold text-gray-500">{{ $place->category }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('admin.places.edit', $place->id) }}" class="text-xs text-indigo-600 hover:text-indigo-900 font-medium whitespace-nowrap bg-indigo-50 px-2 py-1 rounded">Edit</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-12 text-center rounded-xl shadow-sm border border-gray-100">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="text-lg font-bold text-gray-700">No Clusters Configured</h3>
                <p class="text-gray-500 mt-2 max-w-md mx-auto">You have not assigned any destinations to a cluster yet. Edit a destination and add a cluster name (like "Nagoya" or "Barelang") to start organizing them.</p>
                <a href="{{ route('admin.places.index') }}" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">Go to Destinations</a>
            </div>
        @endforelse
    </div>
</x-app-layout>
