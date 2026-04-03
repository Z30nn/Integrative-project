-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 06, 2024 at 09:24 AM
-- Server version: 10.6.16-MariaDB-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hltypgzv_laraveil_suite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `availed_services`
--

CREATE TABLE `availed_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `service_id` bigint(20) NOT NULL,
  `service_date` date NOT NULL,
  `payment_method` enum('over_the_counter','online_payment') NOT NULL,
  `payment_status` enum('pending','paid','Refunded') NOT NULL DEFAULT 'pending',
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `booking_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `availed_services`
--

INSERT INTO `availed_services` (`id`, `guest_name`, `service_id`, `service_date`, `payment_method`, `payment_status`, `total_price`, `created_at`, `updated_at`, `booking_id`) VALUES
(56, 'irish rapal', 15, '2024-12-04', 'online_payment', 'Refunded', '123.00', '2024-12-03 19:50:20', '2024-12-03 19:51:06', 'l4s9ird11m49ckm5a'),
(59, 'fusby aikawa', 13, '2024-12-05', 'over_the_counter', 'Refunded', '324234.00', '2024-12-04 18:31:55', '2024-12-04 18:42:33', 'tw20m3oskm4akbagi'),
(60, 'fusby aikawa', 16, '2024-12-05', 'over_the_counter', 'Refunded', '23123.00', '2024-12-04 18:32:04', '2024-12-04 18:42:44', 'tw20m3oskm4akbagi'),
(61, 'fusby aikawa', 16, '2024-12-05', 'over_the_counter', 'Refunded', '23123.00', '2024-12-04 18:32:08', '2024-12-04 18:42:46', 'tw20m3oskm4akbagi'),
(62, 'fusby aikawa', 15, '2024-12-05', 'over_the_counter', 'Refunded', '123.00', '2024-12-04 18:32:13', '2024-12-04 18:42:47', 'tw20m3oskm4akbagi'),
(63, 'fusby aikawa', 15, '2024-12-05', 'over_the_counter', 'paid', '123.00', '2024-12-04 18:32:17', '2024-12-04 18:43:05', 'tw20m3oskm4akbagi'),
(64, 'kirk Kirk', 13, '2024-12-05', 'over_the_counter', 'paid', '324234.00', '2024-12-04 18:54:20', '2024-12-06 15:14:11', 'm91icl5o0m4aq38p6'),
(65, 'kirk fabon', 13, '2025-01-03', 'over_the_counter', 'paid', '324234.00', '2024-12-06 13:26:50', '2024-12-06 15:14:24', '0hj6lmk15m4chddxd'),
(66, 'reese lizardo', 16, '2024-12-11', 'over_the_counter', 'paid', '799.00', '2024-12-06 15:12:36', '2024-12-06 17:02:21', 'khvcsj4erm4cl69y4'),
(67, 'reese lizardo', 15, '2024-12-06', 'over_the_counter', 'paid', '449.00', '2024-12-06 15:12:44', '2024-12-06 17:02:40', 'khvcsj4erm4cl69y4'),
(68, 'reese lizardo', 15, '2024-12-06', 'over_the_counter', 'pending', '449.00', '2024-12-06 15:13:00', '2024-12-06 15:13:00', 'khvcsj4erm4cl69y4');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('aikawasss@gmail.com|127.0.0.1', 'i:1;', 1732895291),
('aikawasss@gmail.com|127.0.0.1:timer', 'i:1732895291;', 1732895291),
('cashier@example.com|127.0.0.1', 'i:1;', 1732797307),
('cashier@example.com|127.0.0.1:timer', 'i:1732797307;', 1732797307),
('cashier2@gmail.com|127.0.0.1', 'i:2;', 1732883499),
('cashier2@gmail.com|127.0.0.1:timer', 'i:1732883499;', 1732883499),
('kristine@gmail.com|127.0.0.1', 'i:1;', 1732895280),
('kristine@gmail.com|127.0.0.1:timer', 'i:1732895280;', 1732895280);

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
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `feedback` text NOT NULL,
  `rating` int(11) NOT NULL,
  `anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `guest_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `feedback`, `rating`, `anonymous`, `guest_id`, `created_at`, `updated_at`) VALUES
(16, 'kjashdka', 3, 0, 105, '2024-12-06 13:27:00', '2024-12-06 13:27:00'),
(17, 'solid', 5, 0, 108, '2024-12-06 15:13:20', '2024-12-06 15:13:20');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `salutation` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `guest_count` int(11) NOT NULL,
  `discount_option` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `booked_rooms` varchar(255) NOT NULL,
  `price_total` decimal(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `booking_id`, `lastname`, `firstname`, `salutation`, `birthdate`, `gender`, `guest_count`, `discount_option`, `email`, `contact_number`, `address`, `check_in`, `check_out`, `booked_rooms`, `price_total`, `created_at`, `updated_at`) VALUES
