<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>klachtenForm</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
<?php if (isset($_GET['error'])): ?>
    <p><?php echo $_GET['error']; ?></p>
<?php endif ?>
<form method="post" action="upload.php" enctype="multipart/form-data">
    <label for="foto">foto:</label>
    <input type="file" name="foto" accept="image/*">
    <input type="submit" value="send complaint" class="submitButton">
</body>