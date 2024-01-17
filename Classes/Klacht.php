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
    public function createKlacht()
    {
        require "database/conn.php";

        $omschrijving = $this->get_omschrijving();
        $gpsId = $this->get_gpsId();
        $foto = $this->get_foto();
        $klantId = $this->get_klantId();
        $status = $this->get_status();
        $timestamp = $this->get_timestamp();
        $gebruikersId = $this->get_gebruikersId();

        $sql = "INSERT INTO klachten (omschrijving, gpsId, foto, klantId, status, timestamp, gebruikersId)
                VALUES ('$omschrijving', '$gpsId', '$foto', '$klantId', '$status', '$timestamp', '$gebruikersId')";

        if (mysqli_query($con, $sql)) {
            echo "<p class='klachtMaded'>Klacht succesvol aangemaakt!</p>";
        } else {
            echo "Fout bij het aanmaken van de klacht: " . mysqli_error($con);
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
        echo '<tr><th>ID</th><th>Omschrijving</th><th>gpsID</th><th>Foto ID</th> <th>Status</th> <th>Timestamp</th><th>Gebruikers ID</th><th>Acties</th><th>Acties</th><th>Acties</th></tr>';

        foreach ($sql as $klacht) {
            echo '<tr>';
            echo '<td>' . $klacht['id'] . '</td>';
            echo '<td>' . $klacht['omschrijving'] . '</td>';
            echo '<td>' . $klacht['gpsId'] . '</td>';
            echo '<td>' . $klacht['foto'] . '</td>';
            echo '<td>' . $klacht['status'] . '</td>';
            echo '<td>' . $klacht['timestamp'] . '</td>';
            echo '<td>' . $klacht['gebruikersId'] . '</td>';
            echo '<td><a href="create_klacht.php">Create</a></td>';
            echo '<td><a href="?delete=' . $klacht['id'] . '">Delete</a></td>';
            echo '<td><a href="update_klacht.php">Update</a></td>';
            echo '</tr>';
        }

        echo '</table></div>';
    }

    public function updateKlacht($klachtId)
    {
        require 'database/conn.php';

        $omschrijving = $this->get_omschrijving();
        $gpsId = $this->get_gpsId();
        $foto = $this->get_foto();
        $klantId = $this->get_klantId();
        $status = $this->get_status();
        $timestamp = $this->get_timestamp();
        $gebruikersId = $this->get_gebruikersId();

        $sql = "UPDATE klachten SET omschrijving = '$omschrijving', gpsId = '$gpsId', foto = '$foto', klantId = '$klantId', status = '$status', timestamp = '$timestamp', gebruikersId = '$gebruikersId' WHERE id = $klachtId";

        if (mysqli_query($con, $sql)) {
            echo "<p class='klachtUpdated'>Klacht succesvol bijgewerkt!</p>";
        } else {
            echo "Fout bij het bijwerken van de klacht: " . mysqli_error($con);
        }
    }
    public function createKlachten($gebruikerID, $omschrijving)
    {
        require 'database/database.php';

        $sql = $conn->prepare('INSERT INTO klachten (gebruikersId, omschrijving) VALUES (:gebruikerID, :omschrijving )');
        $sql->bindParam(':gebruikerID', $gebruikerID);
        $sql->bindParam(':omschrijving', $omschrijving);


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
