-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2012 at 01:29 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `studentdetails`
--
CREATE DATABASE `studentdetails` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `studentdetails`;

-- --------------------------------------------------------

--
-- Table structure for table `attandance`
--

CREATE TABLE IF NOT EXISTS `attandance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rollno` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `nodaypresent` varchar(35) NOT NULL,
  `nodayabsent` varchar(35) NOT NULL,
  `totalday` varchar(35) NOT NULL,
  `percentage` varchar(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `attandance`
--

INSERT INTO `attandance` (`id`, `rollno`, `name`, `nodaypresent`, `nodayabsent`, `totalday`, `percentage`) VALUES
(1, '10MCA58', 'Vinoth K S', '35', '0', '35', '100');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `md5_id` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `full_name` tinytext COLLATE latin1_general_ci NOT NULL,
  `user_name` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_email` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_level` tinyint(4) NOT NULL DEFAULT '1',
  `pwd` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `country` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `year` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `users_ip` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `approved` int(1) NOT NULL DEFAULT '0',
  `activation_code` int(10) NOT NULL DEFAULT '0',
  `banned` int(1) NOT NULL DEFAULT '0',
  `ckey` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ctime` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`user_email`),
  FULLTEXT KEY `idx_search` (`full_name`,`user_email`,`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=59 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `md5_id`, `full_name`, `user_name`, `user_email`, `user_level`, `pwd`, `country`, `year`, `date`, `users_ip`, `approved`, `activation_code`, `banned`, `ckey`, `ctime`) VALUES
(54, '', 'admin', 'admin', 'admin@localhost', 5, '6ab7a3175d547e1f7b6a5ed21b820c7f82cd92b62578a23cb', 'Admin', 'Second Year', '2010-05-04', '', 1, 0, 0, '', ''),
(56, '9f61408e3afb633e50cdf1b20de6f466', 'Vinoth K S', '10MCA58', '104501604058', 1, 'ba9ece6854d4665a3abef2d9b3d36f392764cd767259f1f2f', 'MCA', 'Second', '2012-01-09', '127.0.0.1', 1, 8730, 0, '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
