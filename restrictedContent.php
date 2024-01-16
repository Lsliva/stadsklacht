<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<?php include("assets/nav.php"); ?>
<style>
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); */
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
        }
        .supportView, .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .redirect a{
            color: black;
        }
    </style>
<main>
    <div class="content">
        <div class="supportView">
            <div class="container">
                <h1>Restricted Access</h1>
                <p>Sorry, but you don't have permission to access this content.</p>
                <p>If you believe this is an error, please contact the administrator.</p>
                <p class="redirect"><a href="loginForm.php">Login here<i class='bx bxs-right-arrow-alt'></i></a></p>
            </div>
        </div>        
    </div>
</main>

<script src="assets/main.js"></script>
</body>
</html>