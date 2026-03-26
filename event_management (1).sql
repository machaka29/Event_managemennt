-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 06:47 AM
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
-- Database: `event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `access_code` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`id`, `access_code`, `full_name`, `email`, `phone`, `organization`, `created_at`, `updated_at`) VALUES
(5, 'EmCa-TSYCQ-26', 'Juma Masoud', 'juma@gmail.com', '+255736765432', 'EmCa', '2026-03-24 03:31:42', '2026-03-24 03:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Concerts', 'concerts', 'fa-microphone', '2026-03-19 08:07:09', '2026-03-19 08:07:09'),
(2, 'Parties', 'parties', 'fa-cake-candles', '2026-03-19 08:07:09', '2026-03-19 08:07:09'),
(3, 'Business', 'business', 'fa-briefcase', '2026-03-19 08:07:09', '2026-03-19 08:07:09'),
(4, 'Sports', 'sports', 'fa-soccer-ball', '2026-03-19 08:07:09', '2026-03-19 08:07:09');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `reg_start_date` date NOT NULL,
  `reg_end_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `organizer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`, `time`, `location`, `capacity`, `image_path`, `reg_start_date`, `reg_end_date`, `status`, `organizer_id`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 'School meeting', 'should attend to the school conference', '2026-04-02', '08:00:00', 'moshi', 100, 'events/CtEEUqNZjzuHT6UnlI0eidqXHs7Ef512xsGX5ptn.jpg', '2026-03-17', '2026-03-30', 'approved', 2, '2026-03-17 16:11:28', '2026-03-24 10:49:35', 1),
