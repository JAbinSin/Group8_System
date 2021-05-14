-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2021 at 12:53 AM
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
  `item` int(25) NOT NULL COMMENT 'int(25)\r\nFor id',
  `quantity` int(25) NOT NULL COMMENT 'int(25)',
  `price` int(25) NOT NULL COMMENT 'int(25)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(12, 'Pizza', 'The Best Family Pizza', '100.00', '12_picture.jpg'),
(13, 'Siopao', 'Asado', '20.00', '13_picture.jpg');

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
(5, 'zate', 'niemo', 'LoliShlong', '$2y$10$uxyfbkAwItGq.g6RQ0tXJ.ArB3UHnb.Ud5yFQ1NcGqAN4QPneB9vq', 'exmapleqwe@email.com', '09123231432', '5_profile.jpg', 'client'),
(6, 'testing', 'master', 'user123123', '$2y$10$yoRKELcTsVZD9j/V0qg2GOdvzhruXAFABf6Ju2htMN/JJieTyhuP2', 'kdsofksdokso@wekofdksf', '09123123423', 'default.png', 'client'),
(7, 'Severino', 'Norbert', 'admin123123', '$2y$10$wKj6Gjq0gvWW3yCHPXcdNuMq8M7LlCfWm9tq3tFo7XSsNBdYdeXT2', 'admin@admin123', '11111111110', 'default.png', 'admin');

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
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'int(25)';

--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'int(25)', AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'int(25)', AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
