<?php
require_once 'inlogCheck.php';

session_start();
if ($_SESSION['rights'] !== 'management' && $_SESSION['rights'] !== 'admin'){
    header("Location: restrictedContent");
} else {
session_abort();
?>
<?php include("assets/nav.php");?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/style.scss">
    <title>Document</title>
</head>
<body>
<?php

?><div class="readContent">
    <div class="readCreate">
        <div class="readCenter">
            <?php
           
            $klacht->readnotification();
            ?>
        </div>

    </div>
</div>
<?php } ?>
</body>
</html>