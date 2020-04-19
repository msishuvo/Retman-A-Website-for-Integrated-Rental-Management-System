-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2018 at 08:37 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `retman`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Levis'),
(2, 'Apex'),
(3, 'Sony'),
(4, 'Apple'),
(5, 'BMW'),
(6, 'Samsung'),
(7, 'Bata'),
(8, 'Activition'),
(9, 'EA Sports'),
(10, 'Marcedes'),
(11, 'Canon'),
(12, 'Onnoprokash'),
(13, 'Ekota'),
(14, 'Mazda'),
(15, 'Chevrolet'),
(16, 'GFC'),
(17, 'Phillips'),
(18, 'RFL'),
(19, 'Ecstasy'),
(20, 'Jupiter'),
(21, 'Panjeri'),
(22, 'Toyota'),
(23, 'Asus');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `shipped`) VALUES
(15, '[{\"id\":\"4\",\"edition\":\"Large\",\"quantity\":\"1\"},{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":2},{\"id\":\"4\",\"edition\":\"Medium\",\"quantity\":\"2\"}]', '2018-05-12 21:16:02', 0, 0),
(16, '[{\"id\":\"4\",\"edition\":\"Medium\",\"quantity\":\"1\"},{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":\"1\"}]', '2018-05-14 08:10:45', 1, 0),
(17, '[{\"id\":\"4\",\"edition\":\"Large\",\"quantity\":\"1\"}]', '2018-05-14 15:23:07', 1, 0),
(18, '[{\"id\":\"4\",\"edition\":\"Medium\",\"quantity\":\"3\"}]', '2018-05-14 15:37:09', 1, 0),
(19, '[{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":\"2\"}]', '2018-05-14 15:52:15', 1, 0),
(20, '[{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":\"2\"},{\"id\":\"4\",\"edition\":\"Medium\",\"quantity\":\"2\"}]', '2018-05-14 21:19:26', 1, 0),
(21, '[{\"id\":\"4\",\"edition\":\"Large\",\"quantity\":2},{\"id\":\"4\",\"edition\":\"Medium\",\"quantity\":\"3\"}]', '2018-05-14 21:22:12', 1, 0),
(22, '[{\"id\":\"4\",\"edition\":\"Medium\",\"quantity\":\"2\"}]', '2018-05-14 21:54:22', 1, 0),
(24, '[{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":\"1\"}]', '2018-05-14 22:33:00', 0, 0),
(26, '[{\"id\":\"4\",\"edition\":\"Medium\",\"quantity\":\"1\"}]', '2018-05-14 22:40:26', 1, 0),
(27, '[{\"id\":\"4\",\"edition\":\"Large\",\"quantity\":\"1\"}]', '2018-05-14 22:48:23', 0, 0),
(28, '[{\"id\":\"4\",\"edition\":\"Large\",\"quantity\":\"1\"}]', '2018-05-14 23:03:04', 1, 0),
(29, '[{\"id\":\"4\",\"edition\":\"Large\",\"quantity\":\"1\"}]', '2018-05-15 00:05:26', 1, 0),
(30, '[{\"id\":\"4\",\"edition\":\"Large\",\"quantity\":\"1\"}]', '2018-05-15 00:17:43', 1, 0),
(31, '[{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":\"1\"}]', '2018-05-15 00:19:52', 1, 0),
(32, '[{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":\"1\"}]', '2018-05-15 00:26:43', 1, 0),
(33, '[{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":\"1\"}]', '2018-05-15 00:28:25', 1, 0),
(34, '[{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":\"1\"}]', '2018-05-15 00:55:59', 1, 0),
(35, '[{\"id\":\"5\",\"edition\":\"2008\",\"quantity\":2},{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":9},{\"id\":\"4\",\"edition\":\"Medium\",\"quantity\":9},{\"id\":\"4\",\"edition\":\"Large\",\"quantity\":\"2\"}]', '2018-05-15 09:14:13', 1, 1),
(38, '[{\"id\":\"6\",\"edition\":\"2016\",\"quantity\":3},{\"id\":\"4\",\"edition\":\"Medium\",\"quantity\":\"1\"},{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":1}]', '2018-05-16 13:39:20', 1, 0),
(39, '[{\"id\":\"6\",\"edition\":\"2016\",\"quantity\":\"1\"}]', '2018-05-17 09:20:58', 0, 0),
(40, '[{\"id\":\"6\",\"edition\":\"2016\",\"quantity\":\"1\"}]', '2018-05-17 13:23:25', 1, 0),
(41, '[{\"id\":\"22\",\"edition\":\"Large\",\"quantity\":\"2\"},{\"id\":\"11\",\"edition\":\"2017\",\"quantity\":\"1\"},{\"id\":\"12\",\"edition\":\"Small\",\"quantity\":\"1\"},{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":\"2\"},{\"id\":\"18\",\"edition\":\"2015\",\"quantity\":\"2\"}]', '2018-05-23 16:33:09', 1, 0),
(42, '[{\"id\":\"19\",\"edition\":\"2009\",\"quantity\":\"1\"},{\"id\":\"16\",\"edition\":\"2018\",\"quantity\":\"1\"}]', '2018-05-23 16:54:16', 1, 0),
(44, '[{\"id\":\"16\",\"edition\":\"2018\",\"quantity\":\"1\"},{\"id\":\"3\",\"edition\":\"2014\",\"quantity\":\"2\"}]', '2018-05-23 17:25:11', 1, 0),
(45, '[{\"id\":\"6\",\"edition\":\"2016\",\"quantity\":\"1\"},{\"id\":\"19\",\"edition\":\"2009\",\"quantity\":\"1\"}]', '2018-05-23 17:40:59', 1, 0),
(46, '[{\"id\":\"10\",\"edition\":\"2016\",\"quantity\":\"1\"}]', '2018-05-23 17:49:22', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Academics', 0),
(2, 'Vehicles', 0),
(3, 'Fashionaries', 0),
(4, 'Accessories', 0),
(5, 'Books', 1),
(6, 'Notes', 1),
(7, 'Researches', 1),
(8, 'Others', 1),
(9, 'Cars', 2),
(10, 'Bikes', 2),
(11, 'Microbuses', 2),
(12, 'Others', 2),
(13, 'Male', 3),
(14, 'Female', 3),
(15, 'Household Accessories', 4),
(16, 'Gadgets', 4),
(17, 'Electronics', 0),
(18, 'Fans', 17),
(19, 'Lights', 17),
(20, 'Khata', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` int(11) NOT NULL DEFAULT '0',
  `editions` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `editions`, `deleted`) VALUES
(3, 'PlayStation4', '20.00', '150.00', 3, '16', '/retman/images/productsecfc645e7685494eb303647b18518a4e.jpg', 'New gaming console. Enjoy !!', 1, '2014:0:3', 0),
(4, 'Levi&#039;s Jeans', '10.00', '30.00', 1, '13', '/retman/images/productsb245564083b0e0d108fc6111e61b47be.png', 'Fully Fit, comfortable jeans.', 0, 'Large:1:2,Medium:2:2', 0),
(5, 'Call of Duty ', '10.00', '50.00', 8, '16', '/retman/images/productsd0ba69717cbf2c0144183c958face090.jpg', 'Best FPS game ever.', 1, '2008:1:2', 0),
(6, 'Canon DSLR', '15.00', '150.00', 11, '16', '/retman/images/products084456c2377ec405dc357b3c1b503228.jpg', 'Capture your precious moments !!!', 1, '2016:1:2', 0),
(7, 'Ebong Himu', '5.00', '10.00', 12, '5', '/retman/images/productsc948d826a4bfedb3d0e5709cf692d15b.jpg', 'Best Book!!', 1, '2013:6:10', 0),
(8, 'Onnodin', '5.00', '20.00', 13, '5', '/retman/images/products675d11ce5b565bdd4e10e28938126019.jpg', 'Best Book!!', 1, '2007:3:6', 0),
(9, 'Private Car', '50.00', '500.00', 5, '9', '/retman/images/productse0813f72c31099a00b92e9a4197a7d69.jpg', 'Best car for travelling !!', 0, '2010:2:3', 0),
(10, 'Mazda Car', '60.00', '700.00', 14, '9', '/retman/images/productsfcb17b73bb980ff087af7cde96736398.jpg', 'Best Sports Car !!', 1, '2016:3:8', 0),
(11, 'Chevrolet Car', '90.00', '1000.00', 15, '9', '/retman/images/productsb7a9c84e62fca9c09bcdecd7933b6d84.jpg', 'Best car for racing !!', 1, '2017:7:9', 0),
(12, 'Stand Fan', '7.00', '20.00', 16, '18', '/retman/images/products0d35f3e0181260755ea7773f404a605d.393c1d5c696fa9eab45a5746332ae20d', 'Best solution in warm weather.', 1, 'Small:3:7', 0),
(13, 'Green Bulb', '3.00', '15.00', 17, '19', '/retman/images/products37784aa7dc007e66b6720843bdebb49f.jpg', 'Use it for decoration !!', 0, 'Medium:5:15', 0),
(14, 'Washing Brush', '2.00', '10.00', 18, '15', '/retman/images/products6c27ed5f4330f980d4a1352e7f6782f5.jpg', 'Washing will be comfortable.', 0, 'Medium:10:15', 0),
(15, 'Baby Dress', '10.00', '35.00', 19, '14', '/retman/images/products45ef6fc1ef2e63b1ab45c7e456a2255e.png', 'Comfortable Dress.', 0, 'Medium:5:6,Large:4:4', 0),
(16, 'All in One Guide Book', '10.00', '30.00', 20, '6', '/retman/images/productsae3f92a73d93887671d7cb4b8c94677a.jpg', 'Best help for a student.', 1, '2018:5:9', 0),
(17, 'Math Guide Book', '10.00', '30.00', 21, '6', '/retman/images/products7abd41e270ced607f1db0bc275cfff3d.jpg', 'Best for Math.', 1, '2016:5:5', 0),
(18, 'Bangla Guide', '10.00', '30.00', 21, '6', '/retman/images/products2c813365c082bebbbe9465e1e1462deb.jpeg', 'For help in Bangla.', 1, '2015:6:8', 0),
(19, 'Hiace Micro', '70.00', '500.00', 22, '11', '/retman/images/products0272fcae571ad8d3b71d0b2be7cd9f07.jpg', 'Best car for Party with friends.', 1, '2009:2:4', 0),
(22, 'Decoration Light', '15.00', '150.00', 17, '19', '/retman/images/products1ead7f3cc35259fab8dd52b9cb39ec2b.jpg,/retman/images/productsc1c173f0d99d62e1d994c08e41e59627.jpg', 'Best for Home Decoration.', 1, 'Large:2:4', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `charge_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `txn_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `charge_id`, `cart_id`, `full_name`, `email`, `phone`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `sub_total`, `tax`, `grand_total`, `description`, `txn_type`, `txn_date`) VALUES
(1, 'ch_1CGoWaIA6XAZe4pKVrONa1lK', 17, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '10.00', '0.15', '10.15', '1 item from Retman.', 'charge', '2018-04-14 19:34:40'),
(2, 'ch_1CGobJIA6XAZe4pKbGShk2Yi', 18, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '30.00', '0.45', '30.45', '3 items from Retman.', 'charge', '2018-04-14 19:39:32'),
(3, '', 19, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '40.00', '0.60', '40.60', '2 items from Retman.', 'cash on delivery', '2018-04-15 01:13:12'),
(4, '', 20, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '60.00', '0.90', '60.90', '4 items from Retman.', 'cash on delivery', '2018-04-15 01:19:45'),
(5, '', 21, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '50.00', '0.75', '50.75', '5 items from Retman.', 'cash on delivery', '2018-04-15 01:24:35'),
(6, 'ch_1CGuVjIA6XAZe4pKW23eiM6n', 22, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '20.00', '0.30', '20.30', '2 items from Retman.', 'charge', '2018-04-15 01:58:09'),
(8, 'ch_1CGvI4IA6XAZe4pKfKXQVd3p', 26, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '10.00', '0.15', '10.15', '1 item from Retman.', 'charge', '2018-04-15 02:48:06'),
(13, 'ch_1CGwiFIA6XAZe4pKEL6D6s8H', 30, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '10.00', '0.15', '10.15', '1 item from Retman.', 'charge', '2018-04-15 04:19:14'),
(16, '', 33, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'daw', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '20.00', '0.30', '20.30', '1 item from Retman.', 'cash on delivery', '2018-04-15 04:53:46'),
(17, '', 34, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '20.00', '0.30', '20.30', '1 item from Retman.', 'cash on delivery', '2018-04-15 05:11:59'),
(18, '', 35, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '310.00', '4.65', '314.65', '22 items from Retman.', 'cash on delivery', '2018-04-15 13:19:42'),
(19, 'ch_1CHocWIA6XAZe4pKEBbc7hyf', 38, 'Ronaldo', 'cr7@rma.com', '', 'Madrid', 'Road', 'Madrid', 'North', '1234', 'Spain', '75.00', '1.13', '76.13', '5 items from Retman.', 'charge', '2018-04-17 13:52:54'),
(20, 'ch_1CHrwhIA6XAZe4pK270Uupgc', 40, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '15.00', '0.23', '15.23', '1 item from Retman.', 'charge', '2018-04-17 17:26:02'),
(21, '', 41, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '187.00', '2.81', '189.81', '8 items from Retman.', 'cash on delivery', '2018-04-23 20:40:28'),
(22, 'ch_1CK644IA6XAZe4pKM5GuWfWM', 42, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '80.00', '1.20', '81.20', '2 items from Retman.', 'charge', '2018-04-23 20:54:49'),
(23, '', 44, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '50.00', '0.75', '50.75', '3 items from Retman.', 'cash on delivery', '2018-04-23 21:26:00'),
(24, '', 45, 'Shuvo', 'si_shuvo95@yahoo.com', '', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '85.00', '1.28', '86.28', '2 items from Retman.', 'cash on delivery', '2018-04-23 21:41:21'),
(25, '', 46, 'Shuvo', 'si_shuvo95@yahoo.com', '01521434794', 'Manikdi', 'Cantonment', 'Dhaka', 'Dhaka', '1206', 'Bangladesh', '60.00', '0.90', '60.90', '1 item from Retman.', 'cash on delivery', '2018-04-23 21:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'Shafiqul Islam', 'si_shuvo95@yahoo.com', '$2y$10$conbeZ2cHUwUpQha8QvtM.zoGgtkAz11a0Cply0KvTbRJyY9mAoyq', '2018-04-03 22:45:38', '2018-04-23 16:51:10', 'admin,user'),
(5, 'Cristiano Ronaldo', 'cr7@rma.com', '$2y$10$WCajSNWCTjMdI5jS.JF42.hVp10JtdChh3a/V1xffRz2RkiWD.1Fu', '2018-04-16 04:40:24', '2018-04-17 09:50:22', 'user'),
(6, 'Lionel Messi', 'lm10@fcb.com', '$2y$10$2Wa5ARh914LZIYrh6kMxGu06EaJRsMe4A6ulVghs5q6EryIcjU7E.', '2018-04-16 05:01:27', '2018-04-16 03:38:07', 'user'),
(7, 'Sergio Ramos', 'sr4@rma.com', '$2y$10$6rDYKYftTdKZp2wswWPKueCtvhGs/doRYT3HeZtEa0AAQsX28.cCi', '2018-04-16 05:06:20', '2018-04-16 13:47:02', 'user'),
(9, 'Brad Pitt', 'bp@hollywood.com', '$2y$10$dZh2YNnCUUm54UUXG31pGejZcaD7qmOpI6BrhImbBUo03FLabpXmi', '2018-04-16 05:13:04', '2018-04-16 01:13:33', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
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
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
