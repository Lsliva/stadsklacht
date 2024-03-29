<?php

class Gebruiker {
    protected $email;
    protected $naam; // Veranderd van $wachtwoord naar $naam

    public function __construct($email = NULL, $naam = NULL) { // Veranderd van $wachtwoord naar $naam
        $this->email = $email;
        $this->naam = $naam; // Veranderd van $wachtwoord naar $naam
    }

    // ...

    public function getNaam() { // Nieuwe methode voor het ophalen van de naam
        return $this->naam;
    }

    public function setNaam($naam) { // Nieuwe methode voor het instellen van de naam
        $this->naam = $naam;
    }

    // ...

    public function readGebruiker($gebruikersId) {
        require 'database/conn.php';
    
        $sql = $conn->prepare('SELECT id, email, naam FROM gebruikers WHERE id =:id');
        $sql->bindParam(':id', $gebruikersId);
        $sql->execute();
    
        echo '<div style="display: flex; padding: 24px; font-size: 20px; justify-content: center; text-align: center; color: white; flex-direction: column; "><table>';
        echo '<tr><th>Email</th><th>Naam</th><th>Actie</th></tr>';
    
        foreach ($sql as $klacht) {
            echo '<tr>';
            echo '<td>' . $klacht['email'] . '</td>';
            echo '<td>' . $klacht['naam'] . '</td>';
            echo '<td><a href="update_gebruiker.php?id=' . $klacht['id'] . '">Update</a></td>'; // Voeg updateknop toe met link naar update_gebruiker.php
            echo '</tr>';
        }
    
        echo '</table></div>';
    }

    public function getKlantIdSession($qqleq) {

        require_once 'database/conn.php';
        $sql = $conn->prepare('SELECT id FROM gebruikers WHERE naam = :username');
        $sql->bindParam(':username', $qqleq);
    
        $sql->execute();
    
        $row = $sql->fetch(PDO::FETCH_ASSOC);
    
    
        if ($row) {
            return $row['id'];
        } else {
            return null;
        }

    }


    public function updateGebruiker($gebruikerId, $naam, $wachtwoord) {
        require 'database/conn.php';

        $updateSql = $conn->prepare('UPDATE gebruikers SET naam = :naam, wachtwoord = :wachtwoord WHERE id = :id');
        $updateSql->bindParam(':id', $gebruikerId);
        $updateSql->bindParam(':naam', $naam);
        $updateSql->bindParam(':wachtwoord', $wachtwoord);
        $updateSql->execute();
    }
    
    // get the user information using gebruikerId for gps pins
    public function getGebruiker($gebruikersId) {
        require 'database/conn.php';

        $statement = $conn->prepare("SELECT naam, email FROM gebruikers WHERE ID = :gebruikersId");
        $statement->bindParam(':gebruikersId', $gebruikersId, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetch(PDO::FETCH_ASSOC);

        return $results;
    }


    
   

}


