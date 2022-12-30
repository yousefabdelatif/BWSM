-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Dec 30, 2022 at 01:28 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bwsm`
--

-- --------------------------------------------------------

--
-- Table structure for table `bwsm`
--

CREATE TABLE `bwsm` (
  `ID` int(255) NOT NULL,
  `NAME` varchar(64) NOT NULL,
  `EMAIL` varchar(64) NOT NULL,
  `PASSWORD` varchar(128) NOT NULL,
  `DATE` varchar(16) NOT NULL,
  `FRIENDS` text NOT NULL,
  `NUMBER_OF_FRIENDS` smallint(255) NOT NULL,
  `REATION_ACTIVTY` text NOT NULL,
  `PHOTO_URL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_posts`
--

CREATE TABLE `users_posts` (
  `POSTER_ID` int(255) NOT NULL,
  `POST_ID` text DEFAULT NULL,
  `POST_TEXT` text NOT NULL,
  `POST_IMAGE_URL` varchar(255) DEFAULT NULL,
  `NUMBER_OF_LIKES` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bwsm`
--
ALTER TABLE `bwsm`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bwsm`
--
ALTER TABLE `bwsm`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
