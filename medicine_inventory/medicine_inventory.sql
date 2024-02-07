-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2024 at 04:52 AM
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
  `Acc_fullname` varchar(50) NOT NULL,
  `Acc_password` varchar(50) NOT NULL,
  `Acc_email` varchar(50) NOT NULL,
  `Acc_date` date NOT NULL,
  `Acc_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`Acc_Id`, `Acc_username`, `Acc_fullname`, `Acc_password`, `Acc_email`, `Acc_date`, `Acc_time`) VALUES
(641, '123', '123', 'e466e3494f1d4ce6fb8bd678d45cd801ac10b9ba', '123', '2024-01-25', '17:39:01'),
(642, '456', '123', 'e466e3494f1d4ce6fb8bd678d45cd801ac10b9ba', '123', '2023-12-27', '17:42:39'),
(643, 'admin', 'admin', 'd90b5f405979e3170c233147d23187858d61c8f9', 'admin', '2024-02-06', '08:36:20'),
(644, 'roland', 'roland', '7b3c418a5e0fa8d41b4a9376f2f54c66a991f113', 'roland@g.com', '2024-01-22', '13:13:45'),
(646, '22', '22', 'e41f596ebc76e5878d62d0beb60dc41687f3e96e', 'dsa@f.vo', '2024-01-22', '12:53:46'),
(647, 'dsada', 'dsad', '7b474217d975857db8a8f7269408b6db7b7312c5', 'dsa@f.vo', '2024-01-25', '11:17:44'),
(648, 'dsa', 'dsa', 'e466e3494f1d4ce6fb8bd678d45cd801ac10b9ba', 'lopezrolandshane@gmail.com', '2024-01-26', '11:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `med_inventory`
--

CREATE TABLE `med_inventory` (
  `Med_Id` int(11) NOT NULL,
  `Med_name` varchar(50) NOT NULL,
  `Med_price` int(20) NOT NULL,
  `Med_Quantity` int(20) NOT NULL,
  `Med_status` varchar(15) NOT NULL,
  `Med_ExpDate` date NOT NULL,
  `sup_Id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `med_inventory`
--

INSERT INTO `med_inventory` (`Med_Id`, `Med_name`, `Med_price`, `Med_Quantity`, `Med_status`, `Med_ExpDate`, `sup_Id`) VALUES
(25, 'LPG', 45, 4, 'Available', '2024-01-17', 1),
(26, 'assers', 9, 0, 'Out of Stock', '2024-01-31', 5),
(27, 'paracetamol', 11, 0, 'Out of Stock', '2024-05-25', 6),
(31, 'biogesik1', 20, 10, 'Available', '2024-11-07', 5),
(32, 'loperamaid', 8, 12, 'Available', '2025-02-02', 6),
(34, 'bayotgesiks', 20, 8, 'Available', '2024-02-29', 6),
(35, 'gg20', 20, 20, 'Available', '2024-01-27', 6),
(36, 'amroksol', 50, 0, 'Out of Stock', '2024-06-29', 6);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `sup_Id` int(10) NOT NULL,
  `sup_Company` varchar(20) NOT NULL,
  `sup_Address` varchar(50) NOT NULL,
  `sup_Contact_no.` varchar(20) NOT NULL,
  `sup_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`sup_Id`, `sup_Company`, `sup_Address`, `sup_Contact_no.`, `sup_email`) VALUES
(1, 'unilivers', 'cebus', '0909098s', 'roland@g.coms'),
(5, 'das', 'das', 'dasd', 'dasd'),
(6, 'TGPO', 'cebu', '012012275', 'dsa@f.vo'),
(7, 'antis', 'miglanillas', '0909098s', 'lopezrolandshane@gmail.com');

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
  `trans_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`trans_id`, `Med_Id`, `trans_quan`, `trans_total`, `Acc_Id`, `trans_date`) VALUES
(28, 26, 10, 90, 641, '2024-01-16'),
(29, 27, 12, 22, 641, '2024-01-16'),
(30, 26, 6, 54, 643, '2024-01-17'),
(32, 36, 20, 1000, 643, '2024-01-26'),
(36, 34, 12, 240, 643, '2024-02-05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`Acc_Id`);

--
-- Indexes for table `med_inventory`
--
ALTER TABLE `med_inventory`
  ADD PRIMARY KEY (`Med_Id`),
  ADD KEY `supplier relation` (`sup_Id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `Acc_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=649;

--
-- AUTO_INCREMENT for table `med_inventory`
--
ALTER TABLE `med_inventory`
  MODIFY `Med_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sup_Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `trans_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `med_inventory`
--
ALTER TABLE `med_inventory`
  ADD CONSTRAINT `supplier relation` FOREIGN KEY (`sup_Id`) REFERENCES `supplier` (`sup_Id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `medicine Id` FOREIGN KEY (`Med_Id`) REFERENCES `med_inventory` (`Med_Id`),
  ADD CONSTRAINT `user Id` FOREIGN KEY (`Acc_Id`) REFERENCES `accounts` (`Acc_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
