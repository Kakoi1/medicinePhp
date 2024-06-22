-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2024 at 08:25 AM
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
-- Database: `medicine_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `Acc_Id` int(11) NOT NULL,
  `Acc_username` varchar(50) NOT NULL,
  `Acc_password` varchar(50) NOT NULL,
  `Acc_email` varchar(50) NOT NULL,
  `Acc_date` date NOT NULL,
  `Acc_time` time NOT NULL,
  `Acc_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`Acc_Id`, `Acc_username`, `Acc_password`, `Acc_email`, `Acc_date`, `Acc_time`, `Acc_status`) VALUES
(641, '123', 'e466e3494f1d4ce6fb8bd678d45cd801ac10b9ba', '123', '2024-05-03', '21:21:40', ''),
(642, '456', 'e466e3494f1d4ce6fb8bd678d45cd801ac10b9ba', '123', '2023-12-27', '17:42:39', ''),
(643, 'admin', 'd90b5f405979e3170c233147d23187858d61c8f9', 'admin', '2024-06-11', '10:29:07', 'admin'),
(644, 'roland', '7b3c418a5e0fa8d41b4a9376f2f54c66a991f113', 'roland@g.com', '2024-01-22', '13:13:45', ''),
(646, '22', 'e41f596ebc76e5878d62d0beb60dc41687f3e96e', 'dsa@f.vo', '2024-01-22', '12:53:46', ''),
(647, 'dsada', '7b474217d975857db8a8f7269408b6db7b7312c5', 'dsa@f.vo', '2024-05-02', '10:36:36', ''),
(648, 'dsa', 'e466e3494f1d4ce6fb8bd678d45cd801ac10b9ba', 'lopezrolandshane@gmail.com', '2024-04-25', '16:36:51', ''),
(649, '1234', 'e466e3494f1d4ce6fb8bd678d45cd801ac10b9ba', 'nokielopez@gmail.com', '2024-05-02', '11:26:00', 'pending'),
(650, 'roland1', 'e466e3494f1d4ce6fb8bd678d45cd801ac10b9ba', 'nokielopez@gmail.com', '2024-05-20', '19:41:02', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` longtext NOT NULL,
  `archive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `archive`) VALUES
(1, 'Paracetamol', 'bobo', 0),
(2, 'pain killers', 'gogo', 0),
(3, 'Antifungals', 'rugs used to treat fungal infections, the most common of which affect the hair, skin, nails, or mucous membranes.', 0),
(5, 'Antianxiety Drugs', 'Drugs that suppress anxiety and relax muscles (sometimes called anxiolytics, sedatives, or minor tranquilizers)', 0),
(6, 'Antibacterials', 'Drugs used to treat infections.', 0),
(7, 'Sedatives', 'Same as Antianxiety drugs', 0),
(8, 'Vitamins', 'Chemicals essential in small quantities for good health. Some vitamins are not manufactured by the body, but adequate quantities are present in a normal diet. People whose diets are inadequate or who have digestive tract or liver disorders may need to take supplementary vitamins.', 0),
(9, 'Vitamins1', 'Drugs that suppress anxiety and relax muscles (sometimes called anxiolytics, sedatives, or minor tranquilizers)', 0),
(10, 'anti-inflammatory', 'block certain substances in the body that cause inflammation.', 0),
(11, 'antibiotics', 'fight bacterial infections', 0);

-- --------------------------------------------------------

--
-- Table structure for table `med_inventory`
--

