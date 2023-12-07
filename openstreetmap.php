<!DOCTYPE html>
<html>
<head>
    <title>Rotterdam Map with Mistakes</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>
    <style>
        /* #map {
            max-width: 1000px;
        } */
    </style>
    <?php
    include 'assets/nav.php';
    ?>
    <div class="content">
    <div id="map" style="height: 500px;"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([51.9225, 4.47917], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        // Example markers with mistakes
        var mistakes = [
            // { lat: 51.9167, lon: 4.4758, message: 'Incorrect data' },
            // { lat: 51.922, lon: 4.481, message: 'Missing information' },
            { lat: 52.922, lon: 4.481, message: 'kapotte paal' },

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
                    sendDataToPHP(e);
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
        function sendDataToPHP(e) {
            // let userId = 1;
            let klachtenId = 1;

        // Prepare the data to send
        const data = {
            klachtenId: encodeURIComponent(klachtenId),
            latitude: e.latlng.lat,
            longitude: e.latlng.lng,
        };
          // Convert the data object to a URL-encoded string
        const requestBody = Object.keys(data)
            .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`)
            .join('&');

            // Send the data to the PHP file
            fetch('sendLocation.php', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: requestBody
            })
    .then(response => {
        if (response.ok) {
        // success message for succesfully sending the data
        console.log('Data sent successfully');
        console.log('Id:', data.klachtenId);
        console.log('Latitude:', data.latitude);
        console.log('Longitude:', data.longitude);
        } else {
        throw new Error('Error sending data: ' + response.status);
        }
    })
    .catch(error => {
        // Handle any errors that occurred during the request
        console.error(error);
    });}

     // Fetch GPS locations from PHP
     fetch('getGps.php')
            .then(response => response.json())
            .then(data => {
                // Create markers for each GPS location
                data.forEach(location => {
                    L.marker([location.latitude, location.longitude])
                        .addTo(map)
                        .bindPopup(`Database klacht: ${location.klachtenId}`);
                });
            })
            .catch(error => console.error('Error fetching GPS locations:', error));
    </script>
    </div>
</body>
</html>