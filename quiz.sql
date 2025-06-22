-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 22, 2025 at 12:04 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_user_id_foreign` (`user_id`),
  KEY `cart_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping` decimal(10,2) NOT NULL DEFAULT '10.00',
  `total` decimal(10,2) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `subtotal`, `shipping`, `total`, `status`, `payment_status`, `shipping_address`, `created_at`, `updated_at`) VALUES
(1, 1, 649.95, 10.00, 659.95, 'cancelled', 'pending', 'beirut , al hamra street', '2025-06-22 08:24:03', '2025-06-22 08:25:00'),
(2, 1, 2499.97, 10.00, 2509.97, 'cancelled', 'pending', 'beirut , al hamra street', '2025-06-22 08:24:48', '2025-06-22 08:25:09'),
(3, 1, 629.97, 10.00, 639.97, 'delivered', 'pending', 'beirut , al hamra street', '2025-06-22 08:25:27', '2025-06-22 08:38:27'),
(4, 1, 999.99, 10.00, 1009.99, 'shipped', 'pending', 'saida', '2025-06-22 08:41:27', '2025-06-22 09:02:28'),
(5, 1, 449.97, 10.00, 459.97, 'cancelled', 'pending', 'bekaa', '2025-06-22 08:41:43', '2025-06-22 09:01:33'),
(6, 1, 1299.99, 10.00, 1309.99, 'cancelled', 'pending', 'tripole', '2025-06-22 09:02:07', '2025-06-22 09:02:44'),
(7, 2, 1129.98, 10.00, 1139.98, 'cancelled', 'pending', 'hermel', '2025-06-22 09:03:16', '2025-06-22 09:03:32'),
(8, 2, 929.96, 10.00, 939.96, 'pending', 'pending', 'hermel', '2025-06-22 09:03:54', '2025-06-22 09:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 5, 129.99, '2025-06-22 08:24:03', '2025-06-22 08:24:03'),
(2, 2, 6, 1, 999.99, '2025-06-22 08:24:48', '2025-06-22 08:24:48'),
(3, 2, 7, 1, 1299.99, '2025-06-22 08:24:48', '2025-06-22 08:24:48'),
(4, 2, 4, 1, 199.99, '2025-06-22 08:24:48', '2025-06-22 08:24:48'),
(5, 3, 1, 1, 299.99, '2025-06-22 08:25:27', '2025-06-22 08:25:27'),
(6, 3, 3, 1, 129.99, '2025-06-22 08:25:27', '2025-06-22 08:25:27'),
(7, 3, 4, 1, 199.99, '2025-06-22 08:25:27', '2025-06-22 08:25:27'),
(8, 4, 6, 1, 999.99, '2025-06-22 08:41:27', '2025-06-22 08:41:27'),
(9, 5, 8, 1, 49.99, '2025-06-22 08:41:43', '2025-06-22 08:41:43'),
(10, 5, 4, 2, 199.99, '2025-06-22 08:41:43', '2025-06-22 08:41:43'),
(11, 6, 7, 1, 1299.99, '2025-06-22 09:02:07', '2025-06-22 09:02:07'),
(12, 7, 3, 1, 129.99, '2025-06-22 09:03:16', '2025-06-22 09:03:16'),
(13, 7, 6, 1, 999.99, '2025-06-22 09:03:16', '2025-06-22 09:03:16'),
(14, 8, 9, 3, 249.99, '2025-06-22 09:03:54', '2025-06-22 09:03:54'),
(15, 8, 5, 1, 179.99, '2025-06-22 09:03:54', '2025-06-22 09:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `quantity`, `image`, `created_at`, `updated_at`, `description`) VALUES
(1, 'Digital Camera', 299.99, 14, 'camera.jpg', '2025-06-22 08:21:24', '2025-06-22 08:25:27', 'High-resolution digital camera with 4K video recording'),
(2, 'Gaming Console', 499.99, 0, 'console.jpg', '2025-06-22 08:21:24', '2025-06-22 08:21:24', 'Next-gen gaming console with 1TB storage'),
(3, 'Wireless Earphones', 129.99, 24, 'earphones.jpg', '2025-06-22 08:21:24', '2025-06-22 09:03:32', 'Premium wireless earphones with noise cancellation'),
(4, 'Over-Ear Headphones', 199.99, 11, 'headphones.jpg', '2025-06-22 08:21:24', '2025-06-22 09:01:33', 'Professional studio headphones with deep bass'),
(5, 'Wireless Headphones', 179.99, 17, 'headphones2.jpg', '2025-06-22 08:21:24', '2025-06-22 09:03:54', 'Bluetooth headphones with 30-hour battery life'),
(6, 'Smartphone', 999.99, 9, 'iphone.jpg', '2025-06-22 08:21:24', '2025-06-22 09:03:32', 'Flagship smartphone with advanced camera system'),
(7, 'Ultrabook Laptop', 1299.99, 6, 'laptop.jpg', '2025-06-22 08:21:24', '2025-06-22 09:02:44', 'Thin and light laptop with powerful performance'),
(8, 'Wireless Mouse', 49.99, 30, 'mouse.jpg', '2025-06-22 08:21:24', '2025-06-22 09:01:33', 'Ergonomic wireless mouse with precision tracking'),
(9, 'Smart Watch', 249.99, 17, 'watch.jpg', '2025-06-22 08:21:24', '2025-06-22 09:03:54', 'Fitness tracker with heart rate monitoring');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `role`, `remember_token`, `created_at`, `updated_at`, `phone_number`) VALUES
(1, 'User One', 'user1@test.com', NULL, '$2y$12$ao6E4RJUwI0oyy3MKZdQi.qKPQscyCWx4RddACThF1Gvr4Q7287nW', NULL, NULL, NULL, 'user', NULL, '2025-06-22 08:21:23', '2025-06-22 08:21:23', '70102030'),
(2, 'User Two', 'user2@test.com', NULL, '$2y$12$QhZyfYzySg1oKZaFYcAtxe7S1Bbq7bZHtcEzb6S4DjTR7fpm2IBly', NULL, NULL, NULL, 'user', NULL, '2025-06-22 08:21:23', '2025-06-22 08:21:23', '70203040'),
(3, 'Admin', 'admin@test.com', NULL, '$2y$12$GV9WAly444sUjG20AA0Z7OMc0Y8W/9tDc68ZF1pUu.YECbLAynLFW', NULL, NULL, NULL, 'admin', NULL, '2025-06-22 08:21:24', '2025-06-22 08:21:24', '70304050');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
