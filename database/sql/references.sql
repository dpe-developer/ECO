-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 03, 2023 at 04:09 AM
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
-- Database: `dizon_vision_clinic`
--

--
-- Dumping data for table `eye_prescription_references`
--

INSERT INTO `eye_prescription_references` (`id`, `parent_id`, `child_id`, `type`, `name`, `description`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'parent', 'Old RX', NULL, NULL, NULL, NULL, '2023-10-21 02:38:34', '2023-10-21 02:38:34'),
(2, 1, NULL, 'text', 'OD', NULL, NULL, NULL, NULL, '2023-10-21 02:38:51', '2023-10-21 02:38:51'),
(3, 1, NULL, 'text', 'OS', NULL, NULL, NULL, NULL, '2023-10-21 02:39:17', '2023-10-21 02:39:17'),
(4, 1, NULL, 'text', 'OU', NULL, NULL, NULL, NULL, '2023-10-21 02:39:29', '2023-10-21 02:39:29'),
(5, NULL, NULL, 'text', 'VAB', NULL, NULL, NULL, NULL, '2023-10-21 02:40:09', '2023-10-21 02:40:09'),
(6, NULL, NULL, 'text', 'VAH', NULL, NULL, NULL, NULL, '2023-10-21 02:40:16', '2023-10-21 02:40:16');

--
-- Dumping data for table `medical_history_references`
--

INSERT INTO `medical_history_references` (`id`, `parent_id`, `child_id`, `type`, `name`, `description`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'check_textbox', 'Are you under medical treatment now?', 'If so, what is the condition being treated?', NULL, NULL, NULL, '2023-11-03 03:03:54', '2023-11-03 03:03:54'),
(2, NULL, NULL, 'check_textbox', 'Have you ever had any surgical operation?', 'If so, what illness or operation?', NULL, NULL, NULL, '2023-11-03 03:04:13', '2023-11-03 03:04:13'),
(3, NULL, NULL, 'check_textbox', 'Have you ever been hospitalized?', 'If so, when and why?', NULL, NULL, NULL, '2023-11-03 03:04:26', '2023-11-03 03:04:26'),
(4, NULL, NULL, 'check_textbox', 'Are you taking any prescription/non-prescription medication?', 'If so, please specify', NULL, NULL, NULL, '2023-11-03 03:04:45', '2023-11-03 03:04:45'),
(5, NULL, NULL, 'checkbox', 'Do you use tobacco products?', NULL, NULL, NULL, NULL, '2023-11-03 03:05:11', '2023-11-03 03:05:11'),
(6, NULL, NULL, 'checkbox', 'Do you drink alcoholic beverages?', NULL, NULL, NULL, NULL, '2023-11-03 03:05:19', '2023-11-03 03:05:19'),
(7, NULL, NULL, 'checkbox', 'Are you allergic to any of the following ; Local Anesthetic (ex. Lidocaine), Sulfa drugs, Aspirin', NULL, NULL, NULL, NULL, '2023-11-03 03:06:56', '2023-11-03 03:06:56'),
(8, NULL, NULL, 'parent', 'For women only', NULL, NULL, NULL, NULL, '2023-11-03 03:07:13', '2023-11-03 03:07:13'),
(9, 8, NULL, 'checkbox', 'Are you pregnant?', NULL, NULL, NULL, NULL, '2023-11-03 03:07:24', '2023-11-03 03:07:24'),
(10, 8, NULL, 'checkbox', 'Are you nursing?', NULL, NULL, NULL, NULL, '2023-11-03 03:07:35', '2023-11-03 03:07:35'),
(11, 8, NULL, 'checkbox', 'Are you taking birth control pills?', NULL, NULL, NULL, NULL, '2023-11-03 03:07:49', '2023-11-03 03:07:49'),
(12, NULL, NULL, 'textarea', 'Other medical conditions', NULL, NULL, NULL, NULL, '2023-11-03 03:08:03', '2023-11-03 03:08:03');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
