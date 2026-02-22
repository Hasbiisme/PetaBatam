<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller; // <-- PENTING: Pakai Routing Controller
use Illuminate\Http\Request;
use App\Models\SmallDestination; // <-- Pastikan Model ini ada

class SmallDestinationController extends Controller
{
    // 1. Tampilkan Daftar (Index)
    public function index()
    {
        $destinations = SmallDestination::all();
        return view('admin.small_destinations.index', compact('destinations'));
    }

    // 2. Tampilkan Form Tambah (Create)
    public function create()
    {
        return view('admin.small_destinations.create');
    }

    // 3. Simpan Data (Store)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|max:2048'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Kita simpan di folder khusus 'uploads_small' agar rapi
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads_small'), $filename);
            $imageName = '/uploads_small/' . $filename;
        }

        SmallDestination::create([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.small-destinations.index')
                         ->with('success', 'Destinasi rekomendasi berhasil ditambahkan.');
    }

    // 4. Tampilkan Form Edit (Edit)
    public function edit($id)
    {
        $destination = SmallDestination::findOrFail($id);
        return view('admin.small_destinations.edit', compact('destination'));
    }

    // 5. Update Data (Update)
    public function update(Request $request, $id)
    {
        $destination = SmallDestination::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['name', 'latitude', 'longitude']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($destination->image && file_exists(public_path($destination->image))) {
                unlink(public_path($destination->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads_small'), $filename);
            $data['image'] = '/uploads_small/' . $filename;
        }

        $destination->update($data);

        return redirect()->route('admin.small-destinations.index')
                         ->with('success', 'Data berhasil diperbarui.');
    }

    // 6. Hapus Data (Destroy)
    public function destroy($id)
    {
        $destination = SmallDestination::findOrFail($id);
        
        if ($destination->image && file_exists(public_path($destination->image))) {
            unlink(public_path($destination->image));
        }

        $destination->delete();

        return redirect()->route('admin.small-destinations.index')
                         ->with('success', 'Data berhasil dihapus.');
    }
}