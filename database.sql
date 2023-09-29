-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2023 at 12:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billy`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cid` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cid`, `name`, `phone`, `email`, `address`) VALUES
(27, 'Rajat Singh', '9876554565', 'rajat@email.com', 'India'),
(28, 'Neeraj Kumar', '9999999999', 'neeraj@email.com', 'India');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `mode` varchar(25) NOT NULL,
  `net` float(25,2) NOT NULL,
  `paid` float(25,2) NOT NULL,
  `due` float(25,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  `pdate` date NOT NULL,
  `ptime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pid`, `cid`, `mode`, `net`, `paid`, `due`, `status`, `pdate`, `ptime`) VALUES
(16, 27, 'Bank Transfer', 324998.00, 320000.00, 4998.00, 'Due', '2023-09-29', '03:32:10'),
(17, 28, 'Cheque', 249998.00, 249998.00, 0.00, 'Paid', '2023-09-29', '03:34:03');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(25) NOT NULL,
  `colour` varchar(25) NOT NULL,
  `imei1` varchar(25) NOT NULL,
  `imei2` varchar(25) NOT NULL,
  `battery` varchar(50) NOT NULL,
  `charger` varchar(50) NOT NULL,
  `quantity` int(25) NOT NULL,
  `mrp` float(25,2) NOT NULL,
  `total` float(25,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pid`, `cid`, `brand`, `name`, `code`, `colour`, `imei1`, `imei2`, `battery`, `charger`, `quantity`, `mrp`, `total`) VALUES
(18, 27, 'Apple', 'Iphone 15', 'IP015', 'Sea Blue', '87787678987664766543', '', '', '', 1, 199999.00, 199999.00),
(19, 28, 'Samsung', 'S23 Ultra', 'SMS23U', 'Black', '87787678987664766543', '', '', '', 2, 124999.00, 249998.00),
(20, 27, 'Samsung', 'S23 Ultra', 'SMS23U', 'Black', '87787678987664766543', '', '', '', 1, 124999.00, 124999.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `sname` varchar(50) NOT NULL,
  `sphone` varchar(15) NOT NULL,
  `semail` varchar(50) NOT NULL,
  `saddress` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `name`, `dob`, `email`, `password`, `sname`, `sphone`, `semail`, `saddress`) VALUES
(6, 'Shubham kumar', '2000-01-01', 'shubham14243@email.com', 'shubham123', 'Online Store', '9988776655', 'onlinestore@email.com', 'India');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
