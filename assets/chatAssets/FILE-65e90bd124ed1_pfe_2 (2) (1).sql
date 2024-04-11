-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 01, 2024 at 08:35 PM
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
  `TITLE` varchar(50) DEFAULT NULL,
  `DESCRIPTION` text,
  `DUE_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_ASSIGNMENT`),
  KEY `fk_mo_co` (`ID_MODULE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE IF NOT EXISTS `complaints` (
  `ID_COMPLAINT` int NOT NULL AUTO_INCREMENT,
  `complaint` varchar(100) NOT NULL,
  `TYPE` int NOT NULL,
  `STATUS` int NOT NULL DEFAULT '3',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID_USER` int DEFAULT NULL,
  PRIMARY KEY (`ID_COMPLAINT`),
  KEY `fk_com_us` (`ID_USER`),
  KEY `fk_type_com` (`TYPE`),
  KEY `fk_status_com` (`STATUS`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`ID_COMPLAINT`, `complaint`, `TYPE`, `STATUS`, `time`, `ID_USER`) VALUES
(1, 'Need to get back to my class', 2, 3, '2024-02-20 09:22:55', 7);

-- --------------------------------------------------------

--
-- Table structure for table `complaint_status`
--

DROP TABLE IF EXISTS `complaint_status`;
CREATE TABLE IF NOT EXISTS `complaint_status` (
  `id_status` int NOT NULL AUTO_INCREMENT,
  `status_labelle` varchar(25) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `complaint_status`
--

INSERT INTO `complaint_status` (`id_status`, `status_labelle`) VALUES
(1, 'Compleated'),
(2, 'Under Review'),
(3, 'New');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_type`
--

DROP TABLE IF EXISTS `complaint_type`;
CREATE TABLE IF NOT EXISTS `complaint_type` (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `type_labelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `complaint_type`
--

INSERT INTO `complaint_type` (`id_type`, `type_labelle`) VALUES
(1, 'Bug Report'),
(2, 'Not joining your class');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`ID_DEPARTMENT`, `Department_code`, `DEPARTMENT_NAME`) VALUES
(1, 'GI', 'Génie informatique'),
(2, 'GE', 'Génie éléctrique'),
(3, 'TCC', 'Techniques de Commercialisation et de Communication'),
(4, 'TM', 'Techniques de management');

-- --------------------------------------------------------

--
-- Table structure for table `fillieres`
--

DROP TABLE IF EXISTS `fillieres`;
CREATE TABLE IF NOT EXISTS `fillieres` (
  `ID_FILLIERE` int NOT NULL AUTO_INCREMENT,
  `FILLIERE_NAME` varchar(50) DEFAULT NULL,
  `ID_DEPARTMENT` int DEFAULT NULL,
  PRIMARY KEY (`ID_FILLIERE`),
  KEY `fk_fl_de` (`ID_DEPARTMENT`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fillieres`
--

INSERT INTO `fillieres` (`ID_FILLIERE`, `FILLIERE_NAME`, `ID_DEPARTMENT`) VALUES
(1, 'Génie Informatique', 1),
(2, 'Intelligence Artificielle et Technologies Emergent', 1),
(3, 'Développement Web et Multimédia (DWM)', 1),
(4, 'Génie Electrique', 2),
(5, 'Génie Thermique et Energetique', 2),
(6, 'Génie Industriel et Maintenance', 2),
(7, 'Génie Civil', 2),
(8, 'Techniques de Commercialisation et de Communicatio', 3),
(9, 'Commercialisation des Produits Agroalimentaires', 3),
(10, 'Techniques de Management', 4),
(11, 'Finance, Banque et Assurance', 4),
(12, 'Gestion des ressources humaines', 4);

-- --------------------------------------------------------

--
-- Table structure for table `groupdiscussion`
--

DROP TABLE IF EXISTS `groupdiscussion`;
CREATE TABLE IF NOT EXISTS `groupdiscussion` (
  `ID_GROUP_DISCUSSION` int NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) DEFAULT NULL,
  `TYPE` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`ID_GROUP_DISCUSSION`)
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
  `TIMESTAMP` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_MESSAGE`),
  KEY `fk_me_us` (`ID_USER`),
  KEY `fk_me_gc` (`ID_GROUP_DISCUSSION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `ID_MODULE` int NOT NULL AUTO_INCREMENT,
  `MODULE_NAME` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_MODULE`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`ID_MODULE`, `MODULE_NAME`) VALUES
(1, 'Analyse'),
(2, 'Algebre'),
(3, 'JAVA'),
(4, 'Web Dev');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `modules_fillieres_association`
--

INSERT INTO `modules_fillieres_association` (`id`, `id_filliere`, `id_module`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(7, 2, 1),
(8, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_Role` int NOT NULL AUTO_INCREMENT,
  `name_role` varchar(25) NOT NULL,
  PRIMARY KEY (`id_Role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_Role`, `name_role`) VALUES
(1, 'admin'),
(2, 'teacher'),
(3, 'student');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID_USER`, `FIRST_NAME`, `LAST_NAME`, `EMAIL`, `PASSWORD`, `ROLE`, `image`) VALUES
(1, 'admin', '1', 'admin@admin.com', 'admin', 1, 'Pabloman.webp'),
(3, 'admin', '2', 'admin2@admin.com', 'admin', 1, 'user.png'),
(5, 'Said', 'Benmalk', 'Said@gmail.com', 'password', 3, '../../assets/images/5.jpg'),
(7, 'Mohamed', 'Bendifi', 'pod@gmail.com', 'admin', 2, '../../assets/images/7.jpg'),
(14, 'ZAKARIYAE', 'BELAGRAA', 'zakariyablagrae@gmail.com', 'password', 2, '../../assets/images/97e3ed6983ac282fb7676e373354abdf.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users_fillieres_assoc`
--

INSERT INTO `users_fillieres_assoc` (`id`, `User_ID`, `Filliere_ID`) VALUES
(19, 5, 2),
(1, 7, 1),
(2, 7, 2),
(13, 14, 1),
(14, 14, 2),
(15, 14, 3),
(16, 14, 5),
(17, 14, 9),
(18, 14, 12);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `fk_mo_co` FOREIGN KEY (`ID_MODULE`) REFERENCES `modules` (`ID_MODULE`) ON DELETE CASCADE ON UPDATE CASCADE;

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
