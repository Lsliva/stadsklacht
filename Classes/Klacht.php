<?php

class Klacht
{
    // properties - eigenschappen ------------
    protected $id;
    protected $omschrijving;
    protected $gpsId;
    protected $foto;
    protected $klantId;
    protected $status;
    protected $timestamp;
    protected $gebruikersId;

    // methoden - functies -------------------
    // constructor
    public function __construct($omschrijving = NULL, $gpsId = NULL, $foto = NULL, $klantId = NULL, $status = NULL, $timestamp = NULL, $gebruikersId = NULL)
    {
        $this->omschrijving = $omschrijving;
        $this->gpsId = $gpsId;
        $this->foto = $foto;
        $this->klantId = $klantId;
        $this->status = $status;
        $this->timestamp = $timestamp;
        $this->gebruikersId = $gebruikersId;
    }

    // setters
    public function set_id($id)
    {
        $this->id = $id;
    }

    public function set_omschrijving($omschrijving)
    {
        $this->omschrijving = $omschrijving;
    }

    public function set_gpsId($gpsId)
    {
        $this->gpsId = $gpsId;
    }

    public function set_foto($foto)
    {
        $this->foto = $foto;
    }

    public function set_klantId($klantId)
    {
        $this->klantId = $klantId;
    }

    public function set_status($status)
    {
        $this->status = $status;
    }

    public function set_timestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function set_gebruikersId($gebruikersId)
    {
        $this->gebruikersId = $gebruikersId;
    }

    // getters
    public function get_id()
    {
        return $this->id;
    }

    public function get_omschrijving()
    {
        return $this->omschrijving;
    }

    public function get_gpsId()
    {
        return $this->gpsId;
    }

    public function get_foto()
    {
        return $this->foto;
    }

    public function get_klantId()
    {
        return $this->klantId;
    }

    public function get_status()
    {
        return $this->status;
    }

    public function get_timestamp()
    {
        return $this->timestamp;
    }

    public function get_gebruikersId()
    {
        return $this->gebruikersId;
    }

    // methods specific to handling complaints
    public function createKlachten($omschrijving, $gebruikersId)
    {
        require 'database/conn.php';
        // $gebruikersId = (int)$gebruikersId;
        $sql = $conn->prepare('INSERT INTO klachten (omschrijving, gebruikersId) VALUES (:omschrijving, :gebruikersId)');
        $sql->bindParam(':omschrijving', $omschrijving);
        $sql->bindParam(':gebruikersId', $gebruikersId);
        $sql->execute();

        // Check if the execution was successful
        if ($sql->rowCount() > 0) {
            $last_id = $conn->lastInsertId();
            // echo $last_id;
            return $last_id;
        } else {
            echo "Error: " . $sql->errorInfo()[2]; // Get the detailed error message
        }
    }

