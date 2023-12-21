<?php
// Include the Artikel.php file, which contains the Artikel class
require 'Classes/klachten.php';

// Check if the form has been submitted via the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the values from the form data
    $klachtenId = $_POST['$klachtenId'];
    $StartDatum = $_POST['gebruikersId'];
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $omschrijving = $_POST['omschrijving'];
    $status = $_POST['status'];

    // Create a new instance of the class
    $klacht1 = new Klachten();

    // Call the update method on the object, passing in the form data as arguments
    $klacht1->updateKlacht($klachtenId, $gebruikersId, $naam, $email, $status, $omschrijving);
}
?>
