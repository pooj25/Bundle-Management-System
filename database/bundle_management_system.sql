-- ========================================================
-- Apparel ERP - Production Bundle Management System
-- MySQL 8+ Database Dump
-- Generation Date: 2026-08-26 06:24:25
-- ========================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Table structure for table `buyers`
--
DROP TABLE IF EXISTS `buyers`;
CREATE TABLE `buyers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buyers_buyer_name_index` (`buyer_name`),
  KEY `buyers_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `styles`
--
DROP TABLE IF EXISTS `styles`;
CREATE TABLE `styles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `style_no` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `styles_style_no_index` (`style_no`),
  KEY `styles_status_index` (`status`),
  KEY `styles_buyer_id_style_no_index` (`buyer_id`,`style_no`),
  CONSTRAINT `styles_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `sewing_lines`
--
DROP TABLE IF EXISTS `sewing_lines`;
CREATE TABLE `sewing_lines` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `line_name` varchar(255) NOT NULL,
  `floor` varchar(50) DEFAULT NULL,
  `capacity` int unsigned NOT NULL DEFAULT '1000',
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sewing_lines_line_name_index` (`line_name`),
  KEY `sewing_lines_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `production_bundles`
--
DROP TABLE IF EXISTS `production_bundles`;
CREATE TABLE `production_bundles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bundle_no` varchar(100) NOT NULL,
  `buyer_id` bigint unsigned NOT NULL,
  `style_id` bigint unsigned NOT NULL,
  `line_id` bigint unsigned NOT NULL,
  `color` varchar(50) NOT NULL,
  `size` varchar(20) NOT NULL,
  `quantity` int unsigned NOT NULL,
  `completed_qty` int unsigned NOT NULL DEFAULT '0',
  `rejected_qty` int unsigned NOT NULL DEFAULT '0',
  `operator_name` varchar(100) DEFAULT NULL,
  `production_date` date NOT NULL,
  `remarks` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `production_bundles_bundle_no_unique` (`bundle_no`),
  KEY `production_bundles_color_index` (`color`),
  KEY `production_bundles_size_index` (`size`),
  KEY `production_bundles_operator_name_index` (`operator_name`),
  KEY `production_bundles_production_date_index` (`production_date`),
  KEY `production_bundles_production_date_buyer_id_index` (`production_date`,`buyer_id`),
  KEY `production_bundles_buyer_id_style_id_index` (`buyer_id`,`style_id`),
  KEY `production_bundles_line_id_production_date_index` (`line_id`,`production_date`),
  KEY `production_bundles_deleted_at_production_date_index` (`deleted_at`,`production_date`),
  KEY `production_bundles_deleted_at_created_at_index` (`deleted_at`,`created_at`),
  CONSTRAINT `production_bundles_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `production_bundles_style_id_foreign` FOREIGN KEY (`style_id`) REFERENCES `styles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `production_bundles_line_id_foreign` FOREIGN KEY (`line_id`) REFERENCES `sewing_lines` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `activity_logs`
--
DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bundle_id` bigint unsigned DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `user_name` varchar(100) NOT NULL DEFAULT 'System User',
  `changes` json DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `activity_logs_bundle_id_index` (`bundle_id`),
  KEY `activity_logs_action_index` (`action`),
  KEY `activity_logs_created_at_index` (`created_at`),
  KEY `activity_logs_bundle_id_created_at_index` (`bundle_id`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buyers`
--
INSERT INTO `buyers` (`id`, `buyer_name`, `contact_person`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Global Retail', 'John Doe', 'john@global.com', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(2, 'Urban Out', 'Sarah Smith', 'sarah@urban.com', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(3, 'Metro Wear', 'Mike Ross', 'mike@metro.com', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(4, 'Apex Apparel', 'Emma Watson', 'emma@apex.com', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(5, 'Zara Tex', 'David Lee', 'david@zaratex.com', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(6, 'Nordic Fashion', 'Elena Rostova', 'elena@nordic.com', 'Inactive', '2026-08-26 06:15:16', '2026-08-26 06:15:16');

--
-- Dumping data for table `styles`
--
INSERT INTO `styles` (`id`, `buyer_id`, `style_no`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'ST-8821', 'Men Regular Chino Pants', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(2, 1, 'ST-402 / PO-992', 'Cotton Polo T-Shirt', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(3, 2, 'UO-22X', 'Denim Slim Fit Jeans', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(4, 2, 'ST-118 / PO-881', 'Hooded Sweatshirt Olive', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(5, 3, 'ST-209 / PO-774', 'Linen Formal Shirt', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(6, 3, 'MW-554', 'Cargo Short Khaki', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(7, 4, 'AP-901', 'Women Knit Top', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(8, 5, 'ZT-300', 'Bomber Jacket Black', 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16');

--
-- Dumping data for table `sewing_lines`
--
INSERT INTO `sewing_lines` (`id`, `line_name`, `floor`, `capacity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'A1', 'Floor 1', 1200, 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(2, 'A2', 'Floor 1', 1000, 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(3, 'B1', 'Floor 2', 800, 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(4, 'B2', 'Floor 2', 950, 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(5, 'C1', 'Floor 3', 1100, 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16'),
(6, 'C2', 'Floor 3', 900, 'Active', '2026-08-26 06:15:16', '2026-08-26 06:15:16');

--
-- Dumping data for table `production_bundles`
--
INSERT INTO `production_bundles` (`id`, `bundle_no`, `buyer_id`, `style_id`, `line_id`, `color`, `size`, `quantity`, `completed_qty`, `rejected_qty`, `operator_name`, `production_date`, `remarks`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'BN-1042', 1, 1, 1, 'Navy', 'M', 500, 480, 15, 'John Miller', '2026-08-26', 'High efficiency lot', NULL, '2026-08-26 06:05:16', '2026-08-26 06:05:16'),
(2, 'BN-1043', 1, 1, 1, 'Navy', 'L', 600, 590, 8, 'Robert Chen', '2026-08-26', 'Excellent quality, minimal defects', NULL, '2026-08-26 05:50:16', '2026-08-26 05:50:16'),
(3, 'BN-1044', 2, 3, 4, 'Olive', 'S', 350, 200, 25, 'Maria Gomez', '2026-08-26', 'Thread tension adjusted mid-batch', NULL, '2026-08-26 05:35:16', '2026-08-26 05:35:16'),
(4, 'BN-29384', 1, 2, 2, 'White', 'L', 120, 70, 2, 'Alex Turner', '2026-08-26', 'In cutting-sewing transition', NULL, '2026-08-26 06:10:16', '2026-08-26 06:10:16'),
(5, 'BN-29383', 1, 2, 2, 'Black', 'M', 120, 0, 0, 'Elena Fisher', '2026-08-26', 'Pending line setup', NULL, '2026-08-26 05:30:16', '2026-08-26 05:30:16'),
(6, 'BN-29380', 2, 4, 3, 'Heather Grey', 'XL', 85, 85, 0, 'Sam Wilson', '2026-08-25', 'Passed 100% QC inspection', NULL, '2026-08-26 04:15:16', '2026-08-26 04:15:16'),
(7, 'BN-29375', 3, 5, 5, 'Sky Blue', 'M', 40, 10, 30, 'Lucas Vance', '2026-08-25', 'Fabric flaw rejected by QC', NULL, '2026-08-26 03:15:16', '2026-08-26 03:15:16'),
(8, 'BN-30002', 5, 8, 4, 'Charcoal', 'L', 345, 297, 1, 'Maria Gomez', '2026-08-15', NULL, NULL, '2026-08-15 03:15:16', '2026-08-15 04:15:16'),
(9, 'BN-30003', 2, 3, 4, 'White', '36/32', 330, 320, 5, 'Elena Fisher', '2026-08-21', 'Standard production run', NULL, '2026-08-21 05:15:16', '2026-08-21 01:15:16'),
(10, 'BN-30004', 2, 3, 6, 'Royal Blue', '32/32', 264, 187, 9, 'Maria Gomez', '2026-08-19', 'Standard production run', NULL, '2026-08-19 03:15:16', '2026-08-19 01:15:16'),
(11, 'BN-30005', 3, 6, 5, 'Royal Blue', 'L', 309, 256, 4, 'Liam Nelson', '2026-08-23', 'Standard production run', NULL, '2026-08-22 23:15:16', '2026-08-23 03:15:16'),
(12, 'BN-30007', 1, 1, 5, 'Heather Grey', 'M', 116, 109, 5, 'Alex Turner', '2026-08-18', 'Standard production run', NULL, '2026-08-18 03:15:16', '2026-08-18 00:15:16'),
(13, 'BN-30008', 3, 6, 1, 'Navy', '36/32', 308, 194, 3, 'Elena Fisher', '2026-08-21', 'Standard production run', NULL, '2026-08-20 22:15:16', '2026-08-21 04:15:16'),
(14, 'BN-30009', 1, 2, 2, 'White', '2XL', 368, 180, 6, 'Maria Gomez', '2026-08-20', 'Standard production run', NULL, '2026-08-19 22:15:16', '2026-08-20 04:15:16'),
(15, 'BN-30010', 3, 6, 5, 'Charcoal', 'XS', 22, 22, 0, 'Amina Khan', '2026-08-18', NULL, NULL, '2026-08-18 00:15:16', '2026-08-18 04:15:16'),
(16, 'BN-30011', 1, 1, 5, 'Sky Blue', 'XS', 192, 152, 8, 'Sam Wilson', '2026-08-22', NULL, NULL, '2026-08-22 01:15:16', '2026-08-22 03:15:16'),
(17, 'BN-30012', 1, 1, 1, 'Olive', 'M', 158, 136, 7, 'Sophia Taylor', '2026-08-26', 'Standard production run', NULL, '2026-08-25 22:15:16', '2026-08-26 05:15:16'),
(18, 'BN-30013', 2, 3, 4, 'Khaki', '2XL', 332, 282, 4, 'John Miller', '2026-08-12', NULL, NULL, '2026-08-12 00:15:16', '2026-08-12 05:15:16'),
(19, 'BN-30014', 3, 6, 2, 'Royal Blue', '32/32', 236, 163, 6, 'Elena Fisher', '2026-08-23', 'Standard production run', NULL, '2026-08-23 02:15:16', '2026-08-23 01:15:16'),
(20, 'BN-30015', 2, 3, 2, 'Burgundy', 'XS', 432, 238, 1, 'Sam Wilson', '2026-08-21', 'Standard production run', NULL, '2026-08-21 02:15:16', '2026-08-21 02:15:16'),
(21, 'BN-30016', 3, 5, 3, 'Olive', 'XS', 82, 66, 5, 'Elena Fisher', '2026-08-17', NULL, NULL, '2026-08-17 00:15:16', '2026-08-17 04:15:16'),
(22, 'BN-30017', 1, 1, 1, 'Olive', '2XL', 436, 388, 10, 'Elena Fisher', '2026-08-13', 'Standard production run', NULL, '2026-08-13 00:15:16', '2026-08-13 01:15:16'),
(23, 'BN-30018', 5, 8, 4, 'Burgundy', 'XS', 263, 189, 5, 'Elena Fisher', '2026-08-17', NULL, NULL, '2026-08-17 01:15:16', '2026-08-17 05:15:16'),
(24, 'BN-30019', 2, 4, 1, 'Olive', 'XL', 47, 37, 6, 'Sam Wilson', '2026-08-19', 'Standard production run', NULL, '2026-08-18 23:15:16', '2026-08-18 22:15:16'),
(25, 'BN-30020', 4, 7, 3, 'Burgundy', 'XL', 420, 290, 2, 'Sam Wilson', '2026-08-23', NULL, NULL, '2026-08-23 00:15:16', '2026-08-23 01:15:16'),
(26, 'BN-30021', 5, 8, 3, 'Black', '30/32', 191, 138, 8, 'Maria Gomez', '2026-08-12', NULL, NULL, '2026-08-12 04:15:16', '2026-08-11 22:15:16'),
(27, 'BN-30023', 4, 7, 2, 'Sky Blue', '34/32', 402, 350, 8, 'Alex Turner', '2026-08-15', 'Standard production run', NULL, '2026-08-15 00:15:16', '2026-08-15 00:15:16'),
(28, 'BN-30024', 1, 1, 5, 'Sky Blue', '32/32', 411, 296, 6, 'Sam Wilson', '2026-08-19', NULL, NULL, '2026-08-19 04:15:16', '2026-08-19 03:15:16'),
(29, 'BN-30025', 5, 8, 6, 'Burgundy', 'XS', 382, 164, 8, 'Alex Turner', '2026-08-16', NULL, NULL, '2026-08-16 04:15:16', '2026-08-16 01:15:16'),
(30, 'BN-30026', 4, 7, 1, 'Khaki', 'S', 59, 32, 0, 'Alex Turner', '2026-08-15', 'Standard production run', NULL, '2026-08-15 05:15:16', '2026-08-14 22:15:16'),
(31, 'BN-30027', 2, 4, 1, 'Navy', '2XL', 253, 170, 10, 'John Miller', '2026-08-24', NULL, NULL, '2026-08-24 03:15:16', '2026-08-24 05:15:16'),
(32, 'BN-30028', 1, 1, 2, 'Royal Blue', '2XL', 444, 258, 1, 'Liam Nelson', '2026-08-16', 'Standard production run', NULL, '2026-08-16 00:15:16', '2026-08-16 05:15:16'),
(33, 'BN-30029', 5, 8, 5, 'Burgundy', '32/32', 406, 349, 5, 'Lucas Vance', '2026-08-23', 'Standard production run', NULL, '2026-08-23 01:15:16', '2026-08-22 22:15:16'),
(34, 'BN-30030', 5, 8, 5, 'Heather Grey', 'L', 231, 102, 0, 'John Miller', '2026-08-13', NULL, NULL, '2026-08-12 22:15:16', '2026-08-12 23:15:16'),
(35, 'BN-30031', 1, 1, 5, 'Royal Blue', 'XS', 299, 206, 3, 'Maria Gomez', '2026-08-18', NULL, NULL, '2026-08-18 05:15:16', '2026-08-18 05:15:16'),
(36, 'BN-30032', 1, 1, 3, 'Black', '36/32', 399, 375, 9, 'Elena Fisher', '2026-08-25', 'Standard production run', NULL, '2026-08-25 00:15:16', '2026-08-25 00:15:16'),
(37, 'BN-30033', 4, 7, 6, 'Charcoal', '36/32', 233, 172, 10, 'Sophia Taylor', '2026-08-25', NULL, NULL, '2026-08-25 01:15:16', '2026-08-24 22:15:16'),
(38, 'BN-30035', 4, 7, 3, 'White', '36/32', 224, 130, 4, 'Alex Turner', '2026-08-14', NULL, NULL, '2026-08-14 04:15:16', '2026-08-13 23:15:16'),
(39, 'BN-30036', 4, 7, 4, 'Olive', 'L', 138, 98, 1, 'Elena Fisher', '2026-08-17', 'Standard production run', NULL, '2026-08-16 23:15:16', '2026-08-17 05:15:16'),
(40, 'BN-30037', 4, 7, 3, 'Olive', 'XS', 189, 149, 5, 'John Miller', '2026-08-14', 'Standard production run', NULL, '2026-08-14 02:15:16', '2026-08-14 01:15:16'),
(41, 'BN-30039', 1, 1, 3, 'Olive', '2XL', 222, 186, 6, 'Lucas Vance', '2026-08-23', 'Standard production run', NULL, '2026-08-22 23:15:16', '2026-08-23 05:15:16'),
(42, 'BN-30040', 3, 5, 6, 'Navy', 'L', 496, 476, 7, 'Sophia Taylor', '2026-08-12', NULL, NULL, '2026-08-12 05:15:16', '2026-08-12 03:15:16'),
(43, 'BN-30041', 5, 8, 3, 'Sky Blue', '32/32', 414, 290, 10, 'John Miller', '2026-08-14', NULL, NULL, '2026-08-13 23:15:16', '2026-08-13 22:15:16'),
(44, 'BN-30042', 4, 7, 3, 'Khaki', 'S', 236, 158, 2, 'Liam Nelson', '2026-08-12', 'Standard production run', NULL, '2026-08-12 00:15:16', '2026-08-12 04:15:16'),
(45, 'BN-30043', 4, 7, 4, 'Navy', '30/32', 122, 118, 0, 'Amina Khan', '2026-08-26', 'Standard production run', NULL, '2026-08-26 05:15:16', '2026-08-26 00:15:16'),
(46, 'BN-30044', 1, 1, 2, 'Olive', 'S', 142, 57, 8, 'Amina Khan', '2026-08-21', NULL, NULL, '2026-08-21 01:15:16', '2026-08-20 23:15:16'),
(47, 'BN-30045', 3, 5, 5, 'Royal Blue', 'L', 278, 275, 3, 'Maria Gomez', '2026-08-25', 'Standard production run', NULL, '2026-08-25 00:15:16', '2026-08-25 01:15:16'),
(48, 'BN-30046', 4, 7, 4, 'Heather Grey', 'S', 136, 63, 0, 'Lucas Vance', '2026-08-25', NULL, NULL, '2026-08-25 00:15:16', '2026-08-25 03:15:16'),
(49, 'BN-30047', 1, 2, 6, 'Navy', 'XS', 255, 207, 10, 'Sam Wilson', '2026-08-19', NULL, NULL, '2026-08-19 02:15:16', '2026-08-19 02:15:16'),
(50, 'BN-30048', 2, 4, 2, 'Burgundy', '2XL', 351, 302, 5, 'Elena Fisher', '2026-08-23', 'Standard production run', NULL, '2026-08-22 23:15:16', '2026-08-22 22:15:16'),
(51, 'BN-30049', 2, 3, 4, 'Royal Blue', '30/32', 108, 91, 0, 'Sophia Taylor', '2026-08-16', 'Standard production run', NULL, '2026-08-16 05:15:16', '2026-08-16 00:15:16'),
(52, 'BN-30050', 5, 8, 1, 'Burgundy', 'L', 385, 231, 4, 'Robert Chen', '2026-08-26', 'Standard production run', NULL, '2026-08-25 23:15:16', '2026-08-26 01:15:16'),
(53, 'BN-30051', 1, 1, 2, 'White', 'XL', 307, 178, 10, 'Lucas Vance', '2026-08-18', NULL, NULL, '2026-08-18 04:15:16', '2026-08-17 22:15:16'),
(54, 'BN-30052', 4, 7, 3, 'Burgundy', '34/32', 80, 50, 10, 'Maria Gomez', '2026-08-20', NULL, NULL, '2026-08-20 03:15:16', '2026-08-20 04:15:16'),
(55, 'BN-30053', 2, 4, 6, 'Heather Grey', '34/32', 380, 308, 2, 'Liam Nelson', '2026-08-17', NULL, NULL, '2026-08-16 23:15:16', '2026-08-16 23:15:16'),
(56, 'BN-30055', 3, 5, 5, 'Heather Grey', 'XL', 395, 288, 3, 'Elena Fisher', '2026-08-18', NULL, NULL, '2026-08-18 05:15:16', '2026-08-18 04:15:16'),
(57, 'BN-30057', 1, 2, 2, 'Sky Blue', '34/32', 469, 446, 0, 'Alex Turner', '2026-08-24', NULL, NULL, '2026-08-24 05:15:16', '2026-08-24 01:15:16'),
(58, 'BN-30059', 1, 2, 4, 'Heather Grey', 'XL', 411, 300, 5, 'Sophia Taylor', '2026-08-13', 'Standard production run', NULL, '2026-08-13 02:15:16', '2026-08-13 03:15:16'),
(59, 'BN-30060', 2, 4, 5, 'Navy', '34/32', 152, 84, 5, 'Sophia Taylor', '2026-08-16', 'Standard production run', NULL, '2026-08-15 22:15:16', '2026-08-16 00:15:16'),
(60, 'BN-30061', 1, 1, 5, 'Charcoal', 'S', 188, 167, 1, 'Lucas Vance', '2026-08-20', 'Standard production run', NULL, '2026-08-20 00:15:16', '2026-08-20 03:15:16'),
(61, 'BN-30062', 1, 1, 3, 'Heather Grey', 'S', 479, 292, 4, 'Liam Nelson', '2026-08-14', 'Standard production run', NULL, '2026-08-13 23:15:16', '2026-08-14 00:15:16'),
(62, 'BN-30063', 4, 7, 1, 'Charcoal', 'XS', 201, 111, 7, 'Elena Fisher', '2026-08-14', NULL, NULL, '2026-08-14 00:15:16', '2026-08-14 00:15:16'),
(63, 'BN-30064', 3, 5, 2, 'Sky Blue', 'XS', 229, 126, 5, 'Lucas Vance', '2026-08-15', 'Standard production run', NULL, '2026-08-15 02:15:16', '2026-08-15 00:15:16'),
(64, 'BN-30065', 4, 7, 5, 'Royal Blue', '36/32', 498, 448, 8, 'Maria Gomez', '2026-08-21', NULL, NULL, '2026-08-21 02:15:16', '2026-08-21 04:15:16'),
(65, 'BN-30066', 2, 4, 6, 'Olive', 'XL', 30, 16, 8, 'Alex Turner', '2026-08-17', NULL, NULL, '2026-08-17 03:15:16', '2026-08-17 05:15:16'),
(66, 'BN-30068', 3, 6, 3, 'Black', 'L', 442, 190, 9, 'Sam Wilson', '2026-08-21', NULL, NULL, '2026-08-21 05:15:16', '2026-08-20 23:15:16'),
(67, 'BN-30069', 2, 4, 3, 'Navy', '30/32', 85, 84, 1, 'Robert Chen', '2026-08-22', NULL, NULL, '2026-08-22 03:15:16', '2026-08-22 01:15:16'),
(68, 'BN-30070', 5, 8, 2, 'Sky Blue', '34/32', 222, 198, 8, 'Maria Gomez', '2026-08-14', 'Standard production run', NULL, '2026-08-14 02:15:16', '2026-08-14 03:15:16'),
(69, 'BN-30071', 5, 8, 3, 'Charcoal', '30/32', 68, 29, 6, 'Sophia Taylor', '2026-08-15', 'Standard production run', NULL, '2026-08-15 00:15:16', '2026-08-15 00:15:16'),
(70, 'BN-30072', 1, 1, 6, 'Khaki', '34/32', 34, 23, 5, 'Robert Chen', '2026-08-14', NULL, NULL, '2026-08-14 00:15:16', '2026-08-14 01:15:16'),
(71, 'BN-30073', 1, 2, 6, 'Navy', '36/32', 121, 83, 10, 'Alex Turner', '2026-08-16', 'Standard production run', NULL, '2026-08-16 05:15:16', '2026-08-16 05:15:16'),
(72, 'BN-30074', 3, 5, 1, 'White', 'M', 331, 235, 1, 'Robert Chen', '2026-08-17', NULL, NULL, '2026-08-17 04:15:16', '2026-08-17 00:15:16'),
(73, 'BN-30075', 1, 2, 4, 'Olive', '36/32', 406, 284, 0, 'Liam Nelson', '2026-08-24', 'Standard production run', NULL, '2026-08-24 05:15:16', '2026-08-24 02:15:16'),
(74, 'BN-30076', 3, 5, 1, 'Navy', 'XS', 326, 274, 9, 'Robert Chen', '2026-08-12', 'Standard production run', NULL, '2026-08-12 02:15:16', '2026-08-12 01:15:16'),
(75, 'BN-30077', 4, 7, 5, 'Sky Blue', 'L', 394, 236, 2, 'Elena Fisher', '2026-08-26', 'Standard production run', NULL, '2026-08-26 03:15:16', '2026-08-26 04:15:16'),
(76, 'BN-30078', 2, 3, 1, 'Khaki', '36/32', 301, 295, 4, 'Sam Wilson', '2026-08-25', 'Standard production run', NULL, '2026-08-24 23:15:16', '2026-08-24 23:15:16'),
(77, 'BN-30079', 4, 7, 3, 'Royal Blue', '2XL', 206, 196, 8, 'Maria Gomez', '2026-08-17', 'Standard production run', NULL, '2026-08-17 05:15:16', '2026-08-16 22:15:16'),
(78, 'BN-30080', 4, 7, 1, 'Charcoal', '36/32', 298, 229, 8, 'Sam Wilson', '2026-08-24', 'Standard production run', NULL, '2026-08-24 01:15:16', '2026-08-24 05:15:16'),
(79, 'BN-30081', 1, 2, 6, 'Olive', '30/32', 41, 18, 10, 'Alex Turner', '2026-08-24', NULL, NULL, '2026-08-24 04:15:16', '2026-08-24 03:15:16'),
(80, 'BN-30083', 4, 7, 2, 'Navy', 'L', 499, 409, 3, 'Sam Wilson', '2026-08-18', NULL, NULL, '2026-08-18 00:15:16', '2026-08-18 04:15:16'),
(81, 'BN-30084', 4, 7, 2, 'Heather Grey', 'M', 156, 109, 1, 'Liam Nelson', '2026-08-25', 'Standard production run', NULL, '2026-08-25 03:15:16', '2026-08-25 04:15:16'),
(82, 'BN-30085', 5, 8, 3, 'Black', 'XS', 168, 74, 1, 'Liam Nelson', '2026-08-19', NULL, NULL, '2026-08-19 02:15:16', '2026-08-19 02:15:16'),
(83, 'BN-30086', 4, 7, 4, 'Royal Blue', 'XL', 41, 41, 0, 'John Miller', '2026-08-15', NULL, NULL, '2026-08-15 01:15:16', '2026-08-15 05:15:16'),
(84, 'BN-30087', 3, 5, 2, 'Sky Blue', 'XS', 434, 195, 9, 'Robert Chen', '2026-08-23', NULL, NULL, '2026-08-22 22:15:16', '2026-08-23 01:15:16'),
(85, 'BN-30088', 1, 2, 6, 'Sky Blue', '36/32', 47, 38, 9, 'Maria Gomez', '2026-08-16', NULL, NULL, '2026-08-16 05:15:16', '2026-08-16 05:15:16'),
(86, 'BN-30089', 2, 4, 1, 'Olive', 'XL', 92, 59, 0, 'Liam Nelson', '2026-08-20', 'Standard production run', NULL, '2026-08-19 23:15:16', '2026-08-19 23:15:16'),
(87, 'BN-30091', 3, 5, 4, 'Royal Blue', 'L', 165, 124, 4, 'Elena Fisher', '2026-08-15', NULL, NULL, '2026-08-15 05:15:16', '2026-08-15 05:15:16'),
(88, 'BN-30092', 2, 4, 4, 'Royal Blue', 'M', 398, 179, 7, 'Lucas Vance', '2026-08-17', NULL, NULL, '2026-08-17 03:15:16', '2026-08-17 04:15:16'),
(89, 'BN-30093', 2, 3, 5, 'Sky Blue', 'XL', 405, 166, 6, 'Liam Nelson', '2026-08-23', 'Standard production run', NULL, '2026-08-23 03:15:16', '2026-08-22 22:15:16'),
(90, 'BN-30094', 5, 8, 3, 'Charcoal', '2XL', 159, 75, 8, 'Liam Nelson', '2026-08-16', NULL, NULL, '2026-08-16 03:15:16', '2026-08-16 00:15:16'),
(91, 'BN-30095', 4, 7, 4, 'Olive', '2XL', 382, 191, 3, 'Sam Wilson', '2026-08-23', NULL, NULL, '2026-08-23 00:15:16', '2026-08-23 02:15:16'),
(92, 'BN-30096', 4, 7, 4, 'White', 'XS', 219, 166, 1, 'Amina Khan', '2026-08-24', 'Standard production run', NULL, '2026-08-24 01:15:16', '2026-08-24 03:15:16'),
(93, 'BN-30097', 3, 6, 3, 'Royal Blue', '36/32', 241, 181, 10, 'Sophia Taylor', '2026-08-21', 'Standard production run', NULL, '2026-08-21 02:15:16', '2026-08-20 22:15:16'),
(94, 'BN-30098', 4, 7, 2, 'Navy', 'M', 396, 396, 0, 'Lucas Vance', '2026-08-13', NULL, NULL, '2026-08-13 05:15:16', '2026-08-13 01:15:16'),
(95, 'BN-30100', 1, 2, 4, 'Burgundy', 'XS', 78, 33, 7, 'Lucas Vance', '2026-08-16', NULL, NULL, '2026-08-16 00:15:16', '2026-08-15 22:15:16'),
(96, 'BN-30101', 4, 7, 1, 'Sky Blue', '30/32', 163, 82, 7, 'Elena Fisher', '2026-08-24', 'Standard production run', NULL, '2026-08-24 02:15:16', '2026-08-24 05:15:16'),
(97, 'BN-30102', 1, 2, 6, 'Charcoal', '30/32', 356, 206, 0, 'Amina Khan', '2026-08-23', 'Standard production run', NULL, '2026-08-22 23:15:16', '2026-08-23 02:15:16'),
(98, 'BN-30103', 4, 7, 1, 'Sky Blue', 'XL', 113, 46, 3, 'Amina Khan', '2026-08-26', NULL, NULL, '2026-08-26 05:15:16', '2026-08-25 23:15:16'),
(99, 'BN-30104', 2, 3, 2, 'Black', '30/32', 343, 285, 0, 'Elena Fisher', '2026-08-17', NULL, NULL, '2026-08-17 04:15:16', '2026-08-16 22:15:16'),
(100, 'BN-30105', 3, 5, 1, 'Black', '32/32', 342, 246, 10, 'Elena Fisher', '2026-08-17', 'Standard production run', NULL, '2026-08-16 23:15:16', '2026-08-17 05:15:16'),
(101, 'BN-30106', 3, 5, 5, 'Charcoal', '30/32', 163, 75, 4, 'Sophia Taylor', '2026-08-16', 'Standard production run', NULL, '2026-08-16 02:15:16', '2026-08-15 23:15:16'),
(102, 'BN-30107', 4, 7, 1, 'White', 'XS', 69, 48, 7, 'Lucas Vance', '2026-08-14', NULL, NULL, '2026-08-14 05:15:16', '2026-08-14 03:15:16'),
(103, 'BN-30108', 3, 6, 6, 'Olive', 'M', 483, 232, 10, 'Lucas Vance', '2026-08-18', 'Standard production run', NULL, '2026-08-18 05:15:16', '2026-08-18 05:15:16'),
(104, 'BN-30109', 2, 4, 1, 'Burgundy', 'S', 399, 371, 2, 'Alex Turner', '2026-08-23', 'Standard production run', NULL, '2026-08-22 23:15:16', '2026-08-23 03:15:16'),
(105, 'BN-30111', 4, 7, 6, 'Black', 'M', 188, 103, 10, 'Sophia Taylor', '2026-08-23', NULL, NULL, '2026-08-22 23:15:16', '2026-08-23 05:15:16'),
(106, 'BN-30112', 5, 8, 6, 'Sky Blue', '36/32', 53, 21, 10, 'John Miller', '2026-08-14', 'Standard production run', NULL, '2026-08-14 03:15:16', '2026-08-14 05:15:16'),
(107, 'BN-30113', 1, 2, 6, 'Royal Blue', 'XL', 166, 93, 0, 'John Miller', '2026-08-23', NULL, NULL, '2026-08-23 02:15:16', '2026-08-23 05:15:16'),
(108, 'BN-30114', 3, 5, 3, 'Burgundy', '30/32', 469, 417, 3, 'Alex Turner', '2026-08-14', NULL, NULL, '2026-08-14 02:15:16', '2026-08-13 23:15:16'),
(109, 'BN-30115', 1, 2, 1, 'White', '34/32', 172, 83, 0, 'Amina Khan', '2026-08-21', NULL, NULL, '2026-08-20 23:15:16', '2026-08-21 03:15:16'),
(110, 'BN-30116', 5, 8, 4, 'Burgundy', '2XL', 117, 82, 7, 'Liam Nelson', '2026-08-18', 'Standard production run', NULL, '2026-08-18 04:15:16', '2026-08-18 03:15:16'),
(111, 'BN-30117', 2, 4, 1, 'White', '2XL', 392, 380, 3, 'Elena Fisher', '2026-08-18', 'Standard production run', NULL, '2026-08-18 05:15:16', '2026-08-17 22:15:16'),
(112, 'BN-30119', 5, 8, 4, 'Charcoal', 'XL', 36, 22, 3, 'Alex Turner', '2026-08-17', NULL, NULL, '2026-08-17 04:15:16', '2026-08-16 23:15:16'),
(113, 'BN-30120', 3, 5, 4, 'Charcoal', '32/32', 75, 53, 10, 'Lucas Vance', '2026-08-15', 'Standard production run', NULL, '2026-08-15 01:15:16', '2026-08-15 01:15:16'),
(114, 'BN-30121', 2, 4, 2, 'Black', 'XL', 24, 13, 9, 'Robert Chen', '2026-08-25', 'Standard production run', NULL, '2026-08-25 02:15:16', '2026-08-24 23:15:16'),
(115, 'BN-30122', 4, 7, 6, 'Burgundy', 'L', 29, 19, 1, 'Lucas Vance', '2026-08-15', 'Standard production run', NULL, '2026-08-15 03:15:16', '2026-08-15 05:15:16'),
(116, 'BN-30123', 3, 6, 4, 'Charcoal', '30/32', 469, 291, 10, 'Amina Khan', '2026-08-15', NULL, NULL, '2026-08-14 23:15:16', '2026-08-15 04:15:16'),
(117, 'BN-30125', 5, 8, 4, 'White', '36/32', 264, 224, 7, 'Lucas Vance', '2026-08-17', 'Standard production run', NULL, '2026-08-16 22:15:16', '2026-08-17 03:15:16'),
(118, 'BN-30126', 1, 2, 2, 'Burgundy', 'S', 420, 206, 3, 'Liam Nelson', '2026-08-26', NULL, NULL, '2026-08-26 02:15:16', '2026-08-26 05:15:16'),
(119, 'BN-30128', 3, 5, 5, 'Heather Grey', 'XL', 28, 20, 3, 'Lucas Vance', '2026-08-20', NULL, NULL, '2026-08-20 04:15:16', '2026-08-20 02:15:16'),
(120, 'BN-30129', 1, 1, 2, 'White', 'L', 372, 153, 10, 'John Miller', '2026-08-15', 'Standard production run', NULL, '2026-08-15 04:15:16', '2026-08-15 02:15:16'),
(121, 'BN-30130', 3, 5, 1, 'Burgundy', '34/32', 391, 278, 4, 'Alex Turner', '2026-08-21', 'Standard production run', NULL, '2026-08-21 01:15:16', '2026-08-21 01:15:16'),
(122, 'BN-30132', 4, 7, 4, 'Burgundy', '32/32', 298, 215, 7, 'Elena Fisher', '2026-08-15', NULL, NULL, '2026-08-15 05:15:16', '2026-08-15 04:15:16'),
(123, 'BN-30133', 3, 6, 5, 'Olive', 'L', 297, 258, 6, 'Amina Khan', '2026-08-23', NULL, NULL, '2026-08-23 02:15:16', '2026-08-23 03:15:16'),
(124, 'BN-30134', 3, 5, 3, 'Khaki', '30/32', 262, 113, 5, 'Amina Khan', '2026-08-21', NULL, NULL, '2026-08-20 23:15:16', '2026-08-20 22:15:16'),
(125, 'BN-30135', 1, 2, 1, 'Sky Blue', '30/32', 108, 52, 1, 'Amina Khan', '2026-08-15', NULL, NULL, '2026-08-15 03:15:16', '2026-08-15 03:15:16'),
(126, 'BN-30136', 4, 7, 3, 'Khaki', '34/32', 233, 177, 8, 'Maria Gomez', '2026-08-17', NULL, NULL, '2026-08-17 05:15:16', '2026-08-17 01:15:16'),
(127, 'BN-30137', 5, 8, 1, 'Sky Blue', '34/32', 482, 260, 1, 'Liam Nelson', '2026-08-22', NULL, NULL, '2026-08-22 04:15:16', '2026-08-21 23:15:16'),
(128, 'BN-30138', 1, 2, 4, 'Black', 'XL', 221, 217, 4, 'Robert Chen', '2026-08-19', NULL, NULL, '2026-08-19 00:15:16', '2026-08-19 04:15:16'),
(129, 'BN-30139', 5, 8, 1, 'Burgundy', '2XL', 78, 37, 3, 'Elena Fisher', '2026-08-17', NULL, NULL, '2026-08-17 03:15:16', '2026-08-17 04:15:16'),
(130, 'BN-30140', 4, 7, 3, 'Royal Blue', '30/32', 487, 268, 8, 'Liam Nelson', '2026-08-18', NULL, NULL, '2026-08-18 02:15:16', '2026-08-18 05:15:16'),
(131, 'BN-30141', 5, 8, 4, 'Khaki', '36/32', 104, 97, 4, 'Maria Gomez', '2026-08-20', 'Standard production run', NULL, '2026-08-20 03:15:16', '2026-08-20 01:15:16'),
(132, 'BN-30142', 1, 1, 4, 'Royal Blue', 'S', 82, 75, 4, 'Sam Wilson', '2026-08-18', 'Standard production run', NULL, '2026-08-17 22:15:16', '2026-08-18 05:15:16'),
(133, 'BN-30143', 5, 8, 5, 'Sky Blue', 'XL', 223, 127, 10, 'Liam Nelson', '2026-08-14', 'Standard production run', NULL, '2026-08-14 03:15:16', '2026-08-13 22:15:16'),
(134, 'BN-30144', 4, 7, 3, 'Black', 'L', 164, 113, 5, 'Elena Fisher', '2026-08-23', NULL, NULL, '2026-08-23 02:15:16', '2026-08-23 04:15:16'),
(135, 'BN-30146', 3, 6, 4, 'Burgundy', '32/32', 477, 219, 10, 'Lucas Vance', '2026-08-13', 'Standard production run', NULL, '2026-08-13 04:15:16', '2026-08-13 01:15:16'),
(136, 'BN-30147', 5, 8, 4, 'White', '32/32', 326, 310, 10, 'John Miller', '2026-08-14', NULL, NULL, '2026-08-14 00:15:16', '2026-08-13 23:15:16'),
(137, 'BN-30148', 5, 8, 2, 'Navy', 'XS', 274, 247, 8, 'Lucas Vance', '2026-08-22', NULL, NULL, '2026-08-22 02:15:16', '2026-08-22 02:15:16'),
(138, 'BN-30149', 2, 3, 6, 'Navy', '36/32', 500, 480, 8, 'Amina Khan', '2026-08-12', 'Standard production run', NULL, '2026-08-11 22:15:16', '2026-08-11 23:15:16'),
(139, 'BN-30150', 4, 7, 1, 'Burgundy', 'S', 61, 51, 0, 'John Miller', '2026-08-16', 'Standard production run', NULL, '2026-08-15 23:15:16', '2026-08-16 00:15:16');

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
