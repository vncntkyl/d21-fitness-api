-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2025 at 11:42 AM
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
-- Database: `d21`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `contact_number` varchar(13) DEFAULT NULL,
  `password` text NOT NULL,
  `role` int(11) NOT NULL,
  `token` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `last_online` datetime DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`ID`, `username`, `email_address`, `contact_number`, `password`, `role`, `token`, `status`, `last_online`, `created_at`, `modified_at`) VALUES
(1, 'admin', 'kyle.rinoza2009@gmail.com', NULL, '$2y$10$Q65nq5TQmK9go9nE4TVj8u7hSL/lnDNgtOSuh6I4wQakz5ZMUKsX6', 1, 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE3NTgwOTYyNTEsImV4cCI6MTc1ODE4MjY1MX0.2jQkPpDNvGqaj2sCPujw2u3oaSySO7f5yP-NgBbzwkU', 1, '2025-09-17 16:04:11', '2025-08-30 16:17:42', '2025-08-30 16:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `ID` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(128) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`ID`, `name`, `description`, `amount`, `payment_mode`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Test', '', 1000.00, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Student', 'Membership for students', 1650.00, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `ID` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`ID`, `name`, `description`, `status`, `created_at`, `modified_at`) VALUES
(1, 'superadmin', 'Overall admin of the system', 1, '2025-08-31 00:58:07', '2025-08-31 00:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `role_modules`
--

CREATE TABLE `role_modules` (
  `ID` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_modules`
--

INSERT INTO `role_modules` (`ID`, `name`, `status`, `created_at`, `modified_at`) VALUES
(1, 'users', 1, '2025-08-31 00:59:45', '2025-08-31 00:59:45');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `ID` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `can_view` tinyint(1) NOT NULL DEFAULT 1,
  `can_add` tinyint(1) DEFAULT 0,
  `can_edit` tinyint(1) DEFAULT 0,
  `can_delete` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`ID`, `role_id`, `module_id`, `can_view`, `can_add`, `can_edit`, `can_delete`, `created_at`, `modified_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, '2025-08-30 19:03:15', '2025-08-30 19:03:15');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `ID` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `amount` decimal(10,0) NOT NULL,
  `duration` int(11) NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`ID`, `name`, `description`, `amount`, `duration`, `payment_mode`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Monthly', NULL, 2000, 1, 2, 1, '2025-08-31 19:17:16', '2025-09-03 12:15:37'),
(2, 'Quarterly', NULL, 1800, 3, 2, 1, '2025-08-31 19:18:46', '2025-08-31 10:05:32'),
(3, '6 Months', NULL, 1600, 6, 2, 2, '2025-08-31 19:19:40', '2025-08-31 19:19:40'),
(4, 'Annual', 'Best value with full-year access.', 1400, 12, 2, 1, '2025-08-31 19:20:35', '2025-08-31 19:20:35'),
(5, 'Non-member monthly', 'for non members', 2500, 1, 2, 1, '2025-08-31 19:21:38', '2025-08-31 19:21:38'),
(6, 'Student Plan', 'Budget friendly plan for students (monthly)', 1650, 1, 2, 1, '2025-08-31 19:22:29', '2025-08-31 19:22:29'),
(7, 'Daily Access', 'Daily access gym plan', 400, 1, 3, 1, '2025-08-31 19:23:09', '2025-08-31 19:23:09'),
(8, 'Test Plan', 'Sample description', 3000, 10, 2, 0, '2025-09-02 20:22:39', '2025-09-02 08:24:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `birthday` date NOT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `subscription_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `account_id`, `first_name`, `middle_name`, `last_name`, `address`, `birthday`, `membership_id`, `subscription_id`, `created_at`, `modified_at`) VALUES
(1, 1, 'vincent kyle', 'torres', 'rinoza', 'Makati, Metro Manila', '2001-04-17', NULL, NULL, '2025-08-30 16:20:41', '2025-08-30 16:20:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `role_modules`
--
ALTER TABLE `role_modules`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `membership_id` (`membership_id`),
  ADD KEY `subscription_id` (`subscription_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role_modules`
--
ALTER TABLE `role_modules`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `role_modules` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`ID`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`ID`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
