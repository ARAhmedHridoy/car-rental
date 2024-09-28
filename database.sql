-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2024 at 03:55 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car-rental-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `car_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `daily_rent_price` decimal(8,2) NOT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `name`, `brand`, `model`, `year`, `car_type`, `daily_rent_price`, `availability`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Toyota Vitz', 'Toyota', 'Toyota Vitz', 2015, 'SUV', 7000.00, 1, '1727291876.png', '2024-09-18 08:03:05', '2024-09-25 13:17:56'),
(4, 'Hyundai Tucson', 'Hyundai', 'Tucson', 2011, 'SUV', 3000.00, 1, '1727291866.png', '2024-09-19 13:52:09', '2024-09-25 13:17:46'),
(5, 'Mercedes Benz R3', 'Toyota', '2010', 2010, 'SUV', 1000.00, 1, '1727291773.png', '2024-09-19 14:40:56', '2024-09-25 13:16:13'),
(6, 'Honda Grace LX 2019 Midnight Blue', 'Honda', 'Grace LX', 2019, 'SUV', 5000.00, 1, '1727291853.png', '2024-09-20 09:28:54', '2024-09-25 13:17:33'),
(7, 'Honda Vezel 2014 Blue', 'Honda', 'Vezel 2014', 2014, 'SUV', 3000.00, 1, '1727291839.png', '2024-09-20 09:40:20', '2024-09-25 13:17:19'),
(8, 'Audi Q5 2018', 'Audi', 'Audi Q5', 2018, 'SUV', 4600.00, 0, '1727291830.png', '2024-09-20 09:43:07', '2024-09-25 13:18:25'),
(11, 'Test Car', 'Toyota', 'Tucson test', 2010, 'Sedan', 1000.00, 1, '1727444909.jpg', '2024-09-27 07:48:29', '2024-09-27 07:48:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_09_17_171515_create_cars_table', 1),
(8, '2024_09_18_195520_create_rentals_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `status` enum('Pending','Ongoing','Completed','Canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`id`, `user_id`, `car_id`, `start_date`, `end_date`, `total_cost`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 4, '2024-09-22', '2024-09-23', 6000.00, 'Completed', '2024-09-21 02:16:48', '2024-09-24 12:05:49'),
(2, 1, 2, '2024-09-21', '2024-09-25', 35000.00, 'Completed', '2024-09-21 02:43:28', '2024-09-24 12:07:38'),
(4, 4, 5, '2024-09-22', '2024-09-24', 3000.00, 'Completed', '2024-09-22 02:31:47', '2024-09-24 12:07:48'),
(8, 1, 8, '2024-09-22', '2024-09-30', 41400.00, 'Ongoing', '2024-09-22 05:34:59', '2024-09-24 12:08:05'),
(17, 6, 7, '2024-09-28', '2024-10-01', 12000.00, 'Ongoing', '2024-09-24 09:32:49', '2024-09-25 13:31:27'),
(18, 13, 7, '2024-09-26', '2024-09-27', 6000.00, 'Completed', '2024-09-24 11:41:04', '2024-09-24 14:58:45'),
(19, 1, 5, '2024-10-06', '2024-10-08', 3000.00, 'Pending', '2024-09-24 12:32:08', '2024-09-25 13:30:25'),
(20, 6, 5, '2024-10-02', '2024-10-05', 4000.00, 'Pending', '2024-09-24 12:59:14', '2024-09-25 13:30:00'),
(21, 13, 5, '2024-09-29', '2024-10-01', 3000.00, 'Canceled', '2024-09-24 13:04:59', '2024-09-25 11:38:27'),
(22, 13, 6, '2024-09-30', '2024-10-02', 15000.00, 'Pending', '2024-09-24 13:07:36', '2024-09-25 13:29:23'),
(23, 14, 11, '2024-09-29', '2024-09-30', 2000.00, 'Pending', '2024-09-27 07:49:39', '2024-09-27 07:51:02'),
(25, 16, 11, '2024-10-01', '2024-10-02', 2000.00, 'Pending', '2024-09-27 12:45:11', '2024-09-27 12:45:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `phone_number` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone_number`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hridoy', 'hridoyahmed51@gmail.com', NULL, '$2y$12$NdBwKE.9dlKI7scq7eBtlutKIpeKust9tn4klRdwAyKgIsWhPYAC6', 'customer', '01611633630', 'Gulshan, Dhaka', NULL, '2024-09-17 11:30:55', '2024-09-17 11:30:55'),
(2, 'admin', 'admin@gmail.com', NULL, '$2y$12$nPPMK8sdjhn0.DP2quPwpOJkuXEXA1iBRaudkHDmU/SGZHEZEmbYm', 'admin', '01811633630', 'Banani, Dhaka', NULL, '2024-09-17 14:21:09', '2024-09-17 14:21:09'),
(4, 'Ansar', 'ansar@gmail.com', NULL, '$2y$12$O9lU/MY169LtQCuWRCO6JOj.SKHT7FrXLJy6kb7E2tNTkYvK2sv7a', 'customer', '01830493201', 'Gulshan-1, Dhaka, Bangladesh', NULL, '2024-09-18 12:56:11', '2024-09-18 13:37:39'),
(6, 'Hridoy Ahmed', 'arahmed.hridoy@gmail.com', NULL, '$2y$12$.F/zjfNVqQBIifyhNwHMIOkHSltSamvrOOm5WhrGXbW8rNWrK1/W2', 'customer', '01971633630', 'Gulshan-2, Dhaka, Bangladesh', NULL, '2024-09-24 07:48:28', '2024-09-24 07:48:28'),
(13, 'Customer', 'customer@gmail.com', NULL, '$2y$12$9fPexdXldg2ALesbwFsrfOIFUNrAZmm8agE3UWG5PHCavz1nEokXG', 'customer', '01830493101', 'Banani-1, Dhaka, Bangladesh', NULL, '2024-09-24 11:29:55', '2024-09-24 11:29:55'),
(14, 'Test Customer', 'testcus@gmail.com', NULL, '$2y$12$fAKeVgITgqOWWcvdXWoJUej3GoJxIDn4uWygIjRr5LAPkgL4OpukK', 'customer', '01622633630', 'Gulshan-2, Dhaka, Bangladesh', NULL, '2024-09-27 07:47:17', '2024-09-27 07:47:30'),
(16, 'Test User', 'user@gmail.com', NULL, '$2y$12$/A.dx2JzcN6kaVIx63rVwufYNYyGx3zWTDN0vm1nUvinhO0uJoRl.', 'customer', '01311633630', 'Banasree, Rampura, Dhaka', NULL, '2024-09-27 12:44:30', '2024-09-27 12:44:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rentals_user_id_foreign` (`user_id`),
  ADD KEY `rentals_car_id_foreign` (`car_id`);

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
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `rentals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
