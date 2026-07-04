<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "jewellery";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define Base URL for the application
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
$projectFolder = "jewellery-shop"; // Update this if the folder name changes
if (!defined('BASE_URL')) {
    define('BASE_URL', $protocol . $domainName . "/" . $projectFolder . "/");
}

if (!function_exists('mysqli_real_escape_with_like')) {
    function mysqli_real_escape_with_like($string, $conn) {
        $string = mysqli_real_escape_string($conn, $string);
        return addcslashes($string, '%_');
    }
}
?>
