-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2014 at 09:40 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zachohearn`
--
CREATE DATABASE IF NOT EXISTS `zachohearn` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `zachohearn`;

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
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `firstname`, `lastname`, `username`, `password`, `mtdCalories`, `isTrainee`, `TrainerName`, `email`) VALUES
(1, 'Zachary', 'O''Hearn', 'zachohearn', 'orange', 366, 1, 'Trainer', 'ZZZ@gmail.com'),
(2, 'Trainer', 'Trainer', 'Trainer', 'Trainer', 0, 0, 'None', 'oscar.ng719@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE IF NOT EXISTS `workouts` (
  `name` varchar(30) NOT NULL,
  `dayOfYear` int(11) NOT NULL,
  `link` tinytext NOT NULL,
  `calorieCount` smallint(6) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workouts`
--

INSERT INTO `workouts` (`name`, `dayOfYear`, `link`, `calorieCount`, `description`) VALUES
('run', 80, 'runfast.com', 88, 'blah blah blah blah run alot yo.'),
('exersice', 60, 'justdoit.com', 100, 'lift good bro'),
('work', 83, 'igotnothing.com', 230, 'do some bro lifts then run a mile'),
('sdafsdaf', 82, 'adsfasf', 133, 'aaaaaa');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
