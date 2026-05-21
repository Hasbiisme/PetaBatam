<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;

class ClusterController extends Controller
{
    public function index()
    {
        // Get places that have a cluster, group them by the cluster name
        $places = Place::whereNotNull('cluster')
                    ->where('cluster', '!=', '')
                    ->orderBy('cluster')
                    ->get();

        $clusters = $places->groupBy(function($item, $key) {
            return strtolower(trim($item->cluster));
        });

        $unassignedCount = Place::whereNull('cluster')->orWhere('cluster', '')->count();

        return view('admin.clusters.index', compact('clusters', 'unassignedCount'));
    }
}
