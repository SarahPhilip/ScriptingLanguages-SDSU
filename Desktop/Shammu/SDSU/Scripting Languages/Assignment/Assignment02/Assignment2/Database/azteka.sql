-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2015 at 08:32 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `azteka`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
`ISBN` int(10) unsigned NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Author` int(11) unsigned NOT NULL,
  `Publisher` int(11) unsigned DEFAULT '0',
  `Price` float DEFAULT '0',
  `BestSeller` tinyint(1) DEFAULT '0',
  `Published` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`ISBN`, `Name`, `Author`, `Publisher`, `Price`, `BestSeller`, `Published`) VALUES
(1, 'ABC', 7, 10, 10, 1, 1),
(2, 'DEF', 8, 10, 20, 1, 1),
(3, 'GHIl', 11, 10, 190, 0, 1),
(10, 'JKL', 7, 10, 0, 0, 1),
(11, 'Famous Five I', 11, 10, 0, 0, 1),
(14, 'THE', 8, 10, 0, 1, 1),
(15, 'QWERTY', 8, 10, 0, 0, 1),
(16, 'AABBCC', 10, NULL, 0, 0, 0),
(17, 'QWERT', 10, 10, 30, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(10) unsigned NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` char(40) NOT NULL,
  `user_level` int(10) unsigned NOT NULL DEFAULT '10',
  `active` char(32) DEFAULT NULL,
  `registration_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `pass`, `user_level`, `active`, `registration_date`) VALUES
(6, 'Shameetha', 'Jacob', 'shameetha@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 10, NULL, '2015-03-25 13:57:45'),
(7, 'Polackal', 'James', 'philipjamespolackal@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 20, NULL, '2015-03-25 17:31:38'),
(8, 'Author', 'Abraham', 'author@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 20, NULL, '2015-03-27 00:00:00'),
(10, 'Publisher', 'Jacob', 'publisher@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 30, NULL, '2015-03-25 00:00:00'),
(11, 'Eva', 'Matthews', 'eva@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 20, NULL, '2015-03-11 00:00:00'),
(12, 'Rhea', 'Matthews', 'rhea@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 20, NULL, '2015-03-01 00:00:00'),
(14, 'admin', 'admin', 'admin@admin.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 40, NULL, '2015-03-27 14:44:45'),
(15, 'member', 'Erro', 'member@member.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 10, NULL, '2015-04-06 15:50:55'),
(16, 'Penguin', 'PP', 'penguin@publisher.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 30, NULL, '2015-04-06 15:58:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
 ADD PRIMARY KEY (`ISBN`), ADD UNIQUE KEY `ISBN` (`ISBN`), ADD KEY `Author` (`Author`), ADD KEY `Publisher` (`Publisher`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `email` (`email`), ADD KEY `login` (`email`,`pass`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
MODIFY `ISBN` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`Author`) REFERENCES `users` (`user_id`),
ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`Publisher`) REFERENCES `users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
