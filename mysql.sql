-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 15, 2021 at 04:22 PM
-- Server version: 10.1.48-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wneuwkgkkn`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'RMA ( Returns )', '2021-10-04 07:47:40', '2021-10-04 07:47:40'),
(2, 'Returns / Order Cancelations', '2021-10-04 07:47:40', '2021-10-04 07:47:40'),
(3, 'New Repair Request', '2021-10-04 07:47:40', '2021-10-04 07:47:40'),
(4, 'Old Repair Request / Status Update', '2021-10-04 07:47:40', '2021-10-04 07:47:40'),
(5, 'Other ( Questions )', '2021-10-04 07:47:40', '2021-10-04 07:47:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fileupload`
--

CREATE TABLE `fileupload` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fileupload`
--

INSERT INTO `fileupload` (`id`, `file_name`, `created_at`, `updated_at`) VALUES
(1, '1634249833730spain.png', '2021-10-14 22:17:14', '2021-10-14 22:17:14'),
(2, '1634249845017united-kingdom.png', '2021-10-14 22:17:26', '2021-10-14 22:17:26'),
(3, '1634249926532spain.png', '2021-10-14 22:18:47', '2021-10-14 22:18:47'),
(4, '1634250068643united-kingdom.png', '2021-10-14 22:21:09', '2021-10-14 22:21:09'),
(5, '1634250329610spain.png', '2021-10-14 22:25:30', '2021-10-14 22:25:30'),
(6, '1634250408412spain.png', '2021-10-14 22:26:49', '2021-10-14 22:26:49'),
(7, '1634250412102united-kingdom.png', '2021-10-14 22:26:52', '2021-10-14 22:26:52'),
(8, '1634250505523spain.png', '2021-10-14 22:28:27', '2021-10-14 22:28:27'),
(9, '1634250508274united-kingdom.png', '2021-10-14 22:28:28', '2021-10-14 22:28:28'),
(10, '1634250896753united-kingdom.png', '2021-10-14 22:34:57', '2021-10-14 22:34:57'),
(11, '1634253359273Screenshot_40.png', '2021-10-14 23:16:01', '2021-10-14 23:16:01'),
(12, '1634253590966Screenshot_38.png', '2021-10-14 23:19:52', '2021-10-14 23:19:52'),
(13, '1634254239483Screenshot_10.png', '2021-10-14 23:30:40', '2021-10-14 23:30:40'),
(14, '1634254271402Screenshot_39.png', '2021-10-14 23:31:13', '2021-10-14 23:31:13'),
(15, '1634254611705Screenshot_40.png', '2021-10-14 23:36:53', '2021-10-14 23:36:53'),
(16, '1634254613693Screenshot_37(1).png', '2021-10-14 23:36:54', '2021-10-14 23:36:54'),
(17, '1634254638758Screenshot_39.png', '2021-10-14 23:37:20', '2021-10-14 23:37:20'),
(18, '1634254877884Screenshot_36(1).png', '2021-10-14 23:41:18', '2021-10-14 23:41:18'),
(19, '1634254880459Screenshot_36(2).png', '2021-10-14 23:41:22', '2021-10-14 23:41:22'),
(20, '1634300062721KHeuronet (002).pdf', '2021-10-15 12:14:23', '2021-10-15 12:14:23'),
(21, '1634307680043Screenshot_38.png', '2021-10-15 14:21:24', '2021-10-15 14:21:24'),
(22, '163431278937279849960-F8C2-4E49-83A3-E1CD4C9AE23F.jpeg', '2021-10-15 15:46:31', '2021-10-15 15:46:31'),
(23, '1634312803638Screenshot_10.png', '2021-10-15 15:46:45', '2021-10-15 15:46:45'),
(24, '1634312818515logowebsite.jpg', '2021-10-15 15:47:00', '2021-10-15 15:47:00'),
(25, '163431304667279F87926-B087-41B5-BBFB-1FDBABAC8C60.jpeg', '2021-10-15 15:50:48', '2021-10-15 15:50:48'),
(26, '1634313541186image(10).jpg', '2021-10-15 15:59:10', '2021-10-15 15:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_09_20_145543_create_permission_tables', 1),
(6, '2021_10_08_204608_create_tickets_table', 1),
(7, '2021_10_08_205017_create_categories_table', 1),
(8, '2021_10_09_121112_create_tickets_reply_table', 1),
(9, '2021_10_11_204459_create_ticket_status_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 49),
(2, 'App\\Models\\User', 46),
(2, 'App\\Models\\User', 48),
(2, 'App\\Models\\User', 50),
(2, 'App\\Models\\User', 51),
(2, 'App\\Models\\User', 52);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'edit', 'web', '2021-10-12 22:37:06', '2021-10-12 22:37:06'),
(2, 'delete', 'web', '2021-10-12 22:37:06', '2021-10-12 22:37:06'),
(3, 'publish', 'web', '2021-10-12 22:37:06', '2021-10-12 22:37:06'),
(4, 'unpublish', 'web', '2021-10-12 22:37:06', '2021-10-12 22:37:06');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2021-10-12 22:37:06', '2021-10-12 22:37:06'),
(2, 'user', 'web', '2021-10-12 22:37:06', '2021-10-12 22:37:06');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` text COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `attechment` text COLLATE utf8_unicode_ci,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `show_ticket` int(11) NOT NULL DEFAULT '2',
  `flag` int(11) NOT NULL,
  `file_name` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `number`, `subject`, `category_id`, `description`, `attechment`, `user_id`, `status`, `show_ticket`, `flag`, `file_name`, `created_at`, `updated_at`) VALUES
