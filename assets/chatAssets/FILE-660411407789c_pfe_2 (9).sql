-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 26, 2024 at 06:06 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pfe_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

DROP TABLE IF EXISTS `assignment`;
CREATE TABLE IF NOT EXISTS `assignment` (
  `ID_ASSIGNMENT` int NOT NULL AUTO_INCREMENT,
  `ID_MODULE` int DEFAULT NULL,
  `ID_TEACHER` int NOT NULL,
  `TITLE` varchar(50) DEFAULT NULL,
  `DESCRIPTION` text,
  `file_path` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `DUE_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_ASSIGNMENT`),
  KEY `fk_mo_co` (`ID_MODULE`),
  KEY `fk_us_co` (`ID_TEACHER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE IF NOT EXISTS `complaints` (
  `ID_COMPLAINT` int NOT NULL AUTO_INCREMENT,
  `complaint` varchar(100) NOT NULL,
  `Respond` varchar(250) NOT NULL,
  `TYPE` int NOT NULL,
  `STATUS` int NOT NULL DEFAULT '3',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID_USER` int DEFAULT NULL,
  PRIMARY KEY (`ID_COMPLAINT`),
  KEY `fk_com_us` (`ID_USER`),
  KEY `fk_type_com` (`TYPE`),
  KEY `fk_status_com` (`STATUS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_status`
--

DROP TABLE IF EXISTS `complaint_status`;
CREATE TABLE IF NOT EXISTS `complaint_status` (
  `id_status` int NOT NULL AUTO_INCREMENT,
  `status_labelle` varchar(25) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_type`
--

DROP TABLE IF EXISTS `complaint_type`;
CREATE TABLE IF NOT EXISTS `complaint_type` (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `type_labelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `ID_DEPARTMENT` int NOT NULL AUTO_INCREMENT,
  `Department_code` varchar(5) NOT NULL,
  `DEPARTMENT_NAME` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`ID_DEPARTMENT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fillieres`
--

DROP TABLE IF EXISTS `fillieres`;
CREATE TABLE IF NOT EXISTS `fillieres` (
  `ID_FILLIERE` int NOT NULL AUTO_INCREMENT,
  `FILLIERE_NAME` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ID_DEPARTMENT` int DEFAULT NULL,
  PRIMARY KEY (`ID_FILLIERE`),
  KEY `fk_fl_de` (`ID_DEPARTMENT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groupdiscussion`
--

DROP TABLE IF EXISTS `groupdiscussion`;
CREATE TABLE IF NOT EXISTS `groupdiscussion` (
  `ID_GROUP_DISCUSSION` int NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) DEFAULT NULL,
  `TYPE` int DEFAULT NULL,
  `entity_type` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_GROUP_DISCUSSION`),
  KEY `fk_gc_type` (`TYPE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groupdiscussiontype`
--

DROP TABLE IF EXISTS `groupdiscussiontype`;
CREATE TABLE IF NOT EXISTS `groupdiscussiontype` (
  `id_gc_type` int NOT NULL AUTO_INCREMENT,
  `libelle_gc_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_gc_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groupmembership`
--

DROP TABLE IF EXISTS `groupmembership`;
CREATE TABLE IF NOT EXISTS `groupmembership` (
  `ID_USER` int NOT NULL,
  `ID_GROUP_DISCUSSION` int NOT NULL,
  `ROLE` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_USER`,`ID_GROUP_DISCUSSION`),
  KEY `fk_gm_gc` (`ID_GROUP_DISCUSSION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `ID_MESSAGE` int NOT NULL AUTO_INCREMENT,
  `ID_USER` int DEFAULT NULL,
  `ID_GROUP_DISCUSSION` int DEFAULT NULL,
  `CONTENT` text,
  `file_path` varchar(100) NOT NULL,
  `TIMESTAMP` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_MESSAGE`),
  KEY `fk_me_us` (`ID_USER`),
  KEY `fk_me_gc` (`ID_GROUP_DISCUSSION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `ID_MODULE` int NOT NULL AUTO_INCREMENT,
  `MODULE_NAME` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_MODULE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules_fillieres_association`
--

DROP TABLE IF EXISTS `modules_fillieres_association`;
CREATE TABLE IF NOT EXISTS `modules_fillieres_association` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_filliere` int NOT NULL,
  `id_module` int NOT NULL,
  PRIMARY KEY (`id`,`id_filliere`,`id_module`),
  KEY `fk_assoc_fil` (`id_filliere`),
  KEY `fk_assoc_mod` (`id_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_Role` int NOT NULL AUTO_INCREMENT,
  `name_role` varchar(25) NOT NULL,
  PRIMARY KEY (`id_Role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID_USER` int NOT NULL AUTO_INCREMENT,
  `FIRST_NAME` varchar(25) DEFAULT NULL,
  `LAST_NAME` varchar(25) DEFAULT NULL,
  `EMAIL` varchar(256) DEFAULT NULL,
  `PASSWORD` varchar(25) DEFAULT NULL,
  `ROLE` int DEFAULT NULL,
  `image` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user.png',
  PRIMARY KEY (`ID_USER`),
  UNIQUE KEY `EMAIL` (`EMAIL`),
  KEY `fk_user_role` (`ROLE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_fillieres_assoc`
--

DROP TABLE IF EXISTS `users_fillieres_assoc`;
CREATE TABLE IF NOT EXISTS `users_fillieres_assoc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `User_ID` int NOT NULL,
  `Filliere_ID` int NOT NULL,
  PRIMARY KEY (`id`,`User_ID`,`Filliere_ID`),
  KEY `fk_assoc_user` (`User_ID`),
  KEY `fk_assoc_filliere` (`Filliere_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `fk_mo_co` FOREIGN KEY (`ID_MODULE`) REFERENCES `modules` (`ID_MODULE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_us_co` FOREIGN KEY (`ID_TEACHER`) REFERENCES `users` (`ID_USER`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `fk_com_us` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID_USER`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_status_com` FOREIGN KEY (`STATUS`) REFERENCES `complaint_status` (`id_status`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_type_com` FOREIGN KEY (`TYPE`) REFERENCES `complaint_type` (`id_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fillieres`
--
ALTER TABLE `fillieres`
  ADD CONSTRAINT `fk_fl_de` FOREIGN KEY (`ID_DEPARTMENT`) REFERENCES `departments` (`ID_DEPARTMENT`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groupdiscussion`
--
ALTER TABLE `groupdiscussion`
  ADD CONSTRAINT `fk_gc_type` FOREIGN KEY (`TYPE`) REFERENCES `groupdiscussiontype` (`id_gc_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groupmembership`
--
ALTER TABLE `groupmembership`
  ADD CONSTRAINT `fk_gm_gc` FOREIGN KEY (`ID_GROUP_DISCUSSION`) REFERENCES `groupdiscussion` (`ID_GROUP_DISCUSSION`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gm_us` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID_USER`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_me_gc` FOREIGN KEY (`ID_GROUP_DISCUSSION`) REFERENCES `groupdiscussion` (`ID_GROUP_DISCUSSION`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_me_us` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID_USER`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `modules_fillieres_association`
--
ALTER TABLE `modules_fillieres_association`
  ADD CONSTRAINT `fk_assoc_fil` FOREIGN KEY (`id_filliere`) REFERENCES `fillieres` (`ID_FILLIERE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_assoc_mod` FOREIGN KEY (`id_module`) REFERENCES `modules` (`ID_MODULE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`ROLE`) REFERENCES `roles` (`id_Role`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_fillieres_assoc`
--
ALTER TABLE `users_fillieres_assoc`
  ADD CONSTRAINT `fk_assoc_filliere` FOREIGN KEY (`Filliere_ID`) REFERENCES `fillieres` (`ID_FILLIERE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_assoc_user` FOREIGN KEY (`User_ID`) REFERENCES `users` (`ID_USER`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
