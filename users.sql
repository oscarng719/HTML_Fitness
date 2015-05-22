-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 14, 2014 at 03:51 PM
-- Server version: 5.6.14
-- PHP Version: 5.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zachohearn`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(24) NOT NULL,
  `lastname` varchar(24) NOT NULL,
  `username` varchar(24) NOT NULL,
  `password` varchar(24) NOT NULL,
  `mtdCalories` smallint(6) NOT NULL,
  `isTrainee` tinyint(1) NOT NULL,
  `TrainerName` varchar(24) NOT NULL,
  `email` varchar(50) NOT NULL,
  `workoutDone` smallint(6) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `firstname`, `lastname`, `username`, `password`, `mtdCalories`, `isTrainee`, `TrainerName`, `email`, `workoutDone`) VALUES
(1, 'Zachary', 'O''Hearn', 'zachohearn', 'orange', 1326, 1, 'Trainer', 'ZZZ@gmail.com', 104),
(2, 'Trainer', 'Trainer', 'Trainer', 'Trainer', 25, 0, 'None', 'oscar.ng719@gmail.com', 0),
(3, 'Barrack', 'Obama', 'bdog', 'america', 0, 1, 'Trainer', 'bdog@america.com', 0),
(4, 'Tommy', 'Gunn', 'tommy', 'gunn', 1052, 1, 'Trainer', 'tommy@gunn.com', 0),
(5, 'New ', 'Trainee', 'traineeuser', 'password', 0, 1, 'Trainer', 'email@email.com', 0),
(6, 'o', 'o', 'o', 'o', 0, 1, 'Trainer', 'o', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
