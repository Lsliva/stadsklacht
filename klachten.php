<?php
// process_form.php

// Establish a database connection (replace with your database credentials)
$host = "localhost";
$username = "root";
$password = "";
$dbname = "stadsklacht";

$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a user ID stored in the session after the user logs in
$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Check if the form is submitted with POST method and the required data is available
if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($id) && isset($_POST['omschrijving'])) {
    // Retrieve form data
    $omschrijving = $conn->real_escape_string($_POST['omschrijving']); // Sanitize input

    // Insert data into the database
    $sql = "INSERT INTO your_table_name (id, omschrijving) VALUES ('$id', '$omschrijving')";

    if ($conn->query($sql) === TRUE) {
        // Redirect or perform other actions after successful insertion
        header("Location: index.php");
        exit();
    } else {
        // Handle the case where the insertion fails
        echo "Error: " . $conn->error;
    }
} else {
    // Handle the case where the form is not submitted correctly
    echo "Invalid request";
}

// Close the database connection
$conn->close();
