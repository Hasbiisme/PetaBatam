<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{ __('Itinerary Preview Testing') }}
        </div>
    </x-slot>

    <div class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-140px)]">
        
        <!-- Left Panel: Trip Planner Controls & Results -->
        <div class="w-full lg:w-1/3 flex flex-col gap-4 bg-white rounded-xl shadow-sm border border-gray-100 p-5 overflow-y-auto">
            
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-lg font-bold text-gray-800">Trip Planner Controls</h3>
                <p class="text-xs text-gray-500 mt-1">Test the itinerary generation logic. This panel mimics the public Trip Planner feature.</p>
            </div>

            <div class="space-y-4 pt-2">
                <!-- Categories -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Included Categories</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-2 border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors">
                            <input type="checkbox" id="cat-attraction" class="w-4 h-4 text-indigo-600 rounded" checked value="Attraction">
                            <span class="text-sm font-medium text-gray-700">Attraction</span>
                        </label>
                        <label class="flex items-center gap-3 p-2 border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors">
                            <input type="checkbox" id="cat-culinary" class="w-4 h-4 text-indigo-600 rounded" value="Food & Beverages">
                            <span class="text-sm font-medium text-gray-700">Food & Beverages</span>
                        </label>
                        <label class="flex items-center gap-3 p-2 border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors">
                            <input type="checkbox" id="cat-accommodation" class="w-4 h-4 text-indigo-600 rounded" value="Accommodation">
                            <span class="text-sm font-medium text-gray-700">Accommodation</span>
                        </label>
                    </div>
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Trip Duration</label>
                    <select id="trip-duration" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-sm">
                        <option value="3">Half Day (~3 hours)</option>
                        <option value="5" selected>Standard Day (~5 hours)</option>
                        <option value="8">Full Day (~8 hours)</option>
                        <option value="10">Extended Day (~10 hours)</option>
                    </select>
                </div>

                <!-- Generate Button -->
                <button id="btn-generate" class="w-full py-3 bg-indigo-600 text-white rounded-lg font-bold shadow-sm hover:bg-indigo-700 transition-colors flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span>Generate Itinerary</span>
                    <div id="spinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                </button>
            </div>

            <!-- Results Output -->
            <div id="results-container" class="mt-4 flex-1">
                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500">
                    <p class="text-sm">Configure your settings and click Generate to preview the itinerary.</p>
                </div>
            </div>

        </div>

        <!-- Right Panel: Embedded Map -->
        <div class="w-full lg:w-2/3 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative min-h-[400px]">
            <div id="admin-map" class="w-full h-full absolute inset-0 z-0"></div>
        </div>
    </div>

    <!-- Scripts for Leaflet and Routing -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    
    <style>
        .leaflet-routing-container { display: none !important; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Map
            const map = L.map('admin-map').setView([1.1301, 104.0483], 11);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const userLat = 1.1534; 
            const userLng = 103.9975;
            let routingControl = null;

            // Generate Button logic
            document.getElementById('btn-generate').addEventListener('click', function() {
                const btn = this;
                const spinner = document.getElementById('spinner');
                const resultsContainer = document.getElementById('results-container');
                
                // Collect categories
                const categories = [];
                ['cat-attraction', 'cat-culinary', 'cat-accommodation'].forEach(id => {
                    const cb = document.getElementById(id);
                    if(cb.checked) categories.push(cb.value);
                });

                if(categories.length === 0) {
                    alert('Please select at least one category');
                    return;
                }

                const duration = document.getElementById('trip-duration').value;

                // UI Loading state
                btn.disabled = true;
                btn.querySelector('span').textContent = 'Generating...';
                spinner.classList.remove('hidden');
                
                resultsContainer.innerHTML = '<div class="text-center py-8 text-indigo-600 font-medium">Processing itinerary data...</div>';

                // Fetch Request
                fetch('/generate-trip', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        categories: categories,
                        trip_duration: duration,
                        start_lat: userLat,
                        start_lng: userLng
                    })
                })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    btn.querySelector('span').textContent = 'Generate Itinerary';
                    spinner.classList.add('hidden');

                    if (!data.success) {
                        resultsContainer.innerHTML = `<div class="p-4 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">${data.message || 'No places found for this configuration.'}</div>`;
                        if(routingControl) map.removeControl(routingControl);
                        return;
                    }

                    renderItineraryList(data.itinerary);
                    renderRouteOnMap(data.itinerary);
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.querySelector('span').textContent = 'Generate Itinerary';
                    spinner.classList.add('hidden');
                    resultsContainer.innerHTML = `<div class="p-4 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">Error connecting to Trip Planner API.</div>`;
                    console.error(err);
                });
            });

            function renderItineraryList(itinerary) {
                const container = document.getElementById('results-container');
                
                let html = `
                    <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3 mb-4 flex justify-between items-center">
                        <span class="text-sm font-bold text-indigo-800">${itinerary.length} Stops Configured</span>
                    </div>
                    <div class="space-y-3">
                `;

                itinerary.forEach((stop, idx) => {
                    html += `
                        <div class="flex gap-3 p-3 border border-gray-100 rounded-lg hover:border-indigo-200 transition-colors bg-white shadow-sm cursor-pointer" onclick="map.flyTo([${stop.latitude}, ${stop.longitude}], 15)">
                            <div class="flex-shrink-0 w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-xs">${idx + 1}</div>
                            <div>
                                <div class="text-xs font-bold text-indigo-600">${stop.start_time} - ${stop.end_time}</div>
                                <div class="text-sm font-bold text-gray-900">${stop.name}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <span class="px-1.5 py-0.5 bg-gray-100 rounded">${stop.category}</span>
                                    <span class="px-1.5 py-0.5 bg-gray-100 rounded ml-1">${stop.cluster || 'No Cluster'}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += '</div>';
                container.innerHTML = html;
            }

            function renderRouteOnMap(itinerary) {
                if (routingControl) {
                    map.removeControl(routingControl);
                }

                const waypoints = [L.latLng(userLat, userLng)];
                itinerary.forEach(stop => {
                    if (stop.latitude && stop.longitude) {
                        waypoints.push(L.latLng(stop.latitude, stop.longitude));
                    }
                });

                routingControl = L.Routing.control({
                    waypoints: waypoints,
                    router: L.Routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1',
                        profile: 'driving',
                    }),
                    show: false,
                    createMarker: (i, wp) => {
                        const label = i === 0 ? 'START' : String(i);
                        const color = i === 0 ? '#4b5563' : '#4f46e5';
                        const icon = L.divIcon({
                            html: `<div style="background:${color};color:white;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:bold;box-shadow:0 2px 4px rgba(0,0,0,0.3);border:2px solid white;">${label}</div>`,
                            className: '',
                            iconSize: [28, 28],
                            iconAnchor: [14, 14],
                        });
                        return L.marker(wp.latLng, { icon });
                    },
                    lineOptions: {
                        styles: [{ color: '#4f46e5', opacity: 0.9, weight: 5, dashArray: '8,4' }],
                    },
                    fitSelectedRoutes: true,
                }).addTo(map);
            }
        });
    </script>
</x-app-layout>
