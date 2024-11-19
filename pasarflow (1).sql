-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 01:09 AM
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
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `vehicle_number` varchar(20) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `time_slot_id` int(11) NOT NULL,
  `reminder_time` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `vehicle_number`, `zone_id`, `time_slot_id`, `reminder_time`, `created_at`) VALUES
(1, 'B 1234 ABC', 1, 1, '2023-04-20 07:50:00', '2024-11-15 19:29:16'),
(2, 'D 5678 EFG', 2, 5, '2023-04-20 08:50:00', '2024-11-15 19:29:16'),
(3, 'G 9012 HIJ', 3, 9, '2023-04-20 09:50:00', '2024-11-15 19:29:16');

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
(1, '08:00:00', '09:00:00', 1, 1),
(2, '09:00:00', '10:00:00', 1, 1),
(3, '10:00:00', '11:00:00', 1, 1),
(4, '11:00:00', '12:00:00', 1, 1),
(5, '08:00:00', '09:00:00', 2, 1),
(6, '09:00:00', '10:00:00', 2, 1),
(7, '10:00:00', '11:00:00', 2, 1),
(8, '11:00:00', '12:00:00', 2, 1),
(9, '08:00:00', '09:00:00', 3, 1),
(10, '09:00:00', '10:00:00', 3, 1),
(11, '10:00:00', '11:00:00', 3, 1),
(12, '11:00:00', '12:00:00', 3, 1);

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
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `time_slot_id` (`time_slot_id`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zone_id` (`zone_id`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slots` (`id`);

--
-- Constraints for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD CONSTRAINT `time_slots_ibfk_1` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
