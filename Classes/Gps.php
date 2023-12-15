<?php


class Gps {

    public $klachtenId;
    public $latitude;
    public $longitude;

    // methoden - functies -------------------
    // constructor
    public function __construct($klachtenId = NULL, $latitude = NULL, $longitude = NULL)
    {
        $this->klachtenId = $klachtenId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function sendGps($klachtenId, $latitude, $longitude) {
        require 'database/conn.php';

        $statement = $conn->prepare("INSERT INTO gps (latitude, longitude, klachtenId) VALUES (:latitude, :longitude, :klachtenId)");
        // $statement->bindParam(':userId', $userId);
        $statement->bindParam(':latitude', $latitude);
        $statement->bindParam(':longitude', $longitude);
        $statement->bindParam(':klachtenId', $klachtenId);
        $statement->execute();

    }


    // get all the gps locatins from the database
    public function getGps() {
        require 'database/conn.php';

        $statement = $conn->prepare("SELECT latitude, longitude, klachtenId, timestamp FROM gps");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Output the results as JSON
        header('Content-Type: application/json');
        echo json_encode($results);
    }

    // get gps with klantId for search function
    public function getGpsByKlachtenId($klachtenId) {
        require 'database/conn.php';

        $statement = $conn->prepare("SELECT latitude, longitude, klachtenId, timestamp FROM gps WHERE klachtenId = :klachtenId");
        $statement->bindParam(':klachtenId', $klachtenId, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);

    }
}

