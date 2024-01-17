<?php


class Linkingtable {



    // methoden - functies -------------------
    // constructor
    public function __construct()
    {

    }

    // create a linking table for the new complaint with its gps
    public function createLinkTable($locationName, $latitude, $longitude, $omschrijving, $gebruikersId) {
        require 'database/conn.php';
        require_once 'Classes/Klacht.php';
        require_once 'Classes/Gps.php';
        $gpsClass = new Gps;
        $klachtClass = new Klacht;
        $gebruikersId = intval($gebruikersId);
        // create klacht and return the primairy key
        $klachtId = $klachtClass->createKlachten($omschrijving, $gebruikersId);

        // create the gps location and return the primairy key
        $gpsId = $gpsClass->sendGps($locationName, $latitude, $longitude);

        $statement = $conn->prepare("INSERT INTO linkingtable (klachtenId, gpsId) VALUES (:klachtenId, :gpsId)");
        $statement->bindParam(':klachtenId', $klachtId);
        $statement->bindParam(':gpsId', $gpsId);

        $statement->execute();

        $_SESSION['message'] = 'Complaint sent successfully!';
        header("Location: klachtenread");
    }
    
    // get the other id from the linking table using either klachtenId or gpsId
    public function linkingTableOtherId($givenId, $columnName) {
        require 'database/conn.php';
        $query = "SELECT * FROM linkingtable WHERE $columnName = :givenId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':givenId', $givenId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null; // ID not found
        }
    }





}