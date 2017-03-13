-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2017 at 01:14 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drs`
--

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `ID` int(10) NOT NULL,
  `USERID` int(23) NOT NULL,
  `USERNAME` varchar(30) NOT NULL,
  `PASSWORD` varchar(30) NOT NULL,
  `TYPE` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`ID`, `USERID`, `USERNAME`, `PASSWORD`, `TYPE`) VALUES
(16545, 2147483647, 'nkosi', 'test', ''),
(16562, 2147483000, 'zama', 'test', '');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `ID` int(10) NOT NULL,
  `USERID` int(10) NOT NULL,
  `PASSWORD` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(18) NOT NULL,
  `FIRSTNAME` varchar(30) NOT NULL,
  `LASTNAME` varchar(30) NOT NULL,
  `AGE` int(10) NOT NULL,
  `IDNUMBER` int(13) NOT NULL,
  `ADDRESS1` varchar(30) DEFAULT NULL,
  `ADDRESS2` varchar(30) DEFAULT NULL,
  `ADDRESS3` varchar(30) DEFAULT NULL,
  `LOGIN` int(10) NOT NULL,
  `CARDNUMBER` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `FIRSTNAME`, `LASTNAME`, `AGE`, `IDNUMBER`, `ADDRESS1`, `ADDRESS2`, `ADDRESS3`, `LOGIN`, `CARDNUMBER`) VALUES
(648646, 'Nkosinathi', 'Khumalo', 26, 900323538, '49/614 Lulonga Crescent Ave', 'Cosmo Creek', '2169', 2147483647, 'C-2468'),
(6482324, 'Zama', 'Gumede', 27, 890301538, '49/614 Lulonga Crescent Ave', 'Cosmo Creek', '2169', 2147483000, 'C-2456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
