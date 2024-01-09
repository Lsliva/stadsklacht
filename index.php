<?php

include "assets/nav.php";

// Check if a session is already active
if (session_status() == PHP_SESSION_NONE) {
    // Start a new session if one is not already active
    session_start();
}

// Include your database connection script.
include("database/conn.php");

if (isset($_SESSION['ID'])) {
    // User is logged in. You can retrieve and display their information here.
    $user_id = $_SESSION['ID'];

    try {
        // Prepare a SQL query to fetch the user's information
        $query = "SELECT naam FROM gebruikers WHERE ID = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->rowCount() > 0) {
            $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
            $username = $user_data['naam'];
            echo "Logged in as: " . $username;
        } else {
            echo "User not found in the database.";
        }
    } catch (PDOException $e) {
        // Handle any exceptions that occur during the query execution
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />


    <title>ELEMENTS</title>

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/main.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="assets/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/main.css">
    <link rel="stylesheet" href="assets/responsive.css">
    <link rel="stylesheet" href="assets/style.map.css">
    <link rel="stylesheet" href="assets/style.scss">
    <link rel="stylesheet" href="assets/style1.css">
</head>

<body>
<div class="hero_area">
    <!-- header section strats -->

    <!-- end header section -->
    <!-- slider section -->
    <section class=" slider_section position-relative">

        <div class="slider_bg-container">

        </div>
        <div class="slider-container">

            <div class="detail-box">
                <h1>
                    Project <br>
                    StadsKlacht
                </h1>
                <p>
                  Welkom User, <br> <br>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab asperiores blanditiis debitis, doloribus eius enim fugit in magni maxime
                    molestiae numquam quos sequi similique temporibus voluptas voluptatibus voluptatum. Fugit, magni?
                </p>
                <div>

                </div>
            </div>



    </section>
    <!-- end slider section -->
</div>

<!-- about section -->
<section class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="detail-box">
                    <h6>
                        About
                    </h6>
                    <div class="custom_heading-container">
                        <h2>
                            Gemeente Roffa
                        </h2>
                        <hr>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, commodi cumque delectus
                        dignissimos dolorem doloremque impedit iure minima natus nemo,
                        nesciunt odio perferendis quam sapiente tempore velit voluptatibus! Doloribus, quas!
                    </p>
                    <div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="img-box">
                    <img src="images/about-img.png" alt="">
                </div>
            </div>
        </div>

    </div>
</section>







</body>


</html>