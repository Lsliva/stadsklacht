 // Define the bounds for Rotterdam
 var rotterdamBounds = L.latLngBounds(
    L.latLng(51.855, 4.25), // Southwestern point
    L.latLng(51.975, 4.65)  // Northeastern point
);

// var map = L.map('map').setView([51.9225, 4.47917], 11);
var map = L.map('map', {
    center: [51.9225, 4.47917],
    zoom: 11,
    maxZoom: 18,
    minZoom: 11,
    maxBounds: rotterdamBounds,
    maxBoundsViscosity: .1     // Apply some stickiness to the bounds
});

