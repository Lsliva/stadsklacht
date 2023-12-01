<!DOCTYPE html>
<html>
<head>
<<<<<<< HEAD
    <title>Rotterdam Map with Mistakes</title>
=======
    <title>Rotterdam Map with User Location</title>
>>>>>>> 79d3e831c846e91de1e89500ac6b148e9ae96587
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>
<<<<<<< HEAD
=======
    <?php
    include_once 'assets/nav.php';
    ?>
>>>>>>> 79d3e831c846e91de1e89500ac6b148e9ae96587
    <div id="map" style="height: 500px;"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([51.9225, 4.47917], 13);

<<<<<<< HEAD
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
=======
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

>>>>>>> 79d3e831c846e91de1e89500ac6b148e9ae96587
        // Function to add a new marker on map click
        function onMapClick(e) {
            var popupMessage = prompt("Enter the information for the new marker:");

            if (popupMessage) {
                var newMarker = L.marker(e.latlng).addTo(map)
                    .bindPopup(popupMessage);
<<<<<<< HEAD
=======

                    console.log('Marker Coordinates:', e.latlng.lat, e.latlng.lng);

>>>>>>> 79d3e831c846e91de1e89500ac6b148e9ae96587
            }
        }

        // Add click event listener to the map
        map.on('click', onMapClick);
<<<<<<< HEAD
=======

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
        function sendDataToPHP() {
        // Prepare the data to send
        const data = {
            userId: encodeURIComponent(userId),
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
        console.log('Id:', data.userId);
        console.log('level:', data.latitude);
        console.log('highScore:', data.longitude);
        } else {
        throw new Error('Error sending data: ' + response.status);
        }
    })
    .catch(error => {
        // Handle any errors that occurred during the request
        console.error(error);
    });}
>>>>>>> 79d3e831c846e91de1e89500ac6b148e9ae96587
    </script>
</body>
</html>
