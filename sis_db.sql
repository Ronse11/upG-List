-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2024 at 10:01 AM
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
-- Database: `sis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `p_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_items` varchar(255) NOT NULL,
  `user_price` int(32) NOT NULL,
  `quantity` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`p_id`, `user_id`, `user_items`, `user_price`, `quantity`) VALUES
(88, 2, 'Coffee', 10, 8),
(95, 1, 'Mate', 3, 5),
(98, 1, 'Milo', 10, 2),
(109, 5, 'Mate', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `p_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_items` varchar(255) NOT NULL,
  `user_price` int(32) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`p_id`, `user_id`, `user_items`, `user_price`, `quantity`) VALUES
(92, 2, 'Mate', 4, 5),
(93, 2, 'Milo', 10, 5),
(94, 1, 'Coffee', 8, 5),
(96, 1, 'Choco', 20, 4),
(99, 5, 'Milo', 10, 5),
(101, 5, 'Coffee', 10, 3),
(102, 5, 'Choco', 20, 4),
(111, 1, 'Mate', 2, 1),
(112, 1, 'Ha', 23, 3),
(113, 1, 'Bruh', 14, 5),
(116, 1, 'CHoco', 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_fname` varchar(255) NOT NULL,
  `user_lname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_pass` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fname`, `user_lname`, `user_email`, `user_pass`) VALUES
(1, 'Ronald', 'Seron', 'Ron@gmail.com', '$2y$10$LIT5IRYFg8LASLj988k.F.gjj6WCBQq99GmBs9rlVLQAxFTNAPnYC'),
(5, 'Lali', 'Dua', 'Dua@gmail.com', '$2y$10$Iw.BTjBLfT/VdCpRKTe.lOP1k2zoBFx2lnxjQne2V2MkiCfBS7Ps6'),
(8, 'Lee', 'Bat', 'Lee@gmail.com', '$2y$10$/2/9j887dn6g2NODqMQZE.gCmKtXpTdiV/xR8LqExQO/A1YRGcrHq'),
(9, 'Dey', 'Ser', 'Dey@gmail.com', '$2y$10$R4yoi65PzVXLrwCgE9Gvf.z.mTLnziLY1r3vkwVRpYhpxrbLwjoWK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
