<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.places.index') }}" class="text-gray-400 hover:text-indigo-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            {{ __('Edit Destination: ') }} <span class="font-normal text-gray-500 ml-1">{{ $place->name }}</span>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.places.update', $place->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Info -->
                <div class="space-y-6 md:col-span-2">
                    <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">Basic Information</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Destination Name</label>
                    <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors" value="{{ old('name', $place->name) }}" required>
                    @error('name')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors" value="{{ old('address', $place->address) }}" required>
                    @error('address')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <!-- Categorization -->
                <div class="space-y-6 md:col-span-2 mt-4">
                    <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">Categorization & Planning</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="main_category" id="main_category" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $main => $subs)
                            <option value="{{ $main }}" {{ old('main_category', $place->category) == $main ? 'selected' : '' }}>{{ $main }}</option>
                        @endforeach
                    </select>
                    @error('main_category')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subcategory</label>
                    <select name="sub_category" id="sub_category" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors" required>
                        <option value="">Select Category First</option>
                    </select>
                    @error('sub_category')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cluster <span class="text-gray-400 font-normal">(e.g., Nagoya, Batam_Centre)</span></label>
                    <input type="text" name="cluster" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors" value="{{ old('cluster', $place->cluster) }}">
                    @error('cluster')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Est. Visit Duration (minutes)</label>
                    <input type="number" name="visit_duration" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors" value="{{ old('visit_duration', $place->visit_duration ?? 60) }}" min="15">
                    @error('visit_duration')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <!-- Map Coordinates -->
                <div class="space-y-6 md:col-span-2 mt-4">
                    <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">Geographic Coordinates</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="text" name="latitude" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors" value="{{ old('latitude', $place->latitude) }}" required>
                    @error('latitude')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="text" name="longitude" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors" value="{{ old('longitude', $place->longitude) }}" required>
                    @error('longitude')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <!-- Media & Description -->
                <div class="space-y-6 md:col-span-2 mt-4">
                    <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">Media & Description</h3>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors">{{ old('description', $place->description) }}</textarea>
                    @error('description')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                    @if($place->image)
                        <div class="mb-3">
                            <img src="{{ $place->image }}" alt="Current Image" class="h-32 rounded-lg object-cover border border-gray-200 shadow-sm">
                            <p class="text-xs text-gray-500 mt-1">Current image uploaded.</p>
                        </div>
                    @endif
                    <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                    <p class="text-xs text-gray-400 mt-1">Upload a new image to replace the current one.</p>
                    @error('image')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.places.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">Cancel</a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors shadow-sm">Update Destination</button>
            </div>
        </form>
    </div>

    <!-- Script untuk dinamis dropdown subkategori -->
    <script>
        const categories = @json($categories);
        const mainCatSelect = document.getElementById('main_category');
        const subCatSelect = document.getElementById('sub_category');
        const oldSub = "{{ old('sub_category', $place->subcategory) }}";

        function updateSubcategories() {
            const main = mainCatSelect.value;
            subCatSelect.innerHTML = '<option value="">Select Subcategory</option>';
            if(main && categories[main]) {
                categories[main].forEach(sub => {
                    let option = document.createElement('option');
                    option.value = sub;
                    option.textContent = sub;
                    if(oldSub === sub) option.selected = true;
                    subCatSelect.appendChild(option);
                });
            }
        }

        mainCatSelect.addEventListener('change', updateSubcategories);
        if(mainCatSelect.value) updateSubcategories();
    </script>
</x-app-layout>
