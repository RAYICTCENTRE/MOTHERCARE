-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 04:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mothercare`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `qualifications` text DEFAULT NULL,
  `specialty` varchar(100) DEFAULT NULL,
  `facility` varchar(150) DEFAULT NULL,
  `dcontact` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `photo`, `qualifications`, `specialty`, `facility`, `dcontact`, `created_at`) VALUES
(1, 1, 'uploads/1751140592_VANOES LOGO.jpg', 'phd', 'gynecologist', 'mulago', '+25675623988', '2025-06-28 19:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `symptom_checker`
--

CREATE TABLE `symptom_checker` (
  `id` int(11) NOT NULL,
  `symptoms` text NOT NULL,
  `blood_pressure` varchar(20) NOT NULL,
  `urinalysis_taken` tinyint(1) NOT NULL DEFAULT 0,
  `protein_in_urine` varchar(10) DEFAULT 'Not taken',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `symptom_checker`
--

INSERT INTO `symptom_checker` (`id`, `symptoms`, `blood_pressure`, `urinalysis_taken`, `protein_in_urine`, `submitted_at`) VALUES
(10, 'Blurred vision, Severe abdominal pain, Swelling in hands or feet, Headache', '167/80', 1, 'Yes', '2025-06-28 20:38:46'),
(11, 'Blurred vision, Severe abdominal pain, Swelling in hands or feet, Headache', '167/80', 1, 'Yes', '2025-06-28 20:38:49'),
(12, 'Nausea, Severe abdominal pain, Swelling in hands or feet, Headache', '160/80', 1, 'Yes', '2025-06-29 20:06:54'),
(13, 'Nausea, Severe abdominal pain, Swelling in hands or feet, Headache', '160/80', 1, 'Yes', '2025-06-29 20:07:11'),
(14, 'Headache, Swelling in hands or feet, Severe abdominal pain, Rapid weight gain', '150/80', 1, 'Yes', '2025-06-30 07:59:57'),
(15, 'Headache, Swelling in hands or feet, Severe abdominal pain, Rapid weight gain', '150/80', 1, 'Yes', '2025-06-30 08:00:00'),
(16, 'Headache, Swelling in hands or feet, Severe abdominal pain, Rapid weight gain', '150/80', 1, 'Yes', '2025-06-30 08:00:03'),
(17, 'Headache, Blurred vision, Rapid weight gain', '70/80', 1, 'No', '2025-06-30 13:39:09'),
(18, 'Headache, Blurred vision, Rapid weight gain', '70/80', 1, 'No', '2025-06-30 13:39:17'),
(19, 'Headache, Blurred vision, Nausea', '145/80', 1, 'Yes', '2025-07-01 08:21:18'),
(20, 'Headache, Blurred vision, Nausea', '145/80', 1, 'Yes', '2025-07-01 08:21:25'),
(21, 'Swelling in hands or feet, Shortness of breath', '70/80', 1, 'No', '2025-07-01 08:58:09'),
(22, 'Swelling in hands or feet, Shortness of breath', '70/80', 1, 'No', '2025-07-01 08:58:24'),
(23, 'Rapid weight gain, Nausea', '160/80', 1, 'Yes', '2025-07-01 11:09:45'),
(24, 'Rapid weight gain, Nausea', '160/80', 1, 'No', '2025-07-01 11:14:04'),
(25, 'Rapid weight gain, Nausea', '160/80', 1, 'Yes', '2025-07-01 11:14:15'),
(26, 'Headache, Blurred vision, Rapid weight gain', '130/80', 1, 'Yes', '2025-07-01 11:28:49'),
(27, 'Headache, Blurred vision, Rapid weight gain', '130/80', 1, 'Yes', '2025-07-01 11:28:54'),
(28, 'Headache, Blurred vision, Rapid weight gain', '130/80', 1, 'Yes', '2025-07-01 11:34:50'),
(29, 'Headache, Blurred vision, Rapid weight gain', '130/80', 1, 'Yes', '2025-07-01 11:34:55'),
(30, 'Headache, Severe abdominal pain, Blurred vision', '167/80', 1, 'Yes', '2025-07-01 12:00:56'),
(31, 'Headache, Severe abdominal pain, Blurred vision', '167/80', 1, 'Yes', '2025-07-01 12:01:04'),
(32, 'Headache, Swelling in hands or feet, Decreased urine output', '167/80', 1, 'Yes', '2025-07-01 12:09:31'),
(33, 'Headache, Swelling in hands or feet, Decreased urine output', '167/80', 1, 'Yes', '2025-07-01 12:09:36'),
(34, 'Blurred vision', '167/80', 1, 'Yes', '2025-07-01 13:20:15'),
(35, 'Blurred vision', '167/80', 1, 'Yes', '2025-07-01 13:20:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'Client',
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `contact`, `user_type`, `password`, `created_at`) VALUES
(20, 'OKAO', 'MATHEW', 'matthewokao@gmail.com', NULL, 'Admin', '$2y$10$d35uyUg.fciFD7QogssUAuFR6FMPi2/UH0LdEx401BzsNDtH9QURC', '2025-06-30 13:12:45'),
(21, 'OYELLA', 'FIFI', 'oyella@gmail.com', NULL, 'Client', '$2y$10$4J1c/kgqLgMJEaJzI2z96u79WMPVmz4qo7XGKVHs/bxL93M6GwmwS', '2025-06-30 13:36:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `sub_county` varchar(50) DEFAULT NULL,
  `parish` varchar(50) DEFAULT NULL,
  `village` varchar(50) DEFAULT NULL,
  `nearest_health` varchar(100) DEFAULT NULL,
  `kin_name` varchar(100) DEFAULT NULL,
  `kin_relationship` varchar(50) DEFAULT NULL,
  `kin_contact` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `last_period` date DEFAULT NULL,
  `expected_delivery` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `nationality`, `district`, `sub_county`, `parish`, `village`, `nearest_health`, `kin_name`, `kin_relationship`, `kin_contact`, `dob`, `last_period`, `expected_delivery`, `created_at`) VALUES
(10, 21, 'South Sudan', 'AGAGO', 'PURANGA', 'LORO', 'ALIDI', 'AGULURUDE HC III', 'MARY', 'SISTER', '+256785413934', '2000-03-21', '2025-06-30', '2026-04-06', '2025-06-30 13:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `blood_pressure` varchar(20) DEFAULT NULL,
  `protein` varchar(10) DEFAULT NULL,
  `risk_score` int(11) DEFAULT NULL,
  `risk_level` varchar(20) DEFAULT NULL,
  `recommendation` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `symptom_checker`
--
ALTER TABLE `symptom_checker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `symptom_checker`
--
ALTER TABLE `symptom_checker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
