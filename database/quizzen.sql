-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2018 at 08:23 AM
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
(4, 'Updated', 'De Updated Asis', 'Updated', '', ''),
(5, 'Gian', 'Trillana', 'Perez', 'gian', 'gianfrancis'),
(6, 'Gian', 'Trillana', 'Perez', 'gian', 'gian'),
(7, 'Gian', 'Trillana', 'Perez', 'gian', 'gian'),
(8, 'Marianne', 'aaa', 'ez', 'an', 'an'),
(9, 'Marianne', 'aaa', 'ez', 'aaaaaaaaaaaaaaa', 'annnnnnn'),
(10, 'Marianne', 'Abanico', 'de Asis', 'mariannedeasis2000', 'marianne'),
(11, 'Marianne', 'cdfd', 'de Asis', 'mariannedeasis24300', 'marianne');

-- --------------------------------------------------------

--
-- Table structure for table `hosted_quizzes`
--

CREATE TABLE `hosted_quizzes` (
  `hosted_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hosted_quizzes`
--

INSERT INTO `hosted_quizzes` (`hosted_id`, `admin_id`, `quiz_id`) VALUES
(1, 3, 1),
(2, 69, 7),
(3, 3, 8),
(4, 4, 9);

-- --------------------------------------------------------

--
-- Table structure for table `question_types`
--

CREATE TABLE `question_types` (
  `type_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_types`
--

INSERT INTO `question_types` (`type_id`, `type`) VALUES
(1, 'Multiple Choice'),
(2, 'True or False'),
(3, 'Arrange The Sequence'),
(4, 'Guess the Word');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `quiz_title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `quiz_title`) VALUES
(1, 'Quiz About Programming'),
(7, 'Neon Quiz'),
(8, 'Logical Quiz'),
(9, 'History Quiz');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_parts`
--

CREATE TABLE `quiz_parts` (
  `part_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `part_title` varchar(200) NOT NULL,
  `duration` int(11) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_parts`
--

INSERT INTO `quiz_parts` (`part_id`, `type_id`, `quiz_id`, `part_title`, `duration`, `position`) VALUES
(18, 2, 7, 'Neon Part 1', 10, 1),
(19, 2, 7, 'Neon Part 2', 5, 2),
(20, 2, 7, 'Neon Part 3', 20, 3),
(21, 2, 7, 'Neon Part 4', 12, 4);

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
(4, 'BSIT 3A-G1'),
(5, 'BSIT 3I-G2'),
(6, 'BSIT 3C-G2');

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
('', 0, 'Marianne', '', 'de Asis', 'INACTIVE'),
('2010000000', 1, 'Updated', 'De Updated Asis', 'Updated', 'INACTIVE'),
('2010505565', 2, 'Allen', 'Ronquillo', 'Villanueva', 'INACTIVE'),
('2011111111', 3, 'Denise', 'De Guia', 'Sison', 'INACTIVE'),
('2011555555', 1, 'dfs', 'dfsdf', 'fgd', 'INACTIVE'),
('2012111121', 4, 'Rose Anne', 'Reyes', 'Gabriel', 'INACTIVE'),
('2012209343', 5, 'Jenny', 'Santos', 'Abanico', 'INACTIVE'),
('2015100139', 1, 'Marianne', 'Abanico', 'de Asis', 'ACTIVE'),
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
-- Indexes for table `question_types`
--
ALTER TABLE `question_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quiz_parts`
--
ALTER TABLE `quiz_parts`
  ADD PRIMARY KEY (`part_id`);

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `hosted_quizzes`
--
ALTER TABLE `hosted_quizzes`
  MODIFY `hosted_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `question_types`
--
ALTER TABLE `question_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `quiz_parts`
--
ALTER TABLE `quiz_parts`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `sections_handled`
--
ALTER TABLE `sections_handled`
  MODIFY `handling_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
