<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;

class TripController extends Controller
{
    /**
     * Return all distinct, usable categories for the Trip Planner form.
     * Excludes 'Public Information' as it is not relevant for itinerary planning.
     */
    public function getCategories()
    {
        $excluded = ['Public Information'];

        $categories = Place::select('category')
            ->distinct()
            ->whereNotIn('category', $excluded)
            ->orderBy('category')
            ->pluck('category');

        return response()->json($categories);
    }

    /**
     * Generate a cluster-organised tourism itinerary.
     *
     * Request params:
     *   - categories[]   : array of selected categories (e.g. ['Attraction', 'Food & Beverages'])
     *                      If empty / omitted → defaults to ['Attraction']
     *   - trip_duration  : total trip hours (int, e.g. 5)
     *   - start_lat      : optional user start latitude
     *   - start_lng      : optional user start longitude
     */
    public function generateTrip(Request $request)
    {
        // ── 1. Parse inputs ────────────────────────────────────────────────
        $selectedCategories = $request->input('categories', []);
        if (empty($selectedCategories)) {
            $selectedCategories = ['Attraction'];
        }

        $tripDurationHours = (int) $request->input('trip_duration', 5);
        $tripDurationMins  = $tripDurationHours * 60;

        $startLat = $request->input('start_lat', 1.1534);
        $startLng = $request->input('start_lng', 103.9975);

        // ── 2. Validate categories — never include Public Information ───────
        $allowedCategories = ['Attraction', 'Food & Beverages', 'Accommodation'];
        $selectedCategories = array_values(
            array_intersect($selectedCategories, $allowedCategories)
        );
        if (empty($selectedCategories)) {
            $selectedCategories = ['Attraction'];
        }

        // ── 3. Fetch candidate places ────────────────────────────────────────
        // Priority: Attraction first, then Food & Beverages, then Accommodation
        $priorityOrder = ['Attraction', 'Food & Beverages', 'Accommodation'];
        $orderedCategories = array_values(
            array_intersect($priorityOrder, $selectedCategories)
        );

        $places = Place::whereIn('category', $selectedCategories)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereNotNull('cluster')
            ->get();

        if ($places->isEmpty()) {
            // Fallback: try without cluster filter
            $places = Place::whereIn('category', $selectedCategories)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();
        }

        if ($places->isEmpty()) {
            return response()->json([
                'success'   => false,
                'message'   => 'No places found for the selected categories. Please try different options.',
                'itinerary' => [],
            ]);
        }

        // ── 4. Cluster-based spatial sorting ────────────────────────────────
        // Find the cluster closest to the user's start point, then order clusters
        // so geographically adjacent ones follow in sequence.
        $clusterCentroids = $this->computeClusterCentroids($places);
        $clusterOrder     = $this->sortClustersByProximity($clusterCentroids, $startLat, $startLng);

        // Sort places: by priority category first, then by cluster proximity order
        $clusterIndex = array_flip($clusterOrder); // cluster → rank

        $sorted = $places->sortBy(function ($place) use ($clusterIndex, $orderedCategories) {
            $catRank     = array_search($place->category, $orderedCategories);
            $catRank     = ($catRank === false) ? 99 : $catRank;
            $clusterRank = $clusterIndex[$place->cluster] ?? 99;
            return ($clusterRank * 10) + $catRank;
        })->values();

        // ── 5. Build itinerary respecting total trip duration ───────────────
        $itinerary       = [];
        $accumulatedMins = 0;
        $currentTimeMin  = 9 * 60; // Start at 09:00
        $breakMins       = 15;     // 15 min travel buffer between stops
        $lastCluster     = null;
        $clusterCount    = [];

        // Ensure culinary stops are spaced out (max 1 per 3 attraction stops)
        $attractionsSinceLastCulinary = 0;
        $maxCulinaryRatio = 3; // 1 culinary per 3 attractions

        foreach ($sorted as $place) {
            if ($accumulatedMins >= $tripDurationMins) {
                break;
            }

            $duration = max((int) $place->visit_duration, 30); // min 30 min per place

            // Culinary spacing: skip if too many culinary stops vs attractions
            // Only enforce this if Attractions are actually requested!
            if ($place->category === 'Food & Beverages' && in_array('Attraction', $selectedCategories)) {
                if ($attractionsSinceLastCulinary < $maxCulinaryRatio) {
                    continue; // postpone this culinary stop
                }
            }

            // Don't repeat same cluster too many times (max 3 per cluster)
            $cluster = $place->cluster ?? 'unknown';
            $clusterCount[$cluster] = ($clusterCount[$cluster] ?? 0);
            if ($clusterCount[$cluster] >= 3) {
                continue;
            }

            // Add travel buffer when switching clusters
            $travelBuffer = 0;
            if ($lastCluster !== null && $lastCluster !== $cluster) {
                $travelBuffer = 20; // 20 min inter-cluster travel
            }

            $totalSlotMins = $duration + $travelBuffer + $breakMins;

            if ($accumulatedMins + $totalSlotMins > $tripDurationMins) {
                // Try to fit a shorter stop
                $remainingMins = $tripDurationMins - $accumulatedMins;
                if ($remainingMins < 30 + $travelBuffer) {
                    break;
                }
                $duration = $remainingMins - $travelBuffer - $breakMins;
                if ($duration < 20) break;
            }

            $startTime = $this->minutesToTime($currentTimeMin + $travelBuffer);
            $endTime   = $this->minutesToTime($currentTimeMin + $travelBuffer + $duration);

            $itinerary[] = [
                'order'          => count($itinerary) + 1,
                'place_id'       => $place->id,
                'name'           => $place->name,
                'category'       => $place->category,
                'subcategory'    => $place->subcategory,
                'cluster'        => $cluster,
                'address'        => $place->address,
                'image'          => $place->image,
                'latitude'       => (float) $place->latitude,
                'longitude'      => (float) $place->longitude,
                'visit_duration' => $duration,
                'start_time'     => $startTime,
                'end_time'       => $endTime,
                'travel_buffer'  => $travelBuffer,
            ];

            $currentTimeMin += $travelBuffer + $duration + $breakMins;
            $accumulatedMins += $totalSlotMins;
            $clusterCount[$cluster]++;
            $lastCluster = $cluster;

            if ($place->category === 'Attraction') {
                $attractionsSinceLastCulinary++;
            } elseif ($place->category === 'Food & Beverages') {
                $attractionsSinceLastCulinary = 0;
            }
        }

        if (empty($itinerary)) {
            return response()->json([
                'success'   => false,
                'message'   => 'Could not build an itinerary within the selected duration. Try a longer trip duration.',
                'itinerary' => [],
            ]);
        }

        return response()->json([
            'success'        => true,
            'itinerary'      => $itinerary,
            'total_stops'    => count($itinerary),
            'trip_duration'  => $tripDurationHours,
            'categories_used' => $selectedCategories,
        ]);
    }

