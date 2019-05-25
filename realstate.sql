-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 23, 2019 at 09:56 AM
-- Server version: 5.7.24
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realstate`
--

-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

DROP TABLE IF EXISTS `houses`;
CREATE TABLE IF NOT EXISTS `houses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `tel` varchar(13) COLLATE utf8_persian_ci NOT NULL,
  `mobile` varchar(13) COLLATE utf8_persian_ci NOT NULL,
  `zone` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `house` enum('sell','rent') COLLATE utf8_persian_ci NOT NULL,
  `lot` enum('apartment','condo','old_house') COLLATE utf8_persian_ci NOT NULL,
  `creation_year` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `meter` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `unit` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `options` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `description` text COLLATE utf8_persian_ci NOT NULL,
  `price` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  `monthly_fee` varchar(15) COLLATE utf8_persian_ci DEFAULT NULL,
  `address` text COLLATE utf8_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `houses`
--

INSERT INTO `houses` (`id`, `owner`, `tel`, `mobile`, `zone`, `house`, `lot`, `creation_year`, `meter`, `unit`, `options`, `description`, `price`, `monthly_fee`, `address`, `created_at`) VALUES
(1, 'مهیار معتمدی', '09197030096', '09197030096', '8', 'sell', 'apartment', '1387', '102', '2', 'parking,storage,elevator,toilet', 'آماده فروش', '300000000', '', 'رسالت خیابان سمنگان', '2019-05-21 10:05:37'),
(2, 'علی فیاض', '09122274155', '09122274155', '13', 'rent', 'condo', '1390', '95', '1', 'parking,renovate,storage', 'کاملا بازسازی شده', '1000000', '1500000', 'چهاراره اشراقی خیابان امینی', '2019-05-21 11:56:10'),
(3, 'محسن معمتدی', '09212811634', '09212811634', '4', 'rent', 'old_house', '1360', '100', '3', 'renovate,parking,storage,toilet', 'جنوبی', '100000000', '3000000', 'میدان بهشتی', '2019-05-21 15:01:15');

-- --------------------------------------------------------

--
-- Table structure for table `pics`
--

DROP TABLE IF EXISTS `pics`;
CREATE TABLE IF NOT EXISTS `pics` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `url` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `house_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `house_id` (`house_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pics`
--
ALTER TABLE `pics`
  ADD CONSTRAINT `house_id` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