(2, 'Companny', 'Companny meet all staff shall be attend', '2026-03-24', '17:19:00', 'Dodoma', 200, 'events/FKnjjZXlGvzBJehanQRCFQcKFnb5DQ94cDCaRaJi.jpg', '2026-03-24', '2026-03-24', 'approved', 2, '2026-03-24 11:07:04', '2026-03-24 11:18:04', NULL);

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_17_162016_create_events_table', 1),
(5, '2026_03_17_162017_create_attendees_table', 1),
(6, '2026_03_17_162018_create_registrations_table', 1),
(7, '2026_03_17_162637_add_role_to_users_table', 1),
(9, '2026_03_17_193518_add_profile_image_to_users_table', 2),
(10, '2026_03_17_195619_create_system_settings_table', 3),
(11, '2026_03_19_101312_add_status_to_events_table', 4),
(12, '2026_03_19_134800_add_attended_to_registrations_table', 5),
(13, '2026_03_19_110515_create_categories_table', 6),
(14, '2026_03_19_110550_add_category_id_to_events_table', 6),
(15, '2026_03_19_140438_add_access_code_to_attendees_table', 7),
(16, '2026_03_23_054848_add_phone_to_users_table', 8),
(17, '2026_03_18_134754_add_phone_and_organization_to_users_table', 9),
(18, '2026_03_19_094119_create_settings_table', 9);

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
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `attendee_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` varchar(255) NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Registered','Attended','Absent') NOT NULL DEFAULT 'Registered',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `event_id`, `attendee_id`, `ticket_id`, `attended`, `status`, `created_at`, `updated_at`) VALUES
(5, 1, 5, 'FF1MQ4MJ', 0, 'Registered', '2026-03-24 03:42:18', '2026-03-24 03:42:18');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('a3IbhM0j3ZNlONmvMBWxZTKmZbQhUhTTpqe6QWgH', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnRQZFk5M3pLekZKbFhseDh0M3hERmVsT0VQTlFEMDZhNHlhN2NUaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly9sb2NhbGhvc3QvRXZlbnRfbWFuYWdlbWVubnQvcHVibGljP3NlYXJjaD1tZWV0aW5nIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774373212),
('CL3H3VqCWQ1SlcdXJUr6hRbwJjI6AMf2kdatoqTJ', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic0UzYUQ1Vnh3ZUZoRGE2dVliVm13bnlkSlR0b0x6NWk3bW1acU90cSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9vcmdhbml6ZXIvcmVwb3J0cyI7czo1OiJyb3V0ZSI7czoyMzoib3JnYW5pemVyLnJlcG9ydHMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1774361986),
('kj9rj3CESkVE21TM5dj2DAQu7kzU2YX9PyPeQkCA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQzNCc2V1ZzZxN1pTeG1yU3diS0h0OVE3b2FEdjVYSmNIWVM2STJFWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9hZG1pbi9kYXNoYm9hcmQiO319', 1774378800),
('liwRoKVWT0uAyjKKIYhMCqpOqZkZzgxGrVnPi004', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ2VpckYxZERDUVFTbW5yYlRPblpqSVoyekJ5ZWhnd29PZXFkV2JEdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1774417456),
('Su9046vOdzAkKjitPIa7xXVWGAdq5yupeJYBpF0o', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUVVHSGV4SUVvUnlTbjFYc2dGdkdDZXJhb2J5OVFhamlhN0VSZXdCRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvRXZlbnRfbWFuYWdlbWVubnQvcHVibGljIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjU4OiJodHRwOi8vbG9jYWxob3N0L0V2ZW50X21hbmFnZW1lbm50L3B1YmxpYy9hZG1pbi9vcmdhbml6ZXJzIjt9fQ==', 1774359776),
('t1SIWMEZuz1rtTRKAT9k3qPrdzmE8XgcTKMJtVSc', NULL, '192.168.100.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZHFXQzAzWnFwNEdKdU5Ea1RQTmRKekxBT1RSRlhWVXJSR2xMTjF1NyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774360795),
('WmxLrCWZhRJuIivJv0JsHUT7617tAL5ESzmhB5vU', 1, '192.168.100.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZWEyeWNpZHQxdXJORUFnOWl5SnlVd0xZMUNka3czVTBmZWo0MHZIdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xOTIuMTY4LjEwMC4xMTk6ODAwMC9hZG1pbi9zbXMiO3M6NToicm91dGUiO3M6MTY6ImFkbWluLnNtcy5jcmVhdGUiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1774363502),
('wttGQiTNE32YLuzUtNDGOcfJS6urj3k5s7wkHjxg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRkUwdHhmYlR0aURHZUdlVm1nNjVYdHFIN01OU3NFWFF0T2hoUlVyNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774373235);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'system_name', 'EmCa Technologies', '2026-03-18 10:04:20', '2026-03-18 10:04:20'),
(2, 'system_phone', '+255 749 719 998', '2026-03-18 10:04:20', '2026-03-18 10:04:20'),
(3, 'system_email', 'emca@emca.tech', '2026-03-18 10:04:20', '2026-03-18 10:04:20'),
(4, 'system_logo', 'system/lyodQkLkIsfoVpqu8sw4MMaLhkXOkP9BhbMaXlCz.png', '2026-03-24 07:13:07', '2026-03-24 07:13:07'),
(5, 'system_footer', 'Managed by EmCa TECHONOLOGY', '2026-03-24 07:13:16', '2026-03-24 07:13:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'organizer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `organization`, `profile_image`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'System Admin', 'admin@event.com', NULL, NULL, NULL, NULL, '$2y$12$NTW.q.7sB/4JaL9LFVJmXu1WfUeSs21vS0iBor/MtP2S2i4o8iN7y', 'admin', NULL, '2026-03-17 13:30:51', '2026-03-17 13:30:51'),
(2, 'inocent Machaka', 'inocentmachaka29@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$E/wpIIjq9TK70kOpTLw49.4xKuj.cLhcanw0xGoHpoTgUQJXWfhpK', 'organizer', NULL, '2026-03-17 16:00:44', '2026-03-17 16:00:44'),
(3, 'Abdu shabani', 'abdushabni@gmail.com', '+255776679394', NULL, NULL, NULL, '$2y$12$KSBBhseKmiHqQdw6FVAkqONZD1BwyXo2oTN4iGGX179hN9.CcQvUq', 'organizer', NULL, '2026-03-17 16:20:32', '2026-03-24 03:18:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendees_email_unique` (`email`),
  ADD UNIQUE KEY `attendees_access_code_unique` (`access_code`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_organizer_id_foreign` (`organizer_id`),
  ADD KEY `events_category_id_foreign` (`category_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registrations_ticket_id_unique` (`ticket_id`),
  ADD KEY `registrations_event_id_foreign` (`event_id`),
  ADD KEY `registrations_attendee_id_foreign` (`attendee_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `system_settings_setting_key_unique` (`setting_key`);

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
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_organizer_id_foreign` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_attendee_id_foreign` FOREIGN KEY (`attendee_id`) REFERENCES `attendees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
