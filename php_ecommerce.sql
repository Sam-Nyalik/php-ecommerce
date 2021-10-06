-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 06, 2021 at 10:39 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationDate` datetime DEFAULT current_timestamp(),
  `updationDate` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `profileImage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullName`, `emailAddress`, `gender`, `password`, `creationDate`, `updationDate`, `profileImage`) VALUES
(4, 'Sam Junior', 'samjunior@gmail.com', 'Male', '$2y$10$rzXfdbYaAsIegNxt1zWsfOOkp8gQuh2x2uNBcnXZQLFgy.mqJFVga', '2021-09-18 15:32:25', '2021-10-06 23:33:18', 'administrator/profileImages/IMG_20210629_005001_716.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `all_products`
--

CREATE TABLE `all_products` (
  `id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productDescription` text NOT NULL,
  `productType` varchar(50) NOT NULL,
  `productBrand` varchar(50) NOT NULL,
  `productRetailPrice` decimal(7,2) DEFAULT 0.00,
  `productPrice` decimal(7,2) NOT NULL,
  `productQuantity` int(11) NOT NULL,
  `productImage` text NOT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `all_products`
--

INSERT INTO `all_products` (`id`, `productName`, `productDescription`, `productType`, `productBrand`, `productRetailPrice`, `productPrice`, `productQuantity`, `productImage`, `date_added`, `updation_date`) VALUES
(1, 'iphone x', 'This is an iphone x', 'Mobile Phone', 'Apple', '1000.00', '850.00', 30, 'administrator/allProductImages/image7.jpg', '2021-09-10 16:08:36', '2021-09-11 16:18:14'),
(3, 'Samsung s21', 'This is a Samsung s21', 'Mobile Phone', 'Samsung', '1100.00', '550.00', 20, 'administrator/allProductImages/image5.jpg', '2021-09-10 16:15:41', '2021-09-10 22:21:37'),
(8, 'Huawei Mate', 'This is a Huawei Mate 30', 'Mobile Phone', 'Huawei', '880.00', '450.00', 10, 'administrator/allProductImages/image13.jpg', '2021-09-10 23:10:12', '2021-09-19 16:34:17'),
(9, 'HP Envy', 'HP Envy Laptop 4', 'Laptop', 'HP', '650.00', '350.00', 10, 'administrator/allProductImages/image8.jpg', '2021-09-11 15:09:31', '2021-09-12 22:39:00'),
(10, 'Samsung s20', 'This is a Samsung s20', 'Mobile Phone', 'Samsung', '880.00', '740.00', 8, 'administrator/allProductImages/image15.jpg', '2021-09-11 15:41:23', NULL),
(11, 'Dell Alienware', 'Dell Alienware 17 is a Windows 10 Home laptop with a 17.30-inch display that has a resolution of 1920x1080 pixels. It is powered by a Core i7 processor and it comes with 16GB of RAM. The Dell Alienware 17 packs 1TB of HDD storage. Graphics are powered by Intel Integrated Integrated Graphics 5500.', 'Laptop', 'Dell', '1500.00', '1350.00', 15, 'administrator/allProductImages/image18.jpg', '2021-09-11 16:39:42', '2021-09-12 22:40:41'),
(12, 'Macbook Pro', 'Apple MacBook Pro is a macOS laptop with a 13.30-inch display that has a resolution of 2560x1600 pixels. It is powered by a Core i5 processor and it comes with 12GB of RAM. The Apple MacBook Pro packs 512GB of SSD storage.', 'Laptop', 'Apple', '1150.00', '900.00', 10, 'administrator/allProductImages/image20.jpg', '2021-09-12 22:42:36', '2021-09-13 23:50:34'),
(13, 'iphone 12', 'The iPhone 12 features a 6.1-inch (15 cm) display with Super Retina XDR OLED technology at a resolution of 2532×1170 pixels and a pixel density of about 460 ppi. The iPhone 12 Mini features a 5.4-inch (14 cm) display with the same technology at a resolution of 2340×1080 pixels and a pixel density of about 476 ppi.', 'Mobile Phone', 'Apple', '1200.00', '980.00', 12, 'administrator/allProductImages/image21.jpg', '2021-09-15 08:37:28', NULL),
(14, 'airpods', 'Comfort earbuds', 'earbuds', 'Apple', '200.00', '150.00', 10, 'administrator/allProductImages/daniel-romero-AgLMrojqjAM-unsplash.jpg', '2021-09-19 16:32:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contact_queries`
--

