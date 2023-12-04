<?php
require 'Classes/Gps.php';
if (isset($_POST['klachtenId'])) {
    // Retrieve the data sent from JavaScript

    // $userId = $_POST['userId'];
    $klachtenId = $_POST['klachtenId'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    
    // Log the received data
    error_log("Received Data:");
    // error_log("userId: " . $userId);
    error_log("klachtenId: " . $klachtenId);
    error_log("latitude: " . $latitude);
    error_log("longitude: " . $longitude);

    $newGps = new Gps();    
    $newGps->sendGps($klachtenId, $latitude, $longitude);
    
    // Send a success response
    echo 'Data sent successfully';    // Now you can safely use $userId
} else {
    // Handle the case when 'userId' key is not present in $_POST
}

?>
