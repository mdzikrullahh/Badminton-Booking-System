-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2023 at 01:46 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dtar_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `booking_datetime` datetime DEFAULT NULL,
  `booking_usedatetime` datetime DEFAULT NULL,
  `booking_duration` varchar(50) DEFAULT NULL,
  `booking_cancel` varchar(50) DEFAULT NULL,
  `booking_history` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `delete_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL,
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `booking_datetime`, `booking_usedatetime`, `booking_duration`, `booking_cancel`, `booking_history`, `customer_id`, `delete_at`, `update_at`, `create_at`, `token`) VALUES
(93, '2023-06-19 23:49:17', '2023-06-19 10:00:00', '1', NULL, 'Paid', 9, '2023-06-19 15:50:27', '2023-06-19 15:50:27', '2023-06-19 15:49:17', NULL),
(94, '2023-06-19 23:49:31', '2023-06-19 16:00:00', '4', NULL, 'Paid', 9, '2023-06-19 15:50:06', '2023-06-19 15:50:06', '2023-06-19 15:49:31', NULL),
(99, '2023-06-20 00:04:56', '2023-06-22 20:00:00', '1', NULL, 'Paid', 11, '2023-06-19 16:11:49', '2023-06-19 16:11:49', '2023-06-19 16:04:56', NULL),
(100, '2023-06-20 19:44:17', '2023-06-21 13:00:00', '5', NULL, 'Paid', 10, '2023-06-20 23:39:51', '2023-06-20 23:39:51', '2023-06-20 11:44:17', NULL),
(101, '2023-06-20 20:09:57', '2023-06-22 14:00:00', '3', NULL, 'Pending', 10, '2023-06-20 12:09:57', NULL, '2023-06-20 12:09:57', NULL),
(102, '2023-06-20 20:10:15', '2023-06-20 10:00:00', '6', NULL, 'Paid', 10, '2023-06-20 16:30:30', '2023-06-20 16:30:30', '2023-06-20 12:10:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_court`
--

