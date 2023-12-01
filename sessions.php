<?php
require 'database/database.php'; 

if(isset($_SESSION['username']) || isset($_SESSION['user_id'])) {
    // User is logged in

    // Get the logged in user's username
    $username = $_SESSION['username'];

    // Prepare the SELECT statement
    $query = "SELECT id, profile_pic, highscore, email FROM players WHERE username = :username";
    $stmt = $conn->prepare($query);

    // Bind the parameters
    $stmt->bindParam(':username', $username);

    // Execute the query
    $stmt->execute();

    // Fetch the results
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Store the results in the session
    $_SESSION['profile_pic'] = $result['profile_pic'];
    $_SESSION['highscore'] = $result['highscore'];
    $_SESSION['email'] = $result['email'];
    $_SESSION['userId'] = $result['id'];

}

?>