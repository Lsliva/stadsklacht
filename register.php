<?php
session_start();
$naam = $_POST['username']; // Aangepast naar 'naam'
$email = $_POST['email'];
$wachtwoord = $_POST['password']; // Aangepast naar 'wachtwoord'

$_SESSION['usernamePost'] = $naam; // Aangepast naar 'naam'
$_SESSION['emailPost'] = $email;
$_SESSION['passwordPost'] = $_POST['password'];

try {
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "stadsklacht";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE naam = :naam OR email = :email"); // Aangepast naar 'naam'
    $stmt->bindParam(':naam', $naam); // Aangepast naar 'naam'
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $_SESSION['message'] = 'Username or email already exists. Please choose a different one.';
        header("Location: registerForm"); // Redirect to registration form
    } else {
        // Insert new user into the database
        $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT); // Aangepast naar 'wachtwoord'

        $stmt = $conn->prepare("INSERT INTO gebruikers (naam, email, wachtwoord) VALUES (:naam, :email, :wachtwoord)"); // Aangepast naar 'naam' en 'wachtwoord'
        $stmt->bindParam(':naam', $naam); // Aangepast naar 'naam'
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':wachtwoord', $hashed_password); // Aangepast naar 'wachtwoord'
        $stmt->execute();

        $_SESSION['message'] = 'Registration successful. You can now log in.';
        header("Location: loginForm"); // Redirect to login form
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
