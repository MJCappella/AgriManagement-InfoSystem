-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.36 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for amis_db
DROP DATABASE IF EXISTS `amis_db`;
CREATE DATABASE IF NOT EXISTS `amis_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `amis_db`;

-- Dumping structure for table amis_db.account_status
DROP TABLE IF EXISTS `account_status`;
CREATE TABLE IF NOT EXISTS `account_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` enum('active','suspended','inactive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.account_status: ~3 rows (approximately)
INSERT INTO `account_status` (`id`, `name`) VALUES
	(1, 'active'),
	(2, 'suspended'),
	(3, 'inactive');

-- Dumping structure for table amis_db.admin
DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `user_type_id` int NOT NULL DEFAULT '6',
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_number` int NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `account_status` enum('active','suspended','inactive') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email` (`email`),
  KEY `user_type_id` (`user_type_id`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_type_tbl` (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.admin: ~2 rows (approximately)
INSERT INTO `admin` (`admin_id`, `user_type_id`, `username`, `email`, `id_number`, `password`, `account_status`, `created_at`, `updated_at`) VALUES
	(1, 6, 'John Smith', 'johnsmith@yahoo.com', 13902253, 'd0d8bda2ec288938dbed16522a638011', 'active', '2024-07-25 18:33:22', '2024-07-25 18:33:22'),
	(2, 6, 'James Bond', 'jamesbond@gmail.com', 23457642, 'd0d8bda2ec288938dbed16522a638011', 'active', '2024-07-25 19:16:29', '2024-07-25 19:16:29');

-- Dumping structure for table amis_db.adverts
DROP TABLE IF EXISTS `adverts`;
CREATE TABLE IF NOT EXISTS `adverts` (
  `advert_id` int NOT NULL AUTO_INCREMENT,
  `farmer_id` int DEFAULT NULL,
  `crop_id` int DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int DEFAULT NULL,
  `unit` enum('count','kgs','debes','crates','sacks') NOT NULL DEFAULT 'count',
  `date` date NOT NULL,
  `status` enum('available','unavailable','finished') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`advert_id`),
  KEY `farmer_id` (`farmer_id`),
  KEY `crop_id` (`crop_id`),
  CONSTRAINT `adverts_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`),
  CONSTRAINT `adverts_ibfk_2` FOREIGN KEY (`crop_id`) REFERENCES `crops` (`crop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.adverts: ~4 rows (approximately)
INSERT INTO `adverts` (`advert_id`, `farmer_id`, `crop_id`, `price`, `quantity`, `unit`, `date`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 4, 2, 99.00, 89, 'kgs', '2024-07-27', 'available', '2024-07-27 12:47:54', 4, '2024-07-27 20:12:19', 4),
	(2, 4, 1, 290.00, 100, 'sacks', '2024-07-27', 'available', '2024-07-27 13:13:19', 4, '2024-07-27 20:05:31', 4),
	(4, 4, 11, 113.00, 7, 'kgs', '2024-08-10', 'available', '2024-08-10 19:14:58', 4, '2024-08-10 19:14:58', NULL),
	(5, 4, 9, 100.00, 1000, 'kgs', '2024-08-10', 'available', '2024-08-10 20:17:00', 4, '2024-08-10 20:17:00', NULL);

-- Dumping structure for table amis_db.advert_status
DROP TABLE IF EXISTS `advert_status`;
CREATE TABLE IF NOT EXISTS `advert_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` enum('available','unavailable','finished') NOT NULL DEFAULT 'available',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.advert_status: ~3 rows (approximately)
INSERT INTO `advert_status` (`id`, `name`) VALUES
	(1, 'available'),
	(2, 'unavailable'),
	(3, 'finished');

-- Dumping structure for table amis_db.buyer
DROP TABLE IF EXISTS `buyer`;
CREATE TABLE IF NOT EXISTS `buyer` (
  `buyer_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `account_status` enum('active','suspended','inactive') NOT NULL DEFAULT 'inactive',
  `subscription` enum('subscribed','unsubscribed') NOT NULL DEFAULT 'unsubscribed',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`buyer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.buyer: ~23 rows (approximately)
INSERT INTO `buyer` (`buyer_id`, `username`, `email`, `password`, `phone`, `account_status`, `subscription`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'Brenda Joe', 'bndunguedu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0720543370', 'suspended', 'unsubscribed', '2024-07-22 07:31:06', NULL, '2024-08-12 21:49:54', NULL),
	(2, 'John Njogu', 'pndungu081@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0730513371', 'active', 'subscribed', '2024-07-24 22:55:53', NULL, '2024-08-12 21:46:14', NULL),
	(3, 'James Bond', 'jamesbond@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '723654555', 'active', 'unsubscribed', '2024-07-25 19:19:01', NULL, '2024-07-25 19:38:22', NULL),
	(4, 'rjoules0', 'cillyes0@example.com', 'e10adc3949ba59abbe56e057f20f883e', '6926702645', 'inactive', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-08-10 22:21:56', NULL),
	(5, 'apoppleston1', 'jdemageard1@dell.com', 'e10adc3949ba59abbe56e057f20f883e', '5711054580', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(6, 'lsavell2', 'aturbefield2@hibu.com', 'e10adc3949ba59abbe56e057f20f883e', '8192088951', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(7, 'mhedgeman3', 'ilandor3@reference.com', 'e10adc3949ba59abbe56e057f20f883e', '9476476046', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(8, 'dpochon4', 'ffrangello4@toplist.cz', 'e10adc3949ba59abbe56e057f20f883e', '3811039793', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(9, 'ecockerton5', 'ckienzle5@va.gov', 'e10adc3949ba59abbe56e057f20f883e', '6505262597', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(10, 'epanton6', 'vhasnney6@free.fr', 'e10adc3949ba59abbe56e057f20f883e', '5259770168', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(11, 'ihansed7', 'fjorck7@php.net', 'e10adc3949ba59abbe56e057f20f883e', '2189106966', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(12, 'jdwane8', 'owhitchurch8@desdev.cn', 'e10adc3949ba59abbe56e057f20f883e', '5665493053', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(13, 'cmccracken9', 'nshuttlewood9@oaic.gov.au', 'e10adc3949ba59abbe56e057f20f883e', '4563777466', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(14, 'nohalleghanea', 'mdorneya@trellian.com', 'e10adc3949ba59abbe56e057f20f883e', '8599256728', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(15, 'vbennenb', 'akidbyb@themeforest.net', 'e10adc3949ba59abbe56e057f20f883e', '2057820065', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(16, 'drainsburyc', 'ainnocentic@amazon.co.uk', 'e10adc3949ba59abbe56e057f20f883e', '1513531845', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(17, 'dcattanachd', 'twoolattd@google.ca', 'e10adc3949ba59abbe56e057f20f883e', '1528825312', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(18, 'kiglesiaze', 'glyngstede@barnesandnoble.com', 'e10adc3949ba59abbe56e057f20f883e', '8261449389', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(19, 'fyanelef', 'blinsleyf@marriott.com', 'e10adc3949ba59abbe56e057f20f883e', '3309674644', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(20, 'hwhitehorneg', 'kmcfaddeng@eepurl.com', 'e10adc3949ba59abbe56e057f20f883e', '5143347935', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(21, 'esummersh', 'mcolliarh@networksolutions.com', 'e10adc3949ba59abbe56e057f20f883e', '3859540808', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(22, 'jshrevei', 'scaheyi@rakuten.co.jp', 'e10adc3949ba59abbe56e057f20f883e', '1064188254', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(23, 'acawsej', 'efillaryj@google.it', 'e10adc3949ba59abbe56e057f20f883e', '5906499074', 'active', 'unsubscribed', '2024-07-25 19:37:26', NULL, '2024-07-25 19:38:22', NULL),
	(24, 'Best Buyer', 'pndunguedu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0706077443', 'active', 'subscribed', '2024-07-27 10:43:26', NULL, '2024-08-13 07:16:42', NULL);

-- Dumping structure for table amis_db.compliance_certificates
DROP TABLE IF EXISTS `compliance_certificates`;
CREATE TABLE IF NOT EXISTS `compliance_certificates` (
  `certificate_id` int NOT NULL AUTO_INCREMENT,
  `farmer_id` int DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  `approved_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`certificate_id`),
  KEY `farmer_id` (`farmer_id`),
  KEY `approved_by` (`approved_by`),
  CONSTRAINT `compliance_certificates_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`),
  CONSTRAINT `compliance_certificates_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `admin` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.compliance_certificates: ~0 rows (approximately)

-- Dumping structure for table amis_db.counties
DROP TABLE IF EXISTS `counties`;
CREATE TABLE IF NOT EXISTS `counties` (
  `county_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `capital` varchar(100) DEFAULT NULL,
  `code` int NOT NULL,
  PRIMARY KEY (`county_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.counties: ~47 rows (approximately)
INSERT INTO `counties` (`county_id`, `name`, `capital`, `code`) VALUES
	(1, 'Baringo', NULL, 30),
	(2, 'Bomet', NULL, 36),
	(3, 'Bungoma', NULL, 39),
	(4, 'Busia', NULL, 40),
	(5, 'Elgeyo-Marakwet', NULL, 28),
	(6, 'Embu', NULL, 14),
	(7, 'Garissa', NULL, 7),
	(8, 'Homa Bay', NULL, 43),
	(9, 'Isiolo', NULL, 11),
	(10, 'Kajiado', NULL, 34),
	(11, 'Kakamega', NULL, 37),
	(12, 'Kericho', NULL, 35),
	(13, 'Kiambu', NULL, 22),
	(14, 'Kilifi', NULL, 3),
	(15, 'Kirinyaga', NULL, 20),
	(16, 'Kisii', NULL, 45),
	(17, 'Kisumu', NULL, 42),
	(18, 'Kitui', NULL, 15),
	(19, 'Kwale', NULL, 2),
	(20, 'Laikipia', NULL, 31),
	(21, 'Lamu', NULL, 5),
	(22, 'Machakos', NULL, 16),
	(23, 'Makueni', NULL, 17),
	(24, 'Mandera', NULL, 9),
	(25, 'Marsabit', NULL, 10),
	(26, 'Meru', NULL, 12),
	(27, 'Migori', NULL, 44),
	(28, 'Mombasa', NULL, 1),
	(29, 'Murang\'a', NULL, 21),
	(30, 'Nairobi', NULL, 47),
	(31, 'Nakuru', NULL, 32),
	(32, 'Nandi', NULL, 29),
	(33, 'Narok', NULL, 33),
	(34, 'Nyamira', NULL, 46),
	(35, 'Nyandarua', NULL, 18),
	(36, 'Nyeri', NULL, 19),
	(37, 'Samburu', NULL, 25),
	(38, 'Siaya', NULL, 41),
	(39, 'Taita-Taveta', NULL, 6),
	(40, 'Tana River', NULL, 4),
	(41, 'Tharaka-Nithi', NULL, 13),
	(42, 'Trans-Nzoia', NULL, 26),
	(43, 'Turkana', NULL, 23),
	(44, 'Uasin Gishu', NULL, 27),
	(45, 'Vihiga', NULL, 38),
	(46, 'Wajir', NULL, 8),
	(47, 'West Pokot', NULL, 24);

-- Dumping structure for table amis_db.crops
DROP TABLE IF EXISTS `crops`;
CREATE TABLE IF NOT EXISTS `crops` (
  `crop_id` int NOT NULL AUTO_INCREMENT,
  `cropname` varchar(100) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT '../uploads/images/crops/default.jpg',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`crop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.crops: ~15 rows (approximately)
INSERT INTO `crops` (`crop_id`, `cropname`, `description`, `price`, `image_path`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'potatoes', 'Rich in carbohydrates', 300.00, '../../uploads/images/crops/potatoes.jpg', '2024-07-18 23:38:49', NULL, '2024-07-25 21:13:27', NULL),
	(2, 'Tomato', 'Fruit', 100.00, '../../uploads/images/crops/tomatoes.jpg', '2024-07-18 23:40:30', NULL, '2024-08-12 20:56:48', NULL),
	(3, 'dry maize', 'Red', 100.00, '../../uploads/images/crops/maize.jpg', '2024-07-20 15:16:16', NULL, '2024-07-25 21:22:18', NULL),
	(4, 'Beetroot', 'Rich in red', 100.00, '../../uploads/images/crops/beetroot.jpg', '2024-07-20 15:17:56', NULL, '2024-08-11 00:00:14', NULL),
	(6, 'beans', 'High protein legume', 100.00, '../../uploads/images/crops/beans.jpg', '2024-07-25 21:21:01', NULL, '2024-07-25 21:21:01', NULL),
	(7, 'corn', 'Staple grain', 50.00, '../../uploads/images/crops/corn.jpg', '2024-07-25 21:21:01', NULL, '2024-07-25 21:21:01', NULL),
	(8, 'wheat', 'Common cereal grain', 70.00, '../../uploads/images/crops/wheat.jpg', '2024-07-25 21:21:01', NULL, '2024-07-25 21:21:01', NULL),
	(9, 'rice', 'Primary food source', 60.00, '../../uploads/images/crops/rice.jpg', '2024-07-25 21:21:01', NULL, '2024-07-25 21:21:01', NULL),
	(10, 'butternut', 'Starchy tuber', 40.00, '../../uploads/images/crops/butternut.jpg', '2024-07-25 21:21:01', NULL, '2024-08-11 00:15:12', NULL),
	(11, 'peas', 'Versatile fruit', 80.00, '../../uploads/images/crops/peas.jpg', '2024-07-25 21:21:02', NULL, '2024-08-11 00:02:00', NULL),
	(12, 'carrots', 'Root vegetable', 30.00, '../../uploads/images/crops/carrots.jpg', '2024-07-25 21:21:02', NULL, '2024-07-25 21:21:02', NULL),
	(13, 'lettuce', 'Leafy green', 20.00, '../../uploads/images/crops/lettuce.jpg', '2024-07-25 21:21:02', NULL, '2024-07-25 21:21:02', NULL),
	(14, 'peppers', 'Spicy vegetable', 90.00, '../../uploads/images/crops/peppers.jpg', '2024-07-25 21:21:02', NULL, '2024-07-25 21:21:02', NULL),
	(15, 'cabbage', 'Cruciferous vegetable', 25.00, '../../uploads/images/crops/cabbage.jpg', '2024-07-25 21:21:02', NULL, '2024-07-25 21:21:02', NULL),
	(16, 'sorghum', 'Rich in minerals', 120.00, '../../uploads/images/crops/sorghum.jpg', '2024-08-10 23:34:23', NULL, '2024-08-10 23:37:40', NULL);

-- Dumping structure for table amis_db.customer_feedback
DROP TABLE IF EXISTS `customer_feedback`;
CREATE TABLE IF NOT EXISTS `customer_feedback` (
  `feedback_id` int NOT NULL AUTO_INCREMENT,
  `buyer_id` int NOT NULL,
  `farmer_id` int NOT NULL,
  `feedback` text,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`feedback_id`),
  KEY `buyer_id` (`buyer_id`),
  KEY `farmer_id` (`farmer_id`),
  CONSTRAINT `customer_feedback_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`),
  CONSTRAINT `customer_feedback_ibfk_2` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.customer_feedback: ~0 rows (approximately)

