<!DOCTYPE html>
<html>
<head>
    <title>Rotterdam Map with Mistakes</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>
    <div id="map" style="height: 500px;"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([51.9225, 4.47917], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);
// Example markers with mistakes
var mistakes = [
    { lat: 51.9167, lon: 4.4758, message: 'Incorrect data' },
    { lat: 51.922, lon: 4.481, message: 'Missing information' },
    { lat: 52.922, lon: 4.481, message: 'kapotte paal pik' },

    // Add more markers as needed
];

mistakes.forEach(function (mistake) {
    L.marker([mistake.lat, mistake.lon]).addTo(map)
        .bindPopup(mistake.message);
});
        // Function to add a new marker on map click
        function onMapClick(e) {
            var popupMessage = prompt("Enter the information for the new marker:");

            if (popupMessage) {
                var newMarker = L.marker(e.latlng).addTo(map)
                    .bindPopup(popupMessage);
            }
        }

        // Add click event listener to the map
        map.on('click', onMapClick);
    </script>
</body>
</html>
