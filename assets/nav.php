<?php
require 'database/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link href="assets/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/main.css">
    <link rel="stylesheet" href="assets/responsive.css">
    <link rel="stylesheet" href="assets/style.map.css">
    <link rel="stylesheet" href="assets/style.scss">
    <link rel="stylesheet" href="assets/style1.css">
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>


</head>
<body>
<header class="header_section">
    <div class="container-fluid">

    </div>

<nav class="navbar navbar-expand-lg custom_nav-container ">
    <a class="navbar-brand" href="./">
        <img src="images/logo.png" alt="">
        <span>Stadsklacht</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
            <ul class="navbar-nav  ">
                <li class="nav-item active">
                    <a class="nav-link" href="./">Home <span class="sr-only">(current)</span></a>
                </li>
                <?php
                // Check if user is logged in
                if(isset($_SESSION['username'])) {
                    require 'rights.php';
                     // Display different navigation bar based on user's 'functie'
                     switch($rights) {
                        case "admin":
                            echo '<li class="nav-item"><a class="nav-link" href="openstreetmap">map</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="klantStreetmap">+ complaint</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="klachtenread">All complaints</a></li>';  
                            echo '<li class="nav-item"><a class="nav-link" href="notification">notification</a></li>';  

                            break;
                        case "management":
                            echo '<li class="nav-item"><a class="nav-link" href="openstreetmap">map</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="klantStreetmap">+ complaint</a></li>';    
                            echo '<li class="nav-item">< class="nav-link" href="klachtenread">All complaints</<a>/li>';    
                            echo '<li class="nav-item"><a class="nav-link" href="notification">notification</a></li>';  


                            break;
                        case 'NULL'|| NULL:
                            // Display navigation bar for klant
                            echo '<li class="nav-item"><a class="nav-link" href="about">about us</a></li>';  
                            echo '<li class="nav-item"><a class="nav-link" href="klantStreetmap">+ complaint</a></li>';  
                            echo '<li class="nav-item"><a class="nav-link" href="readKlacht">All my complaints</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="account">Account</a></li>';
                            break;
                    default:
                        // Display default navigation bar
                        break;
                    }

                } else {

                    // Display navigation bar for non-logged-in users
                    ?>
                   <li class="nav-item">
                    <a class="nav-link" href="about">about</a>
                    </li>

                    <?php

                }
                ?>
            </ul>
        </div>
        <div class="quote_btn-container  d-flex justify-content-center">


        </div>
    </div>
    <?php if(isset($_SESSION['username'])): ?>
        <a href="account"><div class="username"><?php echo $_SESSION['username']; ?></div></a>
        <div class="accountDiv">
            <li><a id="logoutBtn" href="logout"><i class='bx bx-log-out'></i>Logout</a></li>

        </div>
    <?php else: ?>
        <div class="Hlogin">
            <li><a class="Hlogin" href="loginForm">Login</a></li>
            <li><a class="Hlogin" href="registerForm">Register</a></li>
        </div>
    <?php endif; ?>

</nav>
</header>
</body>
