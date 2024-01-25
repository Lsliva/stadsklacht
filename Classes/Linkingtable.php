<?php


class Linkingtable {



    // methoden - functies -------------------
    // constructor
    public function __construct()
    {

    }

    // create a linking table for the new complaint with its gps
    public function createLinkTable($locationName, $latitude, $longitude, $omschrijving, $gebruikersId, $foto_name, $foto_size, $tmp_name) {
        require 'database/conn.php';
        require_once 'Classes/Klacht.php';
        require_once 'Classes/Gps.php';
        $gpsClass = new Gps;
        $klachtClass = new Klacht;
        $gebruikersId = intval($gebruikersId);
        // create klacht and return the primairy key
        $klachtId = $klachtClass->createKlachten($omschrijving, $gebruikersId);

        $klachtClass->foto($klachtId, $foto_name, $foto_size, $tmp_name);
        // create the gps location and return the primairy key
        $gpsId = $gpsClass->sendGps($locationName, $latitude, $longitude);

        $statement = $conn->prepare("INSERT INTO linkingtable (klachtenId, gpsId) VALUES (:klachtenId, :gpsId)");
        $statement->bindParam(':klachtenId', $klachtId);
        $statement->bindParam(':gpsId', $gpsId);

        $statement->execute();
        // Check if the execution was successful
        if ($statement->rowCount() > 0) {
            $last_id = $conn->lastInsertId();

        // Update gps table with linkId
        $sqlGps = $conn->prepare("UPDATE gps SET linkId = :linkId WHERE id = :gpsId");
        $sqlGps->bindParam(':linkId', $last_id);
        $sqlGps->bindParam(':gpsId', $gpsId);
        $sqlGps->execute();
    
        // Update klachten table with linkId
        $sqlKlacht = $conn->prepare("UPDATE klachten SET linkId = :linkId WHERE id = :klachtenId");
        $sqlKlacht->bindParam(':linkId', $last_id);
        $sqlKlacht->bindParam(':klachtenId', $klachtId);
        $sqlKlacht->execute();
        } else {
            echo "Error: " . $statement->errorInfo()[2]; // Get the detailed error message
        }
        

        $_SESSION['message'] = 'Complaint sent successfully!';
        //header("Location: readKlacht");

        // Controleer of rights NULL is in de sessie
if ($_SESSION['rights'] === NULL) {
    // Stuur de gebruiker door naar reviewPage.php met linkId in de URL
    header("Location: reviewCreate.php?linkId=$last_id");
    exit;
}

    }
    
    // get the needed id from the linking table using linkId
    // public function getIdWithLinkId($linkId, $columnName) {
    //     require 'database/conn.php';
    //     $query = "SELECT $columnName FROM linkingtable WHERE ID = :linkId";
    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindParam(':linkId', $linkId, PDO::PARAM_INT);
    //     $stmt->execute();

    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //     if (!$result) {
    //         return null; // ID not found
    //     }
    // }

    // get corresponding linkId using either klachtenId or gpsId
    public function getLinkId($givenId, $columnName) {
        require 'database/conn.php';
        
        $stmt = $conn->prepare("SELECT ID FROM linkingtable WHERE $columnName = :givenId");
        $stmt->bindParam(':givenId', $givenId);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$result) {
            return null; // ID not found
        }
    
        return $result; // Return the found linkId
    }
    

}