<?php
require 'database/conn.php';
require 'assets/nav.php';


// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikerId = $_POST['gebruikerId'];
    $naam = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];

    // Hash het wachtwoord voordat je het opslaat
    $hashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

    // Voer de bijwerking uit
    $updateSql = $conn->prepare('UPDATE gebruikers SET naam = :naam, wachtwoord = :wachtwoord WHERE id = :id');
    $updateSql->bindParam(':id', $gebruikerId);
    $updateSql->bindParam(':naam', $naam);
    $updateSql->bindParam(':wachtwoord', $hashedWachtwoord);
    $updateSql->execute();

    // Redirect naar de gebruikerslijst of een andere pagina indien nodig
    header("Location: account.php");
    exit();
} else 
    // Toon het formulier om de gebruiker bij te werken
    $gebruikerId = $_GET['id'];
    $sql = $conn->prepare('SELECT id, email, naam FROM gebruikers WHERE id = :id');
    $sql->bindParam(':id', $gebruikerId);
    $sql->execute();
    $gebruiker = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Gebruiker Bijwerken</title>
</head>
<body>
    <div class="content">
    <h2>Gebruiker Bijwerken</h2>
    <form method="POST" action="update_gebruiker.php">
        <input type="hidden" name="gebruikerId" value="<?php echo $gebruiker['id']; ?>">
        <label for="naam">Naam:</label>
        <input type="text" name="naam" value="<?php echo $gebruiker['naam']; ?>" required>
        <br>
        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" name="wachtwoord" required>
        <br>
        <input type="submit" value="Bijwerken">
    </form>
    </div>
</body>
</html>