CREATE TABLE `med_inventory` (
  `Med_Id` int(11) NOT NULL,
  `Med_name` varchar(50) NOT NULL,
  `category` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `Med_price` int(20) NOT NULL,
  `Med_Quantity` int(20) NOT NULL,
  `Med_status` varchar(15) NOT NULL,
  `Med_ExpDate` date NOT NULL,
  `sup_Id` int(10) NOT NULL,
  `archive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `med_inventory`
--

INSERT INTO `med_inventory` (`Med_Id`, `Med_name`, `category`, `type`, `Med_price`, `Med_Quantity`, `Med_status`, `Med_ExpDate`, `sup_Id`, `archive`) VALUES
(27, 'biogesic', 'Paracetamol, anti-inflammatory', 'Capsules', 11, 58, 'Available', '2025-01-28', 1, 0),
(31, 'Cephalexin', 'antibiotics', 'Capsules', 20, 5, 'Available', '2024-11-07', 5, 0),
(32, 'loperamaid', '0', '', 8, 10, 'Out of Stock', '2025-02-02', 6, 0),
(36, 'amroksol', '0', '', 50, 24, 'Out of Stock', '2024-06-29', 6, 0),
(108, 'Acetaminophen', 'Antifungals, pain killers', '', 12, 50, 'Available', '2024-08-21', 7, 0),
(109, 'Amlodipine', '0', '', 21, 50, 'Available', '2024-09-26', 5, 0),
(110, 'Amoxicillin', 'anti-inflammatory, Paracetamol', 'Capsules', 10, 120, 'Available', '2025-02-28', 6, 0),
(111, 'Lyrica', 'anti-inflammatory', 'Capsules', 20, 10, 'Available', '2025-01-30', 5, 0),
(112, 'Viagra', 'Vitamins1, Antianxiety Drugs', '', 15, 50, 'Available', '2024-09-26', 6, 0),
(113, 'Trazodone', 'pain killers, Antianxiety Drugs', 'Liquids', 13, 48, 'Available', '2024-12-26', 7, 0),
(114, 'Naproxen', 'pain killers, Paracetamol, Antianxiety Drugs', '', 14, 28, 'Available', '2024-11-27', 7, 0),
(115, 'Advil', 'pain killers', 'Capsules', 12, 96, 'Available', '2024-10-29', 5, 0),
(116, 'profins', 'pain killer', 'Inhalers', 12, 98, 'Available', '2024-07-24', 6, 0),
(117, 'dsa321', 'Antifungals,pain killers, Antianxiety Drugs, Vitamins,Sedatives', 'Capsules', 15, 7, 'Available', '2024-11-28', 9, 1),
(118, 'yesy12', 'Antifungals, pain killers', 'Capsules', 12, 18, 'Available', '2025-01-23', 9, 1),
(119, 'dsada1', 'pain killer', '', 12, 12, 'Available', '2024-05-25', 9, 1),
(127, 'dsa212', 'Antifungals', '', 12, 12, 'Available', '2024-07-17', 9, 1),
(128, 'tolfinol', 'Antianxiety Drugs, Vitamins1', 'Capsules', 20, 10, 'Available', '2025-04-22', 13, 0),
(130, 'Morphine', 'Sedatives, pain killers', 'Liquids', 12, 1, 'Available', '2024-10-17', 11, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `med_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `arrival_date` date NOT NULL,
  `sup_id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending',
  `archive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `med_id`, `quantity`, `arrival_date`, `sup_id`, `requester_id`, `order_date`, `status`, `archive`) VALUES
(1, 36, 200, '2024-06-01', 6, 643, '2024-05-28 09:24:16', 'Pending', 0),
(2, 36, 200, '2024-08-29', 6, 643, '2024-05-28 09:37:19', 'Pending', 0),
(3, 36, 50, '2024-06-01', 6, 643, '2024-05-28 09:49:20', 'Completed', 1),
(4, 32, 10, '2024-05-04', 6, 643, '2024-05-28 09:57:41', 'Replenished', 1),
(5, 36, 12, '2024-05-01', 6, 643, '2024-05-28 10:21:33', 'Replenished', 1),
(6, 32, 122, '2024-11-26', 6, 643, '2024-06-18 02:38:47', 'Pending', 0);

-- --------------------------------------------------------

--
-- Table structure for table `restock_requests`
--

