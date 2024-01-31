<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPS Map</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <?php
    require 'assets/nav.php';
        // require 'Classes/Linkingtable.php';
        // $newlink = new Linkingtable();
        // $ECHO = $newlink->getLinkId(25, 'klachtenId');
        // var_dump($ECHO);

    $klachtenId = 97;
    require 'Classes/Gps.php';
    $newGps = new Gps();    
    echo json_encode($newGps->searchGpsByKlachtenId($klachtenId));
    // echo $newGps->getGps();
    ?>
    <div id="map"></div>
    <script>
        function initMap() {
            // Initialize the map
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 0, lng: 0 }, // Set initial center coordinates
                zoom: 2 // Set initial zoom level
            });

            // Add markers to the map
            var locations = [
                { lat: 37.7749, lng: -122.4194, title: 'San Francisco' },
                { lat: 40.7128, lng: -74.0060, title: 'New York' },
                // Add more locations as needed
            ];

            locations.forEach(function (location) {
                var marker = new google.maps.Marker({
                    position: { lat: location.lat, lng: location.lng },
                    map: map,
                    title: location.title
                });
            });
        }
    </script>
</body>
</html>
