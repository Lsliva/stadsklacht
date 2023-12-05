<?php

session_start();
$username = $_POST['username'];
$password = $_POST['password'];

$_SESSION['usernamePost'] = $_POST['username'];
$_SESSION['passwordPost'] = $POST['password'];


try {
    $servername = "localhost";

    // $servername = "srv12373.hostingserver.nl:3306";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "stadsklacht";


    // Create PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);

    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE naam = :naam");
    $stmt->bindParam(':naam', $naam);

    // Execute statement
    $stmt->execute();

    // Fetch all rows
    $results = $stmt->fetchAll();

    if (!empty($results)) {
        $hashed_password = $results[0]['password'];
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            if (isset($_SESSION['return_to'])) {
                $return_to = $_SESSION['return_to'];
                unset($_SESSION['return_to']);
                header('Location: ' . $return_to);
            } else {
                header("location: /");
            }} else {
            $_SESSION['message'] = 'Invalid login credentials. Please try again.';
            header("Location: loginForm");
        }
    } else {
        $_SESSION['message'] = 'Invalid login credentials. Please try again.';
        header("Location: loginForm");
    }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>




