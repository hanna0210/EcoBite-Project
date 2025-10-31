var map; // Global declaration of the map
var editMap; // Global declaration for edit map
var draw;
var editDraw;
var lastPolygonId = null;
var editLastPolygonId = null;

function initMap() {
    // Get Mapbox API key from the map container's data attribute
    const mapContainer = document.getElementById("map");
    if (!mapContainer) {
        console.error("Map container not found");
        return;
    }
    
    const mapboxToken = mapContainer.dataset.mapboxToken;
    
    if (!mapboxToken) {
        console.error("Mapbox token is required");
        alert("Please configure your Mapbox API key in Map Settings");
        return;
    }

    mapboxgl.accessToken = mapboxToken;
    
    // Initialize Mapbox map for create mode
    map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [0.00, 0.00],
        zoom: 8
    });

    // Add navigation controls
    map.addControl(new mapboxgl.NavigationControl());

    // Initialize Mapbox Draw
    draw = new MapboxDraw({
        displayControlsDefault: false,
        controls: {
            polygon: true,
            trash: true
        },
        defaultMode: 'draw_polygon'
    });

    map.addControl(draw);

    // Get current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = [position.coords.longitude, position.coords.latitude];
                map.setCenter(pos);
            },
            () => {
                console.log('Geolocation failed or was denied');
            }
        );
    }

    // Listen for polygon creation
    map.on('draw.create', updateCoordinates);
    map.on('draw.update', updateCoordinates);
    map.on('draw.delete', clearCoordinates);

    function updateCoordinates(e) {
        const data = draw.getAll();
        
        if (data.features.length > 0) {
            // Keep only the last drawn polygon
            if (data.features.length > 1) {
                const featuresToDelete = data.features.slice(0, -1).map(f => f.id);
                draw.delete(featuresToDelete);
            }

            const lastFeature = data.features[data.features.length - 1];
            if (lastFeature.geometry.type === 'Polygon') {
                lastPolygonId = lastFeature.id;
                const coordinates = lastFeature.geometry.coordinates[0].map(coord => ({
                    lng: coord[0],
                    lat: coord[1]
                }));
                // Emit coordinates to Livewire
                livewire.emit('selectedCoordinates', coordinates);
            }
        }
    }

    function clearCoordinates() {
        lastPolygonId = null;
        livewire.emit('selectedCoordinates', []);
    }
}

function initEditMap(coordinates) {
    // Get Mapbox API key from the map container's data attribute
    const editMapContainer = document.getElementById("editMap");
    if (!editMapContainer) {
        console.error("Edit map container not found");
        return;
    }
    
    const mapboxToken = editMapContainer.dataset.mapboxToken;
    
    if (!mapboxToken) {
        console.error("Mapbox token is required");
        alert("Please configure your Mapbox API key in Map Settings");
        return;
    }

    mapboxgl.accessToken = mapboxToken;
    
    // Initialize Mapbox map for edit mode
    editMap = new mapboxgl.Map({
        container: 'editMap',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [0.00, 0.00],
        zoom: 8
    });

    // Add navigation controls
    editMap.addControl(new mapboxgl.NavigationControl());

    // Initialize Mapbox Draw for edit mode
    editDraw = new MapboxDraw({
        displayControlsDefault: false,
        controls: {
            polygon: true,
            trash: true
        },
        defaultMode: 'simple_select'
    });

    editMap.addControl(editDraw);

    // Wait for map to load before adding polygon
    editMap.on('load', function() {
        if (coordinates && coordinates.length > 0) {
            // Convert coordinates to GeoJSON format
            const polygonCoordinates = coordinates.map(coord => [
                parseFloat(coord.lng),
                parseFloat(coord.lat)
            ]);
            
            // Close the polygon by adding the first coordinate at the end
            polygonCoordinates.push(polygonCoordinates[0]);

            // Create GeoJSON feature
            const polygon = {
                type: 'Feature',
                geometry: {
                    type: 'Polygon',
                    coordinates: [polygonCoordinates]
                }
            };

            // Add polygon to draw
            const featureIds = editDraw.add(polygon);
            if (featureIds.length > 0) {
                editLastPolygonId = featureIds[0];
            }

            // Calculate bounds and fit map
            const bounds = new mapboxgl.LngLatBounds();
            coordinates.forEach(coord => {
                bounds.extend([parseFloat(coord.lng), parseFloat(coord.lat)]);
            });

            editMap.fitBounds(bounds, {
                padding: 50,
                maxZoom: 15
            });
        }
    });

    // Listen for polygon updates in edit mode
    editMap.on('draw.create', updateEditCoordinates);
    editMap.on('draw.update', updateEditCoordinates);
    editMap.on('draw.delete', clearEditCoordinates);

    function updateEditCoordinates(e) {
        const data = editDraw.getAll();
        
        if (data.features.length > 0) {
            // Keep only the last drawn polygon
            if (data.features.length > 1) {
                const featuresToDelete = data.features.slice(0, -1).map(f => f.id);
                editDraw.delete(featuresToDelete);
            }

            const lastFeature = data.features[data.features.length - 1];
            if (lastFeature.geometry.type === 'Polygon') {
                editLastPolygonId = lastFeature.id;
                const coordinates = lastFeature.geometry.coordinates[0].map(coord => ({
                    lng: coord[0],
                    lat: coord[1]
                }));
                // Emit coordinates to Livewire
                livewire.emit('selectedCoordinates', coordinates);
            }
        }
    }

    function clearEditCoordinates() {
        editLastPolygonId = null;
        livewire.emit('selectedCoordinates', []);
    }
}

// Listen for Livewire events
livewire.on("initiateEditMap", (data) => {
    // Small delay to ensure DOM is ready
    setTimeout(() => {
        initEditMap(data);
    }, 100);
});

livewire.on("resetMap", (data) => {
    // Clear polygon from create map
    if (draw && lastPolygonId) {
        draw.delete(lastPolygonId);
        lastPolygonId = null;
    }
    
    // Clear polygon from edit map
    if (editDraw && editLastPolygonId) {
        editDraw.delete(editLastPolygonId);
        editLastPolygonId = null;
    }
});

function distanceFrom(lat1, lng1, lat2, lng2) {
    var lat = [lat1, lat2];
    var lng = [lng1, lng2];
    var R = 6378137;
    var dLat = (lat[1] - lat[0]) * Math.PI / 180;
    var dLng = (lng[1] - lng[0]) * Math.PI / 180;
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat[0] * Math.PI / 180) * Math.cos(lat[1] * Math.PI / 180) *
        Math.sin(dLng / 2) * Math.sin(dLng / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    return Math.round(d);
}
