/**
 * Welcome Page JavaScript
 * School location map initialization with Leaflet
 */

/**
 * Initialize school location map
 * Loads map with school location marker and popup
 */
document.addEventListener('DOMContentLoaded', function () {
  const mapElement = document.getElementById('school-public-map');
  
  // Check if Leaflet is available and map element exists
  if (typeof L === 'undefined' || !mapElement) return;

  // Get school settings - passed from Blade through window object
  const latitude = Number(window.schoolLatitude || '-3.695');
  const longitude = Number(window.schoolLongitude || '128.18');
  const schoolName = window.schoolName || 'SD Negeri Lama';
  const schoolAddress = window.schoolAddress || 'Lokasi sekolah';

  // Initialize Leaflet map
  const schoolMap = L.map(mapElement, { scrollWheelZoom: false }).setView([latitude, longitude], 16);

  // Add OpenStreetMap tile layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 19
  }).addTo(schoolMap);

  // Create popup content
  const popupContent = document.createElement('div');
  const schoolLabel = document.createElement('strong');
  schoolLabel.textContent = schoolName;
  popupContent.appendChild(schoolLabel);
  popupContent.appendChild(document.createElement('br'));
  popupContent.appendChild(document.createTextNode(schoolAddress));

  // Add marker with popup
  L.marker([latitude, longitude])
    .addTo(schoolMap)
    .bindPopup(popupContent)
    .openPopup();

  // Fix map sizing after a short delay
  setTimeout(function () {
    schoolMap.invalidateSize();
  }, 250);
});
