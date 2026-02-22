@extends('layout.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 shadow rounded-lg mt-10 border-t-4 border-purple-600">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Rekomendasi</h1>
        <a href="{{ route('admin.small-destinations.index') }}" class="text-sm text-gray-500 hover:text-purple-700">&larr; Kembali</a>
    </div>

    @if($errors->any()) 
        <div class="bg-red-50 text-red-700 p-3 rounded mb-4 border border-red-200 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error) 
                    <li>{{ $error }}</li> 
                @endforeach
            </ul>
        </div> 
    @endif

    <form action="{{ route('admin.small-destinations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1 text-gray-700">Nama Destinasi</label>
            <input type="text" name="name" class="w-full border border-gray-300 rounded p-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Contoh: Morning Bakery" required>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Latitude</label>
                <input type="text" name="latitude" class="w-full border border-gray-300 rounded p-2 focus:ring-purple-500 focus:border-purple-500" placeholder="1.xxxx" required>
            </div>
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Longitude</label>
                <input type="text" name="longitude" class="w-full border border-gray-300 rounded p-2 focus:ring-purple-500 focus:border-purple-500" placeholder="104.xxxx" required>
            </div>
        </div>

        <div class="mb-6">
            <label class="block font-semibold mb-1 text-gray-700">Gambar (Opsional)</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG. Maks: 2MB.</p>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t">
            <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-2 rounded-lg transition font-semibold shadow">
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection