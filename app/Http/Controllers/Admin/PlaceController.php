<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\SmallDestination;

class PlaceController extends Controller
{
    // Tampilkan daftar semua tempat
    public function index() {
        $places = Place::all();
        return view('admin.index', compact('places'));
    }

    // Tampilkan form create
    public function create() {
        // Kita bisa kirim kategori/subkategori default agar dropdown dinamis
        $categories = [
            'Accommodation' => ['Apartment','Hotel','Villa','Resort'],
            'Food & Beverages' => ['Restaurant','Coffee Shop','Cafeteria','Other FB Services'],
            'Public Information' => ['Hospital','Police Station','Bank'],
            'Attraction' => ['Mall','Nature Attraction','Heritage Site']
        ];
        return view('admin.create', compact('categories'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'main_category' => 'required|string',
            'sub_category' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $imageName);
            $imageName = '/uploads/' . $imageName;
        }

        Place::create([
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'category' => $request->main_category,
            'sub_category' => $request->sub_category,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.places.index')->with('success', 'Data tempat berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit(Place $place) {
        $categories = [
            'Accommodation' => ['Apartment','Hotel','Villa','Resort'],
            'Food & Beverages' => ['Restaurant','Coffee Shop','Cafeteria','Other FB Services'],
            'Public Information' => ['Hospital','Police Station','Bank'],
            'Attraction' => ['Mall','Nature Attraction','Heritage Site']
        ];
        return view('admin.edit', compact('place','categories'));
    }

    // Update data
    public function update(Request $request, Place $place) {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'main_category' => 'required|string',
            'sub_category' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['name','address','latitude','longitude','main_category','sub_category','description']);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['image'] = '/uploads/' . $filename;
        }

        $place->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'description' => $data['description'],
            'category' => $data['main_category'],
            'sub_category' => $data['sub_category'],
            'image' => $data['image'] ?? $place->image
        ]);

        return redirect()->route('admin.places.index')->with('success','Data berhasil diupdate');
    }

    // Hapus data
    public function destroy(Place $place) {
        // Hapus file gambar jika ada
        if($place->image && file_exists(public_path($place->image))){
            unlink(public_path($place->image));
        }

        $place->delete();
        return redirect()->route('admin.places.index')->with('success','Data berhasil dihapus');
    }
}