    // ── Helper: compute geographic centroid per cluster ──────────────────────
    private function computeClusterCentroids($places): array
    {
        $clusters = [];
        foreach ($places as $place) {
            $c = $place->cluster ?? 'unknown';
            if (!isset($clusters[$c])) {
                $clusters[$c] = ['lat_sum' => 0, 'lng_sum' => 0, 'count' => 0];
            }
            $clusters[$c]['lat_sum'] += (float) $place->latitude;
            $clusters[$c]['lng_sum'] += (float) $place->longitude;
            $clusters[$c]['count']++;
        }

        $centroids = [];
        foreach ($clusters as $name => $data) {
            $centroids[$name] = [
                'lat' => $data['lat_sum'] / $data['count'],
                'lng' => $data['lng_sum'] / $data['count'],
            ];
        }
        return $centroids;
    }

    // ── Helper: sort clusters by nearest-neighbour from start point ──────────
    private function sortClustersByProximity(array $centroids, float $startLat, float $startLng): array
    {
        $remaining = $centroids;
        $ordered   = [];
        $curLat    = $startLat;
        $curLng    = $startLng;

        while (!empty($remaining)) {
            $nearest = null;
            $minDist = PHP_FLOAT_MAX;

            foreach ($remaining as $name => $pos) {
                $dist = $this->haversineDistance($curLat, $curLng, $pos['lat'], $pos['lng']);
                if ($dist < $minDist) {
                    $minDist = $dist;
                    $nearest = $name;
                }
            }

            $ordered[] = $nearest;
            $curLat    = $remaining[$nearest]['lat'];
            $curLng    = $remaining[$nearest]['lng'];
            unset($remaining[$nearest]);
        }

        return $ordered;
    }

    // ── Helper: Haversine distance in kilometres ─────────────────────────────
    private function haversineDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R    = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a    = sin($dLat / 2) ** 2
              + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    // ── Helper: convert minutes-since-midnight → "HH:MM" string ─────────────
    private function minutesToTime(int $minutes): string
    {
        $h = intdiv($minutes, 60) % 24;
        $m = $minutes % 60;
        return sprintf('%02d:%02d', $h, $m);
    }
}