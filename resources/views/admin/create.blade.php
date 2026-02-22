@extends('layout.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 shadow rounded-lg mt-10">
    <h1 class="text-2xl font-bold mb-4">Tambah Tempat</h1>

    @if($errors->any()) 
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error) 
                    <li>{{ $error }}</li> 
                @endforeach
            </ul>
        </div> 
    @endif

    <form action="{{ route('admin.places.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nama</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Alamat</label>
            <input type="text" name="address" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Latitude</label>
            <input type="text" name="latitude" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Longitude</label>
            <input type="text" name="longitude" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="description" class="w-full border rounded p-2" rows="3"></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori Utama</label>
            <select name="main_category" id="main_category" class="w-full border rounded p-2" required>
                <option value="">Pilih Kategori</option>
                <option value="accommodation">Accommodation</option>
                <option value="food_beverages">Food Beverages</option>
                <option value="public_information">Public Information</option>
                <option value="attraction">Attraction</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Sub Kategori</label>
            <select name="sub_category" id="sub_category" class="w-full border rounded p-2" required>
                <option value="">Pilih Sub Kategori</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Gambar</label>
            <input type="file" name="image" class="w-full border rounded p-2">
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('admin.places.index') }}" class="ml-2 text-gray-600">Batal</a>
        </div>
    </form>
</div>

<script>
    const subCategories = {
        accommodation: ['Apartment', 'Hotel', 'Villa', 'Resort'],
        food_beverages: ['Restaurant', 'Coffee Shop', 'Cafetaria', 'Other FB Services'],
        public_information: ['Hospital', 'Police Station', 'Bank'],
        attraction: ['Mall', 'Nature Attraction', 'Heritage Site']
    };

    const mainSelect = document.getElementById('main_category');
    const subSelect = document.getElementById('sub_category');

    mainSelect.addEventListener('change', function() {
        subSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
        const items = subCategories[this.value] || [];
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.toLowerCase().replace(/ /g, '_');
            option.text = item;
            subSelect.appendChild(option);
        });
    });
</script>
@endsection
