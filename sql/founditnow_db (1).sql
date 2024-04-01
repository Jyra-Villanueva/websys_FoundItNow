-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2024 at 04:02 PM
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
-- Database: `founditnow_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE `campus` (
  `campusID` varchar(255) NOT NULL,
  `campusName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campus`
--

INSERT INTO `campus` (`campusID`, `campusName`) VALUES
('CAMP1001', 'Urdaneta'),
('CAMP1002', 'Asingan');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lostitems`
--

CREATE TABLE `lostitems` (
  `itemID` int(11) NOT NULL,
  `image` int(11) NOT NULL,
  `ItemName` varchar(255) NOT NULL,
  `campusID` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `locationLost` varchar(255) NOT NULL,
  `dateFound` datetime NOT NULL,
  `contactInfo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lostitems`
--

INSERT INTO `lostitems` (`itemID`, `image`, `ItemName`, `campusID`, `description`, `locationLost`, `dateFound`, `contactInfo`) VALUES
(1, 0, 'Mobile Phone', 'CAMP1001', 'Navy blue Iphone 12 Pro Max with privacy Screen', 'women\'s Restroom', '2024-03-27 15:39:48', '09391111111'),
(2, 0, 'Wallet', 'CAMP1002', 'Black mini wallet. A lot of piso with a face of a man in a UPANG uniform', 'Study Shed', '2024-03-26 22:39:48', '01234567891'),
(3, 0, 'Ponytail', 'CAMP1002', 'Blue ponytail', 'Asingan Room 201', '2024-03-31 18:05:21', '09999111222');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `studentid` varchar(10) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `campusID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `studentid`, `name`, `email`, `password`, `campusID`) VALUES
(6, '21-UR-0003', 'ttt', 't@g.com', '698d51a19d8a121ce581499d7b701668', 'Urdaneta'),
(7, 'n', 'n', 'n@g.com', '698d51a19d8a121ce581499d7b701668', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`campusID`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lostitems`
--
ALTER TABLE `lostitems`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `fk_campID` (`campusID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lostitems`
--
ALTER TABLE `lostitems`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lostitems`
--
ALTER TABLE `lostitems`
  ADD CONSTRAINT `fk_campID` FOREIGN KEY (`campusID`) REFERENCES `campus` (`campusID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
