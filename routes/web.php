<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\SmallDestinationController;
use App\Http\Controllers\Admin\ClusterController;
use App\Http\Controllers\Admin\ItineraryPreviewController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Depan (Publik)
Route::get('/', [MapController::class, 'showMap']);


Route::post('/generate-trip', [TripController::class, 'generateTrip']);
Route::get('/trip/categories', [TripController::class, 'getCategories']);

// 2. Dashboard (Login Required)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// 3. Rute Profile
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

    // Clusters
    Route::get('/clusters', [ClusterController::class, 'index'])->name('admin.clusters.index');

    // Itinerary Preview
    Route::get('/itinerary-preview', [ItineraryPreviewController::class, 'index'])->name('admin.itinerary-preview.index');

    // Small Destinations
    Route::get('/small-destinations', [SmallDestinationController::class, 'index'])->name('admin.small-destinations.index');
    Route::get('/small-destinations/create', [SmallDestinationController::class, 'create'])->name('admin.small-destinations.create');
    Route::post('/small-destinations', [SmallDestinationController::class, 'store'])->name('admin.small-destinations.store');
    Route::get('/small-destinations/{id}/edit', [SmallDestinationController::class, 'edit'])->name('admin.small-destinations.edit');
    Route::put('/small-destinations/{id}', [SmallDestinationController::class, 'update'])->name('admin.small-destinations.update');
    Route::delete('/small-destinations/{id}', [SmallDestinationController::class, 'destroy'])->name('admin.small-destinations.destroy');
});

require __DIR__.'/auth.php';