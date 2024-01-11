<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

</head>
<body>
    <?php include("assets/nav.php"); ?>
    <main>
        <div class="content">
            

            <div class="loginView">  
                <div id="map" style="height: 500px;"></div>

            </div>
        </div>
    </main>
    <style>
        input {
            width: 200px;
            padding: 10px 15px;
            margin: 5px 0;
            box-sizing: border-box;
        }
    </style>
    <!-- openstreetmap api -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- changing popup api -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="assets/openstreetmap.js"></script>
    <script>
     document.addEventListener('DOMContentLoaded', function () {
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            function onMapClick(e) {
                var nominatimUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.latlng.lat}&lon=${e.latlng.lng}`;

                fetch(nominatimUrl)
                    .then(response => response.json())
                    .then(data => {
                    // Extract specific components from the address
                    var street = data.address.road || '';
                    var city = data.address.city || data.address.town || '';
                    var country = data.address.country || '';
                    var postcode = data.address.postcode || '';

                    // Concatenate the components to form a custom address
                    var customAddress = `${postcode}, ${street}, ${city}, ${country}`;       
                    var klachtenformUrl = `klachtenform?lat=${e.latlng.lat}&lon=${e.latlng.lng}&address=${encodeURIComponent(customAddress)}`;

                        // Set location details in session storage
                        sessionStorage.setItem('chosenLocation', JSON.stringify({ lat: e.latlng.lat, lon: e.latlng.lng }));
                        sessionStorage.setItem('chosenAddress', customAddress);

                        // Show a SweetAlert confirmation without an input field
                        Swal.fire({
                            title: `Confirm chosen location: <br> ${customAddress}`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: `<a href="${klachtenformUrl}" onclick="storeChosenLocationInSession()">Yes</a>`,
                            cancelButtonText: 'Cancel',
                            customClass: {
                                container: 'my-swal-container',
                                popup: 'my-swal-popup',
                                title: 'my-swal-title',
                            }
                        }).then((result) => {
                            // Call the function to store chosen location in PHP session
                            storeChosenLocationInSession();

                            // Redirect to klachtenform page
                            window.location.href = klachtenformUrl;

                            // Add the following code to prevent showing the default SweetAlert popup
                            throw new Error('Redirecting...');
                        });
                    })
                    .catch(error => {

                      // Check if the error is due to the redirect
                    if (error.message !== 'Redirecting...') {
                        console.error('Error getting chosen location:', error);
                    }
                });
            }

            map.on('click', onMapClick);
            
            // JavaScript function to store chosen location in PHP session
            window.storeChosenLocationInSession = function() {
                // Make an AJAX request or redirect to a PHP script to store in session
                // You can use XMLHttpRequest or fetch to send the data to a PHP script.
                // Example using fetch:
                fetch('storeLocationSession.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        chosenLocation: JSON.parse(sessionStorage.getItem('chosenLocation')),
                        chosenAddress: sessionStorage.getItem('chosenAddress'),
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Location stored in PHP session:', data);
                })
                .catch(error => {
                    console.error('Error storing location in PHP session:', error);
                });
            };
        });
    </script>

</body>
</html>
