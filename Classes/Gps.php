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

    // create gps location and return the primairy key
    public function sendGps($locationName, $latitude, $longitude) {
        require 'database/conn.php';

        $statement = $conn->prepare("INSERT INTO gps (locationName, latitude, longitude) VALUES (:locationName, :latitude, :longitude)");
        $statement->bindParam(':locationName', $locationName);
        $statement->bindParam(':latitude', $latitude);
        $statement->bindParam(':longitude', $longitude);
        $statement->execute();

        // Check if the execution was successful
        if ($statement->rowCount() > 0) {
            $last_id = $conn->lastInsertId();
            // echo $last_id;
            return $last_id;
        } else {
            echo "Error: " . $statement->errorInfo()[2]; // Get the detailed error message
        }

    }

    // create a linking table for the new complaint with its gps
    public function createLinkTable($locationName, $latitude, $longitude) {
        require 'database/conn.php';
        // create the gps location and return the primairy key
        $gpsId = $this->sendGps($locationName, $latitude, $longitude);
        // create klacht and return the primairy key
        require_once 'Classes/Klacht.php';
        $klachtClass = new Klacht;
        $klachtId = $klachtClass->createKlacht($omschrijving, $gebruikersId);
    }

    // get gps with klantId for search function
    public function getGpsByKlachtenId($klachtenId) {
        require 'database/conn.php';

        $statement = $conn->prepare("SELECT latitude, longitude, klachtenId, timestamp FROM gps WHERE klachtenId = :klachtenId");
        $statement->bindParam(':klachtenId', $klachtenId);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $count = count($results);
        if ($count == 0) {
            // KlachtId does not exist, return an error response
            echo json_encode(['alert' => 'KlachtId not found']);
            exit();
        }

        // Fetch related klachten information for each GPS location
        foreach ($results as &$location) {
            $klachtenInfo = $this->getKlachten($location['klachtenId']);
            // Check if klachten information is available
            if ($klachtenInfo) {
                $gebruikerInfo = $this->getGebruiker($klachtenInfo['gebruikersId']);
                
                // Merge klachten and gebruiker information into the existing result
                $location = array_merge($location, $klachtenInfo, $gebruikerInfo);
            }
        }

        // Output the results as JSON
        header('Content-Type: application/json');
        echo json_encode($results);
    }

    // get all the gps locations from the database with related klachten information
    public function getGps() {
        require 'database/conn.php';

        $statement = $conn->prepare("SELECT locationName, latitude, longitude, klachtenId, timestamp FROM gps");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Fetch related klachten information for each GPS location
        foreach ($results as &$location) {
            $klachtenInfo = $this->getKlachten($location['klachtenId']);
            // Check if klachten information is available
            if ($klachtenInfo) {
                $gebruikerInfo = $this->getGebruiker($klachtenInfo['gebruikersId']);
                
                // Merge klachten and gebruiker information into the existing result
                $location = array_merge($location, $klachtenInfo, $gebruikerInfo);
            }
        }

        // Output the results as JSON
        header('Content-Type: application/json');
        echo json_encode($results);
    }


    // get the klachten information using klachtenId for gps pins
    public function getKlachten($klachtenId) {
        require 'database/conn.php';

        $statement = $conn->prepare("SELECT omschrijving, foto, status, timestamp, gebruikersId FROM klachten WHERE id = :klachtenId");
        $statement->bindParam(':klachtenId', $klachtenId, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetch(PDO::FETCH_ASSOC);

        return $results;
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

