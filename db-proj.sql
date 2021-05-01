-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2021 at 03:07 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db-proj`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appt_ID` varchar(255) NOT NULL,
  `p_SS` varchar(255) NOT NULL,
  `d_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appt_ID`, `p_SS`, `d_ID`) VALUES
('1', '23', '1'),
('2', '23', '1');

-- --------------------------------------------------------

--
-- Table structure for table `attends`
--

CREATE TABLE `attends` (
  `p_SS` varchar(255) NOT NULL,
  `a_ID` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attends`
--

INSERT INTO `attends` (`p_SS`, `a_ID`, `date`, `time`) VALUES
('23', '1', '2021-04-20', '18:10:23'),
('23', '2', '2021-04-29', '18:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `consults`
--

CREATE TABLE `consults` (
  `d1_ID` varchar(255) NOT NULL,
  `d2_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `d_ID` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone_num` int(10) NOT NULL,
  `office` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`d_ID`, `firstname`, `middlename`, `lastname`, `phone_num`, `office`) VALUES
('1', 'ally', 'a', 'branch', 77777777, 'rice');

-- --------------------------------------------------------

--
-- Stand-in structure for view `doc_appts_view`
-- (See below for the actual view)
--
CREATE TABLE `doc_appts_view` (
`f_name` varchar(255)
,`m_init` varchar(255)
,`l_name` varchar(255)
,`date` date
,`time` time
,`room_num` varchar(255)
,`username` varchar(255)
,`d_ID` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `doc_patients_view`
-- (See below for the actual view)
--
CREATE TABLE `doc_patients_view` (
`SS` varchar(255)
,`f_name` varchar(255)
,`m_init` varchar(255)
,`l_name` varchar(255)
,`insurance` varchar(255)
,`date_admitted` date
,`date_checkout` date
,`d_ID` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `doc_reserve_view`
-- (See below for the actual view)
--
CREATE TABLE `doc_reserve_view` (
`d_ID` varchar(255)
,`room_num` varchar(255)
,`SS` varchar(255)
,`date` date
,`time` time
,`type` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `nurses`
--

CREATE TABLE `nurses` (
  `n_ID` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `m_init` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) NOT NULL,
  `phone_num` int(10) NOT NULL,
  `department` varchar(255) NOT NULL,
  `d_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nurses`
--

INSERT INTO `nurses` (`n_ID`, `f_name`, `m_init`, `l_name`, `phone_num`, `department`, `d_ID`) VALUES
('1', 'kate', 'd', 'penny', 77777777, 'er', '1');

-- --------------------------------------------------------

--
-- Stand-in structure for view `nurse_appts_view`
-- (See below for the actual view)
--
CREATE TABLE `nurse_appts_view` (
`f_name` varchar(255)
,`m_init` varchar(255)
,`l_name` varchar(255)
,`date` date
,`time` time
,`room_num` varchar(255)
,`username` varchar(255)
,`d_ID` varchar(255)
,`n_ID` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `SS` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `m_init` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) NOT NULL,
  `insurance` varchar(255) NOT NULL,
  `date_admitted` date NOT NULL,
  `date_checkout` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`SS`, `f_name`, `m_init`, `l_name`, `insurance`, `date_admitted`, `date_checkout`) VALUES
('23', 'leigh', 's', 'striffler', 'bcbs', '2021-04-07', '2021-04-16');

-- --------------------------------------------------------

--
-- Stand-in structure for view `patient_appts_view`
-- (See below for the actual view)
--
CREATE TABLE `patient_appts_view` (
`SS` varchar(255)
,`f_name` varchar(255)
,`m_init` varchar(255)
,`l_name` varchar(255)
,`insurance` varchar(255)
,`date_admitted` date
,`date_checkout` date
,`date` date
,`time` time
,`room_num` varchar(255)
,`username` varchar(255)
,`firstname` varchar(255)
,`lastname` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `patient_doc`
--

CREATE TABLE `patient_doc` (
  `SS` varchar(255) NOT NULL,
  `d_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_doc`
--

INSERT INTO `patient_doc` (`SS`, `d_ID`) VALUES
('23', '1');

-- --------------------------------------------------------

--
-- Stand-in structure for view `patient_info_view`
-- (See below for the actual view)
--
CREATE TABLE `patient_info_view` (
`SS` varchar(255)
,`f_name` varchar(255)
,`m_init` varchar(255)
,`l_name` varchar(255)
,`insurance` varchar(255)
,`date_admitted` date
,`date_checkout` date
,`username` varchar(255)
,`fk_ID` varchar(255)
,`pass` varchar(255)
,`role` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `reserves`
--

CREATE TABLE `reserves` (
  `d_ID` varchar(255) NOT NULL,
  `room_num` varchar(255) NOT NULL,
  `SS` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reserves`
--

INSERT INTO `reserves` (`d_ID`, `room_num`, `SS`, `date`, `time`) VALUES
('1', '122', '23', '2021-04-29', '18:10:21'),
('1', '123', '23', '2021-04-20', '18:10:23');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_num` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_num`, `type`) VALUES
('122', 'exam'),
('123', 'exam');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `fk_ID` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `fk_ID`, `pass`, `role`) VALUES
('allyb', '1', 'ally', 'doctor'),
('katiep', '1', 'kp', 'nurse'),
('leighstrif', '23', 'pass1', 'patient');

