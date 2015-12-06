-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2015 at 04:19 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `work_hours`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`,`ip_address`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'project name <50',
  `owner_id` int(11) NOT NULL COMMENT 'user account is as Foreign key',
  `status` enum('inactive','active') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'completed or has not started means inactive, otherwise active',
  `priority` enum('low','normal','high') COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` date NOT NULL COMMENT 'when the project was created?',
  `deadline` date NOT NULL COMMENT 'when is the project due?',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'more info about the project. optional!',
  `note` text COLLATE utf8mb4_unicode_ci COMMENT 'info about project status or other problems, optional!',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE IF NOT EXISTS `user_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '<30',
  `password` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'it should be encrypted!',
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'first - last name',
  `status` enum('inactive','active','blocked') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'active means logged',
  `creation_date` timestamp NOT NULL COMMENT 'when the account was created?',
  `last_login` timestamp NULL DEFAULT NULL COMMENT 'last time the user accessed the account',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_project`
--

CREATE TABLE IF NOT EXISTS `user_project` (
  `user_account_id` int(11) NOT NULL COMMENT 'which user account?',
  `project_id` int(11) NOT NULL COMMENT 'which project?',
  `hours` int(11) NOT NULL DEFAULT '0' COMMENT 'hours worked',
  PRIMARY KEY (`user_account_id`,`project_id`),
  KEY `user_account_id` (`user_account_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user_account` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_project`
--
ALTER TABLE `user_project`
  ADD CONSTRAINT `user_project_ibfk_1` FOREIGN KEY (`user_account_id`) REFERENCES `user_account` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_project_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
