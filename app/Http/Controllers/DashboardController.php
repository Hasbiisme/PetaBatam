<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Calculate Statistics
        $totalPlaces = Place::count();
        $totalAttractions = Place::where('category', 'LIKE', '%Attraction%')->count();
        $totalCulinary = Place::where('category', 'LIKE', '%Food%')->orWhere('category', 'LIKE', '%Culinary%')->count();
        $totalAccommodation = Place::where('category', 'LIKE', '%Accommodation%')->count();
        
        $totalClusters = Place::whereNotNull('cluster')->distinct('cluster')->count('cluster');

        // Fetch recent places
        $recentPlaces = Place::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalPlaces', 
            'totalAttractions', 
            'totalCulinary', 
            'totalAccommodation', 
            'totalClusters',
            'recentPlaces'
        ));
    }
}
