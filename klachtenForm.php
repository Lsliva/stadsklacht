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
<form method="post" action="klachten.php">
    <label for="omschrijving">Omschrijving</label>
    <input type="text" name="omschrijving" required>
    <br>
    <input type="submit" value="Submit">
</form>
</body>
<style>
    input {
        width: 200px;
        padding: 10px 15px;
        margin: 5px 0;
        box-sizing: border-box;
    }
</style>
<script src="assets/klachten.js"></script>
</body>
</html>