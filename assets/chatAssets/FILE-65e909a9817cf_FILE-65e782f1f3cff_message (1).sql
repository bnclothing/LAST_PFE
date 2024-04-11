-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 02, 2024 at 08:06 PM
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
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `ID_MESSAGE` int NOT NULL AUTO_INCREMENT,
  `ID_USER` int DEFAULT NULL,
  `ID_GROUP_DISCUSSION` int DEFAULT NULL,
  `CONTENT` text,
  `TIMESTAMP` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_MESSAGE`),
  KEY `fk_me_us` (`ID_USER`),
  KEY `fk_me_gc` (`ID_GROUP_DISCUSSION`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`ID_MESSAGE`, `ID_USER`, `ID_GROUP_DISCUSSION`, `CONTENT`, `TIMESTAMP`) VALUES
(18, 28, 1, 'Hello', '2024-03-02 19:00:24'),
(19, 28, 11, 'sir tba3d mni', '2024-03-02 19:00:38'),
(20, 32, 1, 'malk', '2024-03-02 19:02:26'),
(21, 28, 1, 'bghit bosa', '2024-03-02 19:02:37'),
(22, 32, 1, 'makhaskx wahd lhaja', '2024-03-02 19:02:53'),
(23, 32, 1, 'alo', '2024-03-02 19:06:25'),
(24, 32, 1, 'alo', '2024-03-02 19:06:27'),
(25, 32, 1, 'alo', '2024-03-02 19:06:28'),
(26, 28, 1, 'as', '2024-03-02 19:06:32'),
(27, 32, 1, 'sa', '2024-03-02 19:07:56'),
(28, 28, 1, 'as', '2024-03-02 19:08:03'),
(29, 28, 1, 'sadasd', '2024-03-02 19:08:06'),
(30, 32, 1, 'asdasd', '2024-03-02 19:08:08'),
(31, 38, 1, 'salam', '2024-03-02 19:32:55'),
(32, 38, 1, 'kayf lhal', '2024-03-02 19:34:39'),
(33, 28, 1, 'mabikhirx', '2024-03-02 19:34:48'),
(34, 38, 1, 'asdasd', '2024-03-02 19:35:18'),
(35, 28, 1, 'alo', '2024-03-02 19:37:12'),
(36, 28, 1, 's', '2024-03-02 19:42:39'),
(37, 28, 1, 'asdasd', '2024-03-02 19:42:44'),
(38, 28, 1, 'asdasd', '2024-03-02 19:42:58'),
(39, 28, 1, 'asdasd', '2024-03-02 19:43:00'),
(40, 28, 1, 'asdasd', '2024-03-02 19:43:03'),
(41, 38, 1, 'hello', '2024-03-02 19:44:15'),
(42, 38, 1, 'salam', '2024-03-02 19:46:06'),
(43, 38, 1, 'alo', '2024-03-02 19:46:28'),
(44, 28, 1, 'ahya fin wsalti', '2024-03-02 19:55:00'),
(45, 38, 1, 'mzl 3at tnxof xno ndir', '2024-03-02 19:55:10'),
(46, 38, 1, 'asdasd', '2024-03-02 20:03:36');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_me_gc` FOREIGN KEY (`ID_GROUP_DISCUSSION`) REFERENCES `groupdiscussion` (`ID_GROUP_DISCUSSION`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_me_us` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID_USER`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
