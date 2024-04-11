-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 03, 2024 at 12:51 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`ID_ASSIGNMENT`, `ID_MODULE`, `ID_TEACHER`, `TITLE`, `DESCRIPTION`, `file_path`, `DUE_DATE`) VALUES
(1, 3, 44, 'PDO TP', 'Kmloh w siftoh liya', NULL, '2024-03-31 17:47:50'),
(2, 3, 44, 'FILE TP', 'Kmloh w siftoh liya', NULL, '2024-03-31 17:47:50'),
(3, 3, 44, 'TP 5', 'Kmloh w siftoh liya', NULL, '2024-03-31 17:47:50'),
(4, 3, 44, 'TP 6', 'Kmloh w siftoh liya', NULL, '2024-03-31 17:47:50');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`ID_COMPLAINT`, `complaint`, `Respond`, `TYPE`, `STATUS`, `time`, `ID_USER`) VALUES
(1, 'Need to get back to my class', 'safi db mzn', 2, 1, '2024-02-20 08:22:55', 44);

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
  `FILLIERE_NAME` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
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
(8, 'Techniques de Commercialisation et de Communication', 3),
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
  `TYPE` int DEFAULT NULL,
  `entity_type` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_GROUP_DISCUSSION`),
  KEY `fk_gc_type` (`TYPE`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `groupdiscussion`
--

INSERT INTO `groupdiscussion` (`ID_GROUP_DISCUSSION`, `NAME`, `TYPE`, `entity_type`) VALUES
(1, 'Global', 1, 'Global'),
(2, 'Global', 2, 'Global'),
(3, 'Global', 3, 'Global'),
(113, 'Intelligence Artificielle et Technologies Emergent', 1, 'Filliere'),
(114, 'Intelligence Artificielle et Technologies Emergent', 2, 'Filliere'),
(115, 'Intelligence Artificielle et Technologies Emergent', 3, 'Filliere'),
(116, 'Développement Web et Multimédia (DWM)', 1, 'Filliere'),
(117, 'Développement Web et Multimédia (DWM)', 2, 'Filliere'),
(118, 'Développement Web et Multimédia (DWM)', 3, 'Filliere'),
(119, 'Génie Thermique et Energetique', 1, 'Filliere'),
(120, 'Génie Thermique et Energetique', 2, 'Filliere'),
(121, 'Génie Thermique et Energetique', 3, 'Filliere'),
(122, 'Techniques de Commercialisation et de Communicatio', 1, 'Filliere'),
(123, 'Techniques de Commercialisation et de Communicatio', 2, 'Filliere'),
(124, 'Techniques de Commercialisation et de Communicatio', 3, 'Filliere'),
(125, 'GI', 1, 'Department'),
(126, 'GI', 2, 'Department'),
(127, 'GI', 3, 'Department'),
(128, 'GE', 1, 'Department'),
(129, 'GE', 2, 'Department'),
(130, 'GE', 3, 'Department'),
(131, 'TCC', 1, 'Department'),
(132, 'TCC', 2, 'Department'),
(133, 'TCC', 3, 'Department'),
(134, 'Analyse', 1, 'Module'),
(135, 'Analyse', 2, 'Module'),
(136, 'Analyse', 3, 'Module'),
(137, 'Web Dev', 1, 'Module'),
(138, 'Web Dev', 2, 'Module'),
(139, 'Web Dev', 3, 'Module'),
(140, 'Génie Informatique', 1, 'Filliere'),
(141, 'Génie Informatique', 2, 'Filliere'),
(142, 'Génie Informatique', 3, 'Filliere'),
(143, 'Algebre', 1, 'Module'),
(144, 'Algebre', 2, 'Module'),
(145, 'Algebre', 3, 'Module'),
(146, 'JAVA', 1, 'Module'),
(147, 'JAVA', 2, 'Module'),
(148, 'JAVA', 3, 'Module');

-- --------------------------------------------------------

--
-- Table structure for table `groupdiscussiontype`
--

DROP TABLE IF EXISTS `groupdiscussiontype`;
CREATE TABLE IF NOT EXISTS `groupdiscussiontype` (
  `id_gc_type` int NOT NULL AUTO_INCREMENT,
  `libelle_gc_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_gc_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `groupdiscussiontype`
--

