<?php
require_once 'Config.php';

header('Content-Type: application/json');

if (isset($_GET['q'])) {
    $q = mysqli_real_escape_with_like($_GET['q'], $conn);
    $query = "SELECT name, image_url, price FROM products WHERE name LIKE '%$q%' LIMIT 8";
    $result = mysqli_query($conn, $query);
    
    $suggestions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row;
    }
    
    echo json_encode($suggestions);
}
?>
