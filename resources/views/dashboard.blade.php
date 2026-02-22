<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-purple-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-600">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-purple-700">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-600 text-sm mt-1">Anda berada di panel kontrol Tourism Map Batam.</p>
                    </div>
                    <a href="{{ route('admin.places.create') }}" class="hidden md:inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                        + Tambah Tempat Baru
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Destinasi</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalPlaces ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.places.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">Lihat semua tempat &rarr;</a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Kategori Utama</p>
                            <p class="text-2xl font-bold text-gray-800">4</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Accommodation</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Attraction</span>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Status Admin</p>
                            <p class="text-lg font-bold text-green-600">Active</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs text-gray-400">Login terakhir: {{ now()->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4">Destinasi Terbaru Ditambahkan</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-purple-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">Nama Tempat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-purple-800 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentPlaces ?? [] as $place)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $place->image ?? 'https://via.placeholder.com/40' }}" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $place->name }}</div>
                                                <div class="text-sm text-gray-500 truncate w-32">{{ $place->address }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            {{ \Illuminate\Support\Str::of($place->category)->replace('_', ' ')->title() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $place->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.places.edit', $place->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data tempat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.places.index') }}" class="text-sm font-semibold text-purple-700 hover:text-purple-900">Lihat Semua Data &rarr;</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>