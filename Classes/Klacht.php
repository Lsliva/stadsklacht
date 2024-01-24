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
    public function createKlachten($omschrijving, $foto, $gebruikersId)
    {

        // $gebruikersId = (int)$gebruikersId;
        $sql = $conn->prepare('INSERT INTO klachten (omschrijving, foto, gebruikersId) VALUES (:omschrijving, :foto :gebruikersId)');
        $sql->bindParam(':omschrijving', $omschrijving);
        $sql->bindParam(':foto', $foto);
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
            echo '<td><a href="?delete=' . $klacht['id'] . '">Delete</a></td>';
            echo '<td><a href="update_klacht.php">Update</a></td>';
            echo '</tr>';
        }

        echo '</table></div>';
    }

    public function updateKlacht($linkId, $omschrijving, $status)
{
    require 'database/conn.php';

    $sql = $conn->prepare('UPDATE klachten SET omschrijving = :omschrijving, status = :status WHERE linkId = :linkId');
    $sql->bindParam(':linkId', $linkId);
    $sql->bindParam(':omschrijving', $omschrijving);
    $sql->bindParam(':status', $status);
    $sql->execute();
    $_SESSION['message'] = 'Klacht geupdate!';
        header("Location: openstreetmap");
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

    public function readKlachtGebruiker($gebruikersId)
    {
        require 'database/conn.php';


        if (!isset($_SESSION['gebruikerId'])) {
            // Redirect naar de inlogpagina als de gebruiker niet is ingelogd
            header("Location: readKlacht.php");
            exit();
        }

        // Remove the following line, as $gebruikersId is already set using $_SESSION['gebruikersId']
        // $gebruikersId = $_SESSION['gebruikersId'];

        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];

            // Eerst verwijderen van gerelateerde records in de 'gps' tabel
            $deleteGpsRecords = $conn->prepare('DELETE FROM gps WHERE klachtenId = ?');
            $deleteGpsRecords->execute([$id]);

            // Nu het record verwijderen uit de 'klachten' tabel
            $deleteKlachtRecord = $conn->prepare('DELETE FROM klachten WHERE id = ? AND gebruikersId = ?');
            $deleteKlachtRecord->execute([$id, $gebruikersId]);
        }

        $sql = $conn->prepare('SELECT * FROM klachten WHERE gebruikersId = ?');
        $sql->execute([$gebruikersId]);

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
            echo '<td><a href="?delete=' . $klacht['id'] . '">Delete</a></td>';
            echo '<td><a href="update_klacht.php">Update</a></td>';
            echo '</tr>';
        }

        echo '</table></div>';
    }

}
