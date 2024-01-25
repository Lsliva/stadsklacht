<?php

require 'Classes/Review.php';

// Check if the form is submitted
if (isset($_POST)) {
    // Create an instance of ReviewHandler
    $reviewHandler = new Review();

    // Retrieve the review and linkId from the form submission
    $review = $_POST["review"];
    $linkId = $_POST["linkId"];

    // Process the review and linkId
    $reviewHandler->insertreview($review, $linkId);
}






