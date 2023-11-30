<!DOCTYPE html>
<html>
<head>
    <title>Rotterdam Map with User Location</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>
    <?php
    include_once 'assets/nav.php';
    ?>
    <div id="map" style="height: 500px;"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([51.9225, 4.47917], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

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

        // Get user's location using Geolocation API
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    var userLat = position.coords.latitude;
                    var userLon = position.coords.longitude;

                    // Add user marker to the map
                    var userMarker = L.marker([userLat, userLon]).addTo(map)
                        .bindPopup('Your Location').openPopup();
                },
                function (error) {
                    console.error('Error getting user location:', error.message);
                }
            );
        } else {
            console.error('Geolocation is not supported by your browser.');
        }
    </script>
</body>
</html>