CREATE TABLE `restock_requests` (
  `id` int(11) NOT NULL,
  `med_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `requester_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `request_date` datetime DEFAULT current_timestamp(),
  `comments` text DEFAULT NULL,
  `archive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restock_requests`
--

INSERT INTO `restock_requests` (`id`, `med_id`, `quantity`, `requester_id`, `status`, `request_date`, `comments`, `archive`) VALUES
(1, 36, 50, 643, 'completed', '2024-05-28 12:52:41', 'bogo ka', 1),
(2, 36, 200, 643, 'approved', '2024-05-28 13:20:45', 'awa', 1),
(3, 32, 10, 643, 'completed', '2024-05-28 17:57:11', 'need more stock', 1),
(4, 36, 12, 643, 'completed', '2024-05-28 18:20:21', 'need more', 1),
(5, 36, 12, 643, 'Pending', '2024-05-29 09:22:12', '', 0),
(6, 32, 122, 643, 'completed', '2024-05-29 09:29:29', 'dadsa', 1),
(7, 36, 20, 643, 'Pending', '2024-05-29 10:57:48', 'qsqewqe', 0),
(8, 128, 20, 650, 'approved', '2024-06-18 11:36:11', 'need more', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `sup_Id` int(10) NOT NULL,
  `sup_Company` varchar(20) NOT NULL,
  `sup_Address` varchar(50) NOT NULL,
  `sup_Contact_no.` varchar(20) NOT NULL,
  `sup_email` varchar(50) NOT NULL,
  `archive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`sup_Id`, `sup_Company`, `sup_Address`, `sup_Contact_no.`, `sup_email`, `archive`) VALUES
(1, 'unilivers', 'cebus', '0909098s', 'roland@g.coms', 0),
(5, 'das', 'das', 'dasd', 'dasd', 0),
(6, 'TGPO', 'cebu', '012012275', 'dsa@f.vo', 0),
(7, 'antis', 'miglanillas', '0909098s', 'lopezrolandshane@gmail.com', 0),
(9, 'generica', 'Tres De Mayo', '0909098', 'rshan0418@gmail.com', 0),
(11, 'dsa22', 'Tres De Mayo', '0909098s', 'nokielopez@gmail.com', 1),
(13, 'JOHNSON & JOHNSON', 'Tres De Mayo', '0909098', 'lopezrolandshane@gmail.com', 0),
(14, 'UNILAB', 'Tres De Mayo', '0909098', 'rshan0418@gmail.com', 0),
(15, 'ADP PHARMA CORPORATI', 'Tres De Mayo', '09090909090', 'nokielopez@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `trans_id` int(10) NOT NULL,
  `Med_Id` int(10) NOT NULL,
  `trans_quan` int(20) NOT NULL,
  `trans_total` int(20) NOT NULL,
  `Acc_Id` int(10) NOT NULL,
  `trans_date` datetime NOT NULL,
  `archive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`trans_id`, `Med_Id`, `trans_quan`, `trans_total`, `Acc_Id`, `trans_date`, `archive`) VALUES
(206, 27, 10, 110, 643, '2024-05-04 11:19:16', 0),
(207, 111, 20, 400, 643, '2024-05-04 02:14:18', 0),
(208, 114, 30, 420, 643, '2024-05-04 00:00:00', 0),
(209, 108, 5, 60, 643, '2024-05-04 05:24:26', 0),
(210, 110, 4, 200, 643, '2024-04-18 03:19:09', 0),
(211, 110, 4, 200, 643, '2024-04-18 14:00:22', 0),
(212, 110, 4, 200, 643, '2024-03-18 17:20:24', 0),
(214, 109, 2, 42, 643, '2024-05-04 14:22:10', 0),
(215, 109, 2, 42, 643, '2024-05-04 10:19:28', 0),
(216, 109, 2, 42, 643, '2024-05-04 10:19:28', 0),
(217, 108, 2, 24, 643, '2024-05-04 10:19:28', 0),
(218, 109, 2, 42, 643, '2024-05-05 11:26:19', 0),
(219, 112, 2, 30, 643, '2024-05-05 11:26:19', 0),
(220, 108, 3, 36, 643, '2024-05-10 20:37:16', 0),
(221, 109, 4, 84, 643, '2024-05-10 20:37:16', 0),
(222, 112, 2, 30, 643, '2024-05-10 20:40:43', 0),
(223, 114, 2, 28, 643, '2024-05-10 20:40:43', 0),
(224, 115, 2, 24, 643, '2024-05-23 15:46:35', 0),
(225, 117, 2, 30, 643, '2024-05-23 15:56:52', 0),
(226, 27, 2, 22, 643, '2024-05-23 15:56:52', 0),
(227, 118, 2, 24, 643, '2024-05-29 08:40:15', 0),
(228, 118, 1, 12, 643, '2024-05-29 08:43:32', 0),
(229, 117, 1, 15, 643, '2024-05-29 08:55:15', 0),
(230, 117, 1, 15, 643, '2024-05-29 11:00:33', 0),
(231, 116, 2, 24, 643, '2024-06-11 10:32:12', 0),
(232, 117, 1, 15, 643, '2024-06-17 12:08:17', 0),
(233, 113, 2, 26, 650, '2024-06-17 14:52:58', 0),
(234, 115, 2, 24, 650, '2024-06-18 10:52:25', 0),
(235, 108, 3, 36, 650, '2024-06-18 10:52:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `useraction`
--

CREATE TABLE `useraction` (
  `id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Acc_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useraction`
--

INSERT INTO `useraction` (`id`, `action`, `dateTime`, `Acc_Id`) VALUES
(1, 'bogo', '2024-05-29 02:10:55', 643),
(2, 'bogos', '2024-05-29 02:17:51', 646),
(3, 'delete Medicine', '2024-05-29 02:23:04', 643),
(4, 'update Medicine', '2024-05-29 02:25:13', 643),
(5, 'update Medicine', '2024-05-29 02:25:13', 643),
(6, 'update Medicine', '2024-05-29 02:28:04', 643),
(7, 'Archive Medicine', '2024-05-29 02:30:53', 643),
(8, 'Restore Medicine', '2024-05-29 02:31:02', 643),
(9, 'Add Category', '2024-05-29 02:34:32', 643),
(10, 'update Category', '2024-05-29 02:35:02', 643),
(11, 'archive Category', '2024-05-29 02:35:10', 643),
(12, 'restore Category', '2024-05-29 02:35:19', 643),
(13, 'restore Category', '2024-05-29 02:44:53', 643),
(14, 'archive Category', '2024-05-29 02:44:59', 643),
(15, 'restore Category', '2024-05-29 02:45:03', 643),
(16, 'archive Category', '2024-05-29 02:46:31', 643),
(17, 'archive Category', '2024-05-29 02:46:37', 643),
(18, 'restore Category', '2024-05-29 02:47:28', 643),
(19, 'delete Category', '2024-05-29 02:50:04', 643),
(20, 'Add Medicine', '2024-05-29 02:53:42', 643),
(21, 'Restock request', '2024-05-29 02:57:48', 643),
(22, 'Add Transaction', '2023-05-29 03:00:33', 643),
(23, 'Add Transaction', '2024-06-11 02:32:12', 643),
(24, 'archive Category', '2024-06-17 03:03:23', 650),
(25, 'restore Category', '2024-06-17 03:03:28', 650),
(26, 'Add Transaction', '2024-06-17 04:08:17', 643),
(27, 'Add Medicine', '2024-06-17 05:15:23', 650),
(28, 'Archive Medicine', '2024-06-17 05:21:18', 650),
(29, 'Archive Medicine', '2024-06-17 05:21:38', 650),
(30, 'Restore Medicine', '2024-06-17 05:21:48', 650),
(31, 'Restore Medicine', '2024-06-17 05:21:52', 650),
(32, 'Add Medicine', '2024-06-17 05:43:35', 650),
(33, 'update Medicine', '2024-06-17 05:44:10', 650),
(34, 'Add Medicine', '2024-06-17 05:45:36', 650),
(35, 'update Medicine', '2024-06-17 05:46:04', 650),
(36, 'Archive Medicine', '2024-06-17 05:46:15', 650),
(37, 'Archive Medicine', '2024-06-17 05:46:19', 650),
(38, 'delete Medicine', '2024-06-17 05:46:28', 650),
(39, 'delete Medicine', '2024-06-17 05:46:33', 650),
(40, 'update Medicine', '2024-06-17 06:29:02', 650),
(41, 'update Medicine', '2024-06-17 06:29:20', 650),
(42, 'update Medicine', '2024-06-17 06:31:01', 650),
(43, 'update Medicine', '2024-06-17 06:31:12', 650),
(44, 'update Medicine', '2024-06-17 06:31:23', 650),
(45, 'Add Transaction', '2024-06-17 06:52:58', 650),
(46, 'Add Transaction', '2024-06-18 02:52:25', 650),
(47, 'Restock request', '2024-06-18 03:36:11', 650),
(48, 'Replenish Medicine', '2024-06-19 11:12:35', 650),
(49, 'update Medicine', '2024-06-22 06:17:21', 650),
(50, 'Archive Medicine', '2024-06-22 06:17:35', 650),
(51, 'Archive Medicine', '2024-06-22 06:17:51', 650),
(52, 'Archive Medicine', '2024-06-22 06:18:00', 650),
(53, 'update Medicine', '2024-06-22 06:18:09', 650),
(54, 'update Medicine', '2024-06-22 06:18:23', 650),
(55, 'Archive Medicine', '2024-06-22 06:18:45', 650),
(56, 'Add Category', '2024-06-22 06:20:16', 650),
(57, 'update Medicine', '2024-06-22 06:21:11', 650),
(58, 'update Medicine', '2024-06-22 06:22:22', 650),
(59, 'Add Category', '2024-06-22 06:22:52', 650),
(60, 'update Medicine', '2024-06-22 06:23:07', 650),
(61, 'update Medicine', '2024-06-22 06:24:23', 650),
(62, 'update Medicine', '2024-06-22 06:24:46', 650),
(63, 'update Medicine', '2024-06-22 06:24:55', 650),
(64, 'update Medicine', '2024-06-22 06:25:07', 650);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`Acc_Id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `med_inventory`
--
ALTER TABLE `med_inventory`
  ADD PRIMARY KEY (`Med_Id`),
  ADD KEY `supplier relation` (`sup_Id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `med_id` (`med_id`),
  ADD KEY `sup_id` (`sup_id`),
  ADD KEY `requester_id` (`requester_id`);

--
-- Indexes for table `restock_requests`
--
ALTER TABLE `restock_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `med_id` (`med_id`),
  ADD KEY `requester_id` (`requester_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`sup_Id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `medicine Id` (`Med_Id`),
  ADD KEY `user Id` (`Acc_Id`);

--
-- Indexes for table `useraction`
--
ALTER TABLE `useraction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user actions` (`Acc_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `Acc_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=651;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `med_inventory`
--
ALTER TABLE `med_inventory`
  MODIFY `Med_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `restock_requests`
--
ALTER TABLE `restock_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sup_Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `trans_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT for table `useraction`
--
ALTER TABLE `useraction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `med_inventory`
--
ALTER TABLE `med_inventory`
  ADD CONSTRAINT `supplier relation` FOREIGN KEY (`sup_Id`) REFERENCES `supplier` (`sup_Id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`med_id`) REFERENCES `med_inventory` (`Med_Id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`sup_id`) REFERENCES `supplier` (`sup_Id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`requester_id`) REFERENCES `accounts` (`Acc_Id`);

--
-- Constraints for table `restock_requests`
--
ALTER TABLE `restock_requests`
  ADD CONSTRAINT `restock_requests_ibfk_1` FOREIGN KEY (`med_id`) REFERENCES `med_inventory` (`Med_Id`),
  ADD CONSTRAINT `restock_requests_ibfk_2` FOREIGN KEY (`requester_id`) REFERENCES `accounts` (`Acc_Id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `medicine Id` FOREIGN KEY (`Med_Id`) REFERENCES `med_inventory` (`Med_Id`),
  ADD CONSTRAINT `user Id` FOREIGN KEY (`Acc_Id`) REFERENCES `accounts` (`Acc_Id`);

--
-- Constraints for table `useraction`
--
ALTER TABLE `useraction`
  ADD CONSTRAINT `user actions` FOREIGN KEY (`Acc_Id`) REFERENCES `accounts` (`Acc_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
