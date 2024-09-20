 -- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2024 at 09:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fashionsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','shipped','delivered') DEFAULT 'pending',
  `address` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `total_amount`, `status`, `address`, `payment_method`) VALUES
(1, 8, '2024-08-31 10:28:06', 28000.00, '', NULL, NULL),
(2, 8, '2024-08-31 14:29:52', 0.00, 'pending', 'ABCD Delhi 92', 'Credit Card'),
(3, 10, '2024-09-01 03:02:23', 7000.00, 'pending', NULL, NULL),
(4, 13, '2024-09-01 03:10:00', 11300.00, 'pending', NULL, NULL),
(5, 13, '2024-09-01 06:41:22', 0.00, 'pending', 'ABCD, block D Delhi 23******', 'Credit Card'),
(6, 13, '2024-09-01 06:49:25', 0.00, 'pending', 'ABCD, block D Delhi 23******', 'Credit Card'),
(7, 13, '2024-09-01 03:19:51', 9000.00, 'pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 2, 1, 3000.00),
(2, 1, 3, 2, 9000.00),
(3, 1, 4, 1, 7000.00),
(4, 3, 4, 1, 7000.00),
(5, 4, 3, 1, 9000.00),
(6, 4, 5, 1, 2300.00),
(7, 7, 3, 1, 9000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `category` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `vendor_id`, `product_name`, `description`, `price`, `stock_quantity`, `category`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gucci', 'Cotton poplin dress with Horsebit', 1800.00, 8, NULL, 'img.png.png', '2024-08-27 11:43:10', '2024-08-27 11:43:10'),
(2, 1, 'breed', 'avant-garde', 3000.00, 5, NULL, 'img1.png', '2024-08-31 13:35:40', '2024-08-31 13:35:40'),
(3, 1, 'Spring Wear', 'Spring 2024 ready to wear ', 9000.00, 4, NULL, 'img2.png', '2024-08-31 13:39:56', '2024-08-31 13:39:56'),
(4, 1, 'Versace', 'Fall 2022 Ready to wear ', 7000.00, 11, NULL, 'img3.png', '2024-08-31 13:49:37', '2024-08-31 13:49:37'),
(5, 1, 'Versace', 'Fall 2024 Ready to wear ', 2300.00, 5, NULL, 'img4.png', '2024-08-31 13:51:59', '2024-08-31 13:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('customer','vendor','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `active_status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `usertype`, `created_at`, `active_status`) VALUES
(1, 'parulrai8799@gmail.com', 'parulrai8799@gmail.com', '$2y$10$1d1wCdJUuEwl2wT9Rd0BvOhmfi.SNXuWlCtsQ9FqvwVxXzaZR0xqK', 'vendor', '2024-08-27 06:26:07', 1),
(3, 'ParulRai', 'parulrai7899@gmail.com', '$2y$10$9CXOJhGv3yfQocbFHtJmW.2aN4Iy6FwXFdDadzuwLnD23yNrBuxom', 'customer', '2024-08-27 06:48:03', 1),
(4, 'raiparul', 'raiparul8799@gmail.com', '$2y$10$0iziahP9ijRo3uZ/f5lX4OrZjV8MHdomm7QjhLrlHKb510uNAf/yO', 'admin', '2024-08-28 07:30:46', 1),
(8, 'vr', 'vr9899@gmail.com', '$2y$10$9EvnWnnGcuyXFQfHqrn0/u.BBPr96HVlT4FjWBEaEcYBJDSWN1XHi', 'customer', '2024-08-30 12:18:43', 1),
(9, 'sk', 'sk6789@gmail.com', '$2y$10$sfleBus7oOXolG7MSHgj2.eTFpZ4ungUxEgjIVIb2QA7EK8xrrNUC', 'admin', '2024-08-31 07:09:34', 1),
(10, 'Akanksha', 'akansha5678@gmail.com', '$2y$10$WVi0e04Yi35rZBkppu6znutVr5Y3M3GUQp1Yy1/d8imvLQEkulfii', 'vendor', '2024-09-01 06:30:12', 1),
(13, 'Parul', 'parulrai@1234gmail.com', '$2y$10$AHrNlamPzRh9L3j5GoGQk.CmAcYe.mgUAenCT0v4XrAfJn5wB9yFW', 'customer', '2024-09-01 06:36:13', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