CREATE TABLE `booking_court` (
  `bookingcourt_id` int(11) NOT NULL,
  `court_id` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `delete_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL,
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_court`
--

INSERT INTO `booking_court` (`bookingcourt_id`, `court_id`, `booking_id`, `delete_at`, `update_at`, `create_at`, `token`) VALUES
(27, 3, 93, '2023-06-19 15:49:18', NULL, '2023-06-19 15:49:18', '18aafc1019e5758d8246904a86daf817'),
(28, 6, 94, '2023-06-19 15:49:31', NULL, '2023-06-19 15:49:31', '18aafc1019e5758d8246904a86daf817'),
(33, 7, 99, '2023-06-19 16:04:56', NULL, '2023-06-19 16:04:56', '9146636ddcf1c26d3a33a8ed43dbe280'),
(34, 1, 100, '2023-06-20 11:44:17', NULL, '2023-06-20 11:44:17', '7dda915d2105ab9314a29c1acb41e696'),
(35, 3, 101, '2023-06-20 12:09:57', NULL, '2023-06-20 12:09:57', '7dda915d2105ab9314a29c1acb41e696'),
(36, 7, 102, '2023-06-20 12:10:15', NULL, '2023-06-20 12:10:15', '7dda915d2105ab9314a29c1acb41e696');

-- --------------------------------------------------------

--
-- Table structure for table `court`
--

CREATE TABLE `court` (
  `court_id` int(11) NOT NULL,
  `court_num` varchar(20) DEFAULT NULL,
  `hall_id` int(11) DEFAULT NULL,
  `court_availability` varchar(20) DEFAULT NULL,
  `delete_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL,
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `court`
--

INSERT INTO `court` (`court_id`, `court_num`, `hall_id`, `court_availability`, `delete_at`, `update_at`, `create_at`, `token`) VALUES
(1, 'Court 1', 7002, 'available', '2023-06-20 19:33:32', NULL, '2023-06-03 16:35:26', NULL),
(3, 'Court 2', 7002, 'available', '2023-06-20 19:34:07', NULL, '2023-06-03 16:37:57', NULL),
(4, 'Court 1', 7001, 'available', '2023-06-20 19:56:09', NULL, '2023-06-03 16:37:57', NULL),
(5, 'Court 2', 7001, 'available', '2023-06-20 19:34:07', NULL, '2023-06-03 16:37:57', NULL),
(6, 'Court 3', 7001, 'available', '2023-06-20 19:34:07', NULL, '2023-06-03 16:37:57', NULL),
(7, 'Court 4', 7001, 'available', '2023-06-20 19:34:07', NULL, '2023-06-03 16:37:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `customer_age` varchar(50) DEFAULT NULL,
  `customer_ic` varchar(50) DEFAULT NULL,
  `customer_pass` varchar(50) DEFAULT NULL,
  `customer_email` varchar(50) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` varchar(100) DEFAULT NULL,
  `delete_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL,
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_age`, `customer_ic`, `customer_pass`, `customer_email`, `customer_phone`, `customer_address`, `delete_at`, `update_at`, `create_at`, `token`) VALUES
(4, 'zik', '3', '010101010', '1234', 'zikry@gmail.com', '0123013033', '', '2023-06-18 17:50:19', '2023-06-18 17:50:19', '2023-06-02 21:09:56', '87648f1ddea04046f86bc4e5023236a3'),
(7, 'Syera Shera', '22', '0076162631', '1234', 'syahirah@gmail.com', '0123456789', 'aaaaaa', '2023-06-19 14:26:22', '2023-06-19 14:26:22', '2023-06-17 15:03:58', '7d741599fc70ad6b58641b8c7b4fe0ed'),
(8, 'azlan chan', NULL, '0202020202', '1234', 'azlan@gmail.com', '0123456789', NULL, '2023-06-19 15:22:43', '2023-06-19 15:22:43', '2023-06-19 15:22:35', 'a852e89c816fb14629cdb82138bbaf73'),
(9, 'izzul', NULL, '02020202', '1234', 'izzul@gmail.com', '0123456788', NULL, '2023-06-19 15:48:55', '2023-06-19 15:48:55', '2023-06-19 15:48:47', '18aafc1019e5758d8246904a86daf817'),
(10, 'gordon ramzik ss', '21', '0203012031', '1234', 'gordonramzik@gmail.com', '0123456789', 'asdasdasda', '2023-06-20 23:25:21', '2023-06-20 23:25:21', '2023-06-19 15:51:10', 'af298816d02951c4a6818e8f66b25b36'),
(11, 'hilmy chan', '22', '02020202021', '1234', 'hilmy@gmail.com', '0123013333', 'asdasdasda', '2023-06-19 16:13:44', '2023-06-19 16:13:44', '2023-06-19 16:02:28', '9146636ddcf1c26d3a33a8ed43dbe280'),
(12, 'ahmad', NULL, '919191919', '1234', 'staff2@gmail.com', '0123013495', NULL, '2023-06-20 03:53:21', NULL, '2023-06-20 03:53:21', 'b9a69f77ddb1d5207c24cdb048e71ce9');

-- --------------------------------------------------------

--
-- Table structure for table `hall`
--

CREATE TABLE `hall` (
  `hall_id` int(11) NOT NULL,
  `hall_name` varchar(50) DEFAULT NULL,
  `hall_availability` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hall`
--

INSERT INTO `hall` (`hall_id`, `hall_name`, `hall_availability`) VALUES
(7001, 'Dewan Kenangan Tun Abdul Razak', 'available'),
(7002, 'Dewan Lama', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `online_payment`
--

CREATE TABLE `online_payment` (
  `online_payment_id` int(11) NOT NULL,
  `current_balance` int(11) DEFAULT NULL,
  `after_balance` int(11) DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL,
  `token` text DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `online_payment`
--

INSERT INTO `online_payment` (`online_payment_id`, `current_balance`, `after_balance`, `delete_at`, `update_at`, `create_at`, `token`, `customer_id`) VALUES
(3, 1000, 1000, '2023-06-18 17:50:19', '2023-06-18 17:50:19', '2023-06-17 13:54:10', NULL, 4),
(4, 1000, 1034, '2023-06-18 17:30:26', '2023-06-18 17:30:26', '2023-06-17 15:03:58', '00492aa9a190cd135e54d15e751f720a', 7),
(5, 450, 450, '2023-06-19 15:22:35', '2023-06-19 15:22:35', '2023-06-19 15:22:35', 'ff91bdc756ceb51c69c7c95e968b8f14', 8),
(6, 450, 440, '2023-06-19 15:50:27', '2023-06-19 15:50:27', '2023-06-19 15:48:47', '18aafc1019e5758d8246904a86daf817', 9),
(7, 450, 450, '2023-06-19 15:51:10', '2023-06-19 15:51:10', '2023-06-19 15:51:10', '7a7651bc094d5794b8a78721aa9a728f', 10),
(8, 450, 440, '2023-06-19 16:13:44', '2023-06-19 16:13:44', '2023-06-19 16:02:28', '9146636ddcf1c26d3a33a8ed43dbe280', 11),
(9, 450, 450, '2023-06-20 03:53:21', '2023-06-20 03:53:21', '2023-06-20 03:53:21', 'b9a69f77ddb1d5207c24cdb048e71ce9', 12);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `payment_datetime` datetime DEFAULT NULL,
  `payment_amount` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `paymentmethod_id` int(11) DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL,
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_datetime`, `payment_amount`, `booking_id`, `customer_id`, `paymentmethod_id`, `delete_at`, `update_at`, `create_at`, `token`) VALUES
(6, '2023-06-19 23:50:06', 40, 94, 9, 1, '2023-06-19 15:50:06', '2023-06-19 15:50:06', '2023-06-19 15:50:06', '18aafc1019e5758d8246904a86daf817'),
(7, '2023-06-19 23:50:27', 10, 93, 9, 2, '2023-06-19 15:50:27', '2023-06-19 15:50:27', '2023-06-19 15:50:27', '18aafc1019e5758d8246904a86daf817'),
(11, '2023-06-20 00:05:34', 10, 99, 11, 3, '2023-06-19 16:05:34', '2023-06-19 16:05:34', '2023-06-19 16:05:34', '9146636ddcf1c26d3a33a8ed43dbe280'),
(12, '2023-06-21 00:30:30', 60, 102, 10, 1, '2023-06-20 16:30:30', '2023-06-20 16:30:30', '2023-06-20 16:30:30', '99ea758ebdf151e261264ff1c9bda795');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `paymentmethod_id` int(11) NOT NULL,
  `paymentmethod_title` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`paymentmethod_id`, `paymentmethod_title`) VALUES
