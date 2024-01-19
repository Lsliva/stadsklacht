<?php
require_once 'assets/nav.php';
require_once 'Classes/Gebruiker.php';
require_once 'database/database.php';



// Controleer of de gebruiker is ingelogd
if (isset($_SESSION['gebruiker'])) {
    $gebruiker = $_SESSION['gebruiker'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nieuwEmail = $_POST['email'];
        $nieuwWachtwoord = $_POST['wachtwoord'];

        // Update de gegevens in de database
        $updateQuery = "UPDATE gebruikers SET email = '$nieuwEmail', wachtwoord = '$nieuwWachtwoord' WHERE email = '{$gebruiker->getEmail()}'";
        
        if ($conn->query($updateQuery) === TRUE) {
            // Update de gebruiker in de sessie
            $gebruiker->setEmail($nieuwEmail);
            $gebruiker->setWachtwoord($nieuwWachtwoord);

            echo "Gegevens succesvol bijgewerkt.";
        } else {
            echo "Fout bij het bijwerken van gegevens: " . $conn->error;
        }
    }
}
// } else {
//     // Redirect naar inlogpagina als de gebruiker niet is ingelogd
//     header("Location: login.php");
//     exit();
// }



?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accountpagina</title>
</head>
<body>

    <h1>Accountpagina</h1>

    <form action="Account.php" method="post">
        <label for="email">Nieuw E-mailadres:</label>
        <input type="email" name="email" id="email" value="<?php echo $gebruiker->getEmail(); ?>" required>

        <label for="wachtwoord">Nieuw Wachtwoord:</label>
        <input type="password" name="wachtwoord" id="wachtwoord" required>

        <input type="submit" name="submit" value="Opslaan">
    </form>

</body>
</html>
