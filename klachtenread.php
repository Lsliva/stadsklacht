<?php
require 'Classes/KLacht.php';

// Assuming you have a method to get all complaints from the database in your Klacht class
$klacht = new Klacht();
$complaints = $klacht->getAllComplaints(); // You need to implement this method in your Klacht class

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Klacht</title>
    <!-- Add your CSS styling here -->
</head>

<body>
<div style="display: flex; padding: 24px; font-size: 20px; justify-content: center; text-align: center; color: white; flex-direction: column; ">
    <table>
        <tr>
            <th>ID</th>
            <th>Omschrijving</th>
            <th>Foto ID</th>
            <th>Status</th>
            <th>Timestamp</th>
            <th>Gebruikers ID</th>
            <th>linkId</th>
            <th>Acties</th>
            <th>Acties</th>
            <th>Acties</th>
        </tr>

        <?php foreach ($complaints as $klacht) : ?>
            <tr>
                <td><?= $klacht['id'] ?></td>
                <td><?= $klacht['omschrijving'] ?></td>
                <td><?= $klacht['foto'] ?></td>
                <td><?= $klacht['status'] ?></td>
                <td><?= $klacht['timestamp'] ?></td>
                <td><?= $klacht['gebruikersId'] ?></td>
                <td><?= $klacht['linkId'] ?></td>
                <td><a href="create_klacht.php">Create</a></td>
                <td><a href="?delete=<?= $klacht['id'] ?>">Delete</a></td>
                <td><a href="update_klacht.php">Update</a></td>
            </tr>
        <?php endforeach; ?>

    </table>
</div>
</body>

</html>