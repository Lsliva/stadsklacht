<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stadsklacht - Klacht Indienen</title>
</head>
<body>
  <button onclick="getLocation()">Krijg mijn locatie</button>

  <script>
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        alert("Geolocatie wordt niet ondersteund door deze browser.");
      }
    }

    function showPosition(position) {
      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;

      // Voeg de verkregen coördinaten toe aan het klachtenformulier
      document.getElementById("latitude").value = latitude;
      document.getElementById("longitude").value = longitude;
    }
  </script>
</body>
</html>
