<?php
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request body
    $json_data = file_get_contents('php://input');
    
    // Decode the JSON data
    $data = json_decode($json_data, true);

    // Check if the necessary data is present
    if (isset($data['chosenLocation'], $data['chosenAddress'])) {
        // Store the chosen location and address in the PHP session
        $_SESSION['chosenLocation'] = $data['chosenLocation'];
        $_SESSION['chosenAddress'] = $data['chosenAddress'];

        // Respond with a success message or any other relevant data
        echo json_encode(['status' => 'success', 'message' => 'Location stored in session.']);
    } else {
        // Respond with an error message if data is missing
        echo json_encode(['status' => 'error', 'message' => 'Incomplete data received.']);
    }
} else {
    // Respond with an error message for non-POST requests
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
