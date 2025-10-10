-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2025 at 02:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_models`
--

CREATE TABLE `about_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_models`
--

INSERT INTO `about_models` (`id`, `image`, `content`, `created_at`, `updated_at`) VALUES
(1, '1746104339.png', '<h1><strong>Meet our company unless</strong></h1>\r\n\r\n<h1><strong>miss the opportunity</strong></h1>\r\n\r\n<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cum velit temporibus repudiandae ipsa, eaque perspiciatis</p>\r\n\r\n<p>cumque incidunt tenetur sequi reiciendis.</p>', '2025-05-01 19:42:30', '2025-05-01 20:03:16');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `heading` varchar(255) NOT NULL,
  `short_desc` text NOT NULL,
  `long_desc` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `heading`, `short_desc`, `long_desc`, `created_at`, `updated_at`) VALUES
(3, 'WHo are you', 'We do nothing', '<p>kdasj lkasdj lkfasdj lkjadsl f</p>', '2025-05-02 00:40:25', '2025-05-02 00:40:25');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`, `updated_at`, `parent_category_id`) VALUES
(5, 'pants', '2025-10-08 18:57:55', '2025-10-09 20:16:47', 3),
(6, 'Shirts', '2025-10-09 19:34:17', '2025-10-09 19:34:17', 3);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_charges`
--

CREATE TABLE `delivery_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `charges` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Delivery charges for the store',
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, 'add_teams_fields', 1),
(6, 'create_permission_tables', 1),
(7, '2025_05_01_070257_create_sliders_table', 2),
(8, '2025_05_01_122045_create_about_models_table', 3),
(9, '2025_05_01_131114_create_services_table', 4),
(10, '2025_05_01_162530_create_blogs_table', 5),
(11, '2025_09_02_054049_create_categories_table', 6),
(12, '2025_09_02_090934_create_stores_table', 7),
(13, '2025_09_02_120434_create_products_table', 8),
(14, '2025_09_02_121506_create_product_images_table', 8),
(16, '2025_09_02_122134_create_product_variations_table', 9),
(23, '2025_09_05_054321_create_web_users_table', 10),
(24, '2025_09_10_091713_create_statuses_table', 10),
(25, '2025_09_10_092845_create_product_statuses_table', 10),
(26, '2025_09_11_094234_create_reviews_table', 11),
(27, '2025_09_16_122636_create_orders_table', 12),
(28, '2025_09_16_124557_create_order_details_table', 12),
(29, '2025_09_19_120058_create_delivery_charges_table', 13),
(31, '2025_10_09_112143_create_parent_categories_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 8),
(5, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `email`, `phone`, `shipping_address`, `city`, `postal_code`, `total`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hasnain Khan', 'hasnaindeveloper69@outlook.com', '+923003404342', 'ijazabad no 2 , gulbahar no 4 , Peshawar', 'Peshawar', '25000', 1500.00, 'cancel', '2025-09-17 19:54:38', '2025-09-17 21:05:33'),
(2, 'Hasnain Khan', 'hasnaindeveloper69@outlook.com', '+923003404342', 'ijazabad no 2 , gulbahar no 4 , Peshawar', 'Peshawar', '25000', 4500.00, 'pending', '2025-09-19 18:43:18', '2025-09-19 18:43:18'),
(3, 'Hasnain Khan', 'hasnaindeveloper69@outlook.com', '+923003404342', 'ijazabad no 2 , gulbahar no 4 , Peshawar', 'Peshawar', '25000', 1500.00, 'processing', '2025-09-19 20:32:00', '2025-09-19 21:13:52');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variation` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `variation`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 6, NULL, 1, 1500.00, '2025-09-17 19:54:38', '2025-09-17 19:54:38'),
(2, 2, 6, NULL, 3, 1500.00, '2025-09-19 18:43:18', '2025-09-19 18:43:18'),
(3, 3, 7, NULL, 1, 1500.00, '2025-09-19 20:32:00', '2025-09-19 20:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `parent_categories`
--

CREATE TABLE `parent_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parent_categories`
--

INSERT INTO `parent_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(3, 'Men', '2025-10-09 19:25:27', '2025-10-09 19:25:27'),
(4, 'Jackets', '2025-10-10 19:08:40', '2025-10-10 19:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Add Roles', 'web', '2025-05-05 11:12:43', '2025-05-05 11:12:43'),
(2, 'Edit Roles', 'web', '2025-05-05 11:13:11', '2025-05-05 11:13:11'),
(3, 'View Roles', 'web', '2025-05-05 11:13:24', '2025-05-05 11:13:24'),
(4, 'Delete Roles', 'web', '2025-05-05 11:13:34', '2025-05-05 11:13:34'),
(5, 'View Users', 'web', '2025-05-05 11:14:01', '2025-05-05 11:14:01'),
(6, 'Edit Users', 'web', '2025-05-05 11:14:09', '2025-05-05 11:14:09'),
(7, 'Add Users', 'web', '2025-05-05 11:14:29', '2025-05-05 11:14:29'),
(8, 'Delete Users', 'web', '2025-05-05 11:14:43', '2025-05-05 11:14:43'),
(9, 'Add Products', 'web', '2025-09-19 19:42:57', '2025-09-19 19:42:57'),
(10, 'View Products', 'web', '2025-09-19 19:43:06', '2025-09-19 19:43:06'),
(11, 'Delete Products', 'web', '2025-09-19 19:43:14', '2025-09-19 19:43:14'),
(12, 'Edit Products', 'web', '2025-09-19 19:43:29', '2025-09-19 19:43:29'),
(13, 'Add Categories', 'web', '2025-09-19 19:44:04', '2025-09-19 19:44:04'),
(14, 'View Categories', 'web', '2025-09-19 19:44:12', '2025-09-19 19:44:12'),
(15, 'Edit Categories', 'web', '2025-09-19 19:44:23', '2025-09-19 19:44:23'),
(16, 'Delete Categories', 'web', '2025-09-19 19:44:32', '2025-09-19 19:44:32'),
(17, 'Add ProductStatus', 'web', '2025-09-19 19:44:52', '2025-09-19 19:44:52'),
(18, 'View ProductStatus', 'web', '2025-09-19 19:45:01', '2025-09-19 19:45:01'),
(19, 'Edit ProductStatus', 'web', '2025-09-19 19:45:08', '2025-09-19 19:45:08'),
(20, 'Delete ProductStatus', 'web', '2025-09-19 19:45:17', '2025-09-19 19:45:17'),
(21, 'View Reviews', 'web', '2025-09-19 19:45:40', '2025-09-19 19:45:40'),
(22, 'Manage Reviews', 'web', '2025-09-19 19:46:41', '2025-09-19 19:46:41'),
(23, 'Add Store', 'web', '2025-09-19 19:56:34', '2025-09-19 19:56:34'),
(24, 'Edit Store', 'web', '2025-09-19 19:56:42', '2025-09-19 19:56:42'),
(25, 'View Store', 'web', '2025-09-19 19:56:59', '2025-09-19 19:56:59'),
(26, 'Delete Store', 'web', '2025-09-19 19:57:08', '2025-09-19 19:57:08'),
(27, 'Manage Orders', 'web', '2025-09-19 21:08:23', '2025-09-19 21:08:23');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `store_id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Shirt', '<p>Drop Shirts</p>', 1500.00, 5, NULL, '1756900111_primary.jpeg', 1, '2025-09-03 18:48:31', '2025-09-03 18:50:04'),
(7, 'Drop Shirt', '<p><strong>SHirt</strong><br />\r\n<em>NOthing</em></p>', 1500.00, 5, 6, '1758288655_primary.jpg', 1, '2025-09-19 20:30:55', '2025-09-19 20:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `path`, `created_at`, `updated_at`) VALUES
(9, 6, '1756900111_68b82b0f7965c.jpg', '2025-09-03 18:48:31', '2025-09-03 18:48:31'),
(10, 6, '1756900111_68b82b0f7cc2a.png', '2025-09-03 18:48:31', '2025-09-03 18:48:31'),
(11, 6, '1756900111_68b82b0f7ef5a.jpeg', '2025-09-03 18:48:31', '2025-09-03 18:48:31'),
(12, 7, '1758288655_68cd5b0f4616d.jpg', '2025-09-19 20:30:55', '2025-09-19 20:30:55'),
(13, 7, '1758288655_68cd5b0f49c89.png', '2025-09-19 20:30:55', '2025-09-19 20:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_statuses`
--

CREATE TABLE `product_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`values`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `product_id`, `name`, `values`, `created_at`, `updated_at`) VALUES
(11, 6, 'Size', '\"[{\\\"value\\\":\\\"Small\\\",\\\"price\\\":null},{\\\"value\\\":\\\"Medium\\\",\\\"price\\\":null},{\\\"value\\\":\\\"Large\\\",\\\"price\\\":null}]\"', '2025-09-03 18:50:04', '2025-09-03 18:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `review` text DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `review`, `subject`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 3, 'asfd', 'Expo Writing', '2025-09-12 17:40:03', '2025-09-12 17:40:03'),
(2, 7, 1, 4, 'heloo', 'nothin', '2025-10-08 19:14:34', '2025-10-08 19:14:34'),
(3, 7, 1, 5, 'kkj', 'hl', '2025-10-09 17:51:59', '2025-10-09 17:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'web', '2025-05-05 11:15:25', '2025-05-05 11:15:25'),
(2, 'del man', 'web', '2025-05-06 14:46:27', '2025-05-06 14:46:27'),
(4, 'Vendor', 'web', '2025-09-19 19:50:02', '2025-09-19 19:50:02'),
(5, 'admin', 'web', '2025-10-09 17:11:09', '2025-10-09 17:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(5, 2),
(5, 5),
(6, 5),
(7, 5),
(8, 5),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 5),
(14, 5),
(15, 5),
(16, 5),
(21, 4),
(23, 4),
(24, 4),
(25, 4),
(25, 5),
(26, 4),
(27, 4);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_desc` text NOT NULL,
  `long_desc` longtext NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `image`, `name`, `short_desc`, `long_desc`, `service_type`, `created_at`, `updated_at`) VALUES
(2, '1746112110.jpg', 'nothing', 'We do nothing', '<h1>Type of Lazy people We Are!!</h1>\r\n\r\n<p>We literlly do nothing!!</p>\r\n\r\n<p>&nbsp;</p>', 'Taxation', '2025-05-01 22:08:30', '2025-05-01 22:35:43');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sliderImg` varchar(255) NOT NULL,
  `sliderTxt` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `sliderImg`, `sliderTxt`, `created_at`, `updated_at`) VALUES
(3, '1746089230.jpg', '<p>;kj;lk</p>', '2025-05-01 15:47:10', '2025-05-01 15:47:10'),
(4, '1746091068.jpg', '<h1>INVEST IN WHAT WE SAY!!</h1>', '2025-05-01 16:17:48', '2025-05-01 16:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'featured', 'Featured Product', '2025-09-10 18:51:35', '2025-09-10 18:51:35'),
(2, 'sale', 'Sale', '2025-09-10 18:54:49', '2025-09-10 18:54:49');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_address` varchar(255) DEFAULT NULL,
  `contact_postal_code` varchar(255) DEFAULT NULL,
  `shipping_policy` text DEFAULT NULL,
  `return_policy` text DEFAULT NULL,
  `privacy_policy` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `description`, `logo`, `banner`, `owner_id`, `contact_phone`, `contact_address`, `contact_postal_code`, `shipping_policy`, `return_policy`, `privacy_policy`, `is_active`, `is_verified`, `created_at`, `updated_at`) VALUES
