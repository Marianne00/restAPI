-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2018 at 07:13 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizzen`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `fname`, `mname`, `lname`, `username`, `password`) VALUES
(1, 'Marianne', 'Abanico', 'de Asis', '__mcdeath', 'helloworld'),
(3, 'Russel', 'Abanico', 'de Asis', '__mcdeath', 'iamrusselthegreat'),
(4, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `hosted_quizzes`
--

CREATE TABLE `hosted_quizzes` (
  `hosted_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hosted_quizzes`
--

INSERT INTO `hosted_quizzes` (`hosted_id`, `quiz_id`, `admin_id`) VALUES
(1, 1, 1),
(2, 16, 69);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quizID` int(11) NOT NULL,
  `quizTitle` varchar(50) NOT NULL,
  `parts` int(10) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quizID`, `quizTitle`, `parts`, `date_created`) VALUES
(1, 'Bigte', 2, '2018-07-11 23:33:40'),
(2, 'Hayop na mabangis: Princess Thea', 3, '2018-07-11 23:34:27'),
(3, '', 0, '2018-07-12 00:16:34'),
(4, '', 0, '2018-07-12 00:21:31'),
(5, 'Pinakamabangis na hayop', 4, '2018-07-12 00:22:30'),
(6, 'Magalis', 6, '2018-07-12 00:36:33'),
(7, 'Magalis si Princess Thea', 6, '2018-07-12 00:37:48'),
(8, 'Maangis', 8, '2018-07-12 00:41:04'),
(9, 'NAKAKAIMPAKTA NA!', 9, '2018-07-12 00:47:18'),
(10, 'NAKAKAIMPAKTA NA HUHUHU!', 10, '2018-07-12 00:56:36'),
(11, 'ENEBE!', 11, '2018-07-12 00:58:40'),
(12, 'PANTULOG NA BA!', 12, '2018-07-12 01:01:01'),
(13, 'HUHU!', 14, '2018-07-12 01:02:02'),
(14, 'EUT!', 14, '2018-07-12 01:02:36'),
(15, 'TEWUP!', 14, '2018-07-12 01:03:28'),
(16, 'MABAGES!', 14, '2018-07-12 01:06:03');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` int(11) NOT NULL,
  `section` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `section`) VALUES
(1, 'BSIT 3C-G1'),
(2, 'BSIT 4E-G1'),
(3, 'ACT 2S-G2'),
(4, 'BSIT 3A-G1');

-- --------------------------------------------------------

--
-- Table structure for table `sections_handled`
--

CREATE TABLE `sections_handled` (
  `handling_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections_handled`
--

INSERT INTO `sections_handled` (`handling_id`, `host_id`, `section_id`) VALUES
(1, 1, 1),
(2, 1, 4),
(3, 3, 2),
(4, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(10) NOT NULL,
  `section_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'INACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `section_id`, `fname`, `mname`, `lname`, `status`) VALUES
('2010000001', 1, 'Updated', 'De Updated Asis', 'Updated', 'ACTIVE'),
('2010505565', 2, 'Allen', 'Ronquillo', 'Villanueva', 'INACTIVE'),
('2011111111', 3, 'Denise', 'De Guia', 'Sison', 'INACTIVE'),
('2012111121', 4, 'Rose Anne', 'Reyes', 'Gabriel', 'INACTIVE'),
('2015422422', 1, 'Chris', 'Gonzales', 'Manuel', 'ACTIVE'),
('2015456500', 1, 'Edzell', 'De Regla', 'Ramos', 'INACTIVE'),
('2015456565', 1, 'Jayare', 'Agot', 'Troyo', 'INACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `hosted_quizzes`
--
ALTER TABLE `hosted_quizzes`
  ADD PRIMARY KEY (`hosted_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quizID`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `sections_handled`
--
ALTER TABLE `sections_handled`
  ADD PRIMARY KEY (`handling_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hosted_quizzes`
--
ALTER TABLE `hosted_quizzes`
  MODIFY `hosted_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quizID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sections_handled`
--
ALTER TABLE `sections_handled`
  MODIFY `handling_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