-- Dumping structure for table amis_db.demand_trends
DROP TABLE IF EXISTS `demand_trends`;
CREATE TABLE IF NOT EXISTS `demand_trends` (
  `trend_id` int NOT NULL AUTO_INCREMENT,
  `crop_id` int DEFAULT NULL,
  `demand` int DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`trend_id`),
  UNIQUE KEY `crop_id` (`crop_id`),
  CONSTRAINT `demand_trends_ibfk_1` FOREIGN KEY (`crop_id`) REFERENCES `crops` (`crop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.demand_trends: ~2 rows (approximately)
INSERT INTO `demand_trends` (`trend_id`, `crop_id`, `demand`, `date`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 1, 5, '2024-08-10', '2024-08-10 20:00:49', NULL, '2024-08-10 20:34:02', NULL),
	(2, 11, 1, '2024-08-10', '2024-08-10 20:01:38', NULL, '2024-08-10 20:01:38', NULL),
	(5, 9, 3, '2024-08-10', '2024-08-10 20:17:19', NULL, '2024-08-10 20:36:13', NULL);

-- Dumping structure for table amis_db.engagements
DROP TABLE IF EXISTS `engagements`;
CREATE TABLE IF NOT EXISTS `engagements` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT 'Engagement',
  `message_text` text NOT NULL,
  `sender` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `sent_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.engagements: ~6 rows (approximately)
INSERT INTO `engagements` (`message_id`, `subject`, `message_text`, `sender`, `receiver`, `sent_at`) VALUES
	(1, 'Engagement', 'Hey hello how are you', 'Marketing 001', 'Best Buyer', '2024-08-10 16:00:36'),
	(2, 'Engagement', 'Are you still there', 'Marketing 001', 'Best Buyer', '2024-08-10 16:27:30'),
	(3, 'Engagement', 'I am fine', 'Best Buyer', 'Marketing 001', '2024-08-10 16:30:13'),
	(4, 'Engagement', 'I am here', 'Best Buyer', 'Marketing 001', '2024-08-10 16:38:03'),
	(5, 'Engagement', 'I want to ask you some questions', 'Marketing 001', 'Best Buyer', '2024-08-10 16:46:23'),
	(6, 'Engagement', 'Go ahead, I am ready', 'Best Buyer', 'Marketer', '2024-08-10 16:58:21');

-- Dumping structure for table amis_db.farmer
DROP TABLE IF EXISTS `farmer`;
CREATE TABLE IF NOT EXISTS `farmer` (
  `farmer_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `account_status` enum('active','suspended','inactive') NOT NULL,
  `compliance_status` enum('pending','approved','rejected') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`farmer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.farmer: ~4 rows (approximately)
INSERT INTO `farmer` (`farmer_id`, `username`, `email`, `password`, `location`, `phone`, `account_status`, `compliance_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'James Matheri', 'jm@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Kisii', '783546322', 'active', 'pending', '2024-07-18 23:27:57', NULL, '2024-07-18 23:27:57', NULL),
	(3, 'Peter Ndungu', 'pndunguedu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Kirinyaga', '0700513972', 'active', 'pending', '2024-07-18 23:36:13', NULL, '2024-07-18 23:36:16', NULL),
	(4, 'John Doe', 'johndoe@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Bomet', '0700513972', 'active', 'pending', '2024-07-20 17:20:10', NULL, '2024-07-20 17:20:10', NULL),
	(11, 'Michael James', 'pndungu081@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Kisii', '0700513972', 'active', 'pending', '2024-08-15 16:38:15', NULL, '2024-08-15 16:39:02', NULL);

-- Dumping structure for table amis_db.forex
DROP TABLE IF EXISTS `forex`;
CREATE TABLE IF NOT EXISTS `forex` (
  `forex_id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `usd` decimal(10,2) DEFAULT NULL,
  `gbp` decimal(10,2) DEFAULT NULL,
  `eur` decimal(10,2) DEFAULT NULL,
  `cad` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`forex_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.forex: ~0 rows (approximately)
INSERT INTO `forex` (`forex_id`, `date`, `usd`, `gbp`, `eur`, `cad`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, '2024-07-18', 129.70, 168.07, 141.44, 94.61, '2024-07-18 20:02:12', NULL, '2024-07-18 20:02:12', NULL),
	(2, '2024-08-09', 128.21, 163.67, 140.25, 93.46, '2024-08-09 07:18:55', NULL, '2024-08-09 07:18:55', NULL);

-- Dumping structure for table amis_db.government
DROP TABLE IF EXISTS `government`;
CREATE TABLE IF NOT EXISTS `government` (
  `agency_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  `account_status` enum('active','suspended','inactive') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`agency_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.government: ~0 rows (approximately)
INSERT INTO `government` (`agency_id`, `username`, `email`, `password`, `location`, `phone`, `status`, `account_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'John Njogu', 'pndunguedu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Kisii', '0700513972', 'pending', 'active', '2024-07-24 22:56:39', NULL, '2024-08-11 00:27:02', NULL);

-- Dumping structure for table amis_db.marketing
DROP TABLE IF EXISTS `marketing`;
CREATE TABLE IF NOT EXISTS `marketing` (
  `professional_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `account_status` enum('active','suspended','inactive') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`professional_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.marketing: ~0 rows (approximately)
INSERT INTO `marketing` (`professional_id`, `username`, `email`, `password`, `company`, `phone`, `account_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'Marketing 001', 'pndunguedu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Peter Ndungu', '0700513972', 'active', '2024-08-09 06:44:10', NULL, '2024-08-11 00:25:42', NULL);

-- Dumping structure for table amis_db.market_prices
DROP TABLE IF EXISTS `market_prices`;
CREATE TABLE IF NOT EXISTS `market_prices` (
  `price_id` int NOT NULL AUTO_INCREMENT,
  `crop_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('effective','not_effective','expired') NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`price_id`),
  KEY `crop_id` (`crop_id`),
  CONSTRAINT `market_prices_ibfk_1` FOREIGN KEY (`crop_id`) REFERENCES `crops` (`crop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.market_prices: ~4 rows (approximately)
INSERT INTO `market_prices` (`price_id`, `crop_id`, `price`, `status`, `date`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 1, 359.00, 'effective', '2024-07-20', '2024-07-20 21:16:00', NULL, '2024-08-13 07:26:40', NULL),
	(2, 2, 52.00, 'effective', '2024-07-25', '2024-07-25 20:02:22', NULL, '2024-08-10 18:54:22', NULL),
	(3, 6, 101.00, 'effective', '2024-08-10', '2024-08-10 18:28:28', NULL, '2024-08-10 18:49:56', NULL),
	(4, 3, 99.00, 'effective', '2024-08-10', '2024-08-10 18:54:53', NULL, '2024-08-10 18:54:53', NULL);

-- Dumping structure for table amis_db.market_trends
DROP TABLE IF EXISTS `market_trends`;
CREATE TABLE IF NOT EXISTS `market_trends` (
  `trend_id` int NOT NULL AUTO_INCREMENT,
  `crop_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`trend_id`),
  KEY `crop_id` (`crop_id`),
  CONSTRAINT `market_trends_ibfk_1` FOREIGN KEY (`crop_id`) REFERENCES `crops` (`crop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.market_trends: ~29 rows (approximately)
INSERT INTO `market_trends` (`trend_id`, `crop_id`, `price`, `date`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 1, 350.00, '2024-07-19', '2024-07-20 16:28:20', NULL, '2024-08-10 09:43:26', NULL),
	(2, 2, 35.00, '2024-07-20', '2024-07-20 16:29:32', NULL, '2024-08-10 10:08:02', NULL),
	(3, 1, 400.00, '2024-07-21', '2024-07-20 16:29:44', NULL, '2024-08-10 09:43:30', NULL),
	(4, 1, 380.00, '2024-07-22', '2024-07-20 16:45:19', NULL, '2024-08-10 09:43:34', NULL),
	(5, 3, 120.00, '2024-08-10', '2024-08-10 09:49:05', NULL, '2024-08-10 09:49:05', NULL),
	(6, 2, 50.00, '2024-08-08', '2024-08-10 09:50:56', NULL, '2024-08-10 10:07:31', NULL),
	(7, 1, 300.00, '2024-08-10', '2024-08-10 09:52:09', NULL, '2024-08-10 09:52:09', NULL),
	(8, 2, 45.00, '2024-08-10', '2024-08-10 10:07:18', NULL, '2024-08-10 10:07:18', NULL),
	(9, 1, 300.00, '2024-01-15', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(10, 2, 100.00, '2024-02-20', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(11, 3, 100.00, '2024-03-10', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(12, 4, 100.00, '2024-04-05', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(13, 6, 100.00, '2024-05-12', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(14, 7, 50.00, '2024-06-18', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(15, 8, 70.00, '2024-07-22', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(16, 1, 300.00, '2024-08-30', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(17, 2, 100.00, '2024-09-14', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(18, 3, 100.00, '2024-10-25', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(19, 4, 100.00, '2024-11-05', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(20, 6, 100.00, '2024-12-10', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(21, 7, 50.00, '2024-01-20', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(22, 8, 70.00, '2024-02-25', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(23, 9, 60.00, '2024-03-15', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(24, 10, 40.00, '2024-04-20', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(25, 11, 80.00, '2024-05-25', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(26, 12, 30.00, '2024-06-30', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(27, 13, 20.00, '2024-07-15', '2024-08-10 15:09:54', NULL, '2024-08-10 15:09:54', NULL),
	(34, 1, 290.00, '2024-08-10', '2024-08-10 20:00:49', NULL, '2024-08-10 20:00:49', NULL),
	(35, 11, 113.00, '2024-08-10', '2024-08-10 20:01:38', NULL, '2024-08-10 20:01:38', NULL),
	(36, 1, 290.00, '2024-08-10', '2024-08-10 20:02:00', NULL, '2024-08-10 20:02:00', NULL),
	(37, 1, 290.00, '2024-08-10', '2024-08-10 20:35:17', NULL, '2024-08-10 20:35:17', NULL),
	(38, 9, 100.00, '2024-08-10', '2024-08-10 20:37:08', NULL, '2024-08-10 20:37:08', NULL);

-- Dumping structure for table amis_db.messages
DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `subject` text NOT NULL,
  `message_text` text NOT NULL,
  `sender_email` varchar(50) NOT NULL DEFAULT 'info@amis.com',
  `receiver_email` varchar(50) NOT NULL,
  `sent_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.messages: ~0 rows (approximately)
INSERT INTO `messages` (`message_id`, `subject`, `message_text`, `sender_email`, `receiver_email`, `sent_at`) VALUES
	(1, 'Exciting New Products Just Arrived!', 'Dear Subscriber,\nWe are thrilled to announce the arrival of our latest products in the market! Our new collection features innovative designs and top-notch quality that you will absolutely love.\nVisit our website to explore the new arrivals and take advantage of exclusive offers available only to our subscribers.\nThank you for being a valued member of our community!\nBest regards,\n                ', 'info@amis.com', 'all2subscribers@amis.com', '2024-08-12 22:42:24');

-- Dumping structure for table amis_db.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `farmer_id` int DEFAULT NULL,
  `buyer_id` int DEFAULT NULL,
  `crop_id` int DEFAULT NULL,
  `advert_id` int DEFAULT NULL,
  `total_cost` decimal(7,2) NOT NULL DEFAULT '0.00',
  `quantity` int DEFAULT NULL,
  `unit` enum('count','kgs','debes','crates','sacks') NOT NULL DEFAULT 'count',
  `date` date NOT NULL,
  `status` enum('pending','confirmed','cancelled','delivered') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `farmer_id` (`farmer_id`),
  KEY `buyer_id` (`buyer_id`),
  KEY `crop_id` (`crop_id`),
  KEY `advert_id` (`advert_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`crop_id`) REFERENCES `crops` (`crop_id`),
  CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`advert_id`) REFERENCES `adverts` (`advert_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.orders: ~2 rows (approximately)
INSERT INTO `orders` (`order_id`, `farmer_id`, `buyer_id`, `crop_id`, `advert_id`, `total_cost`, `quantity`, `unit`, `date`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 4, 24, 1, 2, 2900.00, 10, 'sacks', '2024-08-10', 'pending', '2024-08-10 20:34:02', NULL, '2024-08-14 17:32:44', NULL),
	(2, 4, 24, 9, 5, 1000.00, 10, 'kgs', '2024-08-10', 'confirmed', '2024-08-10 20:36:13', NULL, '2024-08-10 20:37:08', NULL);

-- Dumping structure for table amis_db.order_status
DROP TABLE IF EXISTS `order_status`;
CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` enum('pending','confirmed','cancelled','delivered') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.order_status: ~4 rows (approximately)
INSERT INTO `order_status` (`id`, `name`) VALUES
	(1, 'pending'),
	(2, 'confirmed'),
	(3, 'cancelled'),
	(4, 'delivered');

-- Dumping structure for table amis_db.price_status
DROP TABLE IF EXISTS `price_status`;
CREATE TABLE IF NOT EXISTS `price_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` enum('effective','provisional','ineffective') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.price_status: ~3 rows (approximately)
INSERT INTO `price_status` (`id`, `name`) VALUES
	(1, 'effective'),
	(2, 'provisional'),
	(3, 'ineffective');

-- Dumping structure for table amis_db.sub_counties
DROP TABLE IF EXISTS `sub_counties`;
CREATE TABLE IF NOT EXISTS `sub_counties` (
  `sub_county_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `county_id` int NOT NULL,
  PRIMARY KEY (`sub_county_id`),
  KEY `county_id` (`county_id`),
  CONSTRAINT `sub_counties_ibfk_1` FOREIGN KEY (`county_id`) REFERENCES `counties` (`county_id`)
) ENGINE=InnoDB AUTO_INCREMENT=342 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.sub_counties: ~341 rows (approximately)
INSERT INTO `sub_counties` (`sub_county_id`, `name`, `county_id`) VALUES
	(1, 'Baringo central', 30),
	(2, 'Baringo north', 30),
	(3, 'Baringo south', 30),
	(4, 'Eldama ravine', 30),
	(5, 'Mogotio', 30),
	(6, 'Tiaty', 30),
	(7, 'Bomet central', 36),
	(8, 'Bomet east', 36),
	(9, 'Chepalungu', 36),
	(10, 'Konoin', 36),
	(11, 'Sotik', 36),
	(12, 'Bumula', 39),
	(13, 'Kabuchai', 39),
	(14, 'Kanduyi', 39),
	(15, 'Kimilil', 39),
	(16, 'Mt Elgon', 39),
	(17, 'Sirisia', 39),
	(18, 'Tongaren', 39),
	(19, 'Webuye east', 39),
	(20, 'Webuye west', 39),
	(21, 'Budalangi', 40),
	(22, 'Butula', 40),
	(23, 'Funyula', 40),
	(24, 'Nambele', 40),
	(25, 'Teso North', 40),
	(26, 'Teso South', 40),
	(27, 'Keiyo north', 28),
	(28, 'Keiyo south', 28),
	(29, 'Marakwet east', 28),
	(30, 'Marakwet west', 28),
	(31, 'Manyatta', 14),
	(32, 'Mbeere north', 14),
	(33, 'Mbeere south', 14),
	(34, 'Runyenjes', 14),
	(35, 'Daadab', 7),
	(36, 'Fafi', 7),
	(37, 'Garissa', 7),
	(38, 'Hulugho', 7),
	(39, 'Ijara', 7),
	(40, 'Lagdera balambala', 7),
	(41, 'Homabay town', 43),
	(42, 'Kabondo', 43),
	(43, 'Karachwonyo', 43),
	(44, 'Kasipul', 43),
	(45, 'Mbita', 43),
	(46, 'Ndhiwa', 43),
	(47, 'Rangwe', 43),
	(48, 'Suba', 43),
	(49, 'Central', 11),
	(50, 'Garba tula', 11),
	(51, 'Kina', 11),
	(52, 'Merit', 11),
	(53, 'Oldonyiro', 11),
	(54, 'Sericho', 11),
	(55, 'Isinya', 34),
	(56, 'Kajiado Central', 34),
	(57, 'Kajiado North', 34),
	(58, 'Loitokitok', 34),
	(59, 'Mashuuru', 34),
	(60, 'Butere', 37),
	(61, 'Kakamega central', 37),
	(62, 'Kakamega east', 37),
	(63, 'Kakamega north', 37),
	(64, 'Kakamega south', 37),
	(65, 'Khwisero', 37),
	(66, 'Lugari', 37),
	(67, 'Lukuyani', 37),
	(68, 'Lurambi', 37),
	(69, 'Matete', 37),
	(70, 'Mumias', 37),
	(71, 'Mutungu', 37),
	(72, 'Navakholo', 37),
	(73, 'Ainamoi', 35),
	(74, 'Belgut', 35),
	(75, 'Bureti', 35),
	(76, 'Kipkelion east', 35),
	(77, 'Kipkelion west', 35),
	(78, 'Soin sigowet', 35),
	(79, 'Gatundu north', 22),
	(80, 'Gatundu south', 22),
	(81, 'Githunguri', 22),
	(82, 'Juja', 22),
	(83, 'Kabete', 22),
	(84, 'Kiambaa', 22),
	(85, 'Kiambu', 22),
	(86, 'Kikuyu', 22),
	(87, 'Limuru', 22),
	(88, 'Ruiru', 22),
	(89, 'Thika town', 22),
	(90, 'Lari', 22),
	(91, 'Genzw', 3),
	(92, 'Kaloleni', 3),
	(93, 'Kilifi North', 3),
	(94, 'Kilifi South', 3),
	(95, 'Kilifi West', 3),
	(96, 'Malindi', 3),
	(97, 'Magarini', 3),
	(98, 'Rabai', 3),
	(99, 'Gichugu', 20),
	(100, 'Kirinyaga central', 20),
	(101, 'Kirinyaga east', 20),
	(102, 'Kirinyaga west', 20),
	(103, 'Mwea', 20),
	(104, 'Kisumu central', 42),
	(105, 'Kisumu east', 42),
	(106, 'Kisumu west', 42),
	(107, 'Mohoroni', 42),
	(108, 'Nyakach', 42),
	(109, 'Nyando', 42),
	(110, 'Seme', 42),
	(111, 'Kitui central', 15),
	(112, 'Kitui east', 15),
	(113, 'Kitui north', 15),
	(114, 'Kitui south', 15),
	(115, 'Kitui west', 15),
	(116, 'Mwingi central', 15),
	(117, 'Mwingi north', 15),
	(118, 'Mwingi west', 15),
	(119, 'Mutuga', 2),
	(120, 'Kinango', 2),
	(121, 'Kwale', 2),
	(122, 'Lunga Lunga', 2),
	(123, 'Msambweni', 2),
	(124, 'Laikipia central', 31),
	(125, 'Laikipia east', 31),
	(126, 'Laikipia north', 31),
	(127, 'Laikipia west', 31),
	(128, 'Nyahururu', 31),
	(129, 'Lamu East', 5),
	(130, 'Lamu West', 5),
	(131, 'Kathiani', 16),
	(132, 'Machakos town', 16),
	(133, 'Masinga', 16),
	(134, 'Matungulu', 16),
	(135, 'Mavoko', 16),
	(136, 'Mwala', 16),
	(137, 'Yatta', 16),
	(138, 'Kaiti', 17),
	(139, 'Kibwei west', 17),
	(140, 'Kibwezi east', 17),
	(141, 'Kilome', 17),
	(142, 'Makueni', 17),
	(143, 'Mbooni', 17),
	(144, 'Mandera central', 6),
	(145, 'Mandera east', 6),
	(146, 'Mandera north', 6),
	(147, 'Mandera south', 6),
	(148, 'Mandera west', 6),
	(149, 'Laisamis', 10),
	(150, 'Moyale', 10),
	(151, 'North Hor', 10),
	(152, 'Saku', 10),
	(153, 'Buuri', 15),
	(154, 'Imenti central', 15),
	(155, 'Imenti north', 15),
	(156, 'Imenti south', 15),
	(157, 'Meru', 15),
	(158, 'Tigania east', 15),
	(159, 'Tigania west', 15),
	(160, 'Tharaka', 15),
	(161, 'Awendo', 44),
	(162, 'Kuria east', 44),
	(163, 'Kuria west', 44),
	(164, 'Mabera', 44),
	(165, 'Ntimaru', 44),
	(166, 'Rongo', 44),
	(167, 'Suna east', 44),
	(168, 'Suna west', 44),
	(169, 'Uriri', 44),
	(170, 'Gatanga', 21),
	(171, 'Kahuro', 21),
	(172, 'Kandara', 21),
	(173, 'Kangema', 21),
	(174, 'Kigumo', 21),
	(175, 'Kiharu', 21),
	(176, 'Mathioya', 21),
	(177, 'Murang\'a south', 21),
	(178, 'Awendo', 42),
	(179, 'Rongo', 42),
	(180, 'Suna east', 42),
	(181, 'Suna west', 42),
	(182, 'Uriri', 42),
	(183, 'Changamwe', 1),
	(184, 'Jomvu', 1),
	(185, 'Kisauni', 1),
	(186, 'Mvita', 1),
	(187, 'Nyali', 1),
	(188, 'Dagoretti North Sub County', 47),
	(189, 'Dagoretti South Sub County', 47),
	(190, 'Embakasi Central Sub County', 47),
	(191, 'Embakasi East Sub County', 47),
	(192, 'Embakasi North Sub County', 47),
	(193, 'Embakasi South Sub County', 47),
	(194, 'Embakasi West Sub County', 47),
	(195, 'Kamukunji Sub County', 47),
	(196, 'Kasarani Sub County', 47),
	(197, 'Kibra Sub County', 47),
	(198, 'Lang\'ata Sub County', 47),
	(199, 'Makadara Sub County', 47),
	(200, 'Mathare Sub County', 47),
	(201, 'Roysambu Sub County', 47),
	(202, 'Ruaraka Sub County', 47),
	(203, 'Starehe Sub County', 47),
	(204, 'Westlands Sub County', 47),
	(205, 'Bahati', 32),
	(206, 'Gilgil', 32),
	(207, 'Kuresoi north', 32),
	(208, 'Kuresoi south', 32),
	(209, 'Molo', 32),
	(210, 'Naivasha', 32),
	(211, 'Nakuru town east', 32),
	(212, 'Nakuru town west', 32),
	(213, 'Njoro', 32),
	(214, 'Rongai', 32),
	(215, 'Subukia', 32),
	(216, 'Aldai', 29),
	(217, 'Chesumei', 29),
	(218, 'Emgwen', 29),
	(219, 'Mosop', 29),
	(220, 'Namdi hills', 29),
	(221, 'Tindiret', 29),
	(222, 'Narok east', 33),
	(223, 'Narok north', 33),
	(224, 'Narok south', 33),
	(225, 'Narok west', 33),
	(226, 'Transmara east', 33),
	(227, 'Transmara west', 33),
	(228, 'Borabu', 46),
	(229, 'Manga', 46),
	(230, 'Masaba north', 46),
	(231, 'Nyamira north', 46),
	(232, 'Nyamira south', 46),
	(233, 'Kinangop', 18),
	(234, 'Kipipiri', 18),
	(235, 'Ndaragwa', 18),
	(236, 'Ol Kalou', 18),
	(237, 'Ol joro orok', 18),
	(238, 'Kieni east', 19),
	(239, 'Kieni west', 19),
	(240, 'Mathira east', 19),
	(241, 'Mathira west', 19),
	(242, 'Mkurweni', 19),
	(243, 'Nyeri town', 19),
	(244, 'Othaya', 19),
	(245, 'Tetu', 19),
	(246, 'Alego usonga', 41),
	(247, 'Bondo', 41),
	(248, 'Gem', 41),
	(249, 'Rarieda', 41),
	(250, 'Ugenya', 41),
	(251, 'Unguja', 41),
	(252, 'Samburu east', 25),
	(253, 'Samburu north', 25),
	(254, 'Samburu west', 25),
	(255, 'Mwatate', 6),
	(256, 'Taveta', 6),
	(257, 'Voi', 6),
	(258, 'Wundanyi', 6),
	(259, 'Bura', 4),
	(260, 'Galole', 4),
	(261, 'Garsen', 4),
	(262, 'Chuka', 13),
	(263, 'Igambangobe', 13),
	(264, 'Maara', 13),
	(265, 'Muthambi', 13),
	(266, 'Tharaka north', 13),
	(267, 'Tharaka south', 13),
	(268, 'Cherangany', 26),
	(269, 'Endebess', 26),
	(270, 'Kiminini', 26),
	(271, 'Kwanza', 26),
	(272, 'Saboti', 26),
	(273, 'Loima', 23),
	(274, 'Turkana central', 23),
	(275, 'Turkana east', 23),
	(276, 'Turkana north', 23),
	(277, 'Turkana south', 23),
	(278, 'Ainabkoi', 27),
	(279, 'Kapseret', 27),
	(280, 'Kesses', 27),
	(281, 'Moiben', 27),
	(282, 'Soy', 27),
	(283, 'Turbo', 27),
	(284, 'Emuhaya', 38),
	(285, 'Hamisi', 38),
	(286, 'Luanda', 38),
	(287, 'Sabatia', 38),
	(288, 'Vihiga', 38),
	(289, 'Eldas', 8),
	(290, 'Tarbaj', 8),
	(291, 'Wajir East', 8),
	(292, 'Wajir North', 8),
	(293, 'Wajir South', 8),
	(294, 'Wajir West', 8),
	(295, 'Central Pokot', 24),
	(296, 'North Pokot', 24),
	(297, 'Pokot South', 24),
	(298, 'West Pokot', 24),
	(299, 'Ainabkoi', 29),
	(300, 'Bureti', 29),
	(301, 'Kipkelion East', 29),
	(302, 'Kipkelion West', 29),
	(303, 'Kericho', 29),
	(304, 'Litein', 29),
	(305, 'Gichugu', 12),
	(306, 'Kirinyaga central', 12),
	(307, 'Kirinyaga east', 12),
	(308, 'Kirinyaga west', 12),
	(309, 'Mwea', 12),
	(310, 'Bomachoge', 45),
	(311, 'Bomachoge Borabu', 45),
	(312, 'South Mugirango', 45),
	(313, 'Bobasi', 45),
	(314, 'Nyaribari Chache', 45),
	(315, 'Nyaribari Masaba', 45),
	(316, 'Kitutu Chache', 45),
	(317, 'Kitutu Chache North', 45),
	(318, 'Kitutu Chache South', 45),
	(319, 'Endebess', 11),
	(320, 'Kiminini', 11),
	(321, 'Mt Elgon', 11),
	(322, 'Saboti', 11),
	(323, 'Trans Nzoia East', 11),
	(324, 'Trans Nzoia West', 11),
	(325, 'Emuhaya', 23),
	(326, 'Hamisi', 23),
	(327, 'Sabatia', 23),
	(328, 'Vihiga', 23),
	(329, 'Bumula', 9),
	(330, 'Chwele', 9),
	(331, 'Kabuchai', 9),
	(332, 'Kanduyi', 9),
	(333, 'Mt Elgon', 9),
	(334, 'Sirisia', 9),
	(335, 'Tongaren', 9),
	(336, 'Bomet Central', 24),
	(337, 'Bomet East', 24),
	(338, 'Bomet West', 24),
	(339, 'Chepalungu', 24),
	(340, 'Konoin', 24),
	(341, 'Siongiroi', 24);

-- Dumping structure for table amis_db.transactions
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `farmer_id` int NOT NULL,
  `transaction_code` varchar(255) NOT NULL,
  `status` enum('pending','valid','rejected','expired') NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `farmer_id` (`farmer_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.transactions: ~0 rows (approximately)

-- Dumping structure for table amis_db.transporter
DROP TABLE IF EXISTS `transporter`;
CREATE TABLE IF NOT EXISTS `transporter` (
  `transporter_id` int NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `availability` enum('available','engaged','no_service') NOT NULL,
  `account_status` enum('active','suspended','inactive') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`transporter_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.transporter: ~0 rows (approximately)
INSERT INTO `transporter` (`transporter_id`, `username`, `email`, `password`, `phone`, `description`, `price`, `availability`, `account_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'John Doe', 'pndunguedu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0720543370', 'gfgf', 1200.00, 'available', 'active', '2024-07-24 23:01:12', NULL, '2024-07-24 23:01:12', NULL);

-- Dumping structure for table amis_db.transport_schedules
DROP TABLE IF EXISTS `transport_schedules`;
CREATE TABLE IF NOT EXISTS `transport_schedules` (
  `schedule_id` int NOT NULL AUTO_INCREMENT,
  `farmer_id` int DEFAULT NULL,
  `buyer_id` int DEFAULT NULL,
  `transporter_id` int DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','delivered') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`schedule_id`),
  KEY `farmer_id` (`farmer_id`),
  KEY `buyer_id` (`buyer_id`),
  KEY `transporter_id` (`transporter_id`),
  CONSTRAINT `transport_schedules_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`),
  CONSTRAINT `transport_schedules_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`),
  CONSTRAINT `transport_schedules_ibfk_3` FOREIGN KEY (`transporter_id`) REFERENCES `transporter` (`transporter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.transport_schedules: ~0 rows (approximately)

-- Dumping structure for table amis_db.two_factor_auth
DROP TABLE IF EXISTS `two_factor_auth`;
CREATE TABLE IF NOT EXISTS `two_factor_auth` (
  `auth_id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) DEFAULT NULL,
  `user_type_id` int DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `status` enum('pending','verified','expired','rejected') NOT NULL DEFAULT 'pending',
  `sent_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `verified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`auth_id`),
  UNIQUE KEY `user_email` (`user_email`),
  KEY `user_type_id` (`user_type_id`),
  CONSTRAINT `two_factor_auth_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_type_tbl` (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.two_factor_auth: ~1 rows (approximately)
INSERT INTO `two_factor_auth` (`auth_id`, `user_email`, `user_type_id`, `code`, `status`, `sent_at`, `verified_at`) VALUES
	(1, 'pndunguedu@gmail.com', 2, 'IOOG81', 'expired', '2024-07-22 07:31:03', NULL),
	(7, 'pndungu081@gmail.com', 1, 'CIZQPV', 'expired', '2024-08-15 16:38:13', NULL);

-- Dumping structure for table amis_db.two_factor_auth_status
DROP TABLE IF EXISTS `two_factor_auth_status`;
CREATE TABLE IF NOT EXISTS `two_factor_auth_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` enum('pending','verified','expired','rejected') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.two_factor_auth_status: ~4 rows (approximately)
INSERT INTO `two_factor_auth_status` (`id`, `name`) VALUES
	(1, 'pending'),
	(2, 'verified'),
	(3, 'expired'),
	(4, 'rejected');

-- Dumping structure for table amis_db.unit_of_measure
DROP TABLE IF EXISTS `unit_of_measure`;
CREATE TABLE IF NOT EXISTS `unit_of_measure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` enum('count','kgs','debes','crates','sacks') NOT NULL DEFAULT 'count',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.unit_of_measure: ~5 rows (approximately)
INSERT INTO `unit_of_measure` (`id`, `name`) VALUES
	(1, 'count'),
	(2, 'kgs'),
	(3, 'debes'),
	(4, 'crates'),
	(5, 'sacks');

-- Dumping structure for table amis_db.user_type_tbl
DROP TABLE IF EXISTS `user_type_tbl`;
CREATE TABLE IF NOT EXISTS `user_type_tbl` (
  `user_type_id` int NOT NULL AUTO_INCREMENT,
  `user_type` enum('farmer','buyer','government','transporter','marketing','admin') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.user_type_tbl: ~6 rows (approximately)
INSERT INTO `user_type_tbl` (`user_type_id`, `user_type`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'farmer', '2024-07-18 19:44:41', NULL, '2024-07-18 19:44:41', NULL),
	(2, 'buyer', '2024-07-18 19:44:41', NULL, '2024-07-18 19:44:41', NULL),
	(3, 'government', '2024-07-18 19:44:41', NULL, '2024-07-18 19:44:41', NULL),
	(4, 'transporter', '2024-07-18 19:44:41', NULL, '2024-07-18 19:44:41', NULL),
	(5, 'marketing', '2024-07-18 19:44:41', NULL, '2024-07-18 19:44:41', NULL),
	(6, 'admin', '2024-07-18 19:44:41', NULL, '2024-07-18 19:44:41', NULL);

-- Dumping structure for table amis_db.yields
DROP TABLE IF EXISTS `yields`;
CREATE TABLE IF NOT EXISTS `yields` (
  `yield_id` int NOT NULL AUTO_INCREMENT,
  `farmer_id` int DEFAULT NULL,
  `crop_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `harvest_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`yield_id`),
  KEY `farmer_id` (`farmer_id`),
  KEY `crop_id` (`crop_id`),
  CONSTRAINT `yields_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`),
  CONSTRAINT `yields_ibfk_2` FOREIGN KEY (`crop_id`) REFERENCES `crops` (`crop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table amis_db.yields: ~7 rows (approximately)
INSERT INTO `yields` (`yield_id`, `farmer_id`, `crop_id`, `quantity`, `harvest_date`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(2, 4, 1, 2000, '2024-07-20', '2024-07-26 20:11:45', NULL, '2024-07-26 20:11:45', NULL),
	(3, 4, 4, 230, '2024-06-13', '2024-07-26 20:14:17', NULL, '2024-07-27 09:06:57', NULL),
	(4, 3, 1, 500, '2024-05-19', '2024-07-26 20:15:49', NULL, '2024-07-26 20:15:49', NULL),
	(6, 4, 6, 300, '2024-07-27', '2024-07-27 09:59:53', NULL, '2024-07-27 14:56:24', NULL),
	(7, 4, 8, 347, '2024-07-27', '2024-07-27 10:23:27', NULL, '2024-07-27 10:23:27', NULL),
	(8, 4, 11, 300, '2024-08-10', '2024-08-10 19:13:30', NULL, '2024-08-10 19:13:49', NULL),
	(10, 4, 3, 34, '2024-08-12', '2024-08-12 04:34:27', NULL, '2024-08-12 04:34:27', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
