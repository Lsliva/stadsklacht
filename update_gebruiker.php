<?php
require 'Gebruiker.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikerId = $_POST['gebruiker_id'];
    $naam = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];

    $gebruiker = new Gebruiker();
    $gebruiker->updateGebruiker($gebruikerId, $naam, $wachtwoord);

    // Redirect naar de pagina na de update
    header('Location: lees_gebruikers.php'); // Vervang dit met de daadwerkelijke pagina waar je de gebruikersgegevens leest
    exit();
} else {
    // Laad het formulier met de bestaande gebruikersgegevens
    $gebruikerId = $_GET['id'];
    $gebruiker = new Gebruiker();
    $gebruikerData = $gebruiker->getGebruiker($gebruikerId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Gebruiker</title>
</head>
<body>
    <h2>Update Gebruiker</h2>
    <form method="post" action="update_gebruiker.php">
        <input type="hidden" name="gebruiker_id" value="<?php echo $gebruikerData['id']; ?>">
        Naam: <input type="text" name="naam" value="<?php echo $gebruikerData['naam']; ?>"><br>
        Wachtwoord: <input type="password" name="wachtwoord" value="<?php echo $gebruikerData['wachtwoord']; ?>"><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>

<?php
}
?>
