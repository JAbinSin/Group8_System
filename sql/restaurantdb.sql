-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2021 at 03:57 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurantdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_history`
--

CREATE TABLE `tbl_history` (
  `id` int(25) NOT NULL COMMENT 'int(25)',
  `user` int(25) NOT NULL COMMENT 'int(25)\r\nFor id',
  `picture` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `name` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `item` int(25) NOT NULL COMMENT 'int(25)\r\nFor id',
  `quantity` int(25) NOT NULL COMMENT 'int(25)',
  `price` decimal(11,2) NOT NULL COMMENT 'decimal(11,2)',
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `order_id` int(25) NOT NULL COMMENT 'int(25)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_history`
--

INSERT INTO `tbl_history` (`id`, `user`, `picture`, `name`, `item`, `quantity`, `price`, `time`, `status`, `order_id`) VALUES
(84, 6, '11_picture.jpg', 'Burger', 11, 1, '35.00', '2021-05-18 16:58:54', 'pending', 1),
(85, 6, '10_picture.jpg', 'Siomai', 10, 1, '20.00', '2021-05-18 16:58:54', 'pending', 1),
(86, 6, '12_picture.jpg', 'Pizza', 12, 1, '100.00', '2021-05-18 16:58:54', 'pending', 1),
(87, 6, '10_picture.jpg', 'Siomai', 10, 1, '20.00', '2021-05-18 23:41:07', 'pending', 2),
(88, 6, '11_picture.jpg', 'Burger', 11, 1, '35.00', '2021-05-18 23:41:07', 'pending', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `id` int(25) NOT NULL COMMENT 'int(25)',
  `name` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `description` text NOT NULL COMMENT 'text',
  `price` decimal(11,2) NOT NULL COMMENT 'decimal(11,2)',
  `picture` varchar(255) NOT NULL DEFAULT 'default.png' COMMENT 'varchar(255)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id`, `name`, `description`, `price`, `picture`) VALUES
(8, 'Hotdog', 'Masarap na Hotdog Mainit-init at magulay pa', '25.00', '8_picture.jpg'),
(10, 'Siomai', 'Pork Siomai Na may Chili Sauce', '20.00', '10_picture.jpg'),
(11, 'Burger', 'The Best Burger in Town', '35.00', '11_picture.jpg'),
(12, 'Pizza', 'The Best Family Pizza', '100.00', '12_picture.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(25) NOT NULL COMMENT 'int(25)',
  `first_name` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `last_name` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `username` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `password` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `email` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `phone_number` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `profile_picture` varchar(255) NOT NULL DEFAULT 'default.png' COMMENT 'varchar(255)',
  `user_type` varchar(255) NOT NULL COMMENT 'varchar(255)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `profile_picture`, `user_type`) VALUES
(6, 'boop', 'beep', 'user123123', '$2y$10$yoRKELcTsVZD9j/V0qg2GOdvzhruXAFABf6Ju2htMN/JJieTyhuP2', 'kdsofksdokso@wekofdksfl', '09123123123', '6_profile.jpg', 'client'),
(7, 'Severino', 'Norbert', 'admin123123', '$2y$10$wKj6Gjq0gvWW3yCHPXcdNuMq8M7LlCfWm9tq3tFo7XSsNBdYdeXT2', 'admin@admin123', '11111111110', 'default.png', 'admin'),
(8, 'Leonardo', 'Da Vinci', 'LeonardoDaVinci', '$2y$10$h30oCJbperkS3EVjHHeHdeDCiNFrPIhSLvEvf9/j53qfnFesN/WCO', 'leonardodavinci123@gmai.com', '09333059211', 'default.png', 'client'),
(9, 'Severino', 'Norbert', 'admin', '$2y$10$qd9wmNeI4YuW1VOje7rE7.MovFYmGBSSg7q4K5fd2AP0z19zwawcK', 'admin@admin', '11111111111', 'default.png', 'admin'),
(10, 'Severino', 'Norbert', 'admin123456', '$2y$10$h.VvajekjcYOMrqlJ6clRuSl6TOb8qFu8C9eO73jh7QjlvqeBn9wy', 'admin123456@admin', '11111123421', 'default.png', 'admin'),
(11, 'booper', 'beeper', 'BooperBeeper', '$2y$10$A9CJCeq0IxxRgLEH5BNvROPmwbBRMscnwA4GWyYyr6zb8U3HASwAe', 'boop@beeper.com', '12392371845', 'default.png', 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_history`
--
ALTER TABLE `tbl_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_history`
--
ALTER TABLE `tbl_history`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'int(25)', AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'int(25)', AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'int(25)', AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
 
