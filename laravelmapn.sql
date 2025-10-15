-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2025 at 11:34 AM
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
-- Database: `laravelmapn`
--

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
-- Table structure for table `master_options`
--

CREATE TABLE `master_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_options`
--

INSERT INTO `master_options` (`id`, `category`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'lokasi', 'Gedung A', 1, NULL, NULL),
(2, 'lokasi', 'Lantai 2', 1, NULL, NULL),
(3, 'lokasi', 'Area Produksi', 1, NULL, NULL),
(4, 'jenis', 'Kecelakaan Kerja', 1, NULL, NULL),
(5, 'jenis', 'Penyakit Akibat Kerja', 1, NULL, NULL),
(6, 'jenis', 'Near-Miss', 1, NULL, NULL),
(7, 'jenis', 'Insiden Lingkungan', 1, NULL, NULL),
(8, 'jenis', 'Kerusakan Properti', 1, NULL, NULL),
(9, 'dampak', 'Fatal', 1, NULL, NULL),
(10, 'dampak', 'LTI', 1, NULL, NULL),
(11, 'dampak', 'MTI', 1, NULL, NULL),
(12, 'dampak', 'FAI', 1, NULL, NULL),
(13, 'dampak', 'Kerusakan Properti', 1, NULL, NULL),
(14, 'dampak', 'Dampak Lingkungan', 1, NULL, NULL),
(15, 'status', 'Pending', 1, NULL, NULL),
(16, 'status', 'In Progress', 1, NULL, NULL),
(17, 'status', 'Closed', 1, NULL, NULL),
(18, 'status', 'Overdue', 1, NULL, NULL),
(19, 'status', 'Not Applicable', 1, NULL, NULL),
(20, 'prioritas', 'Tinggi', 1, NULL, NULL),
(21, 'prioritas', 'Sedang', 1, NULL, NULL),
(22, 'prioritas', 'Rendah', 1, NULL, NULL);

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
(3, '0001_01_01_000002_create_jobs_table', 1);

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
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `incident_datetime` datetime DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `impact` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `priority` varchar(255) NOT NULL DEFAULT 'Rendah',
  `reported_by` varchar(255) NOT NULL,
  `involved_parties` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `description`, `incident_datetime`, `location`, `type`, `impact`, `status`, `priority`, `reported_by`, `involved_parties`, `created_at`, `updated_at`, `media_path`) VALUES
