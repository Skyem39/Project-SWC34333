-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 02:59 PM
-- Server version: 8.0.40
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotelbookingdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `customer_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `room_number` int NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `guests` int NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `total_payment` decimal(10,2) NOT NULL,
  `special_request` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_name`, `room_number`, `room_type`, `guests`, `check_in_date`, `check_out_date`, `total_payment`, `special_request`) VALUES
(2, 'Mo Salah', 7, 'standard', 2, '2024-11-18', '2024-11-22', 440.00, 'Bantal peluk'),
(4, 'Amir Zalhasmi', 51, 'deluxe', 2, '2024-11-18', '2024-11-20', 440.00, 'Tiada'),
(5, 'Arif Hakim', 1, 'standard', 1, '2024-11-18', '2024-11-20', 220.00, 'Tiada'),
(11, 'Luis Diaz', 7, 'standard', 1, '2024-11-18', '2024-11-19', 110.00, 'Tiada'),
(12, 'John Kazim', 56, 'deluxe', 1, '2024-11-18', '2024-11-22', 880.00, 'Bawak luggage. Terima kasih'),
(13, 'Sara', 134, 'executive', 1, '2024-11-18', '2024-11-21', 1050.00, 'Selimut lebih'),
(14, 'Jennie', 6, 'standard', 1, '2024-11-21', '2024-11-23', 220.00, 'Tiada');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
