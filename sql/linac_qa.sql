-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 19, 2012 at 06:12 AM
-- Server version: 5.5.25-1~dotdeb.0
-- PHP Version: 5.4.3-1~dotdeb.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `linac_qa`
--

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--
-- Creation: Jun 19, 2012 at 05:40 AM
--

DROP TABLE IF EXISTS `facilities`;
CREATE TABLE IF NOT EXISTS `facilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--
-- Creation: Jun 19, 2012 at 06:09 AM
--

DROP TABLE IF EXISTS `forms`;
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `machine_type_id` int(11) DEFAULT NULL,
  `js` longtext COLLATE utf8_bin NOT NULL,
  `php` longtext COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `machine_type_id` (`machine_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `forms`:
--   `machine_type_id`
--       `machine_types` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `form_entries`
--
-- Creation: Jun 19, 2012 at 06:01 AM
--

DROP TABLE IF EXISTS `form_entries`;
CREATE TABLE IF NOT EXISTS `form_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `machine_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `machine_id` (`machine_id`,`user_id`,`created_at`,`updated_at`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `form_entries`:
--   `user_id`
--       `users` -> `id`
--   `machine_id`
--       `machines` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--
-- Creation: Jun 19, 2012 at 05:59 AM
--

DROP TABLE IF EXISTS `form_fields`;
CREATE TABLE IF NOT EXISTS `form_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(30) COLLATE utf8_bin NOT NULL,
  `default` text COLLATE utf8_bin NOT NULL,
  `type` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `position` (`position`,`section_id`),
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `form_fields`:
--   `section_id`
--       `form_sections` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `form_sections`
--
-- Creation: Jun 19, 2012 at 05:52 AM
--

DROP TABLE IF EXISTS `form_sections`;
CREATE TABLE IF NOT EXISTS `form_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) COLLATE utf8_bin NOT NULL,
  `position` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `position` (`position`,`form_id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `form_sections`:
--   `form_id`
--       `forms` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `form_values`
--
-- Creation: Jun 19, 2012 at 05:59 AM
--

DROP TABLE IF EXISTS `form_values`;
CREATE TABLE IF NOT EXISTS `form_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` text COLLATE utf8_bin NOT NULL,
  `form_entry_id` int(11) DEFAULT NULL,
  `form_field_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_entry_id` (`form_entry_id`,`form_field_id`),
  KEY `form_field_id` (`form_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `form_values`:
--   `form_field_id`
--       `form_fields` -> `id`
--   `form_entry_id`
--       `form_entries` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--
-- Creation: Jun 19, 2012 at 06:09 AM
--

DROP TABLE IF EXISTS `machines`;
CREATE TABLE IF NOT EXISTS `machines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin NOT NULL,
  `facility_id` int(11) NOT NULL,
  `machine_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `facility_id` (`facility_id`,`machine_type_id`),
  KEY `machine_type_id` (`machine_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `machines`:
--   `machine_type_id`
--       `machine_types` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `machine_types`
--
-- Creation: Jun 19, 2012 at 05:41 AM
--

DROP TABLE IF EXISTS `machine_types`;
CREATE TABLE IF NOT EXISTS `machine_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Jun 19, 2012 at 06:10 AM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin NOT NULL,
  `email` text COLLATE utf8_bin NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_bin NOT NULL,
  `userlevel` int(1) NOT NULL,
  `last_ip` varchar(15) COLLATE utf8_bin NOT NULL,
  `facility_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`(30)),
  KEY `userlevel` (`userlevel`),
  KEY `facility_id` (`facility_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `users`:
--   `facility_id`
--       `facilities` -> `id`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`machine_type_id`) REFERENCES `machine_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `form_entries`
--
ALTER TABLE `form_entries`
  ADD CONSTRAINT `form_entries_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `form_entries_ibfk_3` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD CONSTRAINT `form_fields_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `form_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `form_sections`
--
ALTER TABLE `form_sections`
  ADD CONSTRAINT `form_sections_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `form_values`
--
ALTER TABLE `form_values`
  ADD CONSTRAINT `form_values_ibfk_4` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `form_values_ibfk_3` FOREIGN KEY (`form_entry_id`) REFERENCES `form_entries` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `machines`
--
ALTER TABLE `machines`
  ADD CONSTRAINT `machines_ibfk_1` FOREIGN KEY (`machine_type_id`) REFERENCES `machine_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
