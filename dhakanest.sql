-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 08:39 AM
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
-- Database: `dhakanest`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `email`, `phone_no`, `password`) VALUES
(100000, 'Faizur', 'Rahim', 'rahim@gmail.com', '+8801712345678', '123'),
(100001, 'Masum', 'Hasan', 'masum@gmail.com', '+8801812345678', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `book_id` int(11) NOT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`book_id`, `check_in_date`, `check_out_date`, `total_price`, `customer_id`, `room_id`) VALUES
(243, '2024-05-18', '2024-06-17', 180000.00, 12, 3),
(244, '2024-05-18', '2024-06-17', 180000.00, 12, 3),
(245, '2024-05-18', '2024-05-21', 18000.00, 12, 3),
(246, '2024-05-18', '2024-06-17', 180000.00, 12, 3),
(247, '2024-05-18', '2024-06-17', 180000.00, 12, 3),
(248, '2024-05-18', '2024-06-17', 126000.00, 12, 3),
(249, '2024-05-18', '2024-06-17', 210000.00, 12, 4),
(250, '2024-05-18', '2024-06-17', 210000.00, 12, 4),
(251, '2024-05-18', '2024-06-17', 210000.00, 12, 4),
(252, '2024-05-18', '2024-06-17', 210000.00, 12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `order_count` int(10) DEFAULT NULL,
  `customer_type` varchar(20) DEFAULT NULL,
  `reg_id` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `email`, `phone_no`, `order_count`, `customer_type`, `reg_id`) VALUES
(12, 'Masum', 'Ahmed', 'ahmed@yahoo.com', '09090922', 9, 'Loyal', 84);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `reg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_id`, `first_name`, `last_name`, `email`, `phone_no`, `address`, `date_of_birth`, `gender`, `password`, `reg_id`) VALUES
(6, 'Jamuna', 'akbar', 'jamuna222@gmail.com', '+8801912345684', 'Badda', '2000-04-04', 'Male', 'jamuna123', 81);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_type`, `total_price`, `status`, `book_id`) VALUES
(20, 'Bkash', 180000.00, 'Paid', 244),
(21, 'Bkash', 18000.00, 'Paid', 245),
(22, 'Bkash', 180000.00, 'Paid', 246),
(23, 'Bkash', 180000.00, 'Paid', 247),
(24, 'Bkash', 126000.00, 'Paid', 248),
(25, 'Bkash', 210000.00, 'Paid', 249),
(26, 'Bkash', 210000.00, 'Paid', 249),
(27, 'Bkash', 210000.00, 'Paid', 252);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `profile_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `reg_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`reg_id`, `first_name`, `last_name`, `email`, `phone_no`, `address`, `date_of_birth`, `gender`, `password`) VALUES
(67, 'dipto', 'kumar', 'kumazrd@gmail.com', '+880191785962', 'Banani', '1990-04-29', 'male', 'dipto969'),
(68, 'Junaid', 'Karim', 'Junaids@gmail.com', '+880191785762', 'Kafrul', '1993-04-29', 'male', 'junaid13'),
(69, 'raisa', 'nowrin', 'nowrin@gmail.com', '+880191785962', 'Bashundhara', '2002-04-29', 'female', 'Nowrin78'),
(70, 'shehreen', 'islam', 'shehreen@gmail.com', '+880191785962', 'Bashundhara', '2000-05-05', 'female', 'shehreen39'),
(72, 'Atiqul', 'Islam', 'atiqul@gmail.com', '+880191785962', 'Mohammadpur', '2001-04-12', 'male', 'atiquil89'),
(73, 'shachyo', 'karim', 'shachyo@gmail.com', '001556958998', 'Kafrul', '2001-05-29', 'male', 'shachyo99'),
(74, 'mikel', 'hasan', 'mikel@gmail.com', '+880191785962', 'Banani', '1990-04-29', 'male', 'mikel67'),
(75, 'Tamim', 'Iqbal', 'tamim@gmail.com', '+880191785962', 'Bashundhara', '1990-04-29', 'male', 'tamim123'),
(76, 'Nasir', 'Hossain', 'nasir@gmail.com', '001556958998', 'Gabtoli', '1990-04-29', 'male', 'nasir54'),
(77, 'Billu', 'akbar', 'billu@gmail.com', '+8801912345684', 'Tikatoli', '2000-04-04', 'male', 'billu345'),
(78, 'Ishmam', 'Hasan', 'ishmam@gmail.com', '+8801912345684', 'Badda', '2000-04-04', 'male', 'ishmam444'),
(79, 'Jamuna', 'akbar', 'jamuna@gmail.com', '+8801912345684', 'Badda', '2000-04-04', 'male', 'jamuna123'),
(80, 'Jamuna', 'akbar', 'akbar@gmail.com', '+8801912345684', 'Badda', '2000-04-04', 'male', 'jamuna123'),
(81, 'Jamuna', 'akbar', 'jamuna222@gmail.com', '+8801912345684', 'Badda', '2000-04-04', 'male', 'jamuna123'),
(82, 'Rejaul', 'Islam', 'reja@gmail.com', '09988900', 'Juginagar', '2000-01-01', 'male', '1234'),
(83, 'Raheeb', 'Rahman', 'raheeb@example.com', '0922982', 'Badda', '2000-01-01', 'male', '4545'),
(84, 'Masum', 'Ahmed', 'ahmed@yahoo.com', '09090922', 'Bashundhara', '2000-01-01', 'male', '5656');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `floor_number` int(11) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `drawing_rooms` int(11) DEFAULT NULL,
  `dining_rooms` int(11) DEFAULT NULL,
  `verandas` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `kitchens` int(11) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `owner_id`, `location`, `floor_number`, `bedrooms`, `drawing_rooms`, `dining_rooms`, `verandas`, `bathrooms`, `kitchens`, `address`, `price`) VALUES
(1, 6, 'Wari', 2, 2, 1, 1, 2, 2, 1, 'Road -1', 9000.00),
(2, 6, 'Tokatoli', 1, 1, 1, 1, 1, 1, 1, 'Road -2', 6000.00),
(3, 6, 'Dhanmondi', 1, 1, 1, 1, 1, 1, 1, 'Road - 2/a', 6000.00),
(4, 6, 'Dhanmondi', 2, 2, 3, 2, 2, 2, 3, 'Road - 5/a', 14000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `fk_customer_id` (`customer_id`),
  ADD KEY `room_ibfk_1` (`room_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_ibfk_1` (`book_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`reg_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `owner_ibfk_1` (`owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100004;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `booking` (`book_id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `profile_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `owner_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
