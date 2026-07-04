-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2026 at 09:28 PM
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
-- Database: `luxe_spa_mms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `full_name`, `email`, `password`, `phone`, `created_at`) VALUES
(1, 'Administrator', 'admin@luxespa.com', '$2y$10$.RuEk0HUezhWP94JJik0E.DqdGo/XMr7fojYmUQWNvMrPX2UElf0.', '0123456789', '2026-06-27 10:30:49');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `member_code` varchar(10) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `member_type` varchar(50) DEFAULT 'Individual',
  `membership` enum('Bronze','Silver','Gold') DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `member_code`, `full_name`, `email`, `password`, `phone`, `gender`, `member_type`, `membership`, `status`, `join_date`, `created_at`) VALUES
(1, 'M001', 'Siti Sarah ', 'sarah@gmail.com', '$2y$10$0SpB18imqBda/7cotl/lCuvpAKs1dEdi4fJq2zj3p1FqhBAEJCMCW', '0123456789', 'Female', 'Individual', 'Bronze', 'Active', '2024-05-12', '2026-06-27 10:31:06'),
(2, 'M002', 'Izzati', 'izzati@gmail.com', '$2y$10$0SpB18imqBda/7cotl/lCuvpAKs1dEdi4fJq2zj3p1FqhBAEJCMCW', '0123456788', 'Female', 'Individual', 'Gold', 'Active', '2024-05-13', '2026-06-27 10:31:06'),
(3, 'M003', 'Nurin', 'nurin@gmail.com', '$2y$10$0SpB18imqBda/7cotl/lCuvpAKs1dEdi4fJq2zj3p1FqhBAEJCMCW', '0123456787', 'Female', 'Individual', 'Gold', 'Inactive', '2024-05-14', '2026-06-27 10:31:06'),
(4, 'M004', 'Aina', 'aina@gmail.com', '$2y$10$0SpB18imqBda/7cotl/lCuvpAKs1dEdi4fJq2zj3p1FqhBAEJCMCW', '0123456786', 'Female', 'Individual', 'Silver', 'Active', '2024-05-15', '2026-06-27 10:31:06'),
(6, 'M005', 'Anis Alisha', 'alisha@gmail.com', '$2y$10$0SpB18imqBda/7cotl/lCuvpAKs1dEdi4fJq2zj3p1FqhBAEJCMCW', '0123456778', 'Female', 'Individual', 'Bronze', 'Active', '2026-06-27', '2026-06-27 11:23:43'),
(8, 'M007', 'Nur Azlina', 'azlina@gmail.com', '$2y$10$0SpB18imqBda/7cotl/lCuvpAKs1dEdi4fJq2zj3p1FqhBAEJCMCW', '01234560870', 'Female', 'Individual', 'Silver', 'Inactive', '2026-06-26', '2026-06-27 16:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `service` varchar(100) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(30) DEFAULT NULL,
  `payment_status` enum('Completed','Pending') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `member_id`, `service`, `amount`, `payment_date`, `payment_method`, `payment_status`) VALUES
(1, 1, 'Nail Styling', 100.00, '2024-05-12', 'Cash', 'Completed'),
(2, 2, 'Special Guiding', 200.00, '2024-05-13', 'Online Banking', 'Completed'),
(3, 3, 'Health Shower', 150.00, '2024-05-14', 'Credit Card', 'Pending'),
(4, 4, 'Spa Masks', 250.00, '2024-05-15', 'Cash', 'Completed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `member_code` (`member_code`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