(1, 'patah tulang', NULL, 'Area Produksi', 'Kecelakaan Kerja', 'Fatal', 'Overdue', 'Tinggi', 'Bhismo Surya Atmaja', NULL, '2025-09-09 05:44:53', '2025-10-07 06:17:15', NULL),
(2, 'alat rusak', NULL, 'Area Produksi', 'Kerusakan Properti', 'Kerusakan Properti', 'Pending', 'Tinggi', 'Bhismo Surya Atmaja', NULL, '2025-09-22 08:07:38', '2025-09-22 08:15:07', NULL),
(3, 'alat hilang', NULL, 'Lantai 2', 'Insiden Lingkungan', 'Dampak Lingkungan', 'Pending', 'Rendah', 'Bhismo Surya Atmaja', NULL, '2025-09-22 08:43:15', '2025-09-22 08:43:15', 'reports/wkkovNlEeXSi15FslDaJQ1NnTFEqOk1cYDvcBqRG.jpg'),
(4, 'jatuh', NULL, 'Area Produksi', 'Kecelakaan Kerja', 'Fatal', 'Pending', 'Tinggi', 'Bhismo Surya Atmaja', NULL, '2025-09-26 00:50:33', '2025-09-26 00:50:33', 'reports/rurPANHPohut2zfJkXzPNlwd2QUH0iLOUsxpsJWJ.jpg'),
(5, 'www', NULL, 'Gedung A', 'Kecelakaan Kerja', 'Fatal', 'In Progress', 'Sedang', 'Bhismo Surya Atmaja', NULL, '2025-09-26 00:54:22', '2025-10-07 06:18:21', 'reports/G2CH5wFFDFEdOdyddm9hmozonU26h58iA2LU2YV9.jpg'),
(6, 'asdsad', NULL, 'Gedung A', 'Kecelakaan Kerja', 'Fatal', 'In Progress', 'Rendah', 'Bhismo Surya Atmaja', NULL, '2025-09-26 01:11:41', '2025-10-07 06:15:25', 'reports/nAzQvWMomORvwWlMLbe8QOEQ2okreBYdHckIu0wj.jpg'),
(7, 'qqq', NULL, 'Gedung A', 'Kecelakaan Kerja', 'Fatal', 'Pending', 'Tinggi', 'Bhismo Surya Atmaja', NULL, '2025-09-26 01:28:29', '2025-09-26 01:28:29', 'reports/WNpxUVFR6nXsCCUZvc9Uj8D7tlMn7B0OSWTWBgdi.jpg'),
(8, 'Gas beracun', '2025-10-09 09:08:00', 'Gedung A', 'Penyakit Akibat Kerja', 'Fatal', 'Pending', 'Rendah', 'Bhismo Surya Atmaja', 'Pak Jero', '2025-10-08 19:08:51', '2025-10-08 19:08:51', 'reports/gtW6rnT6WeerniLO8ofGjfYP62VMpk3hRTTqJ524.png'),
(9, 'ada saja', '2025-10-31 09:28:00', 'Lantai 2', 'Near-Miss', 'MTI', 'Pending', 'Rendah', 'Bhismo Surya Atmaja', 'pak suhat, pak sidoarjo', '2025-10-08 19:28:56', '2025-10-08 19:28:56', 'storage/reports/f00Cl41nN4sqWP8Wjx6qMxqJmyQgGT4Iqp10kWr0.png'),
(10, 'aaasss', '2025-10-09 09:34:00', 'Area Produksi', 'Near-Miss', 'Fatal', 'Pending', 'Rendah', 'Bhismo Surya Atmaja', 'Pak Jero', '2025-10-08 19:34:49', '2025-10-08 19:34:49', 'reports/4ApQQdw3X0yeO2LrfvD7cqcg74YuVl4JR43xKqc5.png'),
(11, 'rrreee', '2025-10-31 09:47:00', 'Gedung A', 'Near-Miss', 'LTI', 'In Progress', 'Tinggi', 'Bhismo Surya Atmaja', 'Pak Mahenn', '2025-10-08 19:47:50', '2025-10-08 19:56:56', 'reports/FZlOwVLgJKLyHJ6DkdJyXF6rmDI9M1g5uPa5Ys3o.png');

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
('AjZTFIpMxeG1m0JG0JsF8uZiJBOS8DKWMubGNX6H', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNkVjck84akhEQzNMSzdtYTJkWDdtZVdOV0FTRE1LU0hVMkJXaFEyVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NTk5Nzg1OTc7fX0=', 1759979072);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Bhismo Surya Atmaja', 'bhismoatmaja@gmail.com', NULL, '$2y$12$BTmcOF1SKpy5eI0aNy1WHusJyfrG/DAnff6d5tV5wflHpw0Rm.4XG', 'PkZPifJkRzn1tiTHaILNQKzHbsdk4AAoDH9WPdddDw0sDQO3Y2watAxfaOAw', '2025-09-09 05:16:14', '2025-09-09 05:16:14', 'admin'),
(3, 'Mahendra Surya Venlo', 'venloaji0@gmail.com', NULL, '$2y$12$KRV7rjfVwjqkm91wMiWk9u6RxHexcoCjTUSeJ7IMzAwDMu1WrP7Sa', 'G8eLgDn5akyRxi27ERaV1m5ApY52qSXpvDQie7mUl1ns5NCz1UiYaJ31Kgki', '2025-09-09 06:20:27', '2025-09-09 06:20:27', 'spv'),
(4, 'Steve', 'stevejobs@gmail.com', NULL, '$2y$12$IrL9tXlnZ0X4qkjYopSgkeIrlzoTaYd3UjV7tNQOdZvndqMJ1eWEm', NULL, '2025-09-29 22:08:36', '2025-09-29 22:08:36', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

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
-- Indexes for table `master_options`
--
ALTER TABLE `master_options`
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
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `master_options`
--
ALTER TABLE `master_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
