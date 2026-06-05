-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2026 at 01:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
-- 
-- IDEMPOTENT VERSION - Safe to run multiple times
-- IMPORTANT: Data is inserted in correct order (users first, then categories, then expenses)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS=0;

--
-- Database: `expense_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Joshua Jeberson A', 'joshuajeberson@gmail.com', NULL, '$2y$12$ATcyWFhOrqEH36IpyAVLs.rkwLnDNdroYJQ8ZsHD0VATWXQWgyYfm', NULL, '2026-06-03 23:40:01', '2026-06-03 23:40:01')
ON DUPLICATE KEY UPDATE 
  `name` = VALUES(`name`),
  `updated_at` = VALUES(`updated_at`);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#6c757d',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `name`, `icon`, `color`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, 'Food', '🍔', '#FF6B6B', 1, '2026-06-03 23:40:01', '2026-06-03 23:40:01'),
(2, 1, 'Travel', '✈️', '#4ECDC4', 1, '2026-06-03 23:40:01', '2026-06-03 23:40:01'),
(3, 1, 'Fuel', '⛽', '#FFE66D', 1, '2026-06-03 23:40:01', '2026-06-03 23:40:01'),
(4, 1, 'Shopping', '🛍️', '#95E1D3', 1, '2026-06-03 23:40:01', '2026-06-03 23:40:01'),
(5, 1, 'Bills', '📄', '#F38181', 1, '2026-06-03 23:40:01', '2026-06-03 23:40:01'),
(6, 1, 'Entertainment', '🎬', '#AA96DA', 1, '2026-06-03 23:40:01', '2026-06-03 23:40:01'),
(7, 1, 'Health', '🏥', '#FCBAD3', 1, '2026-06-03 23:40:01', '2026-06-03 23:40:01'),
(8, 1, 'Other', '📦', '#6C757D', 1, '2026-06-03 23:40:01', '2026-06-03 23:40:01')
ON DUPLICATE KEY UPDATE 
  `name` = VALUES(`name`),
  `icon` = VALUES(`icon`),
  `color` = VALUES(`color`),
  `updated_at` = VALUES(`updated_at`);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `merchant` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_user_id_foreign` (`user_id`),
  KEY `expenses_category_id_foreign` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `category_id`, `amount`, `merchant`, `notes`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 10000.00, 'chit', NULL, '2026-06-01', '2026-06-03 23:43:11', '2026-06-03 23:43:11'),
