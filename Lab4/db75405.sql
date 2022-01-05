-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2021 at 10:45 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db75405`
--

-- --------------------------------------------------------

--
-- Table structure for table `myuser`
--

CREATE TABLE `myuser` (
  `user_id` int(11) NOT NULL,
  `f_name` varchar(50) DEFAULT NULL,
  `l_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(12) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `state` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `myuser`
--

INSERT INTO `myuser` (`user_id`, `f_name`, `l_name`, `email`, `mobile`, `password`, `gender`, `state`) VALUES
(4, 'Leong', 'Weehong', 'zee@gmail.com', '177655410', '$2y$10$HzPJdEZVL3L5Ixv.EpEq7OtDnZjXTL/1zjFClAL6IuXUTVyKS.QDq', 'male', 'Sabah'),
(5, 'Tang', 'Jee', 'jee@gmail.com', '189876543', '$2y$10$9wXFjuw6.gB5gxscnMCMZ.mW30byp7JMAiOqRz2po0fOyOPYAT/ce', 'male', 'Malacca'),
(6, 'Tee', 'Ali', 'ali@siswa.unimas.my', '108881212', '$2y$10$5AkaRoXpgAcBLXKFdYqMu.b4vRaerE0zfxKgtB6oIngTbDZ3CA/02', 'male', 'Perak'),
(7, 'Muthu', 'Karishma', 'karishma@siswa.unimas.my', '199990101', '$2y$10$NxVfEjpMUtrQctq20efM6u92cgIOqbg/7QLysYNgDq4phZiOvfw2m', 'male', 'Selangor'),
(8, 'Amy', 'Town', 'amy@yahoo.com.my', '123456789', '$2y$10$J0TTPoayuTRuT0fwK4gAP.zJQKxUR2rSV.Sf1WEfcyttTL5Q1Tt6S', 'female', 'Kedah');

-- --------------------------------------------------------

--
-- Table structure for table `myuserlog`
--

CREATE TABLE `myuserlog` (
  `log_id` int(11) NOT NULL,
  `login_date_time` datetime DEFAULT NULL,
  `logout_date_time` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `myuserlog`
--

INSERT INTO `myuserlog` (`log_id`, `login_date_time`, `logout_date_time`, `duration`, `userID`) VALUES
(69, '2021-12-30 17:37:12', '2021-12-30 17:37:17', 5, 4),
(70, '2021-12-30 17:37:29', '2021-12-30 17:37:32', 3, 5),
(71, '2021-12-30 17:37:41', '2021-12-30 17:38:03', 22, 6),
(72, '2021-12-30 17:38:15', '2021-12-30 17:39:09', 54, 7),
(73, '2021-12-30 17:39:23', '2021-12-30 17:40:30', 67, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `myuser`
--
ALTER TABLE `myuser`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `myuserlog`
--
ALTER TABLE `myuserlog`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `myuser`
--
ALTER TABLE `myuser`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `myuserlog`
--
ALTER TABLE `myuserlog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `myuserlog`
--
ALTER TABLE `myuserlog`
  ADD CONSTRAINT `myuserlog_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `myuser` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