(30, 'EUT-1015202116', 'Tracking link of a mining machine', 5, 'Hi,\r\n\r\nWe ordered a mining machine from you (Antminer L3) and we paid on 04.06.2021, but we didn’t receive it yet.\r\n\r\nOrder name: Juhos Nandor Masco Kft.\r\nAddress: 1131 Budapest, Reitter Ferenc utca 166.\r\n\r\nI think the order number: 18-07158-94652 (we wrote it in the notice for the bank transfer)\r\n\r\nPlease inform me about this order and send me the tracking link so we can track the goods. \r\n\r\nThank you very much!', NULL, 51, 2, 1, 0, NULL, '2021-10-15 12:06:23', '2021-10-15 12:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_reply`
--

CREATE TABLE `tickets_reply` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `file_name` text COLLATE utf8_unicode_ci,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tickets_reply`
--

INSERT INTO `tickets_reply` (`id`, `description`, `file_name`, `ticket_id`, `user_id`, `created_at`, `updated_at`) VALUES
(11, 'Yes This works', NULL, 15, 1, '2021-10-14 20:15:47', '2021-10-14 20:15:47'),
(12, 'test', '1634253359273Screenshot_40.png', 17, 46, '2021-10-14 23:19:04', '2021-10-14 23:19:04'),
(13, 'test', '1634253359273Screenshot_40.png', 17, 46, '2021-10-14 23:19:04', '2021-10-14 23:19:04'),
(14, 'test', '1634253590966Screenshot_38.png', 17, 46, '2021-10-14 23:19:59', '2021-10-14 23:19:59'),
(15, 'Attachent test', '1634254271402Screenshot_39.png', 28, 46, '2021-10-14 23:31:19', '2021-10-14 23:31:19'),
(16, 'test', '1634254638758Screenshot_39.png', 28, 50, '2021-10-14 23:41:08', '2021-10-14 23:41:08'),
(17, 'Double image', '1634254877884Screenshot_36(1).png,1634254880459Screenshot_36(2).png', 28, 50, '2021-10-14 23:41:27', '2021-10-14 23:41:27'),
(18, 'Dear Juhos, please tell us on what platform did you make the order and can you send a copy of the transfer as attachment to this support ticket so we can locate your order and payment.', NULL, 30, 1, '2021-10-15 12:13:04', '2021-10-15 12:13:04'),
(19, 'Hi, on EBAY (and then in email) and I attached the TT copy! Please check it and send the tracking link (or the information about the shipping)\r\nThank you!', '1634300062721KHeuronet (002).pdf', 30, 51, '2021-10-15 12:15:32', '2021-10-15 12:15:32'),
(20, 'We are very sorry for this inconvenience but it looks like something went wrong internally  as i can not find your order in our systems and it looks like your order has not been processed.\r\nPlease send us your bank details so we can offer you a full refund. \r\n\r\nAs second option we can put you on our waiting list, as we have more machines arriving before the end of the year.', NULL, 30, 1, '2021-10-15 12:22:12', '2021-10-15 12:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_status`
--

CREATE TABLE `ticket_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `option` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_status`
--

INSERT INTO `ticket_status` (`id`, `option`, `created_at`, `updated_at`) VALUES
(1, 'new', '2021-10-04 07:47:40', '2021-10-04 07:47:40'),
(2, 'Open', '2021-10-04 07:47:40', '2021-10-04 07:47:40'),
(3, 'Reply', '2021-10-04 07:47:40', '2021-10-04 07:47:40'),
(4, 'Pending', '2021-10-04 07:47:40', '2021-10-04 07:47:40'),
(5, 'Complete', '2021-10-04 07:47:40', '2021-10-04 07:47:40'),
(6, 'Processing', '2021-10-04 07:47:40', '2021-10-04 07:47:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verify_token` text COLLATE utf8_unicode_ci,
  `verify` int(11) NOT NULL DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `avatar`, `email`, `email_verified_at`, `password`, `remember_token`, `verify_token`, `verify`, `created_at`, `updated_at`) VALUES
(1, 'euronetimports', NULL, 'euronetimports@icloud.com', '2021-10-12 22:37:07', '$2y$10$/D.rn/tVYIyJmzPTWZYPkO3Je8QyCftdX1/4iFjXmyyqqgvpWzAWS', 'd3871AK88xX86a4zYbbY3hWhBvECvEP3xgIt3EnLasWyEE8kfLUaJ5nlwWiS', NULL, 1, '2021-10-12 22:37:07', '2021-10-12 22:37:07'),
(49, 'Gabriel', NULL, 'admin@gabby.es', NULL, '$2y$10$ooTf.FuxXMxH1vHF/6j5ruzufQg4msDkkPsFYdrsgJlWhzG9spfRi', NULL, 'MTAxNDIwMjExNTQz', 1, '2021-10-14 20:17:25', '2021-10-14 20:50:37'),
(51, 'Virág Serfőző', NULL, 'purchasing.logistic@masco.hu', NULL, '$2y$10$POXFbMN8fMHbDeleLCABJeyNntlgzMwywwisO/mf82OTkOu7wDKB.', NULL, 'MTAxNTIwMjE1MDMzNg%3D%3D', 1, '2021-10-15 12:06:23', '2021-10-15 12:06:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fileupload`
--
ALTER TABLE `fileupload`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_reply`
--
ALTER TABLE `tickets_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_status`
--
ALTER TABLE `ticket_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fileupload`
--
ALTER TABLE `fileupload`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tickets_reply`
--
ALTER TABLE `tickets_reply`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ticket_status`
--
ALTER TABLE `ticket_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
