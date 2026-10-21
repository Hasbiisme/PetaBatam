<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="space-y-6">
        <div class="flex flex-col gap-4 rounded-3xl bg-gradient-to-r from-slate-950 to-indigo-950 p-6 text-white shadow-soft sm:p-8 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-indigo-200">WebGIS Management</p>
                <h1 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">Kelola data destinasi wisata</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-300">Pantau jumlah destinasi, kategori, cluster, dan data terbaru yang ditampilkan pada halaman peta publik.</p>
            </div>
            <a href="{{ route('admin.places.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/25 transition hover:bg-indigo-400">
                + Tambah Destinasi
            </a>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Total Destinasi</p>
                <div class="mt-3 flex items-end justify-between">
                    <p class="text-4xl font-extrabold text-slate-900">{{ $totalPlaces ?? 0 }}</p>
                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-600">Places</span>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Attractions</p>
                <div class="mt-3 flex items-end justify-between">
                    <p class="text-4xl font-extrabold text-slate-900">{{ $totalAttractions ?? 0 }}</p>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">Wisata</span>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Culinary</p>
                <div class="mt-3 flex items-end justify-between">
                    <p class="text-4xl font-extrabold text-slate-900">{{ $totalCulinary ?? 0 }}</p>
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-600">Kuliner</span>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Accommodation</p>
                <div class="mt-3 flex items-end justify-between">
                    <p class="text-4xl font-extrabold text-slate-900">{{ $totalAccommodation ?? 0 }}</p>
                    <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-bold text-sky-600">Hotel</span>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Cluster Aktif</p>
                <div class="mt-3 flex items-end justify-between">
                    <p class="text-4xl font-extrabold text-slate-900">{{ $totalClusters ?? 0 }}</p>
                    <span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-bold text-violet-600">Group</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900">Ringkasan Data</h2>
                        <p class="mt-1 text-sm text-slate-500">Komposisi data destinasi berdasarkan kategori utama.</p>
                    </div>
                    <a href="{{ route('admin.places.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-indigo-200 hover:text-indigo-600">Kelola Destinasi</a>
                </div>

                <div class="mt-6 space-y-4">
                    @php
                        $maxTotal = max(($totalPlaces ?? 0), 1);
                        $bars = [
                            ['label' => 'Attractions', 'value' => $totalAttractions ?? 0, 'class' => 'bg-emerald-500'],
                            ['label' => 'Culinary', 'value' => $totalCulinary ?? 0, 'class' => 'bg-amber-500'],
                            ['label' => 'Accommodation', 'value' => $totalAccommodation ?? 0, 'class' => 'bg-sky-500'],
                        ];
                    @endphp

                    @foreach($bars as $bar)
                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-bold text-slate-700">{{ $bar['label'] }}</span>
                                <span class="font-semibold text-slate-500">{{ $bar['value'] }} data</span>
                            </div>
                            <div class="h-3 overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full {{ $bar['class'] }}" style="width: {{ min(100, round(($bar['value'] / $maxTotal) * 100)) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900">Data Terbaru</h2>
                        <p class="mt-1 text-sm text-slate-500">5 destinasi terakhir.</p>
                    </div>
                    <a href="{{ route('admin.places.index') }}" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600">Lihat</a>
                </div>

                <div class="mt-6 space-y-3">
                    @forelse($recentPlaces ?? [] as $place)
                        <div class="flex items-center gap-3 rounded-2xl border border-slate-100 p-3 transition hover:border-indigo-100 hover:bg-indigo-50/40">
                            <img src="{{ $place->image ?? 'https://via.placeholder.com/80' }}" alt="{{ $place->name }}" class="h-12 w-12 rounded-xl object-cover border border-slate-100">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-bold text-slate-900">{{ $place->name }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $place->category ?? 'Tanpa kategori' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                            Belum ada data destinasi.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
