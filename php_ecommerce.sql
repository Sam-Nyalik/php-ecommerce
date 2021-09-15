-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 15, 2021 at 08:51 AM
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
  `updationDate` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullName`, `emailAddress`, `gender`, `password`, `creationDate`, `updationDate`) VALUES
(1, 'Sam Nyalik', 'samjunior@gmail.com', 'Male', '$2y$10$XPPOnIByK0gAnnVDA6rcieS9bgHiTr6l.kAlLRgdhSWmXtvnhJAXG', '2021-08-27 11:37:35', '2021-09-11 16:52:18');

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
(8, 'Huawei Mate 30', 'This is a Huawei Mate 30', 'Mobile Phone', 'Huawei', '880.00', '450.00', 10, 'administrator/allProductImages/image13.jpg', '2021-09-10 23:10:12', NULL),
(9, 'HP Envy', 'HP Envy Laptop 4', 'Laptop', 'HP', '650.00', '350.00', 10, 'administrator/allProductImages/image8.jpg', '2021-09-11 15:09:31', '2021-09-12 22:39:00'),
(10, 'Samsung s20', 'This is a Samsung s20', 'Mobile Phone', 'Samsung', '880.00', '740.00', 8, 'administrator/allProductImages/image15.jpg', '2021-09-11 15:41:23', NULL),
(11, 'Dell Alienware', 'Dell Alienware 17 is a Windows 10 Home laptop with a 17.30-inch display that has a resolution of 1920x1080 pixels. It is powered by a Core i7 processor and it comes with 16GB of RAM. The Dell Alienware 17 packs 1TB of HDD storage. Graphics are powered by Intel Integrated Integrated Graphics 5500.', 'Laptop', 'Dell', '1500.00', '1350.00', 15, 'administrator/allProductImages/image18.jpg', '2021-09-11 16:39:42', '2021-09-12 22:40:41'),
(12, 'Macbook Pro', 'Apple MacBook Pro is a macOS laptop with a 13.30-inch display that has a resolution of 2560x1600 pixels. It is powered by a Core i5 processor and it comes with 12GB of RAM. The Apple MacBook Pro packs 512GB of SSD storage.', 'Laptop', 'Apple', '1150.00', '900.00', 10, 'administrator/allProductImages/image20.jpg', '2021-09-12 22:42:36', '2021-09-13 23:50:34'),
(13, 'iphone 12', 'The iPhone 12 features a 6.1-inch (15 cm) display with Super Retina XDR OLED technology at a resolution of 2532×1170 pixels and a pixel density of about 460 ppi. The iPhone 12 Mini features a 5.4-inch (14 cm) display with the same technology at a resolution of 2340×1080 pixels and a pixel density of about 476 ppi.', 'Mobile Phone', 'Apple', '1200.00', '980.00', 12, 'administrator/allProductImages/image21.jpg', '2021-09-15 08:37:28', NULL);

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

--
-- Dumping data for table `contact_queries`
--

INSERT INTO `contact_queries` (`id`, `firstName`, `lastName`, `email`, `subject`, `message`, `posting_date`, `updation_date`, `admin_response`, `is_read`) VALUES
(1, 'John', 'Doe', 'johndoe@gmail.com', 'Website Enquiry', 'How did you make this?', '2021-09-07 15:37:33', NULL, NULL, NULL),
(2, 'zinzi', 'nyalk', 'znyalik@gmail.com', 'swiss', 'id like to suck some dick', '2021-09-09 14:04:11', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `main_advertisement`
--

CREATE TABLE `main_advertisement` (
  `id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productDescription` text NOT NULL,
  `productImage` text NOT NULL,
  `productRetailPrice` decimal(7,2) NOT NULL DEFAULT 0.00,
  `productPrice` decimal(7,2) NOT NULL,
  `productQuantity` int(11) NOT NULL,
  `dateAdded` datetime NOT NULL DEFAULT current_timestamp(),
  `updationDate` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_advertisement`
--

INSERT INTO `main_advertisement` (`id`, `productName`, `productDescription`, `productImage`, `productRetailPrice`, `productPrice`, `productQuantity`, `dateAdded`, `updationDate`) VALUES
(1, 'HP ENVY 17', 'Enjoy up to a 4K Ultra HD display with Delta E less than 27 color accuracy for vibrant colors.\r\n', 'images/image16.jpg', '1300.00', '1000.00', 12, '2021-08-22 21:50:43', '2021-08-23 21:56:24');

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
-- Table structure for table `phone_brands`
--

CREATE TABLE `phone_brands` (
  `id` int(11) NOT NULL,
  `brandName` varchar(100) NOT NULL,
  `dateAdded` datetime NOT NULL DEFAULT current_timestamp(),
  `updationDate` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phone_brands`
--

INSERT INTO `phone_brands` (`id`, `brandName`, `dateAdded`, `updationDate`) VALUES
(1, 'Apple', '2021-08-27 22:53:19', NULL),
(2, 'Samsung', '2021-08-27 22:53:19', NULL),
(3, 'Huawei', '2021-08-27 22:53:19', NULL);

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
(5, 'Mobile Phone', '2021-09-09 14:46:06', NULL);

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
-- Indexes for table `phone_brands`
--
ALTER TABLE `phone_brands`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `all_products`
--
ALTER TABLE `all_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contact_queries`
--
ALTER TABLE `contact_queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `main_advertisement`
--
ALTER TABLE `main_advertisement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `newsletter_subscription`
--
ALTER TABLE `newsletter_subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_brands`
--
ALTER TABLE `phone_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_brands`
--
ALTER TABLE `product_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
