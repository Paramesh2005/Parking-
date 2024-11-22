-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2020 at 02:51 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `rate`) VALUES
(1, 'Car', 50),
(2, 'Motorcycle', 35),
(3, 'Sample vehicle', 50),
(4, 'Vehicle type2', 70);

-- --------------------------------------------------------

--
-- Table structure for table `parked_list`
--

CREATE TABLE `parked_list` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `location_id` int(30) NOT NULL,
  `ref_no` varchar(100) NOT NULL,
  `vehicle_brand` varchar(200) NOT NULL,
  `vehicle_registration` varchar(15) NOT NULL,
  `owner` text NOT NULL,
  `vehicle_description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=in, 2= out',
  `amount_due` double NOT NULL,
  `amount_tendered` double NOT NULL,
  `amount_change` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parked_list`
--

INSERT INTO `parked_list` (`id`, `category_id`, `location_id`, `ref_no`, `vehicle_brand`, `vehicle_registration`, `owner`, `vehicle_description`, `status`, `amount_due`, `amount_tendered`, `amount_change`, `date_created`) VALUES
(3, 1, 1, '5020555486', 'Ford Mustang', 'CDM-0623', 'John Smith', 'Black', 1, 0, 0, 0, '2020-10-02 11:38:57'),
(5, 1, 1, '4970885858', 'Fortuner', 'GCN-1514', 'Claire Blake', 'White', 2, 137.5, 150, 12.5, '2020-10-02 12:09:10'),
(6, 1, 1, '9428140638', 'Sample', 'WER-7894', 'Sample Only', 'Sample', 2, 123.33333333333, 150, 26.67, '2020-10-02 12:09:56'),
(7, 2, 2, '4033430792', 'asdasdasd', 'qwa-1234', 'ada asd asd', 'asdasda', 1, 0, 0, 0, '2020-10-02 16:26:27'),
(8, 3, 3, '3599556075', 'Sample', 'GCN-2020', 'Sample Only', 'White ', 2, 3.3333333333333, 50, 46.67, '2020-10-03 08:20:22'),
(9, 4, 4, '4099773928', 'Sample', 'ABC-1234', 'George Wilson', 'Black Vehicle', 2, 1.1666666666667, 5, 3.83, '2020-10-03 08:28:44');

-- --------------------------------------------------------

--
-- Table structure for table `parking_locations`
--

CREATE TABLE `parking_locations` (
  `id` int(30) NOT NULL,
  `location` text NOT NULL,
  `capacity` int(11) NOT NULL,
  `category_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parking_locations`
--

INSERT INTO `parking_locations` (`id`, `location`, `capacity`, `category_id`) VALUES
(1, 'Car Area 1', 10, 1),
(2, 'Area 1', 30, 2),
(3, 'Sample area', 20, 3),
(4, 'Area Block 23', 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `parking_movement`
--

CREATE TABLE `parking_movement` (
  `id` int(30) NOT NULL,
  `pl_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = in ,2 = out',
  `created_timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parking_movement`
--

INSERT INTO `parking_movement` (`id`, `pl_id`, `status`, `created_timestamp`) VALUES
(1, 2, 1, '2020-10-02 11:13:19'),
(2, 3, 1, '2020-10-02 11:31:41'),
(3, 4, 1, '2020-10-02 11:39:37'),
(4, 5, 1, '2020-10-02 12:09:10'),
(5, 6, 1, '2020-10-02 12:09:56'),
(6, 6, 2, '2020-10-02 14:37:00'),
(7, 5, 2, '2020-10-02 14:54:00'),
(8, 7, 1, '2020-10-02 16:26:27'),
(9, 8, 1, '2020-10-03 08:20:22'),
(11, 8, 2, '2020-10-03 08:24:00'),
(12, 9, 1, '2020-10-03 08:28:44'),
(13, 9, 2, '2020-10-03 08:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 2 COMMENT '1 = Admin, 2= staff',
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `type`, `username`, `password`) VALUES
(1, 'Administrator', 1, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parked_list`
--
ALTER TABLE `parked_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking_locations`
--
ALTER TABLE `parking_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking_movement`
--
ALTER TABLE `parking_movement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parked_list`
--
ALTER TABLE `parked_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `parking_locations`
--
ALTER TABLE `parking_locations`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parking_movement`
--
ALTER TABLE `parking_movement`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