(90, 'vvuwp3j15m4a3hc2c', 'Kirk', 'kirk', 'mr', '2024-12-12', 'Male', 1, 'student', 'admin@gmail.com', '09995462768', 'Banton', '2025-01-05', '2025-01-13', 'Deluxe V1,Deluxe V1', '24540.00', '2024-12-04 08:20:49', '2024-12-04 09:04:02'),
(91, 'b0c60bc1am4a3mzfv', 'Kirk', 'kirk', 'mr', '2024-12-20', 'Male', 1, 'student', 'admin@gmail.com', '09995462768', 'Banton', '2025-01-01', '2025-01-02', 'Deluxe V1,Deluxe V1,', '2640.00', '2024-12-04 08:25:12', '2024-12-04 08:25:12'),
(92, 'ayuih2b02m4a3tabh', 'Kirk', 'kirk', 'mr', '2024-12-13', 'Male', 1, 'student', 'tH9q5@example.com', '09995462768', 'Banton', '2025-01-05', '2025-01-13', 'Deluxe V1,Deluxe V1,', '12720.00', '2024-12-04 08:30:07', '2024-12-04 08:30:07'),
(94, 'm91icl5o0m4aq38p6', 'Kirk', 'kirk', 'mr', '2024-12-06', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '09995462768', 'Banton', '2025-01-07', '2025-01-15', 'Luxury V1,Luxury V1,', '17200.00', '2024-12-04 18:53:42', '2024-12-04 18:53:42'),
(95, 'cl32mlwcmm4c9hvyz', 'rapal', 'irish', 'mr', '2024-12-13', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2025-01-08', '2025-01-16', 'Deluxe V1,Deluxe V1,', '12720.00', '2024-12-06 09:44:45', '2024-12-06 09:44:45'),
(96, '98h80e3wzm4c9lwq3', 'lizzardo', 'irah', 'ms', '2024-12-18', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2025-01-02', '2025-01-10', 'Deluxe V1,Deluxe V1,', '12720.00', '2024-12-06 09:47:53', '2024-12-06 09:47:53'),
(97, 'x0yl582y3m4c9s27d', 'lizzardo', 'irah', 'ms', '2024-12-18', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2025-01-02', '2025-01-10', 'Deluxe V1,Deluxe V1,', '12720.00', '2024-12-06 09:52:40', '2024-12-06 09:52:40'),
(98, 'w7v8o9wutm4c9uvrh', 'rapal', 'irish', 'mr', '2024-12-05', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2025-01-08', '2025-01-15', 'Deluxe V1,Deluxe V1,', '11280.00', '2024-12-06 09:54:51', '2024-12-06 09:54:51'),
(99, '96rtwuhs9m4c9wd8e', 'mike', 'doctore', 'mr', '2024-12-13', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2025-01-06', '2025-01-14', 'Luxury V1,Luxury V1,', '17200.00', '2024-12-06 09:56:00', '2024-12-06 09:56:00'),
(100, 'nwg59mbarm4ca8ygc', 'rapal', 'kirk', 'mr', '2024-12-13', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2024-12-07', '2024-12-14', 'Luxury V1,Luxury V1,', '15200.00', '2024-12-06 10:05:48', '2024-12-06 10:05:48'),
(101, 'aax8yp4pfm4cac9yl', 'rapal', 'kirk', 'mr', '2024-12-10', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2025-01-08', '2025-01-15', 'Deluxe V1,Luxury V1,Deluxe V1,Luxury V1', '25280.00', '2024-12-06 10:08:23', '2024-12-06 10:08:23'),
(102, 'o9azsv5tzm4caif3h', 'rapal', 'aikawa', 'mr', '2024-12-13', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2025-01-06', '2025-01-13', 'Luxury V1,Luxury V1', '15200.00', '2024-12-06 10:13:10', '2024-12-06 10:13:10'),
(103, 'ineo8nmwlm4ch0sad', 'rapal', 'kirk', 'mr', '2024-12-05', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2025-01-02', '2025-01-09', 'Deluxe V1, Deluxe V1', '11280.00', '2024-12-06 13:15:24', '2024-12-06 13:15:24'),
(104, '75hflq8dym4ch7g2m', 'rapal', 'kirk', 'mr', '2024-01-01', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2025-01-15', '2025-01-23', 'Deluxe V1, Deluxe V1', '12720.00', '2024-12-06 13:20:34', '2024-12-06 13:20:34'),
(105, '0hj6lmk15m4chddxd', 'fabon', 'kirk', 'mr', '2024-12-13', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '09948566329', 'banton', '2024-12-03', '2024-12-11', 'Luxury V1, Standard V2, Luxury V1, Standard V2', '25520.00', '2024-12-06 13:25:11', '2024-12-06 13:25:11'),
(106, 'o45706imgm4cjuxh0', 'rapal', 'kirk', 'mr', '2024-12-04', 'Male', 1, 'student', 'kirkfabonnnn@gmail.com', '123123', '123123', '2024-12-06', '2024-12-14', 'Luxury V1, Luxury V1', '17200.00', '2024-12-06 14:34:49', '2024-12-06 14:34:49'),
(108, 'khvcsj4erm4cl69y4', 'lizardo', 'reese', 'ms', '2024-12-19', 'Male', 1, 'student', 'mikeddoctor08@gmail.com', '0912939128', 'tondo', '2024-12-06', '2024-12-14', 'Standard V2, Standard V2', '9520.01', '2024-12-06 15:11:37', '2024-12-06 15:11:37'),
(109, 'yinpu61d5m4cp0pi6', 'Doctor', 'John Michael', NULL, '2004-02-02', 'Male', 2, 'student', 'mikeddoctor08@gmail.com', '0912939128', 'pasig', '2024-12-01', '2025-01-01', 'Standard V1, Standard V1', '29360.00', '2024-12-06 16:59:15', '2024-12-06 16:59:15'),
(110, 'a2b3rdf5bm4cp1br0', 'Doctor', 'John Michael', NULL, '2004-02-02', 'Male', 2, 'student', 'mikeddoctor08@gmail.com', '0912939128', 'pasig', '2024-12-01', '2025-01-01', 'Standard V1, Standard V1', '29360.00', '2024-12-06 16:59:43', '2024-12-06 16:59:43');

-- --------------------------------------------------------

--
-- Table structure for table `income_trackers`
--

CREATE TABLE `income_trackers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `availed_service` varchar(255) NOT NULL,
  `price` decimal(11,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `income_trackers`
--

INSERT INTO `income_trackers` (`id`, `booking_id`, `customer_name`, `availed_service`, `price`, `created_at`, `updated_at`) VALUES
(88, '', 'kirk Kirk', 'Airport Shuttle', '1250.00', '2024-12-02 00:53:08', '2024-12-02 00:53:08'),
(89, '', 'Kirk', 'booking reservation', '26400.00', '2024-12-02 01:02:47', '2024-12-02 01:02:47'),
(90, '', 'rapal', 'booking reservation', '1276.80', '2024-12-02 01:15:22', '2024-12-02 01:15:22'),
(91, '6ee7x0ckhm472qnno', 'rapal', 'booking reservation', '2500.00', '2024-12-02 01:16:30', '2024-12-03 09:00:54'),
(92, 'zxqpnynw9m48po0s8', 'mike', 'booking reservation', '85600.00', '2024-12-03 09:06:27', '2024-12-03 09:06:56'),
(93, 'r5jfurh7ym48pr6s6', 'rapal', 'booking reservation', '698528.81', '2024-12-03 09:08:51', '2024-12-03 09:08:51'),
(94, 'lw5q3fb7gm48px6fg', 'rapal', 'booking reservation', '2153174.40', '2024-12-03 09:13:27', '2024-12-03 09:13:27'),
(95, 'v3m3y1vuzm48q5ou4', 'rapal', 'Room Booking', '123.00', '2024-12-03 10:00:17', '2024-12-04 01:42:52'),
(96, 'fg3u0u64tm48qifjy', 'Kirk', 'Room Booking', '1500.00', '2024-12-03 10:00:22', '2024-12-03 10:00:22'),
(97, 'gf7e5ix7wm49c7gdx', 'irish rapal', 'Booking Reservation', '0.00', '2024-12-03 19:37:18', '2024-12-03 19:37:18'),
(98, '2ru0iq99gm49ca0cf', 'irish rapal', 'Booking Reservation', '2153174.40', '2024-12-03 19:39:17', '2024-12-03 19:39:17'),
(99, '4masixdalm49cir3c', 'irish rapal', 'Booking Reservation', '1365187.20', '2024-12-03 19:46:05', '2024-12-03 19:46:05'),
(100, 'l4s9ird11m49ckm5a', 'irish rapal', 'Booking Reservation', '1365187.20', '2024-12-03 19:47:32', '2024-12-03 19:47:32'),
(101, 'l4s9ird11m49ckm5a', 'irish rapal', 'room service', '132.00', '2024-12-03 19:49:43', '2024-12-03 19:49:43'),
(103, '93815dfa7m498kztz', 'Kirk', 'Room Booking', '16700.00', '2024-12-03 22:41:44', '2024-12-03 22:54:01'),
(104, 'gt2ml39qsm499k3q4', 'rapal', 'Room Booking', '21700.00', '2024-12-03 22:45:54', '2024-12-03 22:45:54'),
(105, 'tenqb62blm49p2xy6', 'kirk Kirk', 'Booking Reservation', '8880.01', '2024-12-04 01:37:43', '2024-12-04 01:37:43'),
(106, '6rmfm9r0hm49qkswj', 'kirk Kirk', 'Booking Reservation', '34800.00', '2024-12-04 02:19:36', '2024-12-04 02:19:36'),
(107, 'nl2sl32ovm49qoebj', 'kirk Kirk', 'Booking Reservation', '39600.00', '2024-12-04 02:22:23', '2024-12-04 02:22:23'),
(108, '1rn7ieqwfm49qraq9', 'kirk Kirk', 'Booking Reservation', '7500.00', '2024-12-04 02:24:39', '2024-12-04 08:19:15'),
(109, 'o5jv6cgodm49xq0sl', 'kirk Kirk', 'Booking Reservation', '0.00', '2024-12-04 05:39:36', '2024-12-04 08:17:38'),
(110, '92i249zn4m49xq7ky', 'kirk Kirk', 'Booking Reservation', '8480.01', '2024-12-04 05:39:45', '2024-12-04 05:39:45'),
(111, 'vvuwp3j15m4a3hc2c', 'kirk Kirk', 'Booking Reservation', '24540.00', '2024-12-04 08:20:49', '2024-12-04 09:04:02'),
(112, 'b0c60bc1am4a3mzfv', 'kirk Kirk', 'Booking Reservation', '2640.00', '2024-12-04 08:25:12', '2024-12-04 08:25:12'),
(113, 'ayuih2b02m4a3tabh', 'kirk Kirk', 'Booking Reservation', '12720.00', '2024-12-04 08:30:07', '2024-12-04 08:30:07'),
(114, 'tw20m3oskm4akbagi', 'fusby aikawa', 'Booking Reservation', '63280.01', '2024-12-04 16:12:00', '2024-12-04 16:12:00'),
(118, 'tw20m3oskm4akbagi', 'fusby aikawa', 'asd', '123.00', '2024-12-04 18:43:05', '2024-12-04 18:43:05'),
(119, 'm91icl5o0m4aq38p6', 'kirk Kirk', 'Booking Reservation', '17200.00', '2024-12-04 18:53:42', '2024-12-04 18:53:42'),
(120, 'cl32mlwcmm4c9hvyz', 'irish rapal', 'Booking Reservation', '12720.00', '2024-12-06 09:44:45', '2024-12-06 09:44:45'),
(121, '98h80e3wzm4c9lwq3', 'irah lizzardo', 'Booking Reservation', '12720.00', '2024-12-06 09:47:53', '2024-12-06 09:47:53'),
(122, 'x0yl582y3m4c9s27d', 'irah lizzardo', 'Booking Reservation', '12720.00', '2024-12-06 09:52:40', '2024-12-06 09:52:40'),
(123, 'w7v8o9wutm4c9uvrh', 'irish rapal', 'Booking Reservation', '11280.00', '2024-12-06 09:54:51', '2024-12-06 09:54:51'),
(124, '96rtwuhs9m4c9wd8e', 'doctore mike', 'Booking Reservation', '17200.00', '2024-12-06 09:56:00', '2024-12-06 09:56:00'),
(125, 'nwg59mbarm4ca8ygc', 'kirk rapal', 'Booking Reservation', '15200.00', '2024-12-06 10:05:48', '2024-12-06 10:05:48'),
(126, 'aax8yp4pfm4cac9yl', 'kirk rapal', 'Booking Reservation', '25280.00', '2024-12-06 10:08:23', '2024-12-06 10:08:23'),
(127, 'o9azsv5tzm4caif3h', 'aikawa rapal', 'Booking Reservation', '15200.00', '2024-12-06 10:13:10', '2024-12-06 10:13:10'),
(128, 'ineo8nmwlm4ch0sad', 'kirk rapal', 'Booking Reservation', '11280.00', '2024-12-06 13:15:24', '2024-12-06 13:15:24'),
(129, '75hflq8dym4ch7g2m', 'kirk rapal', 'Booking Reservation', '12720.00', '2024-12-06 13:20:34', '2024-12-06 13:20:34'),
(130, '0hj6lmk15m4chddxd', 'kirk fabon', 'Booking Reservation', '25520.00', '2024-12-06 13:25:11', '2024-12-06 13:25:11'),
(131, 'o45706imgm4cjuxh0', 'kirk rapal', 'Booking Reservation', '17200.00', '2024-12-06 14:34:49', '2024-12-06 14:34:49'),
(132, 'sii4w5x77m4cl078p', 'khae lee', 'Booking Reservation', '42480.00', '2024-12-06 15:06:54', '2024-12-06 15:06:54'),
(133, 'khvcsj4erm4cl69y4', 'reese lizardo', 'Booking Reservation', '9520.01', '2024-12-06 15:11:37', '2024-12-06 15:11:37'),
(134, 'yinpu61d5m4cp0pi6', 'John Michael Doctor', 'Booking Reservation', '29360.00', '2024-12-06 16:59:15', '2024-12-06 16:59:15'),
(135, 'a2b3rdf5bm4cp1br0', 'John Michael Doctor', 'Booking Reservation', '29360.00', '2024-12-06 16:59:43', '2024-12-06 16:59:43'),
(136, 'khvcsj4erm4cl69y4', 'reese lizardo', 'In-Room Spa Treatment', '799.00', '2024-12-06 17:02:21', '2024-12-06 17:02:21'),
(137, 'khvcsj4erm4cl69y4', 'reese lizardo', 'Breakfast in Bed', '449.00', '2024-12-06 17:02:40', '2024-12-06 17:02:40');

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
(4, '2024_10_19_171949_create_rooms_table', 1),
(5, '2024_11_09_111632_guests', 1),
(6, '2024_11_16_003109_income_trackers', 1),
(7, '2024_11_16_140845_create_feedback_table', 1),
(8, '2024_11_16_160538_add_anonymous_to_feedback_table', 1),
(9, '2024_11_21_024450_create_admins_table', 1),
(10, '2024_11_29_130937_services', 2),
(11, '2024_11_29_132057_guest_service', 2),
(12, '2024_11_29_201809_availed_services', 3),
(13, '2024_11_29_203400_create_availed_services_table', 4),
(14, '2024_11_29_203542_create_availed_services_table', 5),
(15, '2024_12_04_083653_room_prices', 6);

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
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `room_price_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_type`, `description`, `image_path`, `room_price_id`, `created_at`, `updated_at`) VALUES
(17, 'Standard V1', 'A cozy and comfortable room equipped with basic amenities, ideal for solo travelers or short stays. Includes a single or double bed, private bathroom, and essential furnishings.', './images/roomImage/room_1733478601.jpg', 1, '2024-12-06 14:50:01', '2024-12-06 14:50:01'),
(18, 'Standard V2', 'A slightly upgraded version of the Standard room, offering additional space or better furnishings. Includes a double bed, private bathroom, and a small workspace or seating area.', './images/roomImage/room_1733478651.jpg', 2, '2024-12-06 14:50:51', '2024-12-06 14:50:51'),
(19, 'Standard V3', 'A premium Standard room with enhanced amenities such as a mini-fridge, modern décor, and a larger layout. Perfect for couples or business travelers.', './images/roomImage/room_1733478703.jpg', 3, '2024-12-06 14:51:43', '2024-12-06 14:51:43'),
(20, 'Deluxe V1', 'A spacious and stylishly designed room featuring premium furnishings, a queen-sized bed, private bathroom, and added amenities like a TV and mini-bar.', './images/roomImage/room_1733478749.jpg', 4, '2024-12-06 14:52:29', '2024-12-06 14:52:29'),
(21, 'Deluxe V2', 'An upgraded Deluxe room with a larger layout, superior views, and additional features such as a small kitchenette or lounge area.', './images/roomImage/room_1733478788.jpg', 5, '2024-12-06 14:53:08', '2024-12-06 14:53:08'),
(22, 'Deluxe V3', 'A top-tier Deluxe room designed for ultimate comfort, offering luxury bedding, advanced tech amenities, and an excellent view. Includes access to exclusive hotel facilities.', './images/roomImage/room_1733478819.jpg', 6, '2024-12-06 14:53:39', '2024-12-06 14:53:39'),
(23, 'Luxury V1', 'An elegant and sophisticated room offering high-end furnishings, a king-sized bed, a spacious bathroom, and exclusive toiletries. Perfect for a luxurious stay.', './images/roomImage/room_1733478857.jpg', 7, '2024-12-06 14:54:17', '2024-12-06 14:54:17'),
(24, 'Luxury V2', 'A premium Luxury suite featuring a separate living area, breathtaking views, and access to VIP services. Ideal for extended stays or special occasions.', './images/roomImage/room_1733478896.jpg', 8, '2024-12-06 14:54:56', '2024-12-06 14:54:56'),
(25, 'Luxury V3', 'The ultimate luxury experience, with a full suite including a bedroom, living room, and dining area. Includes top-tier amenities, personalized service, and access to exclusive facilities.', './images/roomImage/room_1733478923.jpg', 9, '2024-12-06 14:55:23', '2024-12-06 14:55:23'),
(26, 'Standard V2', 'dito masaya', './images/roomImage/room_1733480198.png', 2, '2024-12-06 15:16:07', '2024-12-06 15:16:41');

-- --------------------------------------------------------

--
-- Table structure for table `room_prices`
--

CREATE TABLE `room_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_prices`
--

INSERT INTO `room_prices` (`id`, `room_type`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Standard V1', '1100.00', '2024-12-04 00:46:37', '2024-12-04 00:46:37'),
(2, 'Standard V2', '1300.00', '2024-12-04 00:46:37', '2024-12-04 00:46:37'),
(3, 'Standard V3', '1400.00', '2024-12-04 00:46:37', '2024-12-04 00:46:37'),
(4, 'Deluxe V1', '1800.00', '2024-12-04 00:46:37', '2024-12-04 00:46:37'),
(5, 'Deluxe V2', '2000.00', '2024-12-04 00:46:37', '2024-12-04 00:46:37'),
(6, 'Deluxe V3', '2200.00', '2024-12-04 00:46:37', '2024-12-04 00:46:37'),
(7, 'Luxury V1', '2500.00', '2024-12-04 00:46:37', '2024-12-04 00:46:37'),
(8, 'Luxury V2', '2800.00', '2024-12-04 00:46:37', '2024-12-04 00:46:37'),
(9, 'Luxury V3', '3000.00', '2024-12-04 00:46:37', '2024-12-04 00:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `availed_service` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `availed_service`, `description`, `price`, `created_at`, `updated_at`) VALUES
(15, 'Breakfast in Bed', 'Daily, 6:00 AM – 10:00 AM', 'Enjoy a freshly prepared breakfast served in the comfort of your room. Options include continental, American, or vegetarian breakfast trays.asdasd', '449.00', '2024-12-02 05:24:20', '2024-12-06 14:59:06'),
(16, 'In-Room Spa Treatment', 'Daily, 9:00 AM – 8:00 PM', 'Relax and rejuvenate with a range of spa services, including Swedish massage, deep tissue massage, or facials, delivered directly to your room.', '799.00', '2024-12-02 05:24:42', '2024-12-06 15:00:21'),
(17, 'Laundry and Dry Cleaning', 'Daily, 8:00 AM – 8:00 PM (Next-day delivery)', 'Professional laundry and dry-cleaning services to keep your clothes fresh and clean during your stay.', '749.00', '2024-12-04 05:44:29', '2024-12-06 15:01:34');

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
('2ptTH8Dqo5QyRdYCWNYVs8tkgjgdNdzWSMYDT2JE', NULL, '77.81.142.122', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1FuZjlMYVc0eU1LMTdXMWViOU9DYWw3bWd4V0RDQm15VEZxMDJpOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733483661),
('4rViw1RWrqfzugQiSryzfNdo0p6vqVbvXM4FyxJ8', NULL, '35.94.42.63', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G965U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.111 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1dSZ2hVUWRQOVNlV3NkbE1xMUhwZTJ4WWk4Z3BPcDZORURuamNaNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sYXJhdmVpbHN1aXRlLngxMC5teC9yb29tcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733481658),
('9vCAbm3EBqYz1GEXcNrajrZURrU6qPf2TUUABx3u', 11, '112.209.181.232', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWEdnU2RTYm84V0l3VmpueDhDd29hd091bjNLTXZxbW1STjdvaUhRYyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU5OiJodHRwczovL2xhcmF2ZWlsc3VpdGUueDEwLm14L2Nhc2hpZXI/cGF5bWVudF9zdGF0dXM9cGVuZGluZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjExO30=', 1733486561),
('aX8BiIlrrAiDEIRsWOnA3T3lPdyBEWdrDkcnuw5b', NULL, '149.50.212.205', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibXc4UkJJYmVrd0dOekNXRE5wTW5pd1I4cmN1aTJZcEJyS3R6cXBqeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733482707),
('BahLA8cgQ3k6tG5PdzGW7FXPw1M6KRcU3sFFu6be', NULL, '186.227.198.149', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkVaTjRKRkxDc0ZwRzN3TUc0YndyN2prN1BrSWdxZ0hVRXYyd3dEZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733483709),
('CSCwYXM0a51sVq9tpjOjLKkkkbBFlK4IUHcXBJ2U', NULL, '149.88.22.38', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiem1sRlFQbWtmRHBTTUhyUzljWFhJWldiMklVWnMxT05jTVAwQlc1ayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sYXJhdmVpbHN1aXRlLngxMC5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733481863),
('cyG9Zt7jipyF3sAGNV6Vx7di3VdooZgJ1eL0FBtM', NULL, '185.216.35.70', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNzZxRzZlTHMwQzBFelUzZExuTDlmeXYwOG51bFZocFZsN0c4cmZjciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733482707),
('d8JcM7ool5Fwp04omnPNbZHNfwbgIyI9gi7ylCT8', NULL, '149.40.50.91', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidGtJZlkyOVVLdGZuQjV6U0liWk5LRkRMZ0JEbDRkVjlGN1o3RnBmeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733483563),
('DH8eMZmwj3Q6H5e4YXuOTOiBs62WHB5FeKoeDqfc', NULL, '186.66.165.60', 'python-requests/2.31.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaU9sWk1BSzc1NFE2UjFUMlNxMWhkeEFVWWdRbUNnQm53T2pSS3FCeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733493841),
('dmau8yslQsDZtUYci0bHVFZEsXygJMdB4QwIZ0HI', NULL, '80.82.70.198', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVTdYTVBMYkg4amh2TFFtSnljYk5MTDdYcmRuZFYySHVEUjBvMlRoSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgvcm9vbXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733482543),
('EkCdhFEiwMX0y6kzZ9dHL4OuSKnH3xpN5cTADk8d', NULL, '156.146.41.86', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2dldDVRZVNWWkdScVUyaFdqSnNtS0NmNjZ6TlNPZlZLdmZLYkJiTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sYXJhdmVpbHN1aXRlLngxMC5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733481862),
('LuIAKMmcuWnr1HNQMa1HtAL2X8HHlRv3QtgYaH4B', NULL, '186.227.198.149', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia1NqWUtxUlptckJQZ3JmV3ZGTmlGbFRqVWx0VkVta2ZUYzZwaWJIdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgvcm9vbXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733483230),
('nJhbwUmSoiMEZG9nd6bt9Udt6AH4np4DVQJjB9Te', NULL, '35.94.42.63', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.19582', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWW9YaVZFbkdSNTdyNldsWXEyTVlpblg1cndTdXdRZk9qQk9YNDhiNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sYXJhdmVpbHN1aXRlLngxMC5teC9yb29tcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733481654),
('OTA1Gmq19UmUT9z1UTN413msktclB8XrLbNoO8oQ', NULL, '128.90.105.198', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ0I4UGw4c3F1dGZkYXRJMzBOSDJpekhuaVhCcXN1TmZYWW5Ka2FCTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgvcm9vbXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733482212),
('PnuR2akV72Mg8QL7yH0X8mJVbqbC3K5uX8mn57uL', NULL, '209.38.4.240', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUFZGaEx5SFZvUmN5cEFCUEw4eUw0Z29rdGFXem1Ka0Z6MEM3dDh3YSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgvcm9vbXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733482189),
('QCBKrs8emoly0yTnkztsmVz5VFawqaTgjFPsc284', NULL, '149.102.227.85', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM1lPSnJTdG5JM2liQlBjUjFyNFlaellhV1FLMFdob2I5NExhRjhDSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sYXJhdmVpbHN1aXRlLngxMC5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733481865),
('qpY8zpU0XIZoaa1vn2V1wgnSZX5UzzJIkA7wWyWf', NULL, '77.81.142.122', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSExPWWZLaVJpaDVKVWpudkdMUVZkUkMzbmZ5NkZNeTh2TjdnZUJJYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733482706),
('Ss0m8bTUh3CHSlDB81tlByoxUtzd5uWfrE0k278p', NULL, '1.37.67.200', 'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) QtWebEngine/6.7.2 Chrome/118.0.5993.220 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoialFOcXhvcTZqRFlpZWtma0JGcWJxcnhHVTlGVjFzR1FkSGhNa0pidSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njg6Imh0dHA6Ly9sYXJhdmVpbHN1aXRlLngxMC5teC92aWV3LWJvb2tpbmc/Ym9va2luZ0lkPXNpaTR3NXg3N200Y2wwNzhwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1733484646),
('Thqdh5tLoNbLwdykipgJ6JdSpPhAmkC1ENvUxkbd', NULL, '35.87.221.207', 'Mozilla/5.0 (Linux; Android 12; Pixel 6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUTdUSEFVZEJOTWY3NTRjNk9rMUFhSFRXaDNKcWprYUhjT083QWxtbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733482633),
('WkPxLv9kYQPOnUoJC03knAUDFxydFZZ397DSmnWn', NULL, '186.66.165.60', 'Mozilla/5.0 (X11; Linux x86_64; rv:133.0) Gecko/20100101 Firefox/133.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY3NQRVlpV09BS3lpQzJQQlVnSEFtdzdVaHZFZEJSUk96N2k4TkFnZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgvcm9vbXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733493848),
('wmfKEWWJ2hTEjGyIJmKGplpubhclGTlAxjf7ZvGT', NULL, '149.88.22.38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiakcyRDhiQnJNWmRIcU12YjAyQ2NGcWcxTTIybXJMOFNvRzVCWkdnZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733481877),
('XA8TbsE1J6J6U6GKWarV74v7Ri7m3cxZf85Ba4s5', NULL, '131.226.100.167', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 OPR/114.0.0.0 (Edition std-2)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXRqUUk5ZDR2UUk4ZGpZbDNJSEU4eWRGS1N1bjB3REtGSWV3aDc5SyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgvcm9vbXMiO319', 1733480218),
('XcSD6HwDflVce4c0wISyQqYcC7lKxy9O6FdYtooM', 120, '158.62.42.40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 OPR/114.0.0.0 (Edition std-2)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicVdOZUhlZ3JpT0t4RTh3S2ExWUZVSDJ5UFY0M1Zza1FxUnoyczU0eCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgvY2FzaGllcj9wYXltZW50X3N0YXR1cz1wZW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTIwO30=', 1733487135),
('xvAfEKLfXrhT6pF5kLQp2ubKycc39UZtlxX4MWXk', NULL, '54.191.224.23', 'httpx - Open-source project (github.com/Cloudsek-Engineering/fdf-httpx)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWjczVG1ma0ZtV2VJdXR4UHNsbHJaN0pBTml2eFZMTG5Ub1FnT29aMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733484394),
('zA5ZOd0VfMJAQFY0B2k7fd8XVvqG8e7AWDH4mYip', NULL, '198.44.133.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36 Edg/130.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWNFRW9ZODBMcm9Pa2FCcEFscG9ISDRzbmxtejFvNzVuSjBvb0o3biI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbGFyYXZlaWxzdWl0ZS54MTAubXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733481880);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` enum('admin','cashier','guest') NOT NULL,
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

INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$127Mb/3tuQmC0N.eepFXiecq7ly7CvsI8mAQXp5sauVpd4OCKMs6C', 'nq5axOAjYZSIq7lb8O4efjQLqww82CBCA0b3tNVI3FfQGwekkMWbUxRfM38z', NULL, '2024-11-29 04:20:13'),
(11, 'cashier', 'cashier', 'cashier@gmail.com', NULL, '$2y$12$V69z55qkw4Ww3nbiIIv/8egSSJczRFNfR75ZlZyT/pWZH3eaqo3W.', NULL, '2024-11-29 08:37:20', '2024-11-29 08:37:20'),
(24, 'cashier2', 'cashier', 'cashier2@gmail.com', NULL, '$2y$12$/Wjf0TwpTUBSd1O3U9tkB.jcQvLY712EdZNQ8nbB4CyIh1AkK.FYC', NULL, '2024-12-01 08:19:12', '2024-12-01 08:19:12'),
(25, 'cashier3', 'cashier', 'cashier3@gmail.com', NULL, '$2y$12$lVQ2OXEXKdOMyYVE6q0eSeZz6EmlZp.YAj3TWYN/wHh5t8jUrMYIi', NULL, '2024-12-01 08:21:31', '2024-12-01 08:21:31'),
(91, 'irish', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$JS8j615yaCKHkwa9aOS1LujVGCc59BbgZzYfYoLqrmG7aKlp1ZsBW', NULL, '2024-12-03 19:47:32', '2024-12-03 19:47:32'),
(92, 'kirk', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$02oRm3.BvHaTqKZS7mu9..NYZsB6KW0L1CxsbJrYteGcz.xgtkBge', NULL, '2024-12-04 01:37:44', '2024-12-04 01:37:44'),
(93, 'kirk', 'guest', 'admin@gmail.com', NULL, '$2y$12$2wqWztJjJcy35OAyu0ropuKebTPSk5JC8Yf9EHnirSLKQwukujaTG', NULL, '2024-12-04 02:19:36', '2024-12-04 02:19:36'),
(94, 'kirk', 'guest', 'admin@gmail.com', NULL, '$2y$12$BMvTYP4FQcPP0jfhkDGhguDP5H6DT4H4ghtYiyeV/435RiwLrPmG2', NULL, '2024-12-04 02:22:24', '2024-12-04 02:22:24'),
(95, 'kirk', 'guest', 'admin@gmail.com', NULL, '$2y$12$7DlhFYQkZxxSZk4Aqb9te.Is3f4Qi5sYW.kXYpzcNU7Ms3Omkd4lu', NULL, '2024-12-04 02:24:39', '2024-12-04 02:24:39'),
(96, 'kirk', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$pmh6ED.2MWmICDcvHh7X5O6DcjhDXfvdIBdmE1l.Dpxr6jCXPfsUO', NULL, '2024-12-04 05:39:37', '2024-12-04 05:39:37'),
(97, 'kirk', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$EFp9.quKCmbvlBINABMvA.K57UYtDU.OqWd4gBcu/Uhfj1YkiZzta', NULL, '2024-12-04 05:39:45', '2024-12-04 05:39:45'),
(98, 'kirk', 'guest', 'admin@gmail.com', NULL, '$2y$12$51jDrlM2rUE4WwRjflXkN.L/DqMSxYASiiFR14oJhGHg6AdyWhcGm', NULL, '2024-12-04 08:20:49', '2024-12-04 08:20:49'),
(99, 'kirk', 'guest', 'admin@gmail.com', NULL, '$2y$12$QWF7KlfHtQ99YuZfVxEWceBXPtkccRGUGDxanYNeX1No7ATMXV9S6', NULL, '2024-12-04 08:25:13', '2024-12-04 08:25:13'),
(100, 'kirk', 'guest', 'tH9q5@example.com', NULL, '$2y$12$KUBES7oi.FLjMxl.Y/bZ6O.41nyN6pAXOoZs6ku7P/lLoh5sTGsAW', NULL, '2024-12-04 08:30:07', '2024-12-04 08:30:07'),
(101, 'fusby', 'guest', 'admin@gmail.com', NULL, '$2y$12$I4qrAIzv6J6cjnWMAJpOXuMghavn.GEu3I3O24G2mstwN5tBwWzRq', NULL, '2024-12-04 16:12:01', '2024-12-04 16:12:01'),
(102, 'admin', 'admin', 'admin2@gmail.com', NULL, '$2y$12$kA.WCfHBL2r.OAW1TFIh6OsM.LBl0zeq/5S2wSlFvpqWNZ8X5Bp9S', NULL, '2024-12-04 18:45:37', '2024-12-04 18:45:37'),
(103, 'kirk', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$BtxuAfXX/y2kgPtUioqR8eyuXdBO/FHyylVoC2oN68QJfqbbVeTvS', NULL, '2024-12-04 18:53:43', '2024-12-04 18:53:43'),
(104, 'irish', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$F0QbCQ4HE14zeTK7nQYknuu4gZy/I5QvuT4Bk4s/COTJ2Y93FbYnK', NULL, '2024-12-06 09:44:46', '2024-12-06 09:44:46'),
(105, 'irah', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$9jX71ZRhe4ZWpA3u2EduIOIA9yuFw9h4lY7iP38QCwhBUS4TRxoXS', NULL, '2024-12-06 09:47:53', '2024-12-06 09:47:53'),
(106, 'irah', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$tEWpfjqslMpXMkHGxjwrau7Ej/FSISQ7k6jTqkFWeHEZ1y.gvSi.O', NULL, '2024-12-06 09:52:40', '2024-12-06 09:52:40'),
(107, 'irish', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$wvyF4LsgkVDKGgeTZK9aUO1Z36dD3tV3rC1KpPHc5dmbT1R21/Cs2', NULL, '2024-12-06 09:54:51', '2024-12-06 09:54:51'),
(108, 'doctore', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$qM0XJ17yGK5b6mjCUnpXwO1xiYaEU9kPWRyClntX3zL.L4nSTJ7U.', NULL, '2024-12-06 09:56:00', '2024-12-06 09:56:00'),
(109, 'kirk', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$D6wdZox7MCOucKGdCPcVYuhQYPCiaS78Keel6jQ0kbG9v503gNj0m', NULL, '2024-12-06 10:05:48', '2024-12-06 10:05:48'),
(110, 'kirk', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$kLs8gijDIKASISL2UMYZ7ObbFA/zGmpeRM0Zm0b/8zSELhLNfFjpC', NULL, '2024-12-06 10:08:23', '2024-12-06 10:08:23'),
(111, 'aikawa', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$PToetEgvOYrj0FredauQQu3nmjXctYX91t4jb0Jan5eMGiKJPoy4.', NULL, '2024-12-06 10:13:10', '2024-12-06 10:13:10'),
(112, 'kirk', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$vJ1DTjN4TdXsOPpMzj4iKe2J6/bFrVZpK4Yrof8CijXJeqfA5fki.', NULL, '2024-12-06 13:15:24', '2024-12-06 13:15:24'),
(113, 'kirk', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$cQsbkfOPJawvIOZmJFENpuzj3c3dqWZz.XceZZPBi20Xbd7gMSs2y', NULL, '2024-12-06 13:20:34', '2024-12-06 13:20:34'),
(114, 'kirk', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$sdPXNEeTj/tqlnrpuRuNkef11Xw.LXx3gIJz0GAsgmoxob4hjfEp2', NULL, '2024-12-06 13:25:11', '2024-12-06 13:25:11'),
(115, 'kirk', 'guest', 'kirkfabonnnn@gmail.com', NULL, '$2y$12$1DPC7u3m9Rh7JgQF5cgci.NEAk1.uYytdqmzNHlN.LaCmMVOn.aSm', NULL, '2024-12-06 14:34:49', '2024-12-06 14:34:49'),
(116, 'khae', 'guest', 'mikeddoctor08@gmail.com', NULL, '$2y$12$K6mi2hFPbdLnlNyvw4KVYe5lu6EgeSb2wX.qZIIA9gvGWVh0U5Ou2', NULL, '2024-12-06 15:06:54', '2024-12-06 15:06:54'),
(117, 'reese', 'guest', 'mikeddoctor08@gmail.com', NULL, '$2y$12$4F1.t1VdARJXrt9C1xh51epJbFyvuI1AhwmmCP9esxRPMxAz0r4eC', NULL, '2024-12-06 15:11:37', '2024-12-06 15:11:37'),
(118, 'John Michael', 'guest', 'mikeddoctor08@gmail.com', NULL, '$2y$12$YE4qIMwU0Ry3EjUaVDhr/Onh2ODJWLD7T1vL4UJB225xhmptprxA6', NULL, '2024-12-06 16:59:15', '2024-12-06 16:59:15'),
(119, 'John Michael', 'guest', 'mikeddoctor08@gmail.com', NULL, '$2y$12$KcXjiUTcwmNCa/sisAnCx.NJkxxeCZnQar/kpj7nNvLA33mvqqRwW', NULL, '2024-12-06 16:59:44', '2024-12-06 16:59:44'),
(120, 'Cashier 1', 'cashier', 'mikedtr09@gmail.com', NULL, '$2y$12$qCk/Ees0sHM5tD8ntM5E4eGVNs5zkq2WVH5GlJ87rk6kYSGSnCqK6', NULL, '2024-12-06 17:09:59', '2024-12-06 17:09:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indexes for table `availed_services`
--
ALTER TABLE `availed_services`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_guest_id_foreign` (`guest_id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guests_booking_id_unique` (`booking_id`);

--
-- Indexes for table `income_trackers`
--
ALTER TABLE `income_trackers`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_room_price_id_foreign` (`room_price_id`);

--
-- Indexes for table `room_prices`
--
ALTER TABLE `room_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `availed_services`
--
ALTER TABLE `availed_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `income_trackers`
--
ALTER TABLE `income_trackers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `room_prices`
--
ALTER TABLE `room_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_room_price_id_foreign` FOREIGN KEY (`room_price_id`) REFERENCES `room_prices` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