CREATE TABLE `contact_queries` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` longtext NOT NULL,
  `posting_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `admin_response` longtext DEFAULT NULL,
  `is_read` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `main_advertisement`
--

CREATE TABLE `main_advertisement` (
  `id` int(11) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `productDescription` text NOT NULL,
  `productType` varchar(50) NOT NULL,
  `productBrand` varchar(50) NOT NULL,
  `productRetailPrice` decimal(7,2) DEFAULT 0.00,
  `productPrice` decimal(7,2) NOT NULL,
  `productQuantity` int(11) NOT NULL,
  `productImage` text NOT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_advertisement`
--

INSERT INTO `main_advertisement` (`id`, `productName`, `productDescription`, `productType`, `productBrand`, `productRetailPrice`, `productPrice`, `productQuantity`, `productImage`, `date_added`, `updation_date`) VALUES
(6, 'HP Envy', 'hp envy', 'Laptop', 'HP', '950.00', '750.00', 10, 'administrator/allProductImages/image8.jpg', '2021-09-17 22:35:09', '2021-09-18 22:52:41'),
(7, 'Macbook Pro', 'Macbook pro', 'Laptop', 'Apple', '1550.00', '1050.00', 5, 'administrator/allProductImages/image4.jpg', '2021-09-17 22:42:59', '2021-09-18 22:51:28'),
(8, 'iphone SE 2', 'The iPhone SE appears to feature the same 4.7-inch display that was used in the iPhone 8 with a resolution of 1334 by 750 with 326 pixels per inch and a 1400:1 contrast ratio. It features multi-touch capabilities, P3 wide color support for rich, true-to-life colors, and 625 nits max brightness.', 'Mobile Phone', 'Apple', '550.00', '350.00', 10, 'administrator/allProductImages/image22.jpg', '2021-09-18 22:44:53', '2021-09-18 22:50:40');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscription`
--

CREATE TABLE `newsletter_subscription` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dateAdded` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` int(100) NOT NULL,
  `firstName` varchar(200) NOT NULL,
  `lastName` varchar(200) NOT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `phoneNumber` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_grand_price` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_brands`
--

CREATE TABLE `product_brands` (
  `id` int(11) NOT NULL,
  `productBrand` varchar(50) NOT NULL,
  `dateAdded` datetime DEFAULT current_timestamp(),
  `updationDate` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_brands`
--

INSERT INTO `product_brands` (`id`, `productBrand`, `dateAdded`, `updationDate`) VALUES
(1, 'Apple', '2021-09-09 22:15:19', NULL),
(2, 'Samsung', '2021-09-09 22:16:03', NULL),
(3, 'Huawei', '2021-09-09 22:16:16', NULL),
(4, 'Dell', '2021-09-09 22:16:28', NULL),
(5, 'HP', '2021-09-09 22:16:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` int(11) NOT NULL,
  `productType` varchar(50) NOT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `productType`, `date_added`, `updation_date`) VALUES
(4, 'Laptop', '2021-09-09 14:45:52', NULL),
(5, 'Mobile Phone', '2021-09-09 14:46:06', NULL),
(6, 'earbuds', '2021-09-19 16:28:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`id`, `name`, `date_added`, `updation_date`) VALUES
(1, 'Nairobi', '2021-09-26 16:27:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(200) NOT NULL,
  `lastName` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phoneNumber` int(50) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `password` varchar(255) NOT NULL,
  `success` varchar(100) DEFAULT 'NULL',
  `userIP` binary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_products`
--
ALTER TABLE `all_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_queries`
--
ALTER TABLE `contact_queries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `main_advertisement`
--
ALTER TABLE `main_advertisement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscription`
--
ALTER TABLE `newsletter_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_brands`
--
ALTER TABLE `product_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `all_products`
--
ALTER TABLE `all_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_queries`
--
ALTER TABLE `contact_queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_advertisement`
--
ALTER TABLE `main_advertisement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `newsletter_subscription`
--
ALTER TABLE `newsletter_subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_brands`
--
ALTER TABLE `product_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
