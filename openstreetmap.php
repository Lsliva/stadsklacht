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
        <form id="gpsSearchForm">
            <label for="klachtenId">Enter klachtenId:</label>
            <input type="text" id="klachtenId" name="klachtenId">
            <button type="button" onclick="searchGps()">Search</button>

            <span id="responseCount"></span>
            <button type="button" id="previousButton" onclick="showPrevious()">Previous</button>
            <button type="button" id="nextButton" onclick="showNext()">Next</button>
        </form>
        <div id="map" style="height: 500px;"></div>

        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            var map = L.map('map').setView([51.9225, 4.47917], 11);

            let currentResponseIndex = 0;
let totalResponses = 0; // Variable to store the total number of responses

function searchGps() {
    var klachtenId = document.getElementById('klachtenId').value;

    // Fetch GPS locations from PHP based on the provided klachtenId
    fetch(`searchGps.php?klachtenId=${klachtenId}`)
        .then(response => response.json())
        .then(data => {
            // Clear existing markers on the map
            map.eachLayer(layer => {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            // Create markers for each GPS location
            data.forEach(location => {
                L.marker([location.latitude, location.longitude])
                    .addTo(map)
                    .bindPopup(`Database klacht: ${location.klachtenId}`);
            });

            // Update the total number of responses
            totalResponses = data.length;

            // Update the current response index and count display
            currentResponseIndex = 0;
            updateCountDisplay();

            // Display the map centered on the first GPS location if available
            if (data.length > 0) {
                map.setView([data[0].latitude, data[0].longitude], 20);
            }

            // Show/hide Next and Previous buttons based on the number of responses
            toggleNextButton(data.length > 1);
            togglePreviousButton(false); // Initially, hide Previous button since we're at the first response
        })
        .catch(error => console.error('Error fetching GPS locations:', error));
}

function showNext() {
    // Increment the current response index
    currentResponseIndex++;

    // Update count display
    updateCountDisplay();

    // Fetch the data again or use the existing data array
    var klachtenId = document.getElementById('klachtenId').value;
    fetch(`searchGps.php?klachtenId=${klachtenId}`)
        .then(response => response.json())
        .then(data => {
            // Check if the response is still relevant (ignore if there's a newer request)
            if (currentResponseIndex < data.length) {
                // Clear existing markers on the map
                map.eachLayer(layer => {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                });

                // Create marker for the current response index
                L.marker([data[currentResponseIndex].latitude, data[currentResponseIndex].longitude])
                    .addTo(map)
                    .bindPopup(`Database klacht: ${data[currentResponseIndex].klachtenId}`);

                // Center the map on the current GPS location
                map.setView([data[currentResponseIndex].latitude, data[currentResponseIndex].longitude], 20);
            }

            // Show/hide Next and Previous buttons based on the index
            toggleNextButton(currentResponseIndex < data.length - 1);
            togglePreviousButton(currentResponseIndex > 0);
        })
        .catch(error => console.error('Error fetching GPS locations:', error));
}

function showPrevious() {
    // Decrement the current response index
    currentResponseIndex--;

    // Update count display
    updateCountDisplay();

    // Fetch the data again or use the existing data array
    var klachtenId = document.getElementById('klachtenId').value;
    fetch(`searchGps.php?klachtenId=${klachtenId}`)
        .then(response => response.json())
        .then(data => {
            // Check if the response is still relevant (ignore if there's a newer request)
            if (currentResponseIndex >= 0 && currentResponseIndex < data.length) {
                // Clear existing markers on the map
                map.eachLayer(layer => {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                });

                // Create marker for the current response index
                L.marker([data[currentResponseIndex].latitude, data[currentResponseIndex].longitude])
                    .addTo(map)
                    .bindPopup(`Database klacht: ${data[currentResponseIndex].klachtenId}`);

                // Center the map on the current GPS location
                map.setView([data[currentResponseIndex].latitude, data[currentResponseIndex].longitude], 20);
            }

            // Show/hide Next and Previous buttons based on the index
            toggleNextButton(currentResponseIndex < data.length - 1);
            togglePreviousButton(currentResponseIndex > 0);
        })
        .catch(error => console.error('Error fetching GPS locations:', error));
}

function updateCountDisplay() {
    // Update the count display (assuming you have an element with id "responseCount")
    document.getElementById('responseCount').textContent = `${currentResponseIndex + 1}/${totalResponses || 0}`;
}


            function toggleNextButton(show) {
                // Show/hide the Next button based on the "show" parameter
                document.getElementById('nextButton').style.display = show ? 'inline-block' : 'none';
            }
            function togglePreviousButton(show) {
                // Show/hide the Previous button based on the "show" parameter
                document.getElementById('previousButton').style.display = show ? 'inline-block' : 'none';
            }
            document.addEventListener('DOMContentLoaded', function () {


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
                        });
                }

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
            });
        </script>
    </div>
</body>

</html>