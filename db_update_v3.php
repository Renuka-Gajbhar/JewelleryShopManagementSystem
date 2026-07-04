<?php
require_once 'includes/Config.php';

echo "Updating database schema for orders...<br>";

// Add payment_id if missing
$check = mysqli_query($conn, "SHOW COLUMNS FROM orders LIKE 'payment_id'");
if(mysqli_num_rows($check) == 0) {
    mysqli_query($conn, "ALTER TABLE orders ADD COLUMN payment_id VARCHAR(255) AFTER status");
    echo "Added payment_id column.<br>";
} else {
    echo "payment_id column already exists.<br>";
}

// Add razorpay_order_id if missing (optional but good for history)
$check = mysqli_query($conn, "SHOW COLUMNS FROM orders LIKE 'razorpay_order_id'");
if(mysqli_num_rows($check) == 0) {
    mysqli_query($conn, "ALTER TABLE orders ADD COLUMN razorpay_order_id VARCHAR(255) AFTER payment_id");
    echo "Added razorpay_order_id column.<br>";
} else {
    echo "razorpay_order_id column already exists.<br>";
}

echo "Database update complete!";
?>