-- --------------------------------------------------------

--
-- Structure for view `doc_appts_view`
--
DROP TABLE IF EXISTS `doc_appts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `doc_appts_view`  AS SELECT `patient`.`f_name` AS `f_name`, `patient`.`m_init` AS `m_init`, `patient`.`l_name` AS `l_name`, `attends`.`date` AS `date`, `attends`.`time` AS `time`, `reserves`.`room_num` AS `room_num`, `users`.`username` AS `username`, `appointment`.`d_ID` AS `d_ID` FROM ((((`appointment` join `patient` on(`appointment`.`p_SS` = `patient`.`SS`)) join `users` on(`patient`.`SS` = `users`.`fk_ID`)) join `attends` on(`appointment`.`p_SS` = `attends`.`p_SS`)) join `reserves` on(`reserves`.`SS` = `patient`.`SS`)) ;

-- --------------------------------------------------------

--
-- Structure for view `doc_patients_view`
--
DROP TABLE IF EXISTS `doc_patients_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `doc_patients_view`  AS SELECT `patient`.`SS` AS `SS`, `patient`.`f_name` AS `f_name`, `patient`.`m_init` AS `m_init`, `patient`.`l_name` AS `l_name`, `patient`.`insurance` AS `insurance`, `patient`.`date_admitted` AS `date_admitted`, `patient`.`date_checkout` AS `date_checkout`, `doctors`.`d_ID` AS `d_ID` FROM ((`doctors` join `patient_doc` on(`patient_doc`.`d_ID` = `doctors`.`d_ID`)) join `patient` on(`patient`.`SS` = `patient_doc`.`SS`)) ;

-- --------------------------------------------------------

