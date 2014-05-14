-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2014 at 05:02 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `email_scrapper`
--
CREATE DATABASE IF NOT EXISTS `email_scrapper` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `email_scrapper`;

-- --------------------------------------------------------

--
-- Table structure for table `ci_cookies`
--

CREATE TABLE IF NOT EXISTS `ci_cookies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cookie_id` varchar(255) DEFAULT NULL,
  `netid` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `orig_page_requested` varchar(120) DEFAULT NULL,
  `php_session_id` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('9ca117fccc449ac886f7480a4730d69d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0', 1394469016, 'a:9:{s:9:"user_data";s:0:"";s:8:"is_admin";s:1:"1";s:5:"lg_id";s:1:"1";s:9:"user_name";s:5:"admin";s:12:"is_logged_in";b:1;s:20:"manufacture_selected";N;s:22:"search_string_selected";N;s:5:"order";N;s:10:"order_type";N;}'),
('05f1b65a2308c27c874c928d28136294', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0', 1394473070, 'a:4:{s:8:"is_admin";s:1:"1";s:5:"lg_id";s:1:"1";s:9:"user_name";s:5:"admin";s:12:"is_logged_in";b:1;}');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE IF NOT EXISTS `manufacturers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`) VALUES
(1, 'a'),
(2, 'd');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email_addres` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `pass_word` varchar(32) DEFAULT NULL,
  `pass_orginal` varchar(300) DEFAULT NULL,
  `email_header` text,
  `email_header_title` text,
  `is_admin` tinyint(4) DEFAULT '2',
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `first_name`, `last_name`, `email_addres`, `user_name`, `pass_word`, `pass_orginal`, `email_header`, `email_header_title`, `is_admin`, `date`) VALUES
(1, 'majeed', 'majeed', 'umair_majeed786@live.com', 'admin', 'e7aabb41315aaff23439860e5788349d', 'allah1@', 'uploads/logo.jpg', 'Frill Shop', 1, NULL),
(2, 'umair', 'majeed', 'mentordeveloper@gmail.com', 'umairmajeed', 'e7aabb41315aaff23439860e5788349d', 'allah1@', NULL, NULL, 2, NULL),
(3, 'danish', 'hameed', 'danish@gmail.com', 'danish.hameed', 'e7aabb41315aaff23439860e5788349d', 'allah1@', 'uploads/33-pakmed-net-january-13-2013-medical-education-kjikjfdds3.jpg', 'asdfas saf sf', 2, '2014-03-07'),
(4, 'zain', 'abbas', 'zain@gmail.com', 'zain.abbas', 'e7aabb41315aaff23439860e5788349d', 'allah1@', NULL, NULL, 2, '2014-03-10'),
(5, 'mentor', 'da', 'dasasd@gac.com', 'als.com', '20e43b79d8e1f2c9424239455e3aed01', 'allah', NULL, NULL, 2, '2014-03-10');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rfid` varchar(255) NOT NULL,
  `make` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `vin` varchar(255) DEFAULT NULL,
  `stock` varchar(255) DEFAULT NULL,
  `year` varchar(11) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `geo_location` varchar(255) DEFAULT NULL,
  `miles` varchar(255) DEFAULT NULL,
  `gps_number` varchar(255) DEFAULT NULL,
  `history_of_scan` varchar(255) DEFAULT NULL,
  `pic_of_car` varchar(255) DEFAULT NULL,
  `pic_gps_tag` varchar(255) DEFAULT NULL,
  `pic_inside` varchar(255) DEFAULT NULL,
  `tag_number` varchar(255) DEFAULT NULL,
  `days` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `rfid`, `make`, `model`, `vin`, `stock`, `year`, `color`, `location`, `status`, `geo_location`, `miles`, `gps_number`, `history_of_scan`, `pic_of_car`, `pic_gps_tag`, `pic_inside`, `tag_number`, `days`) VALUES
(1, '', 'as', '44', '44', '443', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '', 's', 'sad', 'asdfa', 'sdfas', 'dfasdf', 'asdasdf', 'adsfasd', 'Active', 'asdf', 'asdfa', 'sdfasd', 'fasd', '', '', '', '423ds', 'asds323'),
(3, '', 's', 'sad', 'asdfa', 'sdfas', 'dfasdf', 'asdasdf', 'adsfasd', 'Active', 'asdf', 'asdfa', 'sdfasd', 'fasd', 'uploads//HU-at-LSC_05-e12931107849712.jpg', 'uploads//LSE_talk_in_Ashton1.png', 'uploads//33-pakmed-net-january-13-2013-medical-education-kjikjfdds1.jpg', '423ds', 'asds323'),
(4, 'dd', 's', 'sad', 'asdfa', 'sdfas', 'dfasdf', 'asdasdf', 'adsfasd', 'Active', 'asdf', 'asdfa', 'sdfasd', 'fasd', 'uploads/HU-at-LSC_05-e12931107849713.jpg', 'uploads/LSE_talk_in_Ashton2.png', 'uploads/33-pakmed-net-january-13-2013-medical-education-kjikjfdds2.jpg', '423ds434', 'asds323');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
