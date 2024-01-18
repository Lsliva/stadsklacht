<?php
// Include the klacht.php file, which contains the klacht class
require 'Classes/klacht';

// Check if the form has been submitted via the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the values from the form data
    $klachtenId = $_POST['$klachtenId'];
    $omschrijving = $_POST['omschrijving'];
    $status = $_POST['status'];

    // Create a new instance of the class
    $klacht1 = new Klacht();

    // Call the update method on the object, passing in the form data as arguments
    $klacht1->updateKlacht($klachtenId, $omschrijving, $status);
}
?>
