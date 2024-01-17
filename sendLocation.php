<?php
require 'Classes/Gps.php';
if (isset($_POST)) {
    // Retrieve the data sent from JavaScript

    // $userId = $_POST['userId'];
    $locationName = $_POST['chosenLocationName'];
    $latitude = $_POST['chosenLocationLat'];
    $longitude = $_POST['chosenLocationLon'];
    
    // Log the received data
    error_log("Received Data:");
    // error_log("userId: " . $userId);
    error_log("locationName: " . $locationName);
    error_log("latitude: " . $latitude);
    error_log("longitude: " . $longitude);

    $newGps = new Gps();    
    $newGps->sendGps($locationName, $latitude, $longitude);
    
    // Send a success response
    echo 'Data sent successfully';    // Now you can safely use $userId
} else {
    // Handle the case when 'userId' key is not present in $_POST
}

?>
