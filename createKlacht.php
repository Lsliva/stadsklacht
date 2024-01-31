<?php
require 'Classes/Linkingtable.php';

if (isset($_POST)) {
    // Retrieve the data sent from JavaScript

    // $userId = $_POST['userId'];
    $locationName = $_POST['chosenLocationName'];
    $latitude = $_POST['chosenLocationLat'];
    $longitude = $_POST['chosenLocationLon'];
    $omschrijving = $_POST['omschrijving'];
    $gebruikersId = $_POST['gebruikersId'];
    $foto_name = $_FILES['foto']['name'];
    $foto_size = $_FILES['foto']['size'];
    $tmp_name = $_FILES['foto']['tmp_name'];

    // check if there is any inapropriate word in the username or the email
    $inapropriate_words = array("fuck", "hell","crap", "damn", "ass", "hoe", "whore", "kanker", "kut", "tering" , "shite", "nigger", "nigga" ,"shit", "bitch", "penis");
    foreach($inapropriate_words as $word){
        if (strpos($omschrijving, $word) !== false ) {
            echo "Sorry, inapropriate word found.";

        }
    }
    if (is_numeric($gebruikersId)) {
        // Convert to integer if it's a numeric string
        $gebruikersId = (int)$gebruikersId;

        // Log the received data
        error_log("Received Data:");
        // error_log("userId: " . $userId);
        error_log("locationName: " . $locationName);
        error_log("latitude: " . $latitude);
        error_log("longitude: " . $longitude);
        error_log("omschrijving: " . $omschrijving);
        error_log("gebruikersId: " . $gebruikersId);


        $newLinkingtable = new Linkingtable();
        $newLinkingtable->createLinkTable($locationName, $latitude, $longitude, $omschrijving, $gebruikersId, $foto_name, $foto_size, $tmp_name);

        // Send a success response
        echo 'Data sent successfully';
    } else {
        // Handle the case when gebruikerID is not a numeric value
        echo "Invalid gebruikerID. It must be a numeric value.";
    }} else {
    // Handle the case when 'userId' key is not present in $_POST
}

?>