/**
 * Admin Kontak - School Location Map Management
 * Handles interactive Leaflet map for updating school coordinates
 */

document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('school-location-map');
    const latitudeInput = document.getElementById('school-latitude');
    const longitudeInput = document.getElementById('school-longitude');

    // Exit if Leaflet or DOM elements are not available
    if (typeof L === 'undefined' || !mapElement || !latitudeInput || !longitudeInput) {
        return;
    }

    // Initialize map with stored coordinates
    const initialLatitude = Number(latitudeInput.value);
    const initialLongitude = Number(longitudeInput.value);
    const locationMap = L.map(mapElement).setView([initialLatitude, initialLongitude], 15);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(locationMap);

    // Add draggable marker
    const schoolMarker = L.marker([initialLatitude, initialLongitude], { draggable: true }).addTo(locationMap);

    /**
     * Update latitude and longitude input fields
     */
    function updateInputs(latitude, longitude) {
        latitudeInput.value = latitude.toFixed(7);
        longitudeInput.value = longitude.toFixed(7);
    }

    /**
     * Handle marker drag end event
     */
    schoolMarker.on('dragend', function (event) {
        const position = event.target.getLatLng();
        updateInputs(position.lat, position.lng);
    });

    /**
     * Handle map click to reposition marker
     */
    locationMap.on('click', function (event) {
        schoolMarker.setLatLng(event.latlng);
        updateInputs(event.latlng.lat, event.latlng.lng);
    });

    /**
     * Update marker position when input values change
     */
    function updateMarkerFromInputs() {
        const latitude = Number(latitudeInput.value);
        const longitude = Number(longitudeInput.value);

        // Validate coordinate values
        if (latitudeInput.value !== '' && longitudeInput.value !== '' && 
            Number.isFinite(latitude) && Number.isFinite(longitude) && 
            Math.abs(latitude) <= 90 && Math.abs(longitude) <= 180) {
            const position = [latitude, longitude];
            schoolMarker.setLatLng(position);
            locationMap.panTo(position);
        }
    }

    // Listen for input changes
    latitudeInput.addEventListener('change', updateMarkerFromInputs);
    longitudeInput.addEventListener('change', updateMarkerFromInputs);

    // Trigger map size calculation after DOM rendering
    setTimeout(function () { locationMap.invalidateSize(); }, 250);
});
