<?php
if(isset($_GET['klachtenId'])) {
    // Retrieve the klachtenId value
    $klachtenId = $_GET['klachtenId'];
    require 'Classes/Gps.php';
    $newGps = new Gps();    
    echo $newGps->getGpsByKlachtenId($klachtenId);
    
} else {
    // Handle the case where klachtenId is not provided
    echo json_encode(['error' => 'klachtenId not provided in the request']);
}

?>