    public function foto($klachtId, $foto_name, $foto_size, $tmp_name)
    {
        require 'database/conn.php';



        $target_dir = 'assets/img/';

        $img_ex = pathinfo($foto_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        // Generate a unique file name for the image
        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;

        // Define the target path for the image
        $target_path = $target_dir . $new_img_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmp_name, $target_path)) {
            try {
                // Prepare SQL query with a parameter placeholder
                $sql = "UPDATE klachten SET foto = :foto WHERE id = :klachtId";
                $stmt = $conn->prepare($sql);

                // Bind the parameter values
                $stmt->bindParam(':foto', $new_img_name, PDO::PARAM_STR);
                $stmt->bindParam(':klachtId', $klachtId, PDO::PARAM_INT);

                // Execute the query
                $stmt->execute();

                // Redirect to view.php
                return true; // Terminate script execution after redirection
            } catch (PDOException $e) {
                // Catching any exceptions that occur during the query execution and displaying an error message
                $em = "Error: " . $e->getMessage();
                header("Location: index.php?error=$em");
                exit(); // Terminate script execution after redirection
            }
        }
    }

    public function readKlacht()
    {
        require 'database/conn.php';


        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];

            // First, delete related records in the 'gps' table
            $deleteGpsRecords = $conn->prepare('DELETE FROM gps WHERE klachtenId = ?');
            $deleteGpsRecords->execute([$id]);

            // Now, delete the record from the 'klachten' table
            $deleteKlachtRecord = $conn->prepare('DELETE FROM klachten WHERE id = ?');
            $deleteKlachtRecord->execute([$id]);
        }

    

        $sql = $conn->prepare('SELECT * FROM klachten');
        $sql->execute();
    
        echo '<div style="display: flex; padding: 24px; font-size: 20px; justify-content: center; text-align: center; color: white; flex-direction: column; "><table>';
        echo '<tr><th>ID</th><th>Omschrijving</th><th>Foto ID</th> <th>Status</th> <th>Timestamp</th><th>Gebruikers ID</th><th>linkId</th><th>Acties</th><th>Acties</th><th>Acties</th></tr>';
    
        foreach ($sql as $klacht) {
            echo '<tr>';
            echo '<td>' . $klacht['id'] . '</td>';
            echo '<td>' . $klacht['omschrijving'] . '</td>';
            echo '<td>' . $klacht['foto'] . '</td>';
            echo '<td>' . $klacht['status'] . '</td>';
            echo '<td>' . $klacht['timestamp'] . '</td>';
            echo '<td>' . $klacht['gebruikersId'] . '</td>';
            echo '<td>' . $klacht['linkId'] . '</td>';
            echo '<td><a href="create_klacht.php">Create</a></td>';
            echo '<td><a href="update_klacht.php?id=' . $klacht['id'] . '">Update</a></td>';
            echo '<td><a href="delete_klacht.php?linkId=' . $klacht['linkId'] . '">Delete</a></td>'; // Add this line for the delete button
    
            echo '</tr>';
        }
    
        echo '</table></div>';
    }
    
    public function readnotification()
    {
        require 'database/conn.php';


        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];

            // First, delete related records in the 'gps' table
            $deleteGpsRecords = $conn->prepare('DELETE FROM gps WHERE klachtenId = ?');
            $deleteGpsRecords->execute([$id]);

            // Now, delete the record from the 'klachten' table
            $deleteKlachtRecord = $conn->prepare('DELETE FROM klachten WHERE id = ?');
            $deleteKlachtRecord->execute([$id]);
        }
        // Huidige datum en tijd
        $currentDateTime = new DateTime();

// Twee weken geleden
        $twoWeeksAgo = $currentDateTime->sub(new DateInterval('P14D'));

