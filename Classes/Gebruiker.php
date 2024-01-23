<?php

class Gebruiker {
    protected $email;
    protected $wachtwoord;

    public function __construct($email = NULL, $wachtwoord = NULL) {
        $this->email = $email;
        $this->wachtwoord = $wachtwoord;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getWachtwoord() {
        return $this->wachtwoord;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setWachtwoord($wachtwoord) {
        $this->wachtwoord = $wachtwoord;
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


}


