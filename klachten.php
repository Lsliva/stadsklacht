<?php
// require 'database.php';
require 'Classes/KLacht.php';

if (isset($_POST)) {

    // Get the submitted form data
    $gebruikerId = $_POST['gebruikersId'];
    $omschrijving = $_POST['omschrijving'];

    // check if there is any inapropriate word in the username or the email
    $inapropriate_words = array("fuck", "hell","crap", "damn", "ass", "hoe", "whore", "kanker", "kut", "tering" , "shite", "nigger", "nigga" ,"shit", "bitch", "penis");
    foreach($inapropriate_words as $word){
        if (strpos($omschrijving, $word) !== false ) {
            echo "Sorry, inapropriate word found.";

        }
    }

    // If all validation checks pass, insert the new user into the database
    $Klacht = new Klacht();
    $Klacht->createKlachten($omschrijving, $gebruikerId);


}

