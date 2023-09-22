-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2023 at 01:21 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tonado`
--

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `id` int(255) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`id`, `name`) VALUES
(1, 'Adele'),
(2, 'Borns'),
(3, 'Guns & Roses'),
(4, 'Tool'),
(5, 'Eminem'),
(6, 'Chiai Fujikawa'),
(7, 'Daft Punk');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(255) NOT NULL,
  `name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'Rock'),
(2, 'Pop'),
(3, 'Metal'),
(4, 'R&B'),
(5, 'Hip-Hop'),
(6, 'J-pop');

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `id` int(255) NOT NULL,
  `name` varchar(500) NOT NULL,
  `artist` varchar(500) NOT NULL,
  `genre` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`id`, `name`, `artist`, `genre`) VALUES
(1, 'November Rain', 'Guns & Roses', 'Rock'),
(2, '10,000 Days (Wings Pt 2)', 'Tool', 'Metal'),
(3, 'Kimi No Namae', 'Chiai Fujikawa', 'J-Pop'),
(4, 'Hello', 'Adele', 'Soul Music'),
(5, 'Mocking Bird', 'Eminem', 'Hip-Hop'),
(6, 'Save Your Tears', 'The Weeknd', 'R & B');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `admin`) VALUES
(1, 'Amit', 'amit@gmail.com', '$2y$10$XPEUK2edrW8J1DLnSycNXOHeCVn6Nb95BlvbP0JT8Xv2rziPN7Ugi', 0),
(2, 'hakulakhe', 'test@gmail.com', '$2y$10$bfNz3Xk1mzOj8FX3IAsSm.RdVDuX1xCn2qiBvl6BaLzwmUlpSOyFq', 0),
(3, 'Admin ', 'admin@gmail.com', '$2y$10$8ut71aaMXXBZdAuvZuQyPupnAhSvaB7nEEPSicUdfboeMXV8C588K', 1),
(4, 'Sailendra Shrestha', 'sailendrashrestha84@gmail.com', '$2y$10$lT3AW85xFiiWWc0qwycEbOn3TGSDC9zjgkWwcfb7XVuHUtfnvZpc6', 0),
(5, 'Saldyn Shrestha', 'saldynshrestha84@gmail.com', '$2y$10$815Ad1f.9TsrJkWIjHwY.uJUi4peAWC7vQVJgF8l8XM8dXv5Mj23i', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