(2, 1, 5, 9900.00, 'House rent', NULL, '2026-06-01', '2026-06-04 00:01:22', '2026-06-04 00:15:14'),
(4, 1, 5, 5844.00, 'Credit card', NULL, '2026-06-01', '2026-06-04 00:02:41', '2026-06-04 00:15:22'),
(5, 1, 5, 4500.00, 'Car EMI', NULL, '2026-06-01', '2026-06-04 00:03:08', '2026-06-05 04:41:49'),
(6, 1, 5, 2094.00, 'Slice', NULL, '2026-06-01', '2026-06-04 00:03:32', '2026-06-05 04:42:02'),
(7, 1, 8, 1000.00, 'Sister', NULL, '2026-06-02', '2026-06-04 00:04:00', '2026-06-04 00:15:06'),
(8, 1, 1, 1089.00, 'Mall of asia', NULL, '2026-06-03', '2026-06-04 00:06:52', '2026-06-04 00:06:52'),
(9, 1, 4, 684.00, 'Supermarket', NULL, '2026-06-01', '2026-06-04 00:07:27', '2026-06-04 00:07:27'),
(10, 1, 1, 50.00, 'foods', NULL, '2026-06-01', '2026-06-04 00:10:13', '2026-06-04 00:10:13'),
(11, 1, 1, 200.00, 'chicken', NULL, '2026-06-01', '2026-06-04 00:10:58', '2026-06-04 00:10:58'),
(12, 1, 1, 106.00, 'food', NULL, '2026-06-01', '2026-06-04 00:11:21', '2026-06-04 00:11:21'),
(13, 1, 1, 40.00, 'food', NULL, '2026-06-01', '2026-06-04 00:12:31', '2026-06-04 00:12:31'),
(14, 1, 8, 177.00, 'sticker printing', NULL, '2026-06-01', '2026-06-04 00:12:57', '2026-06-04 00:12:57'),
(15, 1, 1, 90.00, 'Coffee', NULL, '2026-06-01', '2026-06-04 00:13:11', '2026-06-04 00:13:11'),
(16, 1, 4, 684.00, 'folding table', NULL, '2026-06-01', '2026-06-04 00:13:38', '2026-06-04 00:13:38'),
(17, 1, 1, 198.00, 'Foods', NULL, '2026-06-01', '2026-06-04 00:14:19', '2026-06-04 00:14:19'),
(18, 1, 1, 300.00, 'food', NULL, '2026-06-02', '2026-06-04 00:14:54', '2026-06-04 00:14:54'),
(19, 1, 1, 1692.00, 'combined food expenses', NULL, '2026-06-03', '2026-06-04 00:18:32', '2026-06-04 00:18:32'),
(20, 1, 4, 1329.00, 'Zepto', NULL, '2026-06-03', '2026-06-04 00:19:30', '2026-06-04 00:19:30'),
(21, 1, 1, 530.00, 'All foods cummulative', NULL, '2026-06-05', '2026-06-05 04:40:17', '2026-06-05 04:40:17'),
(22, 1, 4, 283.00, 'Zepto', 'tooth items', '2026-06-05', '2026-06-05 04:40:48', '2026-06-05 04:40:48')
ON DUPLICATE KEY UPDATE 
  `amount` = VALUES(`amount`),
  `merchant` = VALUES(`merchant`),
  `notes` = VALUES(`notes`),
  `updated_at` = VALUES(`updated_at`);

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE IF NOT EXISTS `income` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `source` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `income_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`id`, `user_id`, `amount`, `source`, `notes`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 53780.00, 'Salary', NULL, '2026-05-29', '2026-06-03 23:46:15', '2026-06-03 23:46:15')
ON DUPLICATE KEY UPDATE 
  `amount` = VALUES(`amount`),
  `source` = VALUES(`source`),
  `notes` = VALUES(`notes`),
  `updated_at` = VALUES(`updated_at`);

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE IF NOT EXISTS `budgets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `budgets_user_id_category_id_month_year_unique` (`user_id`,`category_id`,`month`,`year`),
  KEY `budgets_category_id_foreign` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_01_01_000000_create_users_table', 1),
(2, '2024_01_01_000001_create_categories_table', 1),
(3, '2024_01_01_000002_create_expenses_table', 1),
(4, '2024_01_01_000003_create_income_table', 1),
(5, '2024_01_01_000004_create_budgets_table', 1);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `income`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS=1;

--
-- Add Foreign Key Constraints (Idempotent)
--
SET @exist := (SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS 
WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'categories' 
AND CONSTRAINT_NAME = 'categories_user_id_foreign' AND CONSTRAINT_TYPE = 'FOREIGN KEY');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `categories` ADD CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE', 'SELECT ''FK exists''');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist := (SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS 
WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'expenses' 
AND CONSTRAINT_NAME = 'expenses_user_id_foreign' AND CONSTRAINT_TYPE = 'FOREIGN KEY');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `expenses` ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE', 'SELECT ''FK exists''');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist := (SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS 
WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'expenses' 
AND CONSTRAINT_NAME = 'expenses_category_id_foreign' AND CONSTRAINT_TYPE = 'FOREIGN KEY');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `expenses` ADD CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE', 'SELECT ''FK exists''');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist := (SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS 
WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'income' 
AND CONSTRAINT_NAME = 'income_user_id_foreign' AND CONSTRAINT_TYPE = 'FOREIGN KEY');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `income` ADD CONSTRAINT `income_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE', 'SELECT ''FK exists''');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist := (SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS 
WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'budgets' 
AND CONSTRAINT_NAME = 'budgets_user_id_foreign' AND CONSTRAINT_TYPE = 'FOREIGN KEY');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `budgets` ADD CONSTRAINT `budgets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE', 'SELECT ''FK exists''');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist := (SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS 
WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'budgets' 
AND CONSTRAINT_NAME = 'budgets_category_id_foreign' AND CONSTRAINT_TYPE = 'FOREIGN KEY');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `budgets` ADD CONSTRAINT `budgets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE', 'SELECT ''FK exists''');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