(1, 'card'),
(2, 'fpx'),
(3, 'cash');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_title` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_title`) VALUES
(1, 'Admin'),
(2, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_pass` varchar(20) DEFAULT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `user_age` varchar(20) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL,
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_pass`, `user_phone`, `user_age`, `role_id`, `delete_at`, `update_at`, `create_at`, `token`) VALUES
(7, 'administrator2', 'admin@gmail.com', '1234', '0123456890', '1', 1, '2023-06-20 17:25:41', '2023-06-20 17:25:41', '2023-06-18 16:51:36', 'a8a7181b608db4da16e43812530d077e'),
(8, 'deshwin', 'staff@gmail.com', '1234', '0123456789', '22', 1, '2023-06-20 03:52:57', '2023-06-20 03:52:57', '2023-06-18 18:31:35', 'ca8991da88d0cbd94dece38d0323ddf4'),
(9, 'ahmad', 'staff2@gmail.com', '1234', '0123456789', '1', 2, '2023-06-20 03:54:20', '2023-06-20 03:54:20', '2023-06-20 03:54:14', '00b256b8d089d8f546bfa40a0b8b4745'),
(10, 'test name', 'test@gmail.com', '1234', '0123456789', '19', 2, NULL, NULL, '2023-06-20 04:22:34', 'd976f61b9a0ec9fcfa75d22b3ffc222b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `booking_court`
--
ALTER TABLE `booking_court`
  ADD PRIMARY KEY (`bookingcourt_id`),
  ADD KEY `court_id` (`court_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `court`
--
ALTER TABLE `court`
  ADD PRIMARY KEY (`court_id`),
  ADD KEY `hall_id` (`hall_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_email` (`customer_email`);

--
-- Indexes for table `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`hall_id`);

--
-- Indexes for table `online_payment`
--
ALTER TABLE `online_payment`
  ADD PRIMARY KEY (`online_payment_id`),
  ADD KEY `fk_online_payment_customer` (`customer_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `user_id` (`customer_id`),
  ADD KEY `paymentmethod_id` (`paymentmethod_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`paymentmethod_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `booking_court`
--
ALTER TABLE `booking_court`
  MODIFY `bookingcourt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `court`
--
ALTER TABLE `court`
  MODIFY `court_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hall`
--
ALTER TABLE `hall`
  MODIFY `hall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7003;

--
-- AUTO_INCREMENT for table `online_payment`
--
ALTER TABLE `online_payment`
  MODIFY `online_payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `paymentmethod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_court`
--
ALTER TABLE `booking_court`
  ADD CONSTRAINT `booking_court_ibfk_1` FOREIGN KEY (`court_id`) REFERENCES `court` (`court_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_court_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `court`
--
ALTER TABLE `court`
  ADD CONSTRAINT `court_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`hall_id`) ON DELETE CASCADE;

--
-- Constraints for table `online_payment`
--
ALTER TABLE `online_payment`
  ADD CONSTRAINT `fk_online_payment_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_ibfk_3` FOREIGN KEY (`paymentmethod_id`) REFERENCES `payment_method` (`paymentmethod_id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