--
-- Structure for view `doc_reserve_view`
--
DROP TABLE IF EXISTS `doc_reserve_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `doc_reserve_view`  AS SELECT `reserves`.`d_ID` AS `d_ID`, `reserves`.`room_num` AS `room_num`, `reserves`.`SS` AS `SS`, `reserves`.`date` AS `date`, `reserves`.`time` AS `time`, `room`.`type` AS `type` FROM (`reserves` join `room` on(`room`.`room_num` = `reserves`.`room_num`)) ;

-- --------------------------------------------------------

--
-- Structure for view `nurse_appts_view`
--
DROP TABLE IF EXISTS `nurse_appts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nurse_appts_view`  AS SELECT `patient`.`f_name` AS `f_name`, `patient`.`m_init` AS `m_init`, `patient`.`l_name` AS `l_name`, `attends`.`date` AS `date`, `attends`.`time` AS `time`, `reserves`.`room_num` AS `room_num`, `users`.`username` AS `username`, `appointment`.`d_ID` AS `d_ID`, `nurses`.`n_ID` AS `n_ID` FROM (((((`appointment` join `nurses` on(`appointment`.`d_ID` = `nurses`.`d_ID`)) join `patient` on(`appointment`.`p_SS` = `patient`.`SS`)) join `users` on(`patient`.`SS` = `users`.`fk_ID`)) join `attends` on(`appointment`.`p_SS` = `attends`.`p_SS`)) join `reserves` on(`reserves`.`SS` = `patient`.`SS`)) ;

-- --------------------------------------------------------

--
-- Structure for view `patient_appts_view`
--
DROP TABLE IF EXISTS `patient_appts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `patient_appts_view`  AS SELECT `patient`.`SS` AS `SS`, `patient`.`f_name` AS `f_name`, `patient`.`m_init` AS `m_init`, `patient`.`l_name` AS `l_name`, `patient`.`insurance` AS `insurance`, `patient`.`date_admitted` AS `date_admitted`, `patient`.`date_checkout` AS `date_checkout`, `attends`.`date` AS `date`, `attends`.`time` AS `time`, `reserves`.`room_num` AS `room_num`, `users`.`username` AS `username`, `doctors`.`firstname` AS `firstname`, `doctors`.`lastname` AS `lastname` FROM (((((`appointment` join `patient` on(`appointment`.`p_SS` = `patient`.`SS`)) join `users` on(`patient`.`SS` = `users`.`fk_ID`)) join `attends` on(`appointment`.`p_SS` = `attends`.`p_SS`)) join `reserves` on(`reserves`.`SS` = `patient`.`SS`)) join `doctors` on(`doctors`.`d_ID` = `appointment`.`d_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `patient_info_view`
--
DROP TABLE IF EXISTS `patient_info_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `patient_info_view`  AS SELECT `patient`.`SS` AS `SS`, `patient`.`f_name` AS `f_name`, `patient`.`m_init` AS `m_init`, `patient`.`l_name` AS `l_name`, `patient`.`insurance` AS `insurance`, `patient`.`date_admitted` AS `date_admitted`, `patient`.`date_checkout` AS `date_checkout`, `users`.`username` AS `username`, `users`.`fk_ID` AS `fk_ID`, `users`.`pass` AS `pass`, `users`.`role` AS `role` FROM (`patient` join `users` on(`patient`.`SS` = `users`.`fk_ID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appt_ID`),
  ADD KEY `d_ID` (`d_ID`),
  ADD KEY `SS` (`p_SS`);

--
-- Indexes for table `attends`
--
ALTER TABLE `attends`
  ADD PRIMARY KEY (`p_SS`,`a_ID`);

--
-- Indexes for table `consults`
--
ALTER TABLE `consults`
  ADD PRIMARY KEY (`d1_ID`,`d2_ID`),
  ADD KEY `d2_ID` (`d2_ID`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`d_ID`);

--
-- Indexes for table `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`n_ID`),
  ADD KEY `d_ID` (`d_ID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`SS`);

--
-- Indexes for table `patient_doc`
--
ALTER TABLE `patient_doc`
  ADD PRIMARY KEY (`SS`,`d_ID`),
  ADD KEY `d_ID` (`d_ID`);

--
-- Indexes for table `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`room_num`,`d_ID`),
  ADD KEY `SS` (`SS`),
  ADD KEY `d_ID` (`d_ID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_num`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`d_ID`) REFERENCES `doctors` (`d_ID`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`p_SS`) REFERENCES `patient` (`SS`);

--
-- Constraints for table `attends`
--
ALTER TABLE `attends`
  ADD CONSTRAINT `attends_ibfk_1` FOREIGN KEY (`p_SS`) REFERENCES `patient` (`SS`);

--
-- Constraints for table `consults`
--
ALTER TABLE `consults`
  ADD CONSTRAINT `consults_ibfk_1` FOREIGN KEY (`d1_ID`) REFERENCES `doctors` (`d_ID`),
  ADD CONSTRAINT `consults_ibfk_2` FOREIGN KEY (`d2_ID`) REFERENCES `doctors` (`d_ID`);

--
-- Constraints for table `nurses`
--
ALTER TABLE `nurses`
  ADD CONSTRAINT `nurses_ibfk_1` FOREIGN KEY (`d_ID`) REFERENCES `doctors` (`d_ID`);

--
-- Constraints for table `patient_doc`
--
ALTER TABLE `patient_doc`
  ADD CONSTRAINT `patient_doc_ibfk_1` FOREIGN KEY (`d_ID`) REFERENCES `doctors` (`d_ID`),
  ADD CONSTRAINT `patient_doc_ibfk_2` FOREIGN KEY (`SS`) REFERENCES `patient` (`SS`);

--
-- Constraints for table `reserves`
--
ALTER TABLE `reserves`
  ADD CONSTRAINT `reserves_ibfk_1` FOREIGN KEY (`SS`) REFERENCES `patient` (`SS`),
  ADD CONSTRAINT `reserves_ibfk_2` FOREIGN KEY (`d_ID`) REFERENCES `doctors` (`d_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
