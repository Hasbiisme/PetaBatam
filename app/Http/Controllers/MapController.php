<?php

namespace App\Http\Controllers;

// ▼▼▼ GANTI BARIS INI ▼▼▼
use Illuminate\Routing\Controller;
// ▲▲▲ BATAS PERUBAHAN ▲▲▲

// Import Model yang kita butuhkan
use App\Models\Place;
use App\Models\SmallDestination;

class MapController extends Controller
{
    /**
     * Menampilkan halaman peta utama.
     */
    public function showMap()
    {
        // 1. Ambil SEMUA data dari database
        $places = Place::all(); 
        $smallDestinations = SmallDestination::all();

        // 2. KIRIM data itu ke 'view' welcome
        return view('welcome', [
            'places' => $places,
            'smallDestinations' => $smallDestinations
        ]);
    }
}