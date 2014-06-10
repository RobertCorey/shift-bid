-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2014 at 01:33 AM
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
(3, '1402253286', '28', 2),
(5, '12', '15', 10),
(5, '1402245443', '28', 1),
(5, '1402245453', '17', 1),
(5, '1402332237', '28', 3),
(5, '1402332245', '25', 1),
(6, '20', '15', 11);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_num`, `emp_f_name`, `emp_l_name`, `emp_role`, `emp_points`, `emp_email`, `emp_password`) VALUES
(3, 'Trevor', 'Yeroc', 'Server', 12, 'pigpower100@gmail.com', 'ae2b1fca515949e5d54fb22b8ed95575'),
(4, 'Joe', 'Smith', 'doctor', 20, 'a@a.com', 'ae2b1fca515949e5d54fb22b8ed95575'),
(5, 'Martha', 'Turtle', 'Server', 6, 'Martha@aol.com', 'ae2b1fca515949e5d54fb22b8ed95575'),
(6, 'Stephen', 'Bell', 'Manager', 0, 'stbell1223@yahoo.com', 'd69403e2673e611d4cbd3fad6fd1788e'),
(7, 'Joe', 'Smithy', 'Waiter/Waitress', 0, 'Joe@ordinaryguy.com', 'ae2b1fca515949e5d54fb22b8ed95575'),
(8, 'No ', 'Points', 'Waiter/Waitress', 0, 'broke@testing.com', 'ae2b1fca515949e5d54fb22b8ed95575');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE IF NOT EXISTS `shifts` (
  `shift_id` int(5) NOT NULL AUTO_INCREMENT,
  `date_of_shift` date NOT NULL,
  `max_num_employees` int(2) NOT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`shift_id`, `date_of_shift`, `max_num_employees`) VALUES
(15, '2014-06-07', 2),
(16, '2014-06-08', 1),
(17, '2014-06-09', 3),
(25, '2014-06-11', 3),
(26, '2014-06-18', 5),
(27, '2014-06-18', 5),
(28, '2014-06-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(3) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(20) NOT NULL,
  `task_description` varchar(50) NOT NULL,
  `task_status` varchar(15) NOT NULL,
  `task_point_value` int(5) NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `task_description`, `task_status`, `task_point_value`) VALUES
(1, 'Trash', 'Take out the trash', 'Open', 100),
(2, 'Dishes', 'Do Dishes', 'Open', 300);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
