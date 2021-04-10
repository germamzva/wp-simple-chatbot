-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2021 at 08:43 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frn_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_mbd_chatbot`
--

CREATE TABLE `wp_mbd_chatbot` (
  `mbd_chatbot_id` int(11) NOT NULL,
  `chat_q1` varchar(1000) NOT NULL,
  `chat_answer_q1` varchar(1000) NOT NULL,
  `chat_q2` varchar(1000) NOT NULL,
  `chat_answer_q2` varchar(1000) NOT NULL,
  `chat_q3` varchar(1000) NOT NULL,
  `chat_answer_q3` varchar(1000) NOT NULL,
  `mbd_chatbot_post_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_mbd_chatbot`
--
ALTER TABLE `wp_mbd_chatbot`
  ADD PRIMARY KEY (`mbd_chatbot_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_mbd_chatbot`
--
ALTER TABLE `wp_mbd_chatbot`
  MODIFY `mbd_chatbot_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
