<?php
require_once 'includes/Config.php';

// Create reviews table
$reviews_table = "
CREATE TABLE IF NOT EXISTS `reviews` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `rating` INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    `comment` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
)";

if (mysqli_query($conn, $reviews_table)) {
    echo "Reviews table created or already exists.<br>";
} else {
    echo "Error creating reviews table: " . mysqli_error($conn) . "<br>";
}

// Ensure original_price exists in products (it does based on the SQL file view, but let's be safe)
$add_orig_price = "ALTER TABLE products ADD COLUMN IF NOT EXISTS original_price DECIMAL(10, 2) AFTER name";
mysqli_query($conn, $add_orig_price);

echo "Database updates completed.";
?>
