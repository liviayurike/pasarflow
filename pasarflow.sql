-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 01:08 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pasarflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_slots`
--

CREATE TABLE `booking_slots` (
  `id` int(11) NOT NULL,
  `plat_no` varchar(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `delivery_time` enum('07:00-07:30','07:30-08:00','08:00-08:30','08:30-09:00','09:00-09:30','09:30-10:00','10:00-10:30','10:30-11:00','11:30-12:00','12:00-12:30','12:30-13:00','13:00-13:30','13:30-14:00') NOT NULL,
  `status` enum('booked','available') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_slots`
--

INSERT INTO `booking_slots` (`id`, `plat_no`, `user_id`, `store_name`, `tanggal`, `delivery_time`, `status`) VALUES
(1, 'N 123 AA', 5, 'Toko Wijaya', '2024-11-18', '07:00-07:30', 'available'),
(9, 'N 456 DD', 3, 'Toko Mekar Jaya', '2024-11-19', '07:30-08:00', 'available'),
(11, 'N 345 CC', 1, 'Toko Cahaya', '2024-11-19', '08:00-08:30', 'available'),
(12, 'N 234 BB', 2, 'Toko Sumber Mekar', '2024-11-19', '08:30-09:00', 'available'),
(15, 'N 678 FF', 8, 'Toko Jaya', '2024-11-19', '09:00-09:30', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `reminder_time` datetime NOT NULL,
  `status` enum('sent','pending') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `zone_id` int(11) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`id`, `start_time`, `end_time`, `zone_id`, `is_available`) VALUES
(1, '07:00:00', '07:30:00', 1, 1),
(2, '07:30:00', '08:00:00', 1, 1),
(3, '08:00:00', '08:30:00', 1, 1),
(4, '08:30:00', '09:00:00', 1, 1),
(5, '09:00:00', '09:30:00', 2, 1),
(6, '09:30:00', '10:00:00', 2, 1),
(7, '10:00:00', '10:30:00', 2, 1),
(8, '10:30:00', '11:00:00', 2, 1),
(9, '11:00:00', '11:30:00', 3, 1),
(10, '11:30:00', '12:00:00', 3, 1),
(11, '12:00:00', '12:30:00', 3, 1),
(12, '11:00:00', '12:00:00', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Bayu', 'bayu@gmail.com', '$2y$10$Sw.tVJH4N8ut8EZU63.7g.dcgjxR7s/qUQOsq85eYdFXNA.x2r2wi', 'user', '2024-11-18 14:01:57'),
(2, 'Alifia', 'alifia@gmail.com', '$2y$10$uZ6bc/ya2d4JXFuLR6ayuufQNg8TFy4f4OSzW17MVpvKBNyQSiPD6', 'user', '2024-11-18 14:03:37'),
(3, 'Nana', 'nana@gmail.com', '$2y$10$y5hX3enGGq.r4kXeaghANOjbLEgnq.V2UBKTgKWZ3fuvn0OSfRFW2', 'user', '2024-11-18 14:04:27'),
(4, 'admin', 'admin@gmail.com', '$2y$10$lTRjlgMDGR6JWvp3SNlAh.1KCenYEnAGrfiAt.Jd1OzZWkKne6X86', 'admin', '2024-11-18 14:13:00'),
(5, 'Ayu', 'ayu@gmail.com', '$2y$10$GVTgxajLN42NEt6pEit1MOOO.DzFRnVBTS4Ng5ms5McoOBj/7sADu', 'user', '2024-11-18 14:45:48'),
(6, 'Lala', 'lala@gmail.com', '$2y$10$FWE5iwzyV/N2PgszBJPmnuQP1IPzLA9tyVTdKLfAuoZG5qNTo0r5O', 'user', '2024-11-18 16:55:47'),
(7, 'Lia', 'lia@gmail.com', '$2y$10$agsu5O8FXGRXWxEBguXOjedtNtc9UPkzjymj7fHXhlKkIOEp8L1G2', 'user', '2024-11-18 23:54:14'),
(8, 'Ari', 'ari@gmail.com', '$2y$10$4zziXmImDzwwr1FgN8LfU.iHkdLO48IUIjb7Y2DQ.5Eykm1cGza3m', 'user', '2024-11-19 00:01:12');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_stops`
--

CREATE TABLE `vehicle_stops` (
  `id` int(11) NOT NULL,
  `vehicle_number` varchar(20) NOT NULL,
  `start_time` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_stops`
--

INSERT INTO `vehicle_stops` (`id`, `vehicle_number`, `start_time`, `duration`, `status`) VALUES
(1, 'B 1234 ABC', '2023-04-20 08:05:00', 30, 'Stopped'),
(2, 'D 5678 EFG', '2023-04-20 09:15:00', 45, 'Stopped'),
(3, 'G 9012 HIJ', '2023-04-20 10:20:00', 25, 'Stopped');

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `available_slots` int(11) NOT NULL DEFAULT 0,
  `used_slots` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `name`, `available_slots`, `used_slots`) VALUES
(1, 'Zone A', 10, 3),
(2, 'Zone B', 12, 7),
(3, 'Zone C', 8, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_slots`
--
ALTER TABLE `booking_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zone_id` (`zone_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `vehicle_stops`
--
ALTER TABLE `vehicle_stops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_slots`
--
ALTER TABLE `booking_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vehicle_stops`
--
ALTER TABLE `vehicle_stops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_slots`
--
ALTER TABLE `booking_slots`
  ADD CONSTRAINT `booking_slots_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD CONSTRAINT `time_slots_ibfk_1` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
