-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2026 at 12:07 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `affliate`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$10$CI9q94fN/EqegLk9IgjBKeu7YXX2dSKSY9NkdCv/IABQGB/dfCsVe', '2026-02-12 06:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `amazon_categories`
--

CREATE TABLE `amazon_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `is_show` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amazon_categories`
--

INSERT INTO `amazon_categories` (`id`, `category_name`, `slug`, `description`, `image`, `status`, `is_show`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'electronics', 'Electronic devices and accessories like phones', NULL, 'active', 0, 6, '2026-02-09 09:31:15', '2026-02-09 09:31:15'),
(2, 'Books', 'books', 'Books and literature including fiction', NULL, 'active', 0, 6, '2026-02-09 09:31:15', '2026-02-09 09:31:15'),
(3, 'Clothing', 'clothing', 'Fashion and apparel for men', NULL, 'active', 0, 6, '2026-02-09 09:31:15', '2026-02-09 09:31:15'),
(4, 'Home & Kitchen', 'home-kitchen', 'Home appliances', NULL, 'active', 0, 6, '2026-02-09 09:31:15', '2026-02-09 09:31:15'),
(5, 'Sports & Outdoors', 'sports-outdoors', 'Sports equipment', NULL, 'active', 0, 6, '2026-02-09 09:31:15', '2026-02-09 09:31:15'),
(6, 'Beauty & Personal Care', 'beauty-personal-care', 'Cosmetics', NULL, 'active', 0, 6, '2026-02-09 09:31:15', '2026-02-09 09:31:15'),
(7, 'Toys & Games', 'toys-games', 'Children\'s toys', NULL, 'active', 0, 6, '2026-02-09 09:31:15', '2026-02-09 09:31:15'),
(8, 'Health & Wellness', 'health-wellness', 'Vitamins', NULL, 'active', 0, 6, '2026-02-09 09:31:15', '2026-02-09 09:31:15'),
(9, 'Automotive', 'automotive', 'Car parts', NULL, 'active', 0, 6, '2026-02-09 09:31:15', '2026-02-09 09:31:15'),
(10, 'Pet Supplies', 'pet-supplies', 'Pet food', NULL, 'active', 0, 6, '2026-02-09 09:31:15', '2026-02-09 09:31:15'),
(11, 'Electronics', 'electronics-1', 'Latest electronics and gadgets', 'https://via.placeholder.com/300x200/007bff/ffffff?text=Electronics', 'active', 0, 1, NULL, NULL),
(12, 'Fashion', 'fashion', 'Trendy fashion and accessories', 'https://via.placeholder.com/300x200/28a745/ffffff?text=Fashion', 'active', 0, 1, NULL, NULL),
(13, 'Home & Kitchen', 'home-kitchen-1', 'Home appliances and kitchen essentials', 'https://via.placeholder.com/300x200/dc3545/ffffff?text=Home+Kitchen', 'active', 0, 1, NULL, NULL),
(14, 'Sports & Outdoors', 'sports-outdoors-1', 'Sports equipment and outdoor gear', 'https://via.placeholder.com/300x200/ffc107/000000?text=Sports', 'active', 0, 1, NULL, NULL),
(15, 'Books & Media', 'books-media', 'Books, movies, and digital media', 'https://via.placeholder.com/300x200/6f42c1/ffffff?text=Books', 'active', 0, 1, NULL, NULL),
(16, 'Beauty & Personal Care', 'beauty-personal-care-1', 'Beauty products and personal care items', 'https://via.placeholder.com/300x200/e83e8c/ffffff?text=Beauty', 'active', 0, 1, NULL, NULL),
(17, 'Toys & Games', 'toys-games-1', 'Toys, games, and entertainment', 'https://via.placeholder.com/300x20a/20c997/ffffff?text=Toys', 'active', 0, 1, NULL, NULL),
(18, 'Automotive', 'automotive-1', 'Car accessories and automotive parts', 'https://via.placeholder.com/300x200/343a40/ffffff?text=Automotive', 'active', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `amazon_products`
--

CREATE TABLE `amazon_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amazon_category_id` bigint(20) UNSIGNED NOT NULL,
  `amazon_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(191) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `image_url` varchar(191) DEFAULT NULL,
  `link` varchar(191) DEFAULT NULL,
  `affiliate_url` varchar(191) DEFAULT NULL,
  `meta_title` varchar(191) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(191) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amazon_products`
--

INSERT INTO `amazon_products` (`id`, `amazon_category_id`, `amazon_sub_category_id`, `product_name`, `slug`, `description`, `short_description`, `image`, `image_url`, `link`, `affiliate_url`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Wireless Bluetooth Headphones', 'wireless-bluetooth-headphones', 'Premium noise-cancelling wireless headphones with 30-hour battery life and superior sound quality.', NULL, '1770907551_Screenshot 2026-02-12 201537.png', NULL, 'https://amazon.com/headphones', NULL, 'Wireless Bluetooth Headphones - Best Sound Quality', 'Premium noise-cancelling wireless headphones with 30-hour battery life.', 'headphones, bluetooth, wireless, audio', 'active', 6, NULL, '2026-02-12 09:15:51'),
(2, 1, NULL, 'Smart Watch Pro', 'smart-watch-pro', 'Advanced fitness tracking smartwatch with heart rate monitor, GPS, and 5-day battery life.', NULL, '1770907603_Screenshot 2026-02-12 201629.png', NULL, 'https://amazon.com/smartwatch', NULL, 'Smart Watch Pro - Advanced Fitness Tracking', 'Advanced fitness tracking smartwatch with heart rate monitor and GPS.', 'smartwatch, fitness, tracking, gps', 'active', 6, NULL, '2026-02-12 09:16:43'),
(3, 2, NULL, 'Designer Leather Handbag', 'designer-leather-handbag', 'Genuine leather designer handbag with multiple compartments and elegant design.', NULL, '1770907662_Screenshot 2026-02-12 201725.png', NULL, 'https://amazon.com/handbag', NULL, 'Designer Leather Handbag - Premium Quality', 'Genuine leather designer handbag with multiple compartments.', 'handbag, leather, fashion, designer', 'active', 6, NULL, '2026-02-12 09:17:42'),
(4, 3, NULL, 'Air Fryer Deluxe', 'air-fryer-deluxe', '5.8QT air fryer with rapid air technology for healthy frying with little to no oil.', NULL, 'https://via.placeholder.com/300x300/ffc107/000000?text=Air+Fryer', NULL, 'https://amazon.com/airfryer', NULL, 'Air Fryer Deluxe - Healthy Cooking', '5.8QT air fryer with rapid air technology for healthy frying.', 'air fryer, kitchen, cooking, healthy', 'active', 6, NULL, NULL),
(5, 4, NULL, 'Yoga Mat Premium', 'yoga-mat-premium', 'Extra thick non-slip yoga mat with carrying strap for comfortable workout sessions.', NULL, 'https://via.placeholder.com/300x300/6f42c1/ffffff?text=Yoga+Mat', NULL, 'https://amazon.com/yogamat', NULL, 'Yoga Mat Premium - Comfort & Stability', 'Extra thick non-slip yoga mat with carrying strap.', 'yoga mat, fitness, exercise, workout', 'active', 6, NULL, NULL),
(6, 5, NULL, 'Bestseller Novel Collection', 'bestseller-novel-collection', 'Collection of 5 bestselling novels from award-winning authors in various genres.', NULL, 'https://via.placeholder.com/300x300/e83e8c/ffffff?text=Books', NULL, 'https://amazon.com/books', NULL, 'Bestseller Novel Collection - Must Read', 'Collection of 5 bestselling novels from award-winning authors.', 'books, novels, bestseller, reading', 'active', 6, NULL, NULL),
(7, 6, NULL, 'Skincare Set Premium', 'skincare-set-premium', 'Complete 7-piece skincare set with cleanser, toner, serum, and moisturizer for all skin types.', NULL, 'https://via.placeholder.com/300x300/20c997/ffffff?text=Skincare', NULL, 'https://amazon.com/skincare', NULL, 'Skincare Set Premium - Complete Care', 'Complete 7-piece skincare set for all skin types.', 'skincare, beauty, cosmetics, care', 'active', 6, NULL, NULL),
(8, 7, NULL, 'Educational Puzzle Set', 'educational-puzzle-set', '500-piece educational puzzle set featuring world geography and landmarks.', NULL, 'https://via.placeholder.com/300x300/343a40/ffffff?text=Puzzle', NULL, 'https://amazon.com/puzzle', NULL, 'Educational Puzzle Set - Learn & Play', '500-piece educational puzzle featuring world geography.', 'puzzle, educational, toys, learning', 'active', 6, NULL, NULL),
(9, 8, NULL, 'Car Phone Mount', 'car-phone-mount', 'Universal car phone mount with 360-degree rotation and secure grip.', NULL, 'https://via.placeholder.com/300x300/007bff/ffffff?text=Phone+Mount', NULL, 'https://amazon.com/phonemount', NULL, 'Car Phone Mount - Secure & Adjustable', 'Universal car phone mount with 360-degree rotation.', 'car mount, phone, automotive, accessories', 'active', 6, NULL, NULL),
(10, 1, NULL, 'Portable Power Bank', 'portable-power-bank', '20000mAh portable power bank with fast charging and multiple USB ports.', NULL, 'https://via.placeholder.com/300x300/28a745/ffffff?text=Power+Bank', NULL, 'https://amazon.com/powerbank', NULL, 'Portable Power Bank - Stay Charged', '20000mAh portable power bank with fast charging.', 'power bank, portable, charging, electronics', 'active', 6, NULL, NULL),
(11, 2, NULL, 'Sunglasses Premium', 'sunglasses-premium', 'UV protection polarized sunglasses with stylish frame and premium lenses.', NULL, 'https://via.placeholder.com/300x300/dc3545/ffffff?text=Sunglasses', NULL, 'https://amazon.com/sunglasses', NULL, 'Sunglasses Premium - UV Protection', 'UV protection polarized sunglasses with stylish frame.', 'sunglasses, UV protection, fashion, eyewear', 'active', 6, NULL, NULL),
(12, 3, NULL, 'Coffee Maker Deluxe', 'coffee-maker-deluxe', 'Programmable coffee maker with thermal carafe and multiple brewing options.', NULL, 'https://via.placeholder.com/300x300/ffc107/000000?text=Coffee+Maker', NULL, 'https://amazon.com/coffeemaker', NULL, 'Coffee Maker Deluxe - Perfect Brew', 'Programmable coffee maker with thermal carafe.', 'coffee maker, kitchen, brewing, appliance', 'active', 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `amazon_sub_categories`
--

CREATE TABLE `amazon_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `amazon_category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amazon_sub_categories`
--

INSERT INTO `amazon_sub_categories` (`id`, `sub_category_name`, `description`, `image`, `slug`, `status`, `amazon_category_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'hai', 'hai', NULL, 'hai', 'active', 12, 1, '2026-02-24 00:55:24', '2026-02-24 00:55:37');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `user_id`, `title`, `slug`, `photo`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'hai', 'hai', 'storage/banners/1770482930_69876cf2d3a65.png', 'hai', 'active', '2026-02-07 11:18:50', '2026-02-07 11:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `status` enum('new','progress','delivered','cancel') NOT NULL DEFAULT 'new',
  `quantity` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `summary` text DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `is_parent` tinyint(1) NOT NULL DEFAULT 1,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `type` enum('fixed','percent') NOT NULL DEFAULT 'fixed',
  `value` decimal(20,2) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'abc123', 'fixed', '300.00', 'active', NULL, NULL),
(2, '111111', 'percent', '10.00', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lms`
--

CREATE TABLE `lms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lms_category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `document` varchar(191) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lms_categories`
--

CREATE TABLE `lms_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(191) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `subject` text NOT NULL,
  `email` varchar(191) NOT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `message` longtext NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2020_07_10_021010_create_brands_table', 1),
(6, '2020_07_10_025334_create_banners_table', 1),
(7, '2020_07_10_112147_create_categories_table', 1),
(8, '2020_07_11_063857_create_products_table', 1),
(9, '2020_07_12_073132_create_post_categories_table', 1),
(10, '2020_07_12_073701_create_post_tags_table', 1),
(11, '2020_07_12_083638_create_posts_table', 1),
(12, '2020_07_13_151329_create_messages_table', 1),
(13, '2020_07_15_102626_create_carts_table', 1),
(14, '2020_07_16_041623_create_notifications_table', 1),
(15, '2020_07_16_053240_create_coupons_table', 1),
(16, '2020_07_23_143757_create_wishlists_table', 1),
(17, '2020_07_24_131727_create_post_comments_table', 1),
(18, '2020_08_01_143408_create_settings_table', 1),
(19, '2023_06_21_164432_create_jobs_table', 1),
(20, '2026_02_07_051648_add_user_id_to_banners_table', 1),
(21, '2026_02_07_051650_add_user_id_to_brands_table', 1),
(22, '2026_02_07_052225_add_user_id_to_products_table', 1),
(23, '2026_02_07_052846_add_user_id_to_posts_table', 1),
(24, '2026_02_07_052848_add_user_id_to_post_categories_table', 1),
(25, '2026_02_07_052917_add_user_id_to_post_tags_table', 1),
(26, '2026_02_07_053810_add_user_id_to_categories_table', 1),
(27, '2026_02_07_054638_update_role_column_in_users_table', 1),
(28, '2026_02_07_055824_create_roles_table', 1),
(29, '2026_02_07_055854_add_role_id_to_users_table', 1),
(30, '2026_02_07_154010_remove_role_from_users_table', 1),
(31, '2026_02_07_162402_create_permissions_table', 2),
(32, '2026_02_07_162425_create_role_permissions_table', 2),
(33, '2026_02_08_011155_create_lms_categories_table', 3),
(34, '2026_02_08_011159_create_lms_table', 3),
(35, '2026_02_09_062639_create_amazon_categories_table', 4),
(37, '2026_02_09_062639_create_amazon_products_table', 5),
(39, '2026_02_09_131113_add_is_show_to_amazon_categories_table', 6),
(40, '2026_02_24_035603_create_amazon_sub_categories_table', 7),
(41, '2026_02_24_062920_add_amazon_sub_category_id_to_amazon_products_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('amazon2@gmail.com', '$2y$10$68aQ71am0bRawBvdxVoNCO19iWxQTfwFqt62./v2qO3zbPpEpj0ei', '2026-02-16 03:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `display_name` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `module` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `module`, `created_at`, `updated_at`) VALUES
(1, 'view_dashboard', 'View Dashboard', NULL, 'dashboard', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(2, 'view_users', 'View Users', NULL, 'users', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(3, 'create_users', 'Create Users', NULL, 'users', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(4, 'edit_users', 'Edit Users', NULL, 'users', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(5, 'delete_users', 'Delete Users', NULL, 'users', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(6, 'view_products', 'View Products', NULL, 'products', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(7, 'create_products', 'Create Products', NULL, 'products', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(8, 'edit_products', 'Edit Products', NULL, 'products', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(9, 'delete_products', 'Delete Products', NULL, 'products', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(10, 'view_categories', 'View Categories', NULL, 'categories', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(11, 'create_categories', 'Create Categories', NULL, 'categories', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(12, 'edit_categories', 'Edit Categories', NULL, 'categories', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(13, 'delete_categories', 'Delete Categories', NULL, 'categories', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(14, 'view_brands', 'View Brands', NULL, 'brands', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(15, 'create_brands', 'Create Brands', NULL, 'brands', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(16, 'edit_brands', 'Edit Brands', NULL, 'brands', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(17, 'delete_brands', 'Delete Brands', NULL, 'brands', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(18, 'view_banners', 'View Banners', NULL, 'banners', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(19, 'create_banners', 'Create Banners', NULL, 'banners', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(20, 'edit_banners', 'Edit Banners', NULL, 'banners', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(21, 'delete_banners', 'Delete Banners', NULL, 'banners', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(22, 'view_posts', 'View Posts', NULL, 'posts', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(23, 'create_posts', 'Create Posts', NULL, 'posts', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(24, 'edit_posts', 'Edit Posts', NULL, 'posts', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(25, 'delete_posts', 'Delete Posts', NULL, 'posts', '2026-02-07 10:57:34', '2026-02-07 10:57:34'),
(26, 'view_post_categories', 'View Post Categories', NULL, 'post_categories', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(27, 'create_post_categories', 'Create Post Categories', NULL, 'post_categories', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(28, 'edit_post_categories', 'Edit Post Categories', NULL, 'post_categories', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(29, 'delete_post_categories', 'Delete Post Categories', NULL, 'post_categories', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(30, 'view_post_tags', 'View Post Tags', NULL, 'post_tags', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(31, 'create_post_tags', 'Create Post Tags', NULL, 'post_tags', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(32, 'edit_post_tags', 'Edit Post Tags', NULL, 'post_tags', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(33, 'delete_post_tags', 'Delete Post Tags', NULL, 'post_tags', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(34, 'view_coupons', 'View Coupons', NULL, 'coupons', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(35, 'create_coupons', 'Create Coupons', NULL, 'coupons', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(36, 'edit_coupons', 'Edit Coupons', NULL, 'coupons', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(37, 'delete_coupons', 'Delete Coupons', NULL, 'coupons', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(38, 'view_settings', 'View Settings', NULL, 'settings', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(39, 'edit_settings', 'Edit Settings', NULL, 'settings', '2026-02-07 10:57:35', '2026-02-07 10:57:35'),
(40, 'view_lms_categories', 'View LMS Categories', NULL, 'lms_categories', '2026-02-07 20:01:04', '2026-02-07 20:01:04'),
(41, 'create_lms_categories', 'Create LMS Categories', NULL, 'lms_categories', '2026-02-07 20:01:04', '2026-02-07 20:01:04'),
(42, 'edit_lms_categories', 'Edit LMS Categories', NULL, 'lms_categories', '2026-02-07 20:01:04', '2026-02-07 20:01:04'),
(43, 'delete_lms_categories', 'Delete LMS Categories', NULL, 'lms_categories', '2026-02-07 20:01:04', '2026-02-07 20:01:04'),
(44, 'view_lms', 'View LMS Documents', NULL, 'lms', '2026-02-07 20:01:04', '2026-02-07 20:01:04'),
(45, 'create_lms', 'Create LMS Documents', NULL, 'lms', '2026-02-07 20:01:04', '2026-02-07 20:01:04'),
(46, 'edit_lms', 'Edit LMS Documents', NULL, 'lms', '2026-02-07 20:01:04', '2026-02-07 20:01:04'),
(47, 'delete_lms', 'Delete LMS Documents', NULL, 'lms', '2026-02-07 20:01:04', '2026-02-07 20:01:04'),
(48, 'view_amazon_categories', 'View Amazon Categories', NULL, 'amazon_categories', '2026-02-09 02:50:20', '2026-02-09 02:50:20'),
(49, 'create_amazon_categories', 'Create Amazon Categories', NULL, 'amazon_categories', '2026-02-09 02:50:20', '2026-02-09 02:50:20'),
(50, 'edit_amazon_categories', 'Edit Amazon Categories', NULL, 'amazon_categories', '2026-02-09 02:50:20', '2026-02-09 02:50:20'),
(51, 'delete_amazon_categories', 'Delete Amazon Categories', NULL, 'amazon_categories', '2026-02-09 02:50:20', '2026-02-09 02:50:20'),
(52, 'view_amazon_products', 'View Amazon Products', NULL, 'amazon_products', '2026-02-09 02:50:20', '2026-02-09 02:50:20'),
(53, 'create_amazon_products', 'Create Amazon Products', NULL, 'amazon_products', '2026-02-09 02:50:20', '2026-02-09 02:50:20'),
(54, 'edit_amazon_products', 'Edit Amazon Products', NULL, 'amazon_products', '2026-02-09 02:50:20', '2026-02-09 02:50:20'),
(55, 'delete_amazon_products', 'Delete Amazon Products', NULL, 'amazon_products', '2026-02-09 02:50:20', '2026-02-09 02:50:20');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `summary` text NOT NULL,
  `description` longtext DEFAULT NULL,
  `quote` text DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `tags` varchar(191) DEFAULT NULL,
  `post_cat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `post_tag_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `replied_comment` text DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `summary` text NOT NULL,
  `description` longtext DEFAULT NULL,
  `photo` text NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 1,
  `size` varchar(191) DEFAULT 'M',
  `condition` enum('default','new','hot') NOT NULL DEFAULT 'default',
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `price` double(8,2) NOT NULL,
  `discount` double(8,2) NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `cat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `child_cat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amazon_category_id` int(10) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `image_url` varchar(2048) DEFAULT NULL,
  `affiliate_url` varchar(2048) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `meta_keywords` varchar(500) DEFAULT NULL,
  `canonical_url` varchar(2048) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `display_name` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'Super Admin', 'Super Admin', '2026-02-07 10:14:39', '2026-02-07 10:14:39'),
(2, 'amazon', 'amazon', 'amazon', '2026-02-07 10:14:39', '2026-02-07 10:14:39'),
(6, 'learning Management', 'learning', 'learning', '2026-02-09 09:10:05', '2026-02-09 09:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 1, 5, NULL, NULL),
(6, 1, 6, NULL, NULL),
(7, 1, 7, NULL, NULL),
(8, 1, 8, NULL, NULL),
(9, 1, 9, NULL, NULL),
(10, 1, 10, NULL, NULL),
(11, 1, 11, NULL, NULL),
(12, 1, 12, NULL, NULL),
(13, 1, 13, NULL, NULL),
(14, 1, 14, NULL, NULL),
(15, 1, 15, NULL, NULL),
(16, 1, 16, NULL, NULL),
(17, 1, 17, NULL, NULL),
(18, 1, 18, NULL, NULL),
(19, 1, 19, NULL, NULL),
(20, 1, 20, NULL, NULL),
(21, 1, 21, NULL, NULL),
(22, 1, 22, NULL, NULL),
(23, 1, 23, NULL, NULL),
(24, 1, 24, NULL, NULL),
(25, 1, 25, NULL, NULL),
(26, 1, 26, NULL, NULL),
(27, 1, 27, NULL, NULL),
(28, 1, 28, NULL, NULL),
(29, 1, 29, NULL, NULL),
(30, 1, 30, NULL, NULL),
(31, 1, 31, NULL, NULL),
(32, 1, 32, NULL, NULL),
(33, 1, 33, NULL, NULL),
(34, 1, 34, NULL, NULL),
(35, 1, 35, NULL, NULL),
(36, 1, 36, NULL, NULL),
(37, 1, 37, NULL, NULL),
(38, 1, 38, NULL, NULL),
(39, 1, 39, NULL, NULL),
(73, 1, 40, NULL, NULL),
(74, 1, 41, NULL, NULL),
(75, 1, 42, NULL, NULL),
(76, 1, 43, NULL, NULL),
(77, 1, 44, NULL, NULL),
(78, 1, 45, NULL, NULL),
(79, 1, 46, NULL, NULL),
(80, 1, 47, NULL, NULL),
(136, 1, 48, NULL, NULL),
(137, 1, 49, NULL, NULL),
(138, 1, 50, NULL, NULL),
(139, 1, 51, NULL, NULL),
(140, 1, 52, NULL, NULL),
(141, 1, 53, NULL, NULL),
(142, 1, 54, NULL, NULL),
(143, 1, 55, NULL, NULL),
(209, 6, 45, NULL, NULL),
(210, 6, 47, NULL, NULL),
(211, 6, 46, NULL, NULL),
(212, 6, 44, NULL, NULL),
(213, 6, 41, NULL, NULL),
(214, 6, 43, NULL, NULL),
(215, 6, 42, NULL, NULL),
(216, 6, 40, NULL, NULL),
(233, 2, 49, NULL, NULL),
(234, 2, 51, NULL, NULL),
(235, 2, 50, NULL, NULL),
(236, 2, 48, NULL, NULL),
(237, 2, 53, NULL, NULL),
(238, 2, 55, NULL, NULL),
(239, 2, 54, NULL, NULL),
(240, 2, 52, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext NOT NULL,
  `short_des` text NOT NULL,
  `logo` varchar(191) NOT NULL,
  `photo` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `description`, `short_des`, `logo`, `photo`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 'logo.jpg', 'image.jpg', 'tiruppur-641603, tamilnadu, india.', '+91 8807759697', 'avisinnovation@gmail.com', NULL, '2026-02-09 08:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `provider_id` varchar(191) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `provider`, `provider_id`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super Admin', 'superadmin@gmail.com', NULL, '$2y$10$UwsFCwJYGZZHuAfbFeH9kO.y8tGnrkncujEGgIuqKXAutoOF1kwZi', NULL, NULL, NULL, 'active', NULL, NULL, NULL),
(3, 6, 'learning Management', 'learning@gmail.com', NULL, '$2y$10$s4KjOhuzoUqfvujPVHtDAezb9TbwuuzO7FSAtGW.sQtCK7qnVL7Eq', NULL, NULL, NULL, 'active', NULL, '2026-02-07 20:02:31', '2026-02-09 09:12:28'),
(4, 2, 'amazon', 'amazon@gmail.com', NULL, '$2y$10$UwsFCwJYGZZHuAfbFeH9kO.y8tGnrkncujEGgIuqKXAutoOF1kwZi', NULL, NULL, NULL, 'active', 'MmeOLHylPgERUMqWlxypVr8Z4iBguod3dwu6CZTURrvrujs3d6wjPkAB8jwX', '2026-02-09 02:32:21', '2026-02-09 02:32:21'),
(6, 2, 'amazon_2', 'amazon2@gmail.com', NULL, '$2y$10$d/YMaVLb2qKlLydM7rYBkef.vrL0yhuLd7l6jKo2B/N4iwx8U3rLC', NULL, NULL, NULL, 'active', NULL, '2026-02-09 09:21:24', '2026-02-09 09:21:24');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_admin_username` (`username`);

--
-- Indexes for table `amazon_categories`
--
ALTER TABLE `amazon_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `amazon_categories_slug_unique` (`slug`),
  ADD KEY `amazon_categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `amazon_products`
--
ALTER TABLE `amazon_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `amazon_products_slug_unique` (`slug`),
  ADD KEY `amazon_products_amazon_category_id_foreign` (`amazon_category_id`),
  ADD KEY `amazon_products_user_id_foreign` (`user_id`),
  ADD KEY `amazon_products_amazon_sub_category_id_foreign` (`amazon_sub_category_id`);

--
-- Indexes for table `amazon_sub_categories`
--
ALTER TABLE `amazon_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `amazon_sub_categories_amazon_category_id_foreign` (`amazon_category_id`),
  ADD KEY `amazon_sub_categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `banners_slug_unique` (`slug`),
  ADD KEY `banners_user_id_foreign` (`user_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`),
  ADD KEY `brands_user_id_foreign` (`user_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`),
  ADD KEY `categories_added_by_foreign` (`added_by`),
  ADD KEY `categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `lms`
--
ALTER TABLE `lms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lms_lms_category_id_foreign` (`lms_category_id`),
  ADD KEY `lms_user_id_foreign` (`user_id`);

--
-- Indexes for table `lms_categories`
--
ALTER TABLE `lms_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lms_categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_post_cat_id_foreign` (`post_cat_id`),
  ADD KEY `posts_post_tag_id_foreign` (`post_tag_id`),
  ADD KEY `posts_added_by_foreign` (`added_by`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_categories_slug_unique` (`slug`),
  ADD KEY `post_categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_comments_user_id_foreign` (`user_id`),
  ADD KEY `post_comments_post_id_foreign` (`post_id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_tags_slug_unique` (`slug`),
  ADD KEY `post_tags_user_id_foreign` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_cat_id_foreign` (`cat_id`),
  ADD KEY `products_child_cat_id_foreign` (`child_cat_id`),
  ADD KEY `products_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_cart_id_foreign` (`cart_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `amazon_categories`
--
ALTER TABLE `amazon_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `amazon_products`
--
ALTER TABLE `amazon_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `amazon_sub_categories`
--
ALTER TABLE `amazon_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lms`
--
ALTER TABLE `lms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lms_categories`
--
ALTER TABLE `lms_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amazon_categories`
--
ALTER TABLE `amazon_categories`
  ADD CONSTRAINT `amazon_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `amazon_products`
--
ALTER TABLE `amazon_products`
  ADD CONSTRAINT `amazon_products_amazon_category_id_foreign` FOREIGN KEY (`amazon_category_id`) REFERENCES `amazon_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amazon_products_amazon_sub_category_id_foreign` FOREIGN KEY (`amazon_sub_category_id`) REFERENCES `amazon_sub_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `amazon_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `amazon_sub_categories`
--
ALTER TABLE `amazon_sub_categories`
  ADD CONSTRAINT `amazon_sub_categories_amazon_category_id_foreign` FOREIGN KEY (`amazon_category_id`) REFERENCES `amazon_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amazon_sub_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `lms`
--
ALTER TABLE `lms`
  ADD CONSTRAINT `lms_lms_category_id_foreign` FOREIGN KEY (`lms_category_id`) REFERENCES `lms_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lms_categories`
--
ALTER TABLE `lms_categories`
  ADD CONSTRAINT `lms_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `posts_post_cat_id_foreign` FOREIGN KEY (`post_cat_id`) REFERENCES `post_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `posts_post_tag_id_foreign` FOREIGN KEY (`post_tag_id`) REFERENCES `post_tags` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD CONSTRAINT `post_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_child_cat_id_foreign` FOREIGN KEY (`child_cat_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
