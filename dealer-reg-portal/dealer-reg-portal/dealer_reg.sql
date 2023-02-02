-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 24, 2022 at 10:22 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dealer_reg`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `first_name`, `last_name`, `email`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Hassan', 'iqbal', 'hassan4732655@gmail.com', 'hello', '2022-05-18 05:50:15', '2022-05-18 05:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
CREATE TABLE IF NOT EXISTS `forms` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `form_name`, `state`, `message`, `file`, `created_at`, `updated_at`) VALUES
(3, 'registration', 'NY', 'hello.', '[{\"filename\":\"16530290991679091c5a880faf6fb5e6087eb1b2dc.jpg\",\"name\":\"blog1.jpg\",\"ext\":\"jpg\",\"size\":8211,\"date\":\"20-05-22\"}]', '2022-05-20 01:45:18', '2022-05-20 01:45:18'),
(4, 'requirements', 'BY', 'hellolololo', '[{\"filename\":\"16530331818f14e45fceea167a5a36dedd4bea2543.pdf\",\"name\":\"Requirements.pdf\",\"ext\":\"pdf\",\"size\":839146,\"date\":\"20-05-22\"}]', '2022-05-20 02:06:46', '2022-05-20 02:54:13');

-- --------------------------------------------------------

--
-- Table structure for table `general_contacts`
--

DROP TABLE IF EXISTS `general_contacts`;
CREATE TABLE IF NOT EXISTS `general_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ph_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_contacts`
--

INSERT INTO `general_contacts` (`id`, `email`, `ph_number`, `fax_number`, `website`, `created_at`, `updated_at`) VALUES
(1, 'example@example.com', '1234123412', '1452', 'https://dealer/reg', '2022-05-19 02:39:56', '2022-05-19 05:07:55');

-- --------------------------------------------------------

--
-- Table structure for table `mailing_address`
--

DROP TABLE IF EXISTS `mailing_address`;
CREATE TABLE IF NOT EXISTS `mailing_address` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dealer_reg_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suite_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eip_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mailing_address`
--

