-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 14, 2012 at 10:19 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pickr_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `feel`
--

CREATE TABLE IF NOT EXISTS `feel` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `picture_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`picture_id`),
  KEY `picture_id` (`picture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feel`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `feel`
--
ALTER TABLE `feel`
  ADD CONSTRAINT `feel_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `feel_ibfk_2` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`);
