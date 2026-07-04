<?php
session_start();
require '../includes/Config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized or missing ID']);
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = (int)$_GET['id'];

// Fetch Order Base
$order_query = "SELECT id, total_amount, shipping_address, status, created_at FROM orders WHERE id = $order_id AND user_id = $user_id LIMIT 1";
$order_res = mysqli_query($conn, $order_query);

if (mysqli_num_rows($order_res) == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Order not found']);
    exit();
}

$order = mysqli_fetch_assoc($order_res);

// Fetch Order Items
$items_query = "
    SELECT oi.quantity, oi.price, p.name, p.image_url 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = $order_id
";
$items_res = mysqli_query($conn, $items_query);
$items = [];
while($row = mysqli_fetch_assoc($items_res)) {
    $items[] = $row;
}

echo json_encode([
    'status' => 'success',
    'order' => $order,
    'items' => $items
]);
?>
