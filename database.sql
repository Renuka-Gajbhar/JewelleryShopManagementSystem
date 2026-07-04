CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `role` ENUM('admin', 'user') DEFAULT 'user',
  `profile_pic` VARCHAR(255) DEFAULT 'default_profile.png',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10, 2) NOT NULL,
  `original_price` DECIMAL(10, 2) NOT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `stock` INT DEFAULT 0,
  `rating` INT DEFAULT 4,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `cart` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `product_id` INT,
  `quantity` INT DEFAULT 1,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `total_amount` DECIMAL(10, 2) NOT NULL,
  `payment_id` VARCHAR(100) DEFAULT NULL,
  `status` ENUM('Pending', 'Processing', 'Shipped', 'Delivered') DEFAULT 'Pending',
  `shipping_address` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT,
  `product_id` INT,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
);

-- Insert Default Categories
INSERT INTO `categories` (`name`) VALUES 
('Gold'),
('Silver'),
('Diamond'),
('Earring'),
('Necklace'),
('Ring'),
('SilverRing');
