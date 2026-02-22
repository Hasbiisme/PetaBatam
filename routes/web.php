<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\SmallDestinationController;
use App\Http\Controllers\ProfileController; // <--- PENTING: Jangan lupa ini!

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Depan (Publik)
Route::get('/', [MapController::class, 'showMap']);

// 2. Dashboard (Login Required)
Route::get('/dashboard', function () {
    // (Opsional: Tambahkan logika statistik di sini jika mau)
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Rute Profile (YANG HILANG TADI)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. Rute Admin Places (Login Required)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/places', [PlaceController::class, 'index'])->name('admin.places.index');
    Route::get('/places/create', [PlaceController::class, 'create'])->name('admin.places.create');
    Route::post('/places', [PlaceController::class, 'store'])->name('admin.places.store');
    Route::get('/places/{place}/edit', [PlaceController::class, 'edit'])->name('admin.places.edit');
    Route::put('/places/{place}', [PlaceController::class, 'update'])->name('admin.places.update');
    Route::delete('/places/{place}', [PlaceController::class, 'destroy'])->name('admin.places.destroy');
    // ▼▼▼ TAMBAHKAN BLOK INI UNTUK SMALL DESTINATIONS ▼▼▼
    Route::get('/small-destinations', [SmallDestinationController::class, 'index'])->name('admin.small-destinations.index');
    Route::get('/small-destinations/create', [SmallDestinationController::class, 'create'])->name('admin.small-destinations.create');
    Route::post('/small-destinations', [SmallDestinationController::class, 'store'])->name('admin.small-destinations.store');
    Route::get('/small-destinations/{id}/edit', [SmallDestinationController::class, 'edit'])->name('admin.small-destinations.edit');
    Route::put('/small-destinations/{id}', [SmallDestinationController::class, 'update'])->name('admin.small-destinations.update');
    Route::delete('/small-destinations/{id}', [SmallDestinationController::class, 'destroy'])->name('admin.small-destinations.destroy');
    // ▲▲▲ BATAS AKHIR ▲▲▲
});

require __DIR__.'/auth.php';