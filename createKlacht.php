<?php
require 'Classes/Linkingtable.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the data sent from JavaScript
    $locationName = $_POST['chosenLocationName'];
    $latitude = $_POST['chosenLocationLat'];
    $longitude = $_POST['chosenLocationLon'];
    $omschrijving = $_POST['omschrijving'];
    $gebruikersId = $_POST['gebruikersId'];

    // Check if a file was uploaded successfully
    if ($_FILES['foto']['error'] === 0) {
        $foto = $_FILES['foto']['name'];
        $tempFile = $_FILES['foto']['tmp_name'];
        $targetDir = 'uploads/'; // Specify your upload directory
        $targetFile = $targetDir . $foto;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tempFile, $targetFile)) {
            // Log the received data
            error_log("Received Data:");
            error_log("locationName: " . $locationName);
            error_log("latitude: " . $latitude);
            error_log("longitude: " . $longitude);
            error_log("omschrijving: " . $omschrijving);
            error_log("foto: " . $foto);
            error_log("gebruikersId: " . $gebruikersId);

            $newLinkingtable = new Linkingtable();
            $newLinkingtable->createLinkTable($locationName, $latitude, $longitude, $omschrijving, $foto, $gebruikersId);

            echo 'Data sent successfully';
        } else {
            echo 'Error moving uploaded file.';
        }
    } else {
        echo 'Error uploading file. Error code: ' . $_FILES['foto']['error'];
    }
} else {
    echo 'Invalid request method.';
}
?>