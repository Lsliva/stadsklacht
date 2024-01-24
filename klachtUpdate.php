<?php
// Include the klacht.php file, which contains the klacht class
require 'Classes/klacht.php';

// Check if the form has been submitted via the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the values from the form data
    $linkId = $_POST['linkId'];
    $omschrijving = $_POST['omschrijving'];
    $status = $_POST['status'];

    // Create a new voorbeeld of the class
    $klacht1 = new Klacht();

    // Call the update method on the object, passing in the form data as arguments
    $klacht1->updateKlacht($linkId, $omschrijving, $status);
}
?>
