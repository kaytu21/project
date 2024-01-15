-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2023 at 06:22 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `efms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$V0JURNC3IYELq1wUAqCD1udJL9gcM6DMftaeehjf.Ed.8MpI417o2');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(255) NOT NULL,
  `water_level` double NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time(6) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `water_level`, `date`, `time`) VALUES
(1, 1.4, '2023-01-02', '17:50:13.000000'),
(2, 2, '2023-02-02', '18:07:41.000000'),
(3, 2.2, '2023-03-03', '18:08:10.000000'),
(4, 2.1, '2023-04-04', '18:13:49.000000'),
(6, 2.3, '2023-05-05', '18:44:56.000000'),
(7, 2, '2023-06-06', '06:05:13.000000'),
(8, 3.2, '2023-07-07', '07:46:54.000000'),
(9, 2.2, '2023-08-08', '13:11:34.000000'),
(10, 2.5, '2023-09-09', '13:12:48.000000'),
(11, 2.6, '2023-10-06', '13:13:36.000000'),
(12, 2.8, '2023-11-01', '15:13:14.000000'),
(13, 2.7, '2023-12-01', '15:15:44.000000'),
(14, 2.8, '2023-12-02', '15:16:33.000000'),
(15, 3.2, '2023-12-03', '15:16:58.000000'),
(16, 2.7, '2024-01-01', '15:18:15.000000'),
(17, 2, '2024-01-02', '15:19:11.000000'),
(18, 2.9, '2024-02-01', '15:28:07.000000'),
(19, 2.8, '2024-03-01', '15:28:23.000000'),
(20, 2.5, '2024-04-01', '15:30:17.000000'),
(21, 2.2, '2024-05-01', '15:30:34.000000'),
(22, 2.1, '2024-06-07', '15:30:50.000000'),
(23, 1.6, '2024-07-01', '15:31:09.000000'),
(24, 1.4, '2024-08-01', '20:51:11.000000');

-- --------------------------------------------------------

--
-- Table structure for table `phonenumber`
--

CREATE TABLE `phonenumber` (
  `id` int(255) NOT NULL,
  `number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phonenumber`
--

INSERT INTO `phonenumber` (`id`, `number`) VALUES
(2, '09165261138'),
(3, '09632434651'),
(4, '09632434652'),
(8, '09165261139'),
(10, '09632434651'),
(11, '09632434651'),
(12, '09632434651');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phonenumber`
--
ALTER TABLE `phonenumber`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `phonenumber`
--
ALTER TABLE `phonenumber`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
