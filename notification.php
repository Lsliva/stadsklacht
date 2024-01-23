<?php
// Stel de datum in van twee weken geleden
$limietDatum = date('Y-m-d', strtotime('-2 weeks'));

// Verbind met de database (vervang deze gegevens door je eigen databasegegevens)
$host = "localhost";
$gebruikersnaam = "root";
$wachtwoord = "";
$database = "stadsklacht";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);


// Controleer op fouten in de verbinding
if ($conn->connect_error) {
    die("Verbindingsfout: " . $conn->connect_error);
}

// Haal locaties op waarvan de toevoegdatum twee weken geleden is
$sql = "SELECT locatie_naam FROM jouw_tabel WHERE toevoegdatum <= '$limietDatum'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Stuur een notificatie naar de beheerder
    $beheerderEmail = "beheerder@example.com";
    $onderwerp = "Notificatie: Locaties toegevoegd twee weken geleden";
    $bericht = "Er zijn locaties toegevoegd twee weken geleden. Controleer de lijst.";

    // Stuur de e-mail naar de beheerder
    mail($beheerderEmail, $onderwerp, $bericht);

    echo "Notificatie verstuurd naar de beheerder.";
} else {
    echo "Geen locaties gevonden die twee weken geleden zijn toegevoegd.";
}

// Sluit de databaseverbinding
$conn->close();
?>