INSERT INTO `mailing_address` (`id`, `dealer_reg_address`, `suite_number`, `eip_code`, `website`, `created_at`, `updated_at`) VALUES
(1, 'New York, NY , USA', '123', '21', NULL, '2022-05-19 04:54:04', '2022-05-19 05:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(21, '2014_10_12_000000_create_users_table', 1),
(22, '2014_10_12_100000_create_password_resets_table', 1),
(23, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(24, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(25, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(26, '2016_06_01_000004_create_oauth_clients_table', 1),
(27, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(28, '2019_08_19_000000_create_failed_jobs_table', 1),
(29, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(30, '2022_05_17_070528_create_permission_tables', 1),
(31, '2022_05_18_103210_create_contacts_table', 2),
(32, '2022_05_19_064219_create_general_contacts_table', 3),
(33, '2022_05_19_064315_create_mailing_address_table', 3),
(34, '2022_05_19_103607_create_forms_table', 4),
(35, '2022_05_20_095452_create_services_table', 5),
(36, '2022_05_23_071907_create_transactions_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'app', 'bace266f3d3131eabb9aef67e0613546df6e7c74e4939d648932c7fa1d7b9d72', '[\"*\"]', NULL, '2022-05-18 02:26:59', '2022-05-18 02:26:59'),
(2, 'App\\Models\\User', 1, 'app', 'cd034e665f88505af46a917110bdc9ac7d69437f8a8700da5206f45fb6d95ba3', '[\"*\"]', NULL, '2022-05-19 01:41:12', '2022-05-19 01:41:12'),
(3, 'App\\Models\\User', 1, 'app', '00eb235e917d5d0173dceca9fddc975c0597324eeb960cdeae71b2b5f5569cb7', '[\"*\"]', NULL, '2022-05-19 04:15:59', '2022-05-19 04:15:59'),
(4, 'App\\Models\\User', 1, 'app', '5dd0a219766d953f9e87b40bd2e93712554c19e0667eb4c6ddcd6bf8cb18f937', '[\"*\"]', NULL, '2022-05-20 00:50:46', '2022-05-20 00:50:46'),
(5, 'App\\Models\\User', 1, 'app', '47a7c1a8633a880e4dd834e933013660660fd0ac49705455d2166f214960105f', '[\"*\"]', NULL, '2022-05-20 04:41:20', '2022-05-20 04:41:20'),
(6, 'App\\Models\\User', 1, 'app', '73627b8348821f04702e56d6c3d5788c3c907c62578967ea6772ba6bf871c88f', '[\"*\"]', NULL, '2022-05-20 06:56:31', '2022-05-20 06:56:31'),
(7, 'App\\Models\\User', 1, 'app', '5fa1496c96582178a0d93989c7171a7bb30d9154df100d32d5aeb91be99fc826', '[\"*\"]', NULL, '2022-05-20 12:25:53', '2022-05-20 12:25:53'),
(8, 'App\\Models\\User', 1, 'app', 'e519b8d8c8f64cc97f2b82fb16c18a9fe80f3ea673198f9cf1589cf27b0e09b0', '[\"*\"]', NULL, '2022-05-23 01:09:27', '2022-05-23 01:09:27'),
(9, 'App\\Models\\User', 1, 'app', '3331e6aed4c5efe7b7bd79ab725398dc89b8f82390bcea990edd3c4d65857c76', '[\"*\"]', NULL, '2022-05-23 03:59:12', '2022-05-23 03:59:12'),
(10, 'App\\Models\\User', 1, 'app', 'ba5ed9dfaf1086d3e5bc26356709b04d13cb01e8e2bb2efa8c605ce1b3f361ad', '[\"*\"]', NULL, '2022-05-24 01:49:08', '2022-05-24 01:49:08'),
(11, 'App\\Models\\User', 1, 'app', 'c57fd3aff44b84dc0323b1a12f1902215599dcbdf5d89c33399166ec6ccb1b82', '[\"*\"]', NULL, '2022-05-24 04:09:24', '2022-05-24 04:09:24');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2022-05-18 02:23:16', '2022-05-18 02:23:16'),
(2, 'Staff', 'web', '2022-05-18 02:23:25', '2022-05-18 02:23:25'),
(3, 'Member', 'web', '2022-05-18 02:23:35', '2022-05-18 02:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `description`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(2, 'NYS Registration and Plates Service', 'This is a wider card with supporting text below as a natural  lead-in to additional content. This content is a little bit longer', '1653046768-blog_single.jpg', '2', '2022-05-20 05:29:13', '2022-05-20 06:39:28');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `trans_state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_finance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_info` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_lease` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `on_lease` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `veh_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `veh_id_num` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `veh_year` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `veh_make` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `veh_model` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `veh_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `veh_mile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trade_ins` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `veh_weight` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cylinders` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fuel_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_weight` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrant_1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrant_2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `social` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_for` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comapny_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address_2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `trans_state`, `trans_type`, `reg_type`, `is_finance`, `add_info`, `num_lease`, `lien`, `on_lease`, `veh_type`, `veh_id_num`, `veh_year`, `veh_make`, `veh_model`, `veh_color`, `veh_mile`, `total_price`, `trade_ins`, `amount`, `veh_weight`, `cylinders`, `fuel_type`, `gross_weight`, `registrant_1`, `registrant_2`, `owner_1`, `owner_2`, `social`, `transaction_for`, `comapny_name`, `customer_address`, `customer_address_2`, `city`, `state`, `zip_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'abc_state', 'trans_type', 'reg_type', 'yes', 'addinformation', '12', '123', 'yes', 'abc_vehicle', '12', '200', '2000', '20000', 'abc_color', '10', '128', 'yes', '123', '600', '3', 'petrol', '600', 'ali', 'raza', 'sajid', 'ahmad', '123', 'yes', 'baramdat', 'rawalpindi', 'islamabad', 'kharian', 'punjab', '50900', '1', '2022-05-23 04:55:07', '2022-05-23 04:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ph_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dealership_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_contact_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_contact_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fedex_account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ein` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `photo`, `ph_number`, `address`, `city`, `state`, `zip`, `country`, `dealership_name`, `website`, `additional_contact_name`, `additional_contact_email`, `additional_address`, `additional_phone_number`, `fedex_account`, `about`, `ein`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hassan', 'Iqbal', 'Hassan4732655@gmail.com', NULL, '$2y$10$OSWNYNC/kenA4/fTRvQby.D79BflVyhl0cQTBOdV1DJl5dd/GI1B2', '1652860890.blog_ct1.jpg', '1234', NULL, NULL, NULL, NULL, NULL, 'Baramdat', 'Qqqqq', 'Subhan', 'Hassan@gmail.com', NULL, '121212', '14785', NULL, '12', '1', NULL, '2022-05-18 02:26:46', '2022-05-18 05:16:11');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
