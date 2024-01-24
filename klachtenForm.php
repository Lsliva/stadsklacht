<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>klachtenForm</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<style>
    input {
        width: 200px;
        padding: 10px 15px;
        margin: 5px 0;
        box-sizing: border-box;
    }
</style>
<body>

<?php require_once 'inlogCheck.php'?>
<?php include("assets/nav.php"); ?>
<?php $gebruikerId = intval($_SESSION['gebruikerId']);?>


<main>
    <div class="content">
        <form method="post" action="createKlacht.php" enctype="multipart/form-data">
            <label for="omschrijving">Omschrijving</label>
            <input type="text" name="omschrijving" required>
            <label for="foto">Foto</label>
            <input type="file" name="foto" accept="image/*">
            <input type="hidden" id="gebruikersId" name="gebruikersId" value="<?php echo $gebruikerId; ?>">
            <input type="submit" value="send complaint" class="submitButton">
        </form>

            <!-- ... your existing location code ... -->
            <?php
            // Retrieve location details from session
            $location = isset($_SESSION['chosenLocation']) ? $_SESSION['chosenLocation'] : null;
            $address = isset($_SESSION['chosenAddress']) ? $_SESSION['chosenAddress'] : '';
            if (!empty($location) && !empty($address)) :
                ?> <br>
                <label for="Chosen location">Chosen Location:</label>
                <input type="text" id="chosenLocationCord" name="chosenLocationLat" value="<?php echo "{$location['lat']}"; ?>" readonly>
                <input type="text" id="chosenLocationCord" name="chosenLocationLon" value="<?php echo "{$location['lon']}"; ?>" readonly><br>
                <?php echo $address; ?>
                <input type="hidden" id="chosenLocationName" name="chosenLocationName" value="<?php echo $address; ?>">

            <?php else : ?>
                <p>Location has yet to be chosen: <a href="klantStreetmap">Choose a location</a></p>
            <?php endif; ?> <br>

    </div>


        <div id="chooseLocationDiv">



                    <div class="messagePHP"><?php
                        if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        
                        ?></div>
                        <?php if (isset($_GET['message'])) { ?>
                        <div class="message">
                            <?php echo $_GET['message']; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
    </main>
    <style>
        input {
            width: 200px;
            padding: 10px 15px;
            margin: 5px 0;
            box-sizing: border-box;
        }
    </style>

    <script src="assets/klachten.js"></script>


</body>
</html>