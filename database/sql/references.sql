-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 09, 2023 at 01:46 PM
-- Server version: 8.0.32-0ubuntu0.22.04.2
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eco`
--

--
-- Dumping data for table `complaint_references`
--

INSERT INTO `complaint_references` (`id`, `parent_id`, `child_id`, `type`, `name`, `description`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'parent', 'General', NULL, NULL, NULL, NULL, '2023-11-05 09:13:38', '2023-11-05 09:13:38'),
(2, 1, NULL, 'checkbox', 'Fever', NULL, NULL, NULL, NULL, '2023-11-05 09:15:08', '2023-11-05 09:15:08'),
(3, 1, NULL, 'checkbox', 'Headache', NULL, NULL, NULL, NULL, '2023-11-05 09:15:19', '2023-11-05 09:15:19'),
(4, 1, NULL, 'checkbox', 'Cold', NULL, NULL, NULL, NULL, '2023-11-05 09:15:30', '2023-11-05 09:15:30'),
(5, 1, NULL, 'checkbox', 'Nausea', NULL, NULL, NULL, NULL, '2023-11-05 09:16:00', '2023-11-05 09:16:00'),
(6, 1, NULL, 'checkbox', 'Dizziness', NULL, NULL, NULL, NULL, '2023-11-05 09:16:40', '2023-11-05 09:16:40'),
(7, NULL, NULL, 'parent', 'Eye', NULL, NULL, NULL, NULL, '2023-11-05 09:16:49', '2023-11-05 09:16:49'),
(8, 1, NULL, 'textarea', 'Others please specify', NULL, NULL, NULL, NULL, '2023-11-05 09:18:20', '2023-11-05 09:27:25'),
(9, 7, NULL, 'checkbox', 'Excessive Tearing', NULL, NULL, NULL, NULL, '2023-11-05 09:18:30', '2023-11-08 08:14:59'),
(10, 7, NULL, 'checkbox', 'Swollen Eyelids', NULL, NULL, NULL, NULL, '2023-11-05 09:18:38', '2023-11-05 09:18:38'),
(11, 7, NULL, 'checkbox', 'Blinds Spots', NULL, NULL, NULL, NULL, '2023-11-05 09:18:48', '2023-11-05 09:18:48'),
(12, 7, NULL, 'checkbox', 'Eye Twitching', NULL, NULL, NULL, NULL, '2023-11-05 09:18:56', '2023-11-05 09:18:56'),
(13, 7, NULL, 'checkbox', 'Astigmatism', NULL, NULL, NULL, NULL, '2023-11-05 09:19:03', '2023-11-05 09:19:03'),
(14, 7, NULL, 'checkbox', 'Cataracts', NULL, NULL, NULL, NULL, '2023-11-05 09:19:11', '2023-11-05 09:19:11'),
(15, 7, NULL, 'checkbox', 'Poor Night Vision', NULL, NULL, NULL, NULL, '2023-11-05 09:19:20', '2023-11-05 09:19:20'),
(16, 7, NULL, 'checkbox', 'Blurred Vision', NULL, NULL, NULL, NULL, '2023-11-05 09:19:27', '2023-11-05 09:19:27'),
(17, 7, NULL, 'checkbox', 'Double Visions', NULL, NULL, NULL, NULL, '2023-11-05 09:19:34', '2023-11-05 09:19:34'),
(18, 7, NULL, 'checkbox', 'Eye Strain', NULL, NULL, NULL, NULL, '2023-11-05 09:19:40', '2023-11-05 09:19:40'),
(19, 7, NULL, 'checkbox', 'Eye Fatigue', NULL, NULL, NULL, NULL, '2023-11-05 09:20:03', '2023-11-05 09:20:03'),
(20, 7, NULL, 'checkbox', 'Floaters', NULL, NULL, NULL, NULL, '2023-11-05 09:20:45', '2023-11-08 08:19:34'),
(21, 7, NULL, 'textarea', 'Others please specify', NULL, NULL, NULL, NULL, '2023-11-08 08:15:47', '2023-11-08 08:19:20');

--
-- Dumping data for table `eye_prescription_references`
--

INSERT INTO `eye_prescription_references` (`id`, `parent_id`, `child_id`, `type`, `name`, `description`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'parent', 'Old RX', NULL, NULL, NULL, NULL, '2023-10-21 02:38:34', '2023-10-21 02:38:34'),
(2, 1, NULL, 'text', 'OD', NULL, NULL, NULL, NULL, '2023-10-21 02:38:51', '2023-10-21 02:38:51'),
(3, 1, NULL, 'text', 'OS', NULL, NULL, NULL, NULL, '2023-10-21 02:39:17', '2023-10-21 02:39:17'),
(4, 1, NULL, 'text', 'OU', NULL, NULL, NULL, NULL, '2023-10-21 02:39:29', '2023-10-21 02:39:29'),
(5, NULL, NULL, 'parent', 'VA Near', NULL, NULL, NULL, NULL, '2023-10-21 02:40:09', '2023-11-08 08:24:19'),
(7, NULL, NULL, 'parent', 'VA Far', NULL, NULL, NULL, NULL, '2023-11-08 08:23:42', '2023-11-08 08:24:26'),
(8, 5, NULL, 'text', 'OD', NULL, NULL, NULL, NULL, '2023-11-08 08:24:36', '2023-11-08 08:24:36'),
(9, 5, NULL, 'text', 'OS', NULL, NULL, NULL, NULL, '2023-11-08 08:24:49', '2023-11-08 08:24:49'),
(10, 5, NULL, 'text', 'OU', NULL, NULL, NULL, NULL, '2023-11-08 08:25:02', '2023-11-08 08:25:02'),
(11, 7, NULL, 'text', 'OD', NULL, NULL, NULL, NULL, '2023-11-08 08:25:13', '2023-11-08 08:25:13'),
(12, 7, NULL, 'text', 'OS', NULL, NULL, NULL, NULL, '2023-11-08 08:25:26', '2023-11-08 08:25:26'),
(13, 7, NULL, 'text', 'OU', NULL, NULL, NULL, NULL, '2023-11-08 08:25:36', '2023-11-08 08:25:36');

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
