@extends('layout.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 shadow rounded-lg mt-10 border-t-4 border-yellow-500">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Rekomendasi</h1>
        <a href="{{ route('admin.small-destinations.index') }}" class="text-sm text-gray-500 hover:text-purple-700">&larr; Batal</a>
    </div>

    <form action="{{ route('admin.small-destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1 text-gray-700">Nama Destinasi</label>
            <input type="text" name="name" value="{{ $destination->name }}" class="w-full border border-gray-300 rounded p-2 focus:ring-purple-500 focus:border-purple-500" required>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Latitude</label>
                <input type="text" name="latitude" value="{{ $destination->latitude }}" class="w-full border border-gray-300 rounded p-2 focus:ring-purple-500 focus:border-purple-500" required>
            </div>
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Longitude</label>
                <input type="text" name="longitude" value="{{ $destination->longitude }}" class="w-full border border-gray-300 rounded p-2 focus:ring-purple-500 focus:border-purple-500" required>
            </div>
        </div>

        <div class="mb-6">
            <label class="block font-semibold mb-1 text-gray-700">Ganti Gambar (Opsional)</label>
            
            @if($destination->image)
                <div class="mb-2">
                    <img src="{{ $destination->image }}" class="h-20 w-auto rounded shadow-sm border p-1">
                </div>
            @endif

            <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
        </div>

        <div class="flex justify-end pt-4 border-t">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition font-semibold shadow">
                Update Data
            </button>
        </div>
    </form>
</div>
@endsection