INSERT INTO `groupdiscussiontype` (`id_gc_type`, `libelle_gc_type`) VALUES
(1, 'Everyone'),
(2, 'Teachers only'),
(3, 'Students only');

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

--
-- Dumping data for table `groupmembership`
--

INSERT INTO `groupmembership` (`ID_USER`, `ID_GROUP_DISCUSSION`, `ROLE`) VALUES
(44, 1, 'teacher'),
(44, 2, 'teacher'),
(44, 113, 'teacher'),
(44, 114, 'teacher'),
(44, 116, 'teacher'),
(44, 117, 'teacher'),
(44, 119, 'teacher'),
(44, 120, 'teacher'),
(44, 122, 'teacher'),
(44, 123, 'teacher'),
(44, 125, 'teacher'),
(44, 126, 'teacher'),
(44, 128, 'teacher'),
(44, 129, 'teacher'),
(44, 131, 'teacher'),
(44, 132, 'teacher'),
(44, 134, 'teacher'),
(44, 135, 'teacher'),
(44, 137, 'teacher'),
(44, 138, 'teacher'),
(46, 1, 'student'),
(46, 3, 'student'),
(46, 125, 'student'),
(46, 127, 'student'),
(46, 134, 'student'),
(46, 135, 'student'),
(46, 137, 'student'),
(46, 138, 'student'),
(46, 140, 'student'),
(46, 142, 'student'),
(46, 143, 'student'),
(46, 144, 'student'),
(46, 146, 'student'),
(46, 147, 'student'),
(47, 1, 'student'),
(47, 3, 'student'),
(47, 125, 'student'),
(47, 127, 'student'),
(47, 134, 'student'),
(47, 135, 'student'),
(47, 137, 'student'),
(47, 138, 'student'),
(47, 140, 'student'),
(47, 142, 'student'),
(47, 143, 'student'),
(47, 144, 'student'),
(47, 146, 'student'),
(47, 147, 'student');

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
) ENGINE=InnoDB AUTO_INCREMENT=1287 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`ID_MESSAGE`, `ID_USER`, `ID_GROUP_DISCUSSION`, `CONTENT`, `file_path`, `TIMESTAMP`) VALUES
(990, 44, 1, 'dcasc', '', '2024-03-07 00:12:49'),
(991, 44, 125, 'rgdfbv', '', '2024-03-07 00:13:27'),
(992, 44, 1, 'FILE-65e909a9817cf_FILE-65e782f1f3cff_message (1).sql', 'FILE-65e782f1f3cff_message (1).sql', '2024-03-07 00:26:17'),
(993, 44, 1, 'FILE-65e90b77293ad_pfe_2 (2) (1).sql', 'pfe_2 (2) (1).sql', '2024-03-07 00:33:59'),
(994, 44, 1, 'FILE-65e90ba6efec5_user-group-solid.svg', 'user-group-solid.svg', '2024-03-07 00:34:46'),
(995, 44, 1, 'FILE-65e90bd124ed1_pfe_2 (2) (1).sql', 'pfe_2 (2) (1).sql', '2024-03-07 00:35:29'),
(996, 44, 113, 'kjhwuhefwef', '', '2024-03-07 13:15:10'),
(997, 44, 125, 'iuwudgas', '', '2024-03-07 13:16:46'),
(999, 44, 125, 'FILE-65e9be5b27c2f_compressed.tracemonkey-pldi-09.pdf', 'compressed.tracemonkey-pldi-09.pdf', '2024-03-07 13:17:15'),
(1000, 44, 125, 'FILE-65e9be8478e0c_Epic Games Launcher 2024-02-29 17-40-16.mp4', 'Epic Games Launcher 2024-02-29 17-40-16.mp4', '2024-03-07 13:17:56'),
(1002, 44, 125, 'sml', '', '2024-03-07 13:44:37'),
(1004, 44, 125, 'la walo', '', '2024-03-07 13:44:45'),
(1006, 44, 1, 'safasf', '', '2024-03-09 16:02:15'),
(1007, 44, 1, 'asd', '', '2024-03-09 18:26:39'),
(1008, 46, 140, 'salam', '', '2024-03-13 22:59:35'),
(1009, 46, 140, 'how are u ?', '', '2024-03-13 22:59:50'),
(1010, 47, 140, 'hey', '', '2024-03-13 23:00:38'),
(1011, 46, 140, 'asdsad', '', '2024-03-13 23:02:50'),
(1012, 46, 140, 'hello', '', '2024-03-13 23:13:10'),
(1013, 46, 140, 'ss', '', '2024-03-13 23:15:45'),
(1014, 46, 140, 'hello', '', '2024-03-13 23:16:47'),
(1015, 46, 140, 'alo', '', '2024-03-13 23:17:26'),
(1016, 47, 140, 'hhh', '', '2024-03-13 23:17:49'),
(1017, 46, 140, 'kif halk', '', '2024-03-13 23:17:55'),
(1018, 44, 1, 'salam', '', '2024-03-17 22:57:08'),
(1019, 44, 1, 'labas ?', '', '2024-03-17 22:57:13'),
(1020, 44, 1, 'hahaha', '', '2024-03-17 22:58:50'),
(1021, 44, 1, 'helllllo helldivers', '', '2024-03-17 23:00:12'),
(1022, 44, 1, 'SR-65f77e963c53f_audio.wav', 'audio.wav', '2024-03-17 23:36:54'),
(1023, 44, 1, 'SR-65f77f7e17454_audio.wav', 'audio.wav', '2024-03-17 23:40:46'),
(1024, 44, 1, 'zscf', '', '2024-03-17 23:40:59'),
(1025, 44, 1, 'Jjj', '', '2024-03-17 23:46:23'),
(1026, 44, 1, 'salma', '', '2024-03-20 12:29:02'),
(1027, 44, 1, 'salam*', '', '2024-03-20 12:29:35'),
(1028, 44, 1, 'hehe', '', '2024-03-20 13:15:46'),
(1029, 46, 1, 'hellllllo democracy', '', '2024-03-20 13:17:06'),
(1030, 46, 1, 'asdasdas', '', '2024-03-20 13:23:28'),
(1031, 44, 1, 'asjdas', '', '2024-03-20 13:48:34'),
(1032, 44, 1, 'saduasgd', '', '2024-03-20 13:48:35'),
(1033, 44, 1, 'sadoasgud', '', '2024-03-20 13:48:36'),
(1034, 44, 1, 'sadoasud', '', '2024-03-20 13:48:37'),
(1035, 44, 1, 'sadasas', '', '2024-03-20 13:48:37'),
(1036, 44, 1, 'd', '', '2024-03-20 13:48:38'),
(1037, 44, 1, 'asd', '', '2024-03-20 13:48:38'),
(1038, 44, 1, 'asd', '', '2024-03-20 13:48:38'),
(1039, 44, 1, 'asd', '', '2024-03-20 13:48:38'),
(1040, 44, 1, 'as', '', '2024-03-20 13:48:38'),
(1041, 44, 1, 'das', '', '2024-03-20 13:48:38'),
(1042, 44, 1, 'd', '', '2024-03-20 13:48:38'),
(1043, 44, 1, 'das', '', '2024-03-20 13:48:39'),
(1044, 44, 1, 'dasd', '', '2024-03-20 13:48:39'),
(1045, 44, 1, 'as', '', '2024-03-20 13:48:39'),
(1046, 44, 1, 'asd', '', '2024-03-20 13:48:39'),
(1047, 44, 1, 'as', '', '2024-03-20 13:48:40'),
(1048, 44, 1, 'as', '', '2024-03-20 13:48:40'),
(1049, 44, 1, 'das', '', '2024-03-20 13:48:40'),
(1050, 44, 1, 'das', '', '2024-03-20 13:48:40'),
(1051, 44, 1, 'ds', '', '2024-03-20 13:48:40'),
(1052, 44, 1, 'd', '', '2024-03-20 13:48:40'),
(1053, 44, 1, 'sa', '', '2024-03-20 13:48:41'),
(1054, 44, 1, 'ds', '', '2024-03-20 13:48:41'),
(1055, 44, 1, 'das', '', '2024-03-20 13:48:41'),
(1056, 44, 1, 's', '', '2024-03-20 13:48:41'),
(1057, 44, 1, 'ds', '', '2024-03-20 13:48:41'),
(1058, 44, 1, 'd', '', '2024-03-20 13:48:41'),
(1059, 44, 1, 'as', '', '2024-03-20 13:48:41'),
(1060, 44, 1, 'das', '', '2024-03-20 13:48:42'),
(1061, 44, 1, 'das', '', '2024-03-20 13:48:42'),
(1062, 44, 1, 'd', '', '2024-03-20 13:48:42'),
(1063, 44, 1, 'asd', '', '2024-03-20 13:48:42'),
(1064, 44, 1, 'as', '', '2024-03-20 13:48:42'),
(1065, 44, 1, 'd', '', '2024-03-20 13:48:42'),
(1066, 44, 1, 's', '', '2024-03-20 13:48:43'),
(1067, 44, 1, 'salam', '', '2024-03-20 14:09:36'),
(1068, 44, 1, 'alo', '', '2024-03-20 14:09:38'),
(1069, 44, 1, 'asdas', '', '2024-03-20 15:00:04'),
(1070, 44, 1, 'asdasd', '', '2024-03-20 15:03:22'),
(1071, 44, 1, 'asd', '', '2024-03-20 15:06:54'),
(1072, 44, 1, 'w', '', '2024-03-20 15:10:47'),
(1073, 44, 1, 's', '', '2024-03-20 15:11:27'),
(1074, 44, 1, 'wa', '', '2024-03-20 15:12:26'),
(1075, 44, 1, 'mi', '', '2024-03-20 15:15:56'),
(1076, 44, 125, 'alo', '', '2024-03-20 15:16:32'),
(1077, 44, 125, 'asas', '', '2024-03-20 15:16:40'),
(1078, 44, 125, 'miaw', '', '2024-03-20 15:16:43'),
(1079, 44, 1, 'sassaassa', '', '2024-03-20 15:16:59'),
(1080, 44, 1, 's', '', '2024-03-20 15:20:17'),
(1081, 44, 1, 'ssaaaaaaaaaaaa', '', '2024-03-20 15:21:52'),
(1082, 44, 1, 'maaaaaaaaa', '', '2024-03-20 15:22:56'),
(1083, 44, 1, '3aw', '', '2024-03-20 15:23:01'),
(1084, 44, 116, 'asdsada', '', '2024-03-20 15:23:03'),
(1085, 44, 1, 'me And you', '', '2024-03-20 15:33:39'),
(1086, 44, 1, 'me jj', '', '2024-03-20 15:33:55'),
(1087, 44, 1, 'ss', '', '2024-03-20 15:34:00'),
(1088, 44, 1, 'aloooooooo', '', '2024-03-20 15:36:00'),
(1089, 46, 1, 'hehe', '', '2024-03-20 15:37:26'),
(1090, 44, 1, 'miaw', '', '2024-03-20 15:37:34'),
(1091, 44, 1, 'salam', '', '2024-03-20 15:47:52'),
(1092, 46, 1, 'how are u ?', '', '2024-03-20 15:47:58'),
(1093, 44, 1, 'FILE-65fb0541f1031_Miguel Angeles - -slowedandreverbstudio.wav', 'Miguel Angeles - -slowedandreverbstudio.wav', '2024-03-20 15:48:17'),
(1094, 46, 1, 'FILE-65fb05497eb2d_Screenshot 2023-05-16 153013.png', 'Screenshot 2023-05-16 153013.png', '2024-03-20 15:48:25'),
(1095, 44, 1, 'salam', '', '2024-03-20 15:55:35'),
(1096, 44, 1, 'hello', '', '2024-03-20 15:55:37'),
(1097, 44, 1, '1', '', '2024-03-20 15:55:39'),
(1098, 44, 1, '2', '', '2024-03-20 15:55:39'),
(1099, 44, 1, '3', '', '2024-03-20 15:55:40'),
(1100, 44, 1, '4', '', '2024-03-20 15:55:41'),
(1101, 44, 1, '5', '', '2024-03-20 15:55:41'),
(1102, 44, 1, '6', '', '2024-03-20 15:55:42'),
(1103, 44, 1, '7', '', '2024-03-20 15:55:42'),
(1104, 44, 1, '8', '', '2024-03-20 15:55:43'),
(1105, 44, 1, '9', '', '2024-03-20 15:55:43'),
(1106, 44, 1, '10', '', '2024-03-20 15:55:46'),
(1107, 44, 1, '12', '', '2024-03-20 15:55:46'),
(1108, 44, 1, '11', '', '2024-03-20 15:55:48'),
(1109, 44, 1, '13', '', '2024-03-20 15:55:49'),
(1110, 44, 1, '14', '', '2024-03-20 15:55:50'),
(1111, 44, 1, '15', '', '2024-03-20 15:55:51'),
(1112, 44, 1, '16', '', '2024-03-20 15:55:52'),
(1113, 44, 1, '17', '', '2024-03-20 15:55:53'),
(1114, 44, 1, '18', '', '2024-03-20 15:55:55'),
(1115, 44, 1, '19', '', '2024-03-20 15:55:56'),
(1116, 46, 1, 'ma', '', '2024-03-20 15:56:19'),
(1117, 46, 1, '2', '', '2024-03-20 15:56:20'),
(1118, 46, 1, '3', '', '2024-03-20 15:56:21'),
(1119, 46, 1, '4', '', '2024-03-20 15:56:21'),
(1120, 46, 1, '5', '', '2024-03-20 15:56:21'),
(1121, 46, 1, '6', '', '2024-03-20 15:56:22'),
(1122, 46, 1, '7', '', '2024-03-20 15:56:22'),
(1123, 46, 1, '8', '', '2024-03-20 15:56:23'),
(1124, 46, 1, '9', '', '2024-03-20 15:56:23'),
(1125, 46, 1, '10', '', '2024-03-20 15:56:25'),
(1126, 46, 1, '11', '', '2024-03-20 15:56:25'),
(1127, 46, 1, '12', '', '2024-03-20 15:56:26'),
(1128, 46, 1, '13', '', '2024-03-20 15:56:27'),
(1129, 46, 1, '14', '', '2024-03-20 15:56:28'),
(1130, 46, 1, '15', '', '2024-03-20 15:56:28'),
(1131, 46, 1, '16', '', '2024-03-20 15:56:29'),
(1132, 46, 1, '17', '', '2024-03-20 15:56:30'),
(1133, 46, 1, '18', '', '2024-03-20 15:56:32'),
(1134, 46, 1, '19', '', '2024-03-20 15:56:33'),
(1135, 46, 1, '20', '', '2024-03-20 15:56:36'),
(1136, 46, 1, '21', '', '2024-03-20 15:56:38'),
(1137, 44, 1, '22', '', '2024-03-20 15:56:40'),
(1138, 46, 1, '1', '', '2024-03-20 16:03:26'),
(1139, 46, 1, '2', '', '2024-03-20 16:03:28'),
(1140, 46, 1, '3', '', '2024-03-20 16:03:28'),
(1141, 46, 1, '4', '', '2024-03-20 16:03:29'),
(1142, 46, 1, '5', '', '2024-03-20 16:03:29'),
(1143, 46, 1, '6', '', '2024-03-20 16:03:29'),
(1144, 46, 1, '7', '', '2024-03-20 16:03:30'),
(1145, 46, 1, '8', '', '2024-03-20 16:03:30'),
(1146, 46, 1, '9', '', '2024-03-20 16:03:31'),
(1147, 46, 1, '10', '', '2024-03-20 16:03:33'),
(1148, 46, 1, '11', '', '2024-03-20 16:03:34'),
(1149, 46, 1, '12', '', '2024-03-20 16:03:34'),
(1150, 46, 1, '13', '', '2024-03-20 16:03:35'),
(1151, 46, 1, '14', '', '2024-03-20 16:03:36'),
(1152, 46, 1, '15', '', '2024-03-20 16:03:37'),
(1153, 46, 1, '16', '', '2024-03-20 16:03:38'),
(1154, 46, 1, '17', '', '2024-03-20 16:03:39'),
(1155, 46, 1, '18', '', '2024-03-20 16:03:40'),
(1156, 46, 1, '19', '', '2024-03-20 16:03:41'),
(1157, 46, 1, '20', '', '2024-03-20 16:03:42'),
(1158, 46, 1, '21', '', '2024-03-20 16:03:43'),
(1159, 44, 1, '1', '', '2024-03-20 16:04:18'),
(1160, 44, 1, 's', '', '2024-03-20 16:04:30'),
(1161, 46, 1, 'salam', '', '2024-03-20 16:13:13'),
(1162, 46, 1, 'FILE-65fb0b1fb4b87_Screenshot 2023-05-18 152212.png', 'Screenshot 2023-05-18 152212.png', '2024-03-20 16:13:19'),
(1163, 46, 1, 'FILE-65fb0b2c55d26_Screenshot 2023-05-24 142115.png', 'Screenshot 2023-05-24 142115.png', '2024-03-20 16:13:32'),
(1164, 44, 1, 'SR-65fb0b43e92de_audio.wav', 'audio.wav', '2024-03-20 16:13:55'),
(1165, 46, 1, 'SR-65fb0b4e5b4c3_audio.wav', 'audio.wav', '2024-03-20 16:14:06'),
(1166, 44, 1, 'hehe', '', '2024-03-20 16:14:30'),
(1167, 44, 1, '1', '', '2024-03-20 16:17:39'),
(1168, 44, 1, '2', '', '2024-03-20 16:17:40'),
(1169, 44, 1, '3', '', '2024-03-20 16:17:40'),
(1170, 44, 1, '4', '', '2024-03-20 16:17:41'),
(1171, 44, 1, '5', '', '2024-03-20 16:17:41'),
(1172, 44, 1, '6', '', '2024-03-20 16:17:42'),
(1173, 44, 1, '7', '', '2024-03-20 16:17:42'),
(1174, 44, 1, '8', '', '2024-03-20 16:17:44'),
(1175, 44, 1, '9', '', '2024-03-20 16:17:45'),
(1176, 44, 1, '1', '', '2024-03-20 16:18:23'),
(1177, 44, 1, '2', '', '2024-03-20 16:18:24'),
(1178, 44, 1, '3', '', '2024-03-20 16:18:24'),
(1179, 44, 1, '4', '', '2024-03-20 16:18:25'),
(1180, 44, 1, '5', '', '2024-03-20 16:18:25'),
(1181, 44, 1, '6', '', '2024-03-20 16:18:26'),
(1182, 44, 1, '7', '', '2024-03-20 16:18:26'),
(1183, 44, 1, '8', '', '2024-03-20 16:18:28'),
(1184, 44, 1, '9', '', '2024-03-20 16:18:28'),
(1185, 44, 1, '10', '', '2024-03-20 16:18:31'),
(1186, 44, 1, '11', '', '2024-03-20 16:18:31'),
(1187, 44, 1, '12', '', '2024-03-20 16:18:32'),
(1188, 44, 1, '13', '', '2024-03-20 16:18:32'),
(1189, 44, 1, '14', '', '2024-03-20 16:18:33'),
(1190, 44, 1, '15', '', '2024-03-20 16:18:34'),
(1191, 44, 1, '16', '', '2024-03-20 16:18:35'),
(1192, 44, 1, '1', '', '2024-03-20 16:18:36'),
(1193, 44, 1, '1', '', '2024-03-20 16:18:36'),
(1194, 44, 1, '2', '', '2024-03-20 16:18:37'),
(1195, 44, 1, '3', '', '2024-03-20 16:18:38'),
(1196, 44, 1, '4', '', '2024-03-20 16:18:39'),
(1197, 44, 1, '5', '', '2024-03-20 16:18:40'),
(1198, 44, 1, 'asd', '', '2024-03-20 16:18:44'),
(1199, 44, 1, 'q', '', '2024-03-20 16:19:06'),
(1200, 44, 1, 'q', '', '2024-03-20 16:19:07'),
(1201, 44, 1, 'q', '', '2024-03-20 16:19:07'),
(1202, 44, 1, 'q', '', '2024-03-20 16:19:07'),
(1203, 44, 1, 'q', '', '2024-03-20 16:19:07'),
(1204, 44, 1, 'q', '', '2024-03-20 16:19:07'),
(1205, 44, 1, 'q', '', '2024-03-20 16:19:07'),
(1206, 44, 1, 'q', '', '2024-03-20 16:19:08'),
(1207, 44, 1, 'q', '', '2024-03-20 16:19:08'),
(1208, 44, 1, 'q', '', '2024-03-20 16:19:08'),
(1209, 44, 1, 'qd', '', '2024-03-20 16:19:08'),
(1210, 44, 1, 'sff', '', '2024-03-20 16:19:09'),
(1211, 44, 1, 'sd', '', '2024-03-20 16:19:09'),
(1212, 44, 1, 'fsd', '', '2024-03-20 16:19:09'),
(1213, 44, 1, 'fs', '', '2024-03-20 16:19:09'),
(1214, 44, 1, 'f', '', '2024-03-20 16:19:09'),
(1215, 44, 1, 'fs', '', '2024-03-20 16:19:09'),
(1216, 44, 1, 'ds', '', '2024-03-20 16:19:10'),
(1217, 44, 1, 'd', '', '2024-03-20 16:19:11'),
(1218, 44, 1, 'fs', '', '2024-03-20 16:19:12'),
(1219, 44, 1, 'q', '', '2024-03-20 16:19:13'),
(1220, 44, 1, 'sf', '', '2024-03-20 16:19:15'),
(1221, 44, 1, 'f', '', '2024-03-20 16:19:16'),
(1222, 44, 1, 'd', '', '2024-03-20 16:19:17'),
(1223, 44, 1, 'f', '', '2024-03-20 16:19:17'),
(1224, 44, 1, 'f', '', '2024-03-20 16:19:17'),
(1225, 44, 1, 'f', '', '2024-03-20 16:19:18'),
(1226, 44, 1, 'f', '', '2024-03-20 16:19:18'),
(1227, 44, 1, 'f', '', '2024-03-20 16:19:18'),
(1228, 44, 1, 'f', '', '2024-03-20 16:19:18'),
(1229, 44, 1, 'f', '', '2024-03-20 16:19:18'),
(1230, 44, 1, 'f', '', '2024-03-20 16:19:19'),
(1231, 44, 1, 'f', '', '2024-03-20 16:19:19'),
(1232, 44, 1, 'f', '', '2024-03-20 16:19:19'),
(1233, 44, 1, 'f', '', '2024-03-20 16:19:19'),
(1234, 44, 1, 'ff', '', '2024-03-20 16:19:19'),
(1235, 44, 1, 'ff', '', '2024-03-20 16:19:20'),
(1236, 44, 1, 'f', '', '2024-03-20 16:19:20'),
(1237, 44, 1, 'f', '', '2024-03-20 16:19:20'),
(1238, 44, 1, 'f', '', '2024-03-20 16:19:20'),
(1239, 44, 1, 'f', '', '2024-03-20 16:19:20'),
(1240, 44, 1, 'f', '', '2024-03-20 16:19:20'),
(1241, 44, 1, 'f', '', '2024-03-20 16:19:21'),
(1242, 44, 1, 'f', '', '2024-03-20 16:19:21'),
(1243, 44, 1, 'f', '', '2024-03-20 16:19:21'),
(1244, 44, 1, 'f', '', '2024-03-20 16:19:21'),
(1245, 44, 1, 'f', '', '2024-03-20 16:19:21'),
(1246, 44, 1, 'f', '', '2024-03-20 16:19:21'),
(1247, 44, 1, 'asfaf', '', '2024-03-20 16:19:38'),
(1248, 44, 1, 'safas', '', '2024-03-20 16:19:38'),
(1249, 44, 1, 'fsa', '', '2024-03-20 16:19:39'),
(1250, 44, 1, 'fa', '', '2024-03-20 16:19:39'),
(1251, 44, 1, 'f', '', '2024-03-20 16:19:39'),
(1252, 44, 1, 'sdf', '', '2024-03-20 16:19:39'),
(1253, 44, 1, 'sd', '', '2024-03-20 16:19:39'),
(1254, 44, 1, 'sdf', '', '2024-03-20 16:19:39'),
(1255, 44, 1, 'sdfsdf', '', '2024-03-20 16:19:40'),
(1256, 44, 1, 'sdf', '', '2024-03-20 16:19:40'),
(1257, 44, 1, 'sd', '', '2024-03-20 16:19:40'),
(1258, 44, 1, 'fsd', '', '2024-03-20 16:19:40'),
(1259, 44, 1, 'f', '', '2024-03-20 16:19:40'),
(1260, 44, 1, 'sf', '', '2024-03-20 16:19:41'),
(1261, 44, 1, 'sdf', '', '2024-03-20 16:19:41'),
(1262, 44, 1, 'sdf', '', '2024-03-20 16:19:41'),
(1263, 44, 1, 'd', '', '2024-03-20 16:19:41'),
(1264, 44, 1, 'fs', '', '2024-03-20 16:19:41'),
(1265, 44, 1, 'fsd', '', '2024-03-20 16:19:41'),
(1266, 44, 1, 'dsfsdf', '', '2024-03-20 16:19:43'),
(1267, 44, 1, 'sfsdf', '', '2024-03-20 16:19:44'),
(1268, 44, 1, 'FILE-65fb0ce1407ac_Miguel Angeles - .mp3', 'Miguel Angeles - .mp3', '2024-03-20 16:20:49'),
(1269, 46, 1, 'FILE-65fb0def86374_Screenshot 2023-05-16 153715.png', 'Screenshot 2023-05-16 153715.png', '2024-03-20 16:25:19'),
(1270, 44, 1, 'FILE-65fb0df8e1c0c_Rich Amiri - One Call (Official Audio)-slowedandreverbstudio.wav', 'Rich Amiri - One Call (Official Audio)-slowedandreverbstudio.wav', '2024-03-20 16:25:28'),
(1271, 44, 1, 'FILE-65fb0e0454e4e_the weeknd - starboy (slowed  reverb)-slowedandreverbstudio.wav', 'the weeknd - starboy (slowed  reverb)-slowedandreverbstudio.wav', '2024-03-20 16:25:40'),
(1272, 44, 125, 'FILE-65fb0e1283613_Miguel Angeles - -slowedandreverbstudio.wav', 'Miguel Angeles - -slowedandreverbstudio.wav', '2024-03-20 16:25:54'),
(1273, 44, 1, 'salam', '', '2024-03-20 16:49:14'),
(1274, 44, 1, 'ax bghiti ?', '', '2024-03-20 16:49:22'),
(1275, 44, 1, 'xi haja', '', '2024-03-20 16:51:18'),
(1276, 44, 134, 'hehe', '', '2024-03-26 18:28:16'),
(1277, 44, 134, 'mooooooooo', '', '2024-03-26 18:29:45'),
(1278, 44, 134, 'wit', '', '2024-03-26 18:29:57'),
(1279, 44, 134, 'kayf l hal', '', '2024-03-26 18:30:02'),
(1280, 44, 137, 'salam', '', '2024-03-27 12:18:14'),
(1281, 46, 1, 'SR-6604112aca203_audio.wav', 'audio.wav', '2024-03-27 12:29:30'),
(1282, 46, 1, 'FILE-660411407789c_pfe_2 (9).sql', 'pfe_2 (9).sql', '2024-03-27 12:29:52'),
(1283, 46, 1, 'FILE-660411498c5ea_1aec042a9746a4974b83f9b11f987806.jpg', '1aec042a9746a4974b83f9b11f987806.jpg', '2024-03-27 12:30:01'),
(1284, 46, 1, 'FILE-660411714736b_Epic Games Launcher 2024-02-29 17-40-16.mp4', 'Epic Games Launcher 2024-02-29 17-40-16.mp4', '2024-03-27 12:30:41'),
(1285, 46, 1, 'FILE-6604118333ff7_Belagraa_Zakariyae_CV (5).pdf', 'Belagraa_Zakariyae_CV (5).pdf', '2024-03-27 12:30:59'),
(1286, 44, 1, 'SR-66045521c916b_audio.wav', 'audio.wav', '2024-03-27 17:19:29');

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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID_USER`, `FIRST_NAME`, `LAST_NAME`, `EMAIL`, `PASSWORD`, `ROLE`, `image`) VALUES
(1, 'admin', '1', 'admin@admin.com', 'admin', 1, 'Pabloman.webp'),
(44, 'test', 'test', 'test@test.test', 'test', 2, '../../assets/images/user.png'),
(46, 'user', '1', 'user1@estm.ma', 'password', 3, '../../assets/images/user.png'),
(47, 'user', '2', 'user2@estm.ma', 'password', 3, '../../assets/images/user.png');

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
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users_fillieres_assoc`
--

INSERT INTO `users_fillieres_assoc` (`id`, `User_ID`, `Filliere_ID`) VALUES
(73, 44, 2),
(74, 44, 3),
(75, 44, 5),
(76, 44, 8),
(78, 46, 1),
(79, 47, 1);

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
