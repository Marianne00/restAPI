-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2018 at 11:04 AM
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
(11, 'Marianne', 'cdfd', 'de Asis', 'mariannedeasis24300', 'marianne'),
(12, 'Edzell', 'DR', 'Ramos', 'edzell1996', 'marianne'),
(13, 'Edzell', 'DR', 'Ramos', 'edzell1997', 'pooplock'),
(14, 'cHRIS', 'DJAS', 'NJKSDN', 'DSJFNSKFSJK', 'JKDFSKJ');

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
(4, 4, 9),
(5, 7, 10);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `question` varchar(500) NOT NULL,
  `answer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `quiz_id`, `part_id`, `question`, `answer_id`) VALUES
(1, 1, 26, 'Who is the first programmer?', 1);

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
  `quiz_title` varchar(250) NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `quiz_title`, `date_created`) VALUES
(1, 'AngularJS Quiz', '2018-07-18 17:13:15'),
(7, 'Philippine Literature Quiz', '2018-07-18 17:13:15'),
(8, 'Logical Quiz', '2018-07-18 17:13:15'),
(9, 'History Quiz', '2018-07-18 17:13:15'),
(10, 'English Quiz', '2018-07-18 17:13:15');

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
(30, 2, 7, 'Hello Choice', 20, 1),
(31, 1, 7, 'The Witch Hunter', 20, 2),
(32, 1, 7, 'The Boar', 20, 3),
(33, 1, 7, 'Lean With It, Rock With It', 20, 4);

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
('2000000005', 3, 'allenupdated', 'ronquilloupdated', 'villanuevaupdated', 'INACTIVE'),
('2010000000', 1, 'Updated', 'De Updated Asis', 'Updated', 'INACTIVE'),
('2011111111', 3, 'Denise', 'De Guia', 'Sison', 'INACTIVE'),
('2011555555', 1, 'dfs', 'dfsdf', 'fgd', 'INACTIVE'),
('2011555558', 3, 'dfs', 'dfsdf', 'fgd', 'INACTIVE'),
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
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `hosted_quizzes`
--
ALTER TABLE `hosted_quizzes`
  MODIFY `hosted_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `question_types`
--
ALTER TABLE `question_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `quiz_parts`
--
ALTER TABLE `quiz_parts`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
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
