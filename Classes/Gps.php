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

    // get gps with klantId for search function
    public function searchGpsByKlachtenId($klachtenId) {
        require 'database/conn.php';
        require 'Classes/Linkingtable.php';
        $linkingtable = new Linkingtable();
        $columnName = 'klachtenId';
        $linkId =  (int)$linkingtable->getLinkId($klachtenId, $columnName);

        $statement = $conn->prepare("SELECT locationName, latitude, longitude, timestamp FROM gps WHERE linkId = :linkId");
        $statement->bindParam(':linkId', $linkId);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $count = count($results);
        if ($count == 0) {
            // KlachtId does not exist, return an error response
            echo json_encode(['alert' => 'linkId not found']);
            exit();
        }

        // Fetch related klachten information for each GPS location
        foreach ($results as &$location) {
            require 'Classes/Gebruiker.php';
            $gebruikerClass = new Gebruiker();
            $klachtenInfo = $this->getKlachten($linkId);
            // Check if klachten information is available
            if ($klachtenInfo) {
                $gebruikerInfo = $gebruikerClass->getGebruiker($klachtenInfo['gebruikersId']);
                
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
        require 'Classes/Gebruiker.php';
        $gebruikerClass = new Gebruiker();
        $statement = $conn->prepare("SELECT locationName, latitude, longitude, linkId, timestamp FROM gps");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Fetch related klachten information for each GPS location
        foreach ($results as &$location) {
            $klachtenInfo = $this->getKlachten($location['linkId']);
            // Check if klachten information is available
            if ($klachtenInfo) {
                $gebruikerInfo = $gebruikerClass->getGebruiker($klachtenInfo['gebruikersId']);
                
                // Merge klachten and gebruiker information into the existing result
                $location = array_merge($location, $klachtenInfo, $gebruikerInfo);
            }
        }

        // Output the results as JSON
        header('Content-Type: application/json');
        echo json_encode($results);
    }


    // get the klachten information using klachtenId for gps pins
    public function getKlachten($linkId) {
        require 'database/conn.php';

        $statement = $conn->prepare("SELECT omschrijving, foto, status, timestamp, gebruikersId FROM klachten WHERE linkId = :linkId");
        $statement->bindParam(':linkId', $linkId, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetch(PDO::FETCH_ASSOC);

        return $results;
    }


}

