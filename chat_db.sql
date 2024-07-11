-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2024 at 08:40 AM
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
-- Database: `chat_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(50) DEFAULT NULL,
  `receiver` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `receiver`, `message`, `timestamp`) VALUES
(1, 'a', 'b', 'asas', '2024-07-09 05:47:58'),
(2, 'b', 'a', 'asasasas', '2024-07-09 05:48:10'),
(3, 'a', 'b', 'asasfwe', '2024-07-09 05:48:15'),
(4, 'b', 'a', 'rwer', '2024-07-09 05:48:18'),
(5, 'a', 'b', 'werwer', '2024-07-09 05:48:21'),
(6, 'b', 'a', 'ewrwer', '2024-07-09 05:48:22'),
(7, 'a', 'b', 'aa', '2024-07-09 05:48:30'),
(8, 'b', 'a', 'bb', '2024-07-09 05:48:33'),
(9, 'c', 'b', 'aa', '2024-07-09 05:48:55'),
(10, 'c', 'b', 'c', '2024-07-09 05:49:04'),
(11, 'a', 'c', 'a', '2024-07-09 05:49:18'),
(12, 'aaa', 'bbb', 'asas', '2024-07-09 06:23:56'),
(13, 'aaa', 'bbb', 'aa', '2024-07-09 06:23:59'),
(14, 'bbb', 'aaa', 'bbb', '2024-07-09 06:24:04'),
(15, 'aaa', 'bbb', 'asas', '2024-07-09 06:24:08'),
(16, 'bbb', 'aaa', 'dsd', '2024-07-09 06:24:11'),
(17, 'aaa', 'bbb', 'ee', '2024-07-09 06:24:16'),
(18, 'bbb', 'tt', 'rrrttn', '2024-07-09 06:25:56'),
(19, 'yy', 'oo', 'hh', '2024-07-09 07:18:11'),
(20, 'bb', 'yy', 'jhg', '2024-07-10 12:58:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
