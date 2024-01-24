<?php
// KlachtDelete.php

class KlachtDeleter
{
    private $mysqli;

    // Constructor om de databaseverbinding in te stellen
    public function __construct($host, $username, $password, $database)
    {
        $this->mysqli = new mysqli($host, $username, $password, $database);

        // Controleer de verbinding
        if ($this->mysqli->connect_error) {
            die("Verbinding mislukt: " . $this->mysqli->connect_error);
        }
    }

    // Methode om een klacht te verwijderen op basis van ID
    public function deleteKlacht($klachtId)
    {
        // Voorkom SQL-injectie door gebruik te maken van prepared statements
        $query = "DELETE FROM klachten WHERE id = ?";
        $stmt = $this->mysqli->prepare($query);

        // Bind het klachtId aan het prepared statement
        $stmt->bind_param("i", $klachtId);

        // Voer het statement uit
        if ($stmt->execute()) {
            echo "Klacht met ID $klachtId is succesvol verwijderd.";
        } else {
            echo "Fout bij het verwijderen van klacht: " . $stmt->error;
        }

        // Sluit het statement
        $stmt->close();
    }

    // Destructor om de databaseverbinding te sluiten
    public function __destruct()
    {
        // Sluit de databaseverbinding
        $this->mysqli->close();
    }
}

// Gebruik voorbeeld:
$deleter = new KlachtDeleter("localhost", "gebruikersnaam", "wachtwoord", "database_naam");
$deleter->deleteKlacht(1); // Verwijder klacht met ID 1
?>
