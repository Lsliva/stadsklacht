<?php

// Include the PDO connection file
require 'Classes/Klacht.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch file details
    $foto_name = $_FILES['foto']['name'];
    $foto_size = $_FILES['foto']['size'];
    $tmp_name = $_FILES['foto']['tmp_name'];

    $klacht1 = new Klacht;
    $klacht1->foto($foto_name, $foto_size, $tmp_name);
}
