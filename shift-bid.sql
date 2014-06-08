-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2014 at 11:10 AM
-- Server version: 5.5.37-0ubuntu0.13.10.1
-- PHP Version: 5.5.3-1ubuntu2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shift-bid`
--

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE IF NOT EXISTS `bids` (
  `bid_emp_number` int(11) NOT NULL,
  `timestamp` varchar(50) NOT NULL,
  `shift` varchar(5) NOT NULL,
  `wager` int(8) NOT NULL,
  PRIMARY KEY (`bid_emp_number`,`timestamp`,`shift`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`bid_emp_number`, `timestamp`, `shift`, `wager`) VALUES
(1, '1402183447', '15', 1),
(2, '1402183443', '15', 1),
(3, '1402220985', '16', 1),
(3, '1402221627', '17', 1),
(5, '1402221750', '17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `emp_num` int(11) NOT NULL AUTO_INCREMENT,
  `emp_f_name` varchar(50) NOT NULL,
  `emp_l_name` varchar(50) NOT NULL,
  `emp_role` varchar(20) NOT NULL,
  `emp_points` int(7) NOT NULL,
  `emp_email` varchar(30) NOT NULL,
  `emp_password` varchar(50) NOT NULL,
  PRIMARY KEY (`emp_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_num`, `emp_f_name`, `emp_l_name`, `emp_role`, `emp_points`, `emp_email`, `emp_password`) VALUES
(1, 'Kristen', 'Whoo', 'Scientist', 200, 'woo@hoo.com', 'ilovewhoo'),
(2, 'Test', 'Testington', 'Cook', 100, 'test@test.com', 'testword'),
(3, 'Trevor', 'Yeroc', 'Server', 10, 'pigpower100@gmail.com', 'ae2b1fca515949e5d54fb22b8ed95575'),
(4, 'Joe', 'Smith', 'doctor', 20, 'a@a.com', 'ae2b1fca515949e5d54fb22b8ed95575'),
(5, 'Martha', 'Turtle', 'Server', 2, 'Martha@aol.com', 'ae2b1fca515949e5d54fb22b8ed95575'),
(6, 'Stephen', 'Bell', 'Manager', 0, 'stbell1223@yahoo.com', 'd69403e2673e611d4cbd3fad6fd1788e');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `emp_num` int(11) NOT NULL,
  `shift_id` int(3) NOT NULL,
  PRIMARY KEY (`emp_num`,`shift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE IF NOT EXISTS `shifts` (
  `shift_id` int(5) NOT NULL AUTO_INCREMENT,
  `date_of_shift` date NOT NULL,
  `max_num_employees` int(2) NOT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`shift_id`, `date_of_shift`, `max_num_employees`) VALUES
(15, '2014-06-07', 2),
(16, '2014-06-08', 1),
(17, '2014-06-09', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
