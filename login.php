<?php
session_start();
$username = $_POST['naam'];
$password = $_POST['wachtwoord'];

$_SESSION['usernamePost'] = $_POST['naam'];
$_SESSION['passwordPost'] = $_POST['wachtwoord'];

try {
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "stadsklacht";

    // Create PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);

    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE naam = :naam");
    $stmt->bindParam(':naam', $username);
    $stmt->bindParam(':naam', $username);

    // Execute statement
    $stmt->execute();

    // Fetch all rows
    $results = $stmt->fetchAll();

    if (!empty($results)) {
        $hashed_password = $results[0]['wachtwoord'];
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            require_once 'Classes/Gebruiker.php';

            $klantIdSession = new Gebruiker();
            $klantId = $klantIdSession->getKlantIdSession($_SESSION['username']);
            // echo "<pre> test " . print_r($klantId, true) . "</pre>";
            if ($klantId !== null) {
                $_SESSION['gebruikerId'] = (int)$klantId; // Use 'gebruikerId' consistently
                // echo "<pre> test " . print_r($klantId, true) . "</pre>";
                if (isset($_SESSION['return_to'])) {
                    $return_to = $_SESSION['return_to'];
                    unset($_SESSION['return_to']);
                    header('Location: ' . $return_to);
                } else {
                    header("Location: ./");
                }
            } else {
                echo 'Error: Klant ID not found';
            }
            // require 'rights.php';
        } else {
            $_SESSION['message'] = 'Invalid login credentials. Please try again.';
            header("Location: loginForm");
        }
    } else {
        $_SESSION['message'] = 'Invalid login credentials. Please try again.';
        header("Location: loginForm");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
