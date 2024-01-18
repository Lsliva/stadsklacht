<?php

class Gebruiker {
    protected $email;
    protected $wachtwoord;

    public function __construct($email, $wachtwoord) {
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
}

?>
