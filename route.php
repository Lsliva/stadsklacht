<?php
// Get the URL parameter
$url = isset($_GET['url']) ? $_GET['url'] : '/';

// Remove leading and trailing slashes
$url = trim($url, '/');

// Remove the .php extension if present
$url = preg_replace('/\.php$/', '', $url);

// Check for the "index" URL and convert it to "/"
if ($url === 'index' || $url === 'index.php') {
    $url = '/';
}

// Include the corresponding template
if (file_exists("$url.php")) {
    include "$url.php";
} else {
    // Handle 404 (Not Found) error
    include '404.php';
}
