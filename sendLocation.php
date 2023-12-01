<?php
require 'Classes/gps.php';
if (isset($_POST['userId'])) {
    // Retrieve the data sent from JavaScript

    $userId = $_POST['userId'];
    $score = $_POST['score'];
    $level = $_POST['level'];
    $tetrominoes = $_POST['counting'];
    $highScore = $_POST['highScore'];
    
    // Log the received data
    error_log("Received Data:");
    error_log("userId: " . $userId);
    error_log("score: " . $score);
    error_log("level: " . $level);
    error_log("counting: " . $tetrominoes);
    error_log("highScore: " . $highScore);
    
    $newScore = new gps();
    $newScore->setHighScore($userId, $highScore);
    
    $newScore->sendScore($userId, $score, $level, $tetrominoes);
    
    
    // Send a success response
    echo 'Data sent successfully';    // Now you can safely use $userId
} else {
    // Handle the case when 'userId' key is not present in $_POST
}

?>
