@extends('layout.app')

@section('content')
<div class="p-4">
    <div class="topbar bg-white shadow rounded mb-4 p-3 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 text-purple-700 fw-bold">Daftar Rekomendasi Destinasi</h4>
        <a href="{{ route('admin.small-destinations.create') }}" class="btn btn-primary btn-sm fw-semibold" style="background-color: #6b21a8; border-color: #6b21a8;">
            <i class="bi bi-plus-circle me-1"></i> Tambah Destinasi
        </a>
    </div>

    <div class="content-container">
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif
        
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($destinations as $item)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden hover-shadow">
                        <div class="position-relative" style="height: 150px;">
                            <img src="{{ $item->image ?? 'https://via.placeholder.com/300x200.png?text=No+Image' }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-100 h-100 object-fit-cover">
                        </div>

                        <div class="card-body p-3">
                            <h6 class="card-title fw-bold text-purple-700 mb-1">{{ $item->name }}</h6>
                            
                            <div class="text-muted small mb-3" style="font-size: 0.8rem;">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="bi bi-geo-alt me-1 text-purple-500"></i> 
                                    <span>Lat: {{ number_format($item->latitude, 4) }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo me-1 text-purple-500"></i> 
                                    <span>Lng: {{ number_format($item->longitude, 4) }}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between border-top pt-3">
                                <a href="{{ route('admin.small-destinations.edit', $item->id) }}" class="btn btn-sm btn-light text-purple-700 fw-bold">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.small-destinations.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger fw-bold" onclick="return confirm('Hapus destinasi ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light text-center border shadow-sm rounded py-5">
                        <i class="bi bi-map text-muted fs-1 mb-3 d-block"></i>
                        <p class="mb-0 text-muted">Belum ada data rekomendasi destinasi.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(107, 33, 168, 0.15) !important; /* Ungu shadow */
        transition: all 0.3s ease-in-out;
    }
    .object-fit-cover { object-fit: cover; }
    .text-purple-700 { color: #6b21a8 !important; }
    .text-purple-500 { color: #a855f7 !important; }
    .content-container { padding: 10px; }
</style>
@endsection