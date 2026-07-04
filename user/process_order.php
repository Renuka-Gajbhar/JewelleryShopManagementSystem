<?php
session_start();
require '../includes/Config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle Place Dummy Order
if (isset($_POST['place_order'])) {
    $cart = json_decode($_POST['cart'], true);
    $total_amount = (float)$_POST['total_amount'];
    $address = mysqli_real_escape_string($conn, $_POST['shipping_address']);

    // Insert Order - Status set to Processing immediately for dummy payment
    $order_query = "INSERT INTO orders (user_id, total_amount, shipping_address, status, payment_id) VALUES ($user_id, $total_amount, '$address', 'Processing', 'DUMMY_PAY_" . time() . "')";
    
    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn);

        // Insert Items
        foreach ($cart as $item) {
            $product_id = (int)$item['id'];
            $qty = (int)$item['qty'];
            $price = (float)$item['price'];

            mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $qty, $price)");
            
            // Deduct Stock
            mysqli_query($conn, "UPDATE products SET stock = stock - $qty WHERE id = $product_id");
        }

        echo json_encode([
            'status' => 'success',
            'order_id' => $order_id,
            'message' => 'Order placed successfully'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
    }
    exit();
}
?>
