<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<a href="index.php">&#8592;</a>
<?php
// Include the PDO connection file
include 'database/conn.php';

try {
    // Prepare SQL query
    $sql = "SELECT * FROM klachten ORDER BY id DESC";

    // Execute query
    $stmt = $conn->query($sql);

    // Check if there are any results
    if ($stmt->rowCount() > 0) {
        // Fetch all rows as associative array
        $klachten = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Loop through each row
        foreach ($klachten as $klacht) {
            ?>
            <div class="alb">
                <?php
                echo $klacht["omschrijving"];
                ?>
                <img src="assets/img/<?= $klacht['foto'] ?>" alt="<?=$klacht['foto']?>">
            </div>
            <?php
        }
    } else {
        // No klachten found
        echo "<p>No klachten found.</p>";
    }
} catch (PDOException $e) {
    // Catching any exceptions that occur during the query execution and displaying an error message
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
</body>
</html>