// Query om rijen op te halen waar de timestampkolom meer dan twee weken oud is
        $sql = $conn->prepare("SELECT * FROM klachten WHERE timestamp < '" . $twoWeeksAgo->format('Y-m-d H:i:s') . "'");

        $sql->execute();

        echo '<div style="display: flex; padding: 24px; font-size: 20px; justify-content: center; text-align: center; color: white; flex-direction: column; "><table>';
        echo '<tr><th>ID</th><th>Omschrijving</th><th>Foto ID</th> <th>Status</th> <th>Timestamp</th><th>Gebruikers ID</th><th>linkId</th><th>Acties</th><th>Acties</th><th>Acties</th></tr>';

        foreach ($sql as $klacht) {
            echo '<tr>';
            echo '<td>' . $klacht['id'] . '</td>';
            echo '<td>' . $klacht['omschrijving'] . '</td>';
            echo '<td>' . $klacht['foto'] . '</td>';
            echo '<td>' . $klacht['status'] . '</td>';
            echo '<td>' . $klacht['timestamp'] . '</td>';
            echo '<td>' . $klacht['gebruikersId'] . '</td>';
            echo '<td>' . $klacht['linkId'] . '</td>';
            echo '<td><a href="userupdate.php">Update</a></td>';
            echo '<td><a href="delete_klacht.php?linkId=' . $klacht['linkId'] . '">Delete</a></td>'; // Add this line for the delete button
            
            echo '</tr>';
        }

        echo '</table></div>';
    }

    public function NotificationCount()
    {
        require 'database/conn.php';

        // Huidige datum en tijd
        $currentDateTime = new DateTime();

        // Twee weken geleden
        $twoWeeksAgo = $currentDateTime->sub(new DateInterval('P14D'));

        // Voorbereiden van de SQL-query met een prepared statement
// Query om rijen op te halen waar de timestampkolom meer dan twee weken oud is
        $sql = $conn->prepare("SELECT * FROM klachten WHERE timestamp < '" . $twoWeeksAgo->format('Y-m-d H:i:s') . "'");

        // Uitvoeren van de query
        $sql->execute();

        // Resultaten ophalen als een associatieve array
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);


        // Aantal rijen tellen
        $rowCount = count($result);

        return $rowCount;
    }


    public function updateKlacht($linkId, $omschrijving, $status)
    {
        require 'database/conn.php';
        require 'Classes/Gps.php';
        $gps = new Gps();
        if ($status == 'Fixed') {
            $gps->updateGps($linkId);
        }
        $sql = $conn->prepare('UPDATE klachten SET omschrijving = :omschrijving, status = :status WHERE linkId = :linkId');
        $sql->bindParam(':linkId', $linkId);
        $sql->bindParam(':omschrijving', $omschrijving);
        $sql->bindParam(':status', $status);
        $sql->execute();
        $_SESSION['message'] = 'Klacht geupdate!';
        header("Location: openstreetmap");

    }


    // get the klachten information using klachtenId for gps pins
    public function getKlachten($linkId)
    {
        require 'database/conn.php';

        $statement = $conn->prepare("SELECT omschrijving, foto, status, timestamp, gebruikersId FROM klachten WHERE linkId = :linkId");
        $statement->bindParam(':linkId', $linkId, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetch(PDO::FETCH_ASSOC);

        return $results;
    }

    public function readKlachtGebruiker($gebruikersId)
    {
        require 'database/conn.php';
    
        if (!isset($_SESSION['gebruikerId'])) {
            // Redirect naar de inlogpagina als de gebruiker niet is ingelogd
            header("Location: readKlacht.php");
            exit();
        }
    
        $sql = $conn->prepare('SELECT * FROM klachten WHERE gebruikersId = ?');
        $sql->execute([$gebruikersId]);
    
        echo '<div style="display: flex; padding: 24px; font-size: 20px; justify-content: center; text-align: center; color: white; flex-direction: column; "><table>';
        echo '<tr><th>ID</th><th>Omschrijving</th><th>Foto ID</th><th>Status</th><th>Timestamp</th><th>Gebruikers ID</th><th>linkId</th><th>Acties</th><th>Acties</th><th>Acties</th></tr>';
    
        foreach ($sql as $klacht) {
            echo '<tr>';
            echo '<td>' . $klacht['id'] . '</td>';
            echo '<td>' . $klacht['omschrijving'] . '</td>';
            echo '<td>' . $klacht['foto'] . '</td>';
            echo '<td>' . $klacht['status'] . '</td>';
            echo '<td>' . $klacht['timestamp'] . '</td>';
            echo '<td>' . $klacht['gebruikersId'] . '</td>';
            echo '<td>' . $klacht['linkId'] . '</td>';
            echo '<td><a href="create_klacht.php">Create</a></td>';
            echo '<td><a href="update_klacht.php">Update</a></td>';
            echo '<td><a href="delete_klacht.php?linkId=' . $klacht['linkId'] . '&klantwaarde=' . $klacht['gebruikersId'] . '">Delete</a></td>';

    
            echo '</tr>';
        }
    
        echo '</table></div>';
    }

    


    public function deleteKlacht($linkId)
    {
        require 'database/conn.php';
    
        try {
            // Disable foreign key checks temporarily
            $conn->exec('SET foreign_key_checks = 0;');
    
            // Delete associated records from the linkingtable first
            $deleteLinkingQuery = $conn->prepare('DELETE FROM linkingtable WHERE ID = :linkId');
            $deleteLinkingQuery->bindParam(':linkId', $linkId, PDO::PARAM_INT);
            $deleteLinkingQuery->execute();
    
            // Enable foreign key checks again
            $conn->exec('SET foreign_key_checks = 1;');
    
            // Now delete the record from klachten
            $deleteKlachtenQuery = $conn->prepare('DELETE FROM klachten WHERE linkId = :linkId');
            $deleteKlachtenQuery->bindParam(':linkId', $linkId, PDO::PARAM_INT);
            $deleteKlachtenQuery->execute();
    
            // Also, delete from the 'gps' table if needed
            $deleteGPSQuery = $conn->prepare('DELETE FROM gps WHERE linkId = :linkId');
            $deleteGPSQuery->bindParam(':linkId', $linkId, PDO::PARAM_INT);
            $deleteGPSQuery->execute();
    
            echo "Klacht successfully deleted.";
        } catch (PDOException $e) {
            // Handle the exception
            echo "Error deleting klacht: " . $e->getMessage();
        }
    }
    
}
