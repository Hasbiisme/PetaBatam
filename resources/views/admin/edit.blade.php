@extends('layout.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 shadow rounded-lg mt-10">
    <h1 class="text-2xl font-bold mb-4">Edit Tempat</h1>

    <form action="{{ route('admin.places.update', $place->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nama</label>
            <input type="text" name="name" class="w-full border rounded p-2" value="{{ $place->name }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Alamat</label>
            <input type="text" name="address" class="w-full border rounded p-2" value="{{ $place->address }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Latitude</label>
            <input type="text" name="latitude" class="w-full border rounded p-2" value="{{ $place->latitude }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Longitude</label>
            <input type="text" name="longitude" class="w-full border rounded p-2" value="{{ $place->longitude }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="description" class="w-full border rounded p-2" rows="3">{{ $place->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori Utama</label>
            <select name="main_category" id="main_category" class="w-full border rounded p-2" required>
                <option value="">Pilih Kategori</option>
                <option value="accommodation" {{ $place->category=='accommodation'?'selected':'' }}>Accommodation</option>
                <option value="food_beverages" {{ $place->category=='food_beverages'?'selected':'' }}>Food Beverages</option>
                <option value="public_information" {{ $place->category=='public_information'?'selected':'' }}>Public Information</option>
                <option value="attraction" {{ $place->category=='attraction'?'selected':'' }}>Attraction</option>
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
            @if($place->image)
                <img src="{{ $place->image }}" alt="{{ $place->name }}" class="w-48 mt-2 rounded">
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Update</button>
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

    function populateSubCategories(selectedValue) {
        subSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
        const items = subCategories[selectedValue] || [];
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.toLowerCase().replace(/ /g, '_');
            option.text = item;
            if("{{ $place->sub_category }}" === option.value) option.selected = true;
            subSelect.appendChild(option);
        });
    }

    mainSelect.addEventListener('change', function() {
        populateSubCategories(this.value);
    });

    // Inisialisasi saat halaman load
    populateSubCategories(mainSelect.value);
</script>
@endsection
