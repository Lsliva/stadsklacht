<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klachten en Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form, #reviewSection {
            max-width: 400px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        button {
            background-color: #6666ff;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #6ff;
        }
    </style>
</head>
<body>



<?php
// Functie om de gebruiker door te sturen naar de homepage
function redirectToHomepage($message) {
    echo "<script>alert('$message'); window.location.href = 'index.php';</script>";
    exit;
}

// Check of het klachtenformulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Klacht verwerken (hier zou je het in een database kunnen opslaan)
    if (isset($_POST["complaint"])) {
        $complaint = $_POST["complaint"];
        echo "<p>Klacht ontvangen: $complaint</p>";
    }

    // Check of het reviewformulier is ingediend
    if (isset($_POST["review"])) {
        // Verwerk de review en sla deze op in de database
        $review = $_POST["review"];

        // Verbinding met de database
        $servername = "localhost";
        $username = "root";
        $password = ""; // Laat dit leeg als er geen wachtwoord is
        $dbname = "stadsklacht";

        // Maak een databaseverbinding
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Controleer de databaseverbinding
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Voeg de review toe aan de database
        $sql = "INSERT INTO reviews (review) VALUES ('$review')";

        if ($conn->query($sql) === TRUE) {
            // Sluit de databaseverbinding
            $conn->close();

            // Stuur de gebruiker door naar de homepage met een melding
            redirectToHomepage("Bedankt voor uw review!");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>


    <?php
    // Controleer of het klachtenformulier is ingediend
    if (!isset($_POST["complaint"])) {
    ?>
    <form method="post">
        <label for="complaint">Klacht:</label>
        <textarea id="complaint" name="complaint" required></textarea>

        <button type="submit">Dien Klacht In</button>
    </form>
    <?php
    } else {
    ?>
    <div id="reviewSection">
        <h2>Geef een Review</h2>
        <p>Bedankt voor het indienen van uw klacht. Geef alstublieft een review over het proces:</p>
        
        <form method="post">
            <label for="review">Review:</label>
            <textarea id="review" name="review" required></textarea>

            <button type="submit">Verstuur Review</button>
        </form>
    </div>
    <?php
    }
    ?>

</body>
</html>


</body>
</html>     