<?php
require_once 'database/conn.php';

if (isset($_GET['linkId']) && is_numeric($_GET['linkId'])) {
    $linkId = $_GET['linkId'];

    // Assuming you have a method in your class to handle the deletion
    require_once 'Classes/Klacht.php'; // Adjust the path accordingly
    $klacht = new Klacht(); // Instantiate your class
    $klacht->deleteKlacht($linkId);

    // Redirect back to the read page after deletion
    header("Location: readKlacht.php");
    exit();
} else {
    // Handle invalid or missing ID
    echo "Invalid or missing ID for deletion.";
}
?>

