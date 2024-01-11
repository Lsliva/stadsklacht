if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        function (position) {
            var userLat = position.coords.latitude;
            var userLon = position.coords.longitude;

            // Reverse geocoding using OpenStreetMap Nominatim API
            var nominatimUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLat}&lon=${userLon}`;

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
                    // Set values in input fields
                    document.getElementById('locationCord').value = `${userLat},${userLon}`;
                    document.getElementById('locationName').value = customAddress;

                })
                .catch(error => {
                    console.error('Error getting user location:', error);
                });
        },
        function (error) {
            console.error('Error getting user location:', error.message);
        }
    );
} else {
    console.error('Geolocation is not supported by your browser.');
}
