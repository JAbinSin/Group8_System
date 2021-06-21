-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2021 at 05:24 PM
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
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(25) NOT NULL COMMENT 'int(25)',
  `name` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `category_picture` varchar(255) NOT NULL DEFAULT 'default.png' COMMENT 'varchar(255)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `name`, `category_picture`) VALUES
(1, 'Hotdog', '1_picture.jpg'),
(2, 'Pizza', '2_picture.png'),
(3, 'Burger', '3_picture.jpg'),
(4, 'Rice Meal', '4_picture.jpeg'),
(10, 'All', 'default.png');

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
(116, 7, '61_picture.jpg', 'Korean Corn Dog', 61, 1, '30.00', '2021-06-08 16:52:26', 'pending', 1),
(117, 7, '60_picture.jpg', 'Chili Dog', 60, 1, '50.00', '2021-06-08 16:53:54', 'pending', 2),
(118, 7, '62_picture.jpg', 'Sonora Hotdog', 62, 1, '50.00', '2021-06-08 17:41:07', 'pending', 3),
(119, 6, '62_picture.jpg', 'Sonora Hotdog', 62, 1, '50.00', '2021-06-08 17:44:45', 'pending', 4),
(120, 6, '61_picture.jpg', 'Korean Corn Dog', 61, 1, '30.00', '2021-06-08 17:44:58', 'pending', 5),
(121, 6, '30_picture.jpg', 'Kimchi Rice', 30, 1, '50.00', '2021-06-15 14:47:51', 'pending', 6),
(122, 6, '62_picture.jpg', 'Sonora Hotdog', 62, 1, '50.00', '2021-06-15 14:47:51', 'pending', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `id` int(25) NOT NULL COMMENT 'int(25)',
  `name` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `description` text NOT NULL COMMENT 'text',
  `price` decimal(11,2) NOT NULL COMMENT 'decimal(11,2)',
  `picture` varchar(255) NOT NULL DEFAULT 'default.png' COMMENT 'varchar(255)',
  `category` varchar(255) NOT NULL COMMENT 'varchar(255)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id`, `name`, `description`, `price`, `picture`, `category`) VALUES
(30, 'Kimchi Rice', 'Made From Korea\r\nAuthentic Cuisine', '50.00', '30_picture.jpg', 'Rice Meal'),
(60, 'Chili Dog', 'American classic chili dog, grilled hot dog on a bun, smothered in ground beef chili sauce, sprinkled with cheddar cheese and onions.', '50.00', '60_picture.jpg', 'Hotdog'),
(61, 'Korean Corn Dog', 'Korean corn dogs are hot dogs, rice cakes, fish cakes, or mozzarella cheese coated in a batter (and sometimes panko, french fry pieces, or ramen) and deep fried.', '30.00', '61_picture.jpg', 'Hotdog'),
(62, 'Sonora Hotdog', 'A hot dog that is wrapped in bacon and grilled, served on a bolillo-style hot dog bun, and topped with pinto beans, onions, tomatoes, and a variety of additional condiments, often including mayonnaise, mustard, and jalape&#195;&#177;o salsa.', '50.00', '62_picture.jpg', 'Hotdog'),
(64, 'Peperoni Pizza', 'American Style Pizza', '100.00', '64_picture.jpg', 'Pizza');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(25) NOT NULL COMMENT 'int(25)',
  `first_name` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `last_name` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `username` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `address` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `city` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `region` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `zip_code` int(25) NOT NULL COMMENT 'int(25)',
  `password` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `email` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `phone_number` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `profile_picture` varchar(255) NOT NULL DEFAULT 'default.png' COMMENT 'varchar(255)',
  `user_type` varchar(255) NOT NULL COMMENT 'varchar(255)',
  `validated` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'varchar(255)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `first_name`, `last_name`, `username`, `address`, `city`, `region`, `zip_code`, `password`, `email`, `phone_number`, `profile_picture`, `user_type`, `validated`) VALUES
(6, 'Kizuna', 'Ai', 'user123123', 'Malakas Street.', 'taytay', 'rizal', 1870, '$2y$10$yoRKELcTsVZD9j/V0qg2GOdvzhruXAFABf6Ju2htMN/JJieTyhuP2', 'kdsofksdokso@wekofdksfl.com', '09123123123', '6_profile.jpg', 'client', 'yes'),
(7, 'Severino', 'Norbert', 'admin123123', 'yatyat', '', '', 2, '$2y$10$wKj6Gjq0gvWW3yCHPXcdNuMq8M7LlCfWm9tq3tFo7XSsNBdYdeXT2', 'admin@admin123', '11111111110', 'default.png', 'admin', 'no'),
(9, 'Severino', 'Norbert', 'admin', 'moscow', '', '', 4, '$2y$10$qd9wmNeI4YuW1VOje7rE7.MovFYmGBSSg7q4K5fd2AP0z19zwawcK', 'admin@admin', '11111111111', 'default.png', 'admin', 'no'),
(10, 'Severino', 'Norbert', 'admin123456', 'bangtan', '', '', 5, '$2y$10$h.VvajekjcYOMrqlJ6clRuSl6TOb8qFu8C9eO73jh7QjlvqeBn9wy', 'admin123456@admin', '11111123421', 'default.png', 'admin', 'no'),
(14, 'DD', 'Dalida', 'MinroDDD', 'seoul', '', '', 6, '$2y$10$PmIreiTCAEC34vrwbN72e.TYuDY0PylQHgkG1su6kk87zdiTqTYgG', 'gwapoako@gmail.com', '09099999556', 'default.png', 'client', 'no'),
(17, 'Mofu', 'Shesh', 'TheOneTheTwoTheThree', 'rizal', '', '', 9, '$2y$10$vv8a9nL..aXzG8Ycin0gjuJmVgAJv3.GCzdVGfc7RB5YbuwgRncne', 'marcoliver0924@gmail.com', '09164172182', 'default.png', 'client', 'no'),
(18, 'Sarah', 'Fortune', 'ButasMan', 'Demonyo Land', '', '', 1800, '$2y$10$WsXAI/k8ATbGWfCBkdHh5O3rTZrp5INNQl35GctvHS7MqTtIzt/TW', 'Fortune@butasmail.com', '12312312312', '18_profile.png', 'client', 'no'),
(19, 'Aaron', 'Arriola', 'YokoiRima', '69titikomalake', '', '', 1600, '$2y$10$C24sQp6bLKNSP.s9ZkyMVeoqqnDXoLsOvMsdu/2fLv89.6pHYV64u', 'ughugh@gmail.com', '12345678901', 'default.png', 'client', 'no'),
(22, 'Trafalgar D', 'Law', 'JullieBee', 'Jollibee Cainta', '', '', 8700, '$2y$10$leIMmgOZ..IAepYbUV94GO3lfB9KNsoZzlidSnIgBAIyjp1JThKzS', 'TDWL@gmail.com', '87000000000', '22_profile.jpg', 'client', 'no'),
(24, 'aaron', 'arriola', 'michaeng', 'putakadyyanyon', '', '', 1234, '$2y$10$lGMu5JzlbMauipoVgDdD8utXGgLxLpMSKRuErmUdYUSmeBTSZCc8y', 'michaeng@gmail.com', '90909090909', '24_profile.jpeg', 'client', 'no'),
(25, 'ughh', 'hhgu', 'ughhhhhhhh', '123333', '', '', 911, '$2y$10$iWOP7eU2e6dPfCWT8KXqQ.to40Bttlm5xC2dO0V9szkLqVzAPO1Fu', 'ughh@gamil.com', '12121211212', 'default.png', 'client', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'int(25)', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_history`
--
ALTER TABLE `tbl_history`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'int(25)', AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'int(25)', AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'int(25)', AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
