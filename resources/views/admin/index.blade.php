@extends('layout.app')

@section('content')
<div class="p-4">
    <div class="topbar bg-white shadow rounded mb-4 p-3 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 text-purple-700 fw-bold">Daftar Tempat Utama</h4>
        <a href="{{ route('admin.places.create') }}" class="btn btn-primary btn-sm fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> Tambah Tempat
        </a>
    </div>

    <div class="content-container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($places as $place)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden hover-shadow">
                        <img src="{{ $place->image ?? 'https://via.placeholder.com/300x200.png?text=No+Image' }}" alt="{{ $place->name }}" class="card-img-top object-fit-cover" style="height:200px;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-purple-700">{{ $place->name }}</h5>
                            <p class="card-text mb-2"><strong>Alamat:</strong> {{ $place->address }}</p>
                            <div class="mb-2">
                                <span class="badge bg-purple-100 text-purple-800 me-1">{{ \Illuminate\Support\Str::of($place->category)->replace('_', ' ')->title() }}</span>
                                <span class="badge bg-purple-200 text-purple-900">{{ \Illuminate\Support\Str::of($place->subcategory)->replace('_', ' ')->title() }}</span>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('admin.places.edit', $place->id) }}" class="btn btn-outline-warning btn-sm fw-semibold"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                                <form action="{{ route('admin.places.destroy', $place->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash me-1"></i> Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center shadow-sm rounded">Belum ada data tempat.</div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
        transition: all 0.3s ease-in-out;
    }
    .object-fit-cover { object-fit: cover; width: 100%; }
    .badge { font-size: 0.8rem; padding: 0.4em 0.6em; border-radius: 0.5rem; }
    .bg-purple-100 { background-color: #e9d8fd !important; }
    .bg-purple-200 { background-color: #d6bcfa !important; }
    .text-purple-700 { color: #6b21a8 !important; }
    .text-purple-800 { color: #5b21b6 !important; }
    .text-purple-900 { color: #4c1d95 !important; }
    .content-container { padding: 30px; }
    .topbar { padding: 0 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
</style>
@endsection