<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{ __('Destination Management') }}
            <a href="{{ route('admin.places.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Destination
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-4 mx-4 mt-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">All Destinations ({{ count($places) }})</h3>
            <div class="w-full md:w-72 relative">
                <input type="text" id="searchInput" placeholder="Search destinations..." class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors text-sm">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="destinationsTable">
                <thead>
                    <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4 font-medium">Destination</th>
                        <th class="px-6 py-4 font-medium">Category</th>
                        <th class="px-6 py-4 font-medium">Cluster</th>
                        <th class="px-6 py-4 font-medium text-center">Visit Duration</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($places as $place)
                    <tr class="hover:bg-gray-50/50 transition-colors destination-row">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $place->image ?? 'https://via.placeholder.com/40' }}" alt="{{ $place->name }}" class="w-12 h-12 rounded-lg object-cover shadow-sm border border-gray-100">
                                <div>
                                    <div class="text-sm font-bold text-gray-900 destination-name">{{ $place->name }}</div>
                                    <div class="text-xs text-gray-500 max-w-xs truncate">{{ $place->address }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ \Illuminate\Support\Str::of($place->category)->replace('_', ' ')->title() }}
                            </span>
                            @if($place->subcategory)
                            <span class="ml-1 px-2.5 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-600 border border-gray-200">
                                {{ \Illuminate\Support\Str::of($place->subcategory)->replace('_', ' ')->title() }}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($place->cluster)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-slate-50 text-slate-700 border border-slate-200 destination-cluster">
                                    {{ \Illuminate\Support\Str::of($place->cluster)->replace('_', ' ')->title() }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 italic">Unassigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm text-gray-600 font-medium">{{ $place->visit_duration ?? 60 }} min</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.places.edit', $place->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.places.destroy', $place->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this destination?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 bg-gray-50/50">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <span class="text-base font-medium text-gray-600">No destinations found</span>
                                <span class="text-sm mt-1">Get started by adding your first tourism destination.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Simple client-side search script -->
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('.destination-row');
            
            rows.forEach(row => {
                let name = row.querySelector('.destination-name').textContent.toLowerCase();
                let clusterElem = row.querySelector('.destination-cluster');
                let cluster = clusterElem ? clusterElem.textContent.toLowerCase() : '';
                
                if (name.includes(filter) || cluster.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>