(5, 'Hasnain Khan', 'klj', '1758288152.png', '1758288152.jpeg', 1, '03003404342', 'ijazabad no 2 , gulbahar no 4 , Peshawar', '25000', 'adf', 'asdf', 'adsf', 1, 0, '2025-09-19 20:22:32', '2025-09-19 20:22:32'),
(6, 'My Store', 'Nothing', '1758288505.png', '1758288505.jpeg', 5, '03003404342', 'ijazabad no 2 , gulbahar no 4 , Peshawar', '25000', 'Nothing', 'Nothing', 'Nothgin', 1, 0, '2025-09-19 20:28:25', '2025-09-19 20:28:25'),
(7, 'Hasnai', 'wfsad', NULL, NULL, 8, '03003404342', 'ijazabad no 2 , gulbahar no 4 , Peshawar', '25000', 'jlk', 'klj', 'kljl', 1, 0, '2025-10-08 17:27:16', '2025-10-08 17:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'superadmin@gmail.com', NULL, '$2y$12$46v89u9mQsKhoTgwOSnljuv0zZOaqUyclXNsou5e0erCXldr8ASVW', NULL, '2025-05-05 11:03:52', '2025-10-09 17:09:37'),
(2, 'abc', 'del@gmail.com', NULL, '$2y$12$Opjzx6RbB6jsmggC8N.bFejUxLobAaKZJbwtvm82.pQzVzhmL83lG', NULL, '2025-05-06 14:47:03', '2025-05-06 14:47:03'),
(5, 'Vendor', 'vendor@gmail.com', NULL, '$2y$12$Rp/NBGm0vKDoY3zBSyJynOk3aglm1xSj0IwE8CEYGCoqcna.6wPFy', NULL, '2025-09-19 19:50:36', '2025-09-19 19:50:36'),
(6, 'Hasnain Khan', 'vendor2@gmail.com', NULL, '$2y$12$/yoVtk8SdSpWcb936.82dOPXumHppbnK.InEoXN7ScSy4Ml0WOQ5a', NULL, '2025-10-08 17:17:58', '2025-10-08 17:17:58'),
(8, 'Hasnain Khan', 'vendor3@gmail.com', NULL, '$2y$12$aGcDpflTfjy0nQzr2VcXjeKFVG3TbjzXoInXdPctb/.K08JRLusQq', NULL, '2025-10-08 17:21:42', '2025-10-08 17:21:42'),
(9, 'admin', 'admin@gmail.com', NULL, '$2y$12$lL9SPbZsoaYUacGybr5K2eE3V7VpIfSAkPNZMK.s/C6BcoqjjZd4O', NULL, '2025-10-09 17:11:45', '2025-10-09 17:11:45');

-- --------------------------------------------------------

--
-- Table structure for table `web_users`
--

CREATE TABLE `web_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_users`
--

INSERT INTO `web_users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'hassnain', 'hassnainhafeez13@gmail.com', '$2b$10$FumuBztNs/lYPVgg1lNNNOA5R2YB1mbSlpeiYFUWJVXVzqxnQtqqq', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_models`
--
ALTER TABLE `about_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parent_category` (`parent_category_id`);

--
-- Indexes for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_charges_store_id_index` (`store_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `parent_categories`
--
ALTER TABLE `parent_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_store_id_foreign` (`store_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_statuses`
--
ALTER TABLE `product_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_statuses_product_id_status_id_unique` (`product_id`,`status_id`),
  ADD KEY `product_statuses_status_id_foreign` (`status_id`),
  ADD KEY `product_statuses_user_id_foreign` (`user_id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variations_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stores_owner_id_foreign` (`owner_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `web_users`
--
ALTER TABLE `web_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_models`
--
ALTER TABLE `about_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parent_categories`
--
ALTER TABLE `parent_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_statuses`
--
ALTER TABLE `product_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `web_users`
--
ALTER TABLE `web_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_parent_category` FOREIGN KEY (`parent_category_id`) REFERENCES `parent_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  ADD CONSTRAINT `delivery_charges_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_statuses`
--
ALTER TABLE `product_statuses`
  ADD CONSTRAINT `product_statuses_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_statuses_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_statuses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `web_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
