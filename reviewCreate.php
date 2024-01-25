<?php
require_once 'inlogCheck.php';

session_abort();
?>
<?php include("assets/nav.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klachten en Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* margin: 20px; */
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

// Check if linkId is set in the URL
if (isset($_GET['linkId'])) {
    $linkId = intval($_GET['linkId']);

} else {
    // Handle the case where linkId is not set in the URL
    echo "Error: linkId not provided in the URL";
}


?>

    <div id="reviewSection">
        <h2>Geef een Review</h2>
        <p>Bedankt voor het indienen van uw klacht. Geef alstublieft een review over het proces:</p>
        
        <form method="POST" action="reviewPage.php">
            <label for="review">Review:</label>
            <textarea id="review" name="review" required></textarea>
            <input type="hidden" id="linkId" name="LinkId" value="<?php echo $linkId; ?>">
            <button type="submit">Verstuur Review</button>
        </form>
    </div>
    

</body>
</html>


</body>
</html>     