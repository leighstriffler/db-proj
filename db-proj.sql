-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2021 at 11:33 PM
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
  `p_ID` varchar(255) NOT NULL,
  `d_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attends`
--

CREATE TABLE `attends` (
  `p_ID` varchar(255) NOT NULL,
  `appt_ID` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `d_ID` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone_num` int(10) NOT NULL,
  `office` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `doc_appts_view`
-- (See below for the actual view)
--
CREATE TABLE `doc_appts_view` (
`firstname` varchar(255)
,`middlename` varchar(255)
,`lastname` varchar(255)
,`date` date
,`time` time
,`room_num` varchar(255)
,`ID` varchar(255)
,`d_ID` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `doc_patients_view`
-- (See below for the actual view)
--
CREATE TABLE `doc_patients_view` (
`p_ID` varchar(255)
,`firstname` varchar(255)
,`middlename` varchar(255)
,`lastname` varchar(255)
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
,`p_ID` varchar(255)
,`date` date
,`time` time
,`type` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `nurse`
--

CREATE TABLE `nurse` (
  `n_ID` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone_num` int(10) NOT NULL,
  `department` varchar(255) NOT NULL,
  `d_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `nurse_appts_view`
-- (See below for the actual view)
--
CREATE TABLE `nurse_appts_view` (
`firstname` varchar(255)
,`middlename` varchar(255)
,`lastname` varchar(255)
,`date` date
,`time` time
,`room_num` varchar(255)
,`ID` varchar(255)
,`d_ID` varchar(255)
,`n_ID` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `p_ID` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `insurance` varchar(255) NOT NULL,
  `date_admitted` date NOT NULL,
  `date_checkout` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `patient_appts_view`
-- (See below for the actual view)
--
CREATE TABLE `patient_appts_view` (
`p_ID` varchar(255)
,`firstname` varchar(255)
,`middlename` varchar(255)
,`lastname` varchar(255)
,`insurance` varchar(255)
,`date_admitted` date
,`date_checkout` date
,`date` date
,`time` time
,`room_num` varchar(255)
,`ID` varchar(255)
,`doctor.firstname` varchar(255)
,`doctor.lastname` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `patient_doc`
--

CREATE TABLE `patient_doc` (
  `p_ID` varchar(255) NOT NULL,
  `d_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `patient_info_view`
-- (See below for the actual view)
--
CREATE TABLE `patient_info_view` (
`p_ID` varchar(255)
,`firstname` varchar(255)
,`middlename` varchar(255)
,`lastname` varchar(255)
,`insurance` varchar(255)
,`date_admitted` date
,`date_checkout` date
,`ID` varchar(255)
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
  `p_ID` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_num` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `doc_appts_view`
--
DROP TABLE IF EXISTS `doc_appts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `doc_appts_view`  AS SELECT `patient`.`firstname` AS `firstname`, `patient`.`middlename` AS `middlename`, `patient`.`lastname` AS `lastname`, `attends`.`date` AS `date`, `attends`.`time` AS `time`, `reserves`.`room_num` AS `room_num`, `users`.`ID` AS `ID`, `appointment`.`d_ID` AS `d_ID` FROM ((((`appointment` join `patient` on(`appointment`.`p_ID` = `patient`.`p_ID`)) join `users` on(`patient`.`p_ID` = `users`.`ID`)) join `attends` on(`appointment`.`p_ID` = `attends`.`p_ID`)) join `reserves` on(`reserves`.`p_ID` = `patient`.`p_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `doc_patients_view`
--
DROP TABLE IF EXISTS `doc_patients_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `doc_patients_view`  AS SELECT `patient`.`p_ID` AS `p_ID`, `patient`.`firstname` AS `firstname`, `patient`.`middlename` AS `middlename`, `patient`.`lastname` AS `lastname`, `patient`.`insurance` AS `insurance`, `patient`.`date_admitted` AS `date_admitted`, `patient`.`date_checkout` AS `date_checkout`, `doctor`.`d_ID` AS `d_ID` FROM ((`doctor` join `patient_doc` on(`patient_doc`.`d_ID` = `doctor`.`d_ID`)) join `patient` on(`patient`.`p_ID` = `patient_doc`.`p_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `doc_reserve_view`
--
DROP TABLE IF EXISTS `doc_reserve_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `doc_reserve_view`  AS SELECT `reserves`.`d_ID` AS `d_ID`, `reserves`.`room_num` AS `room_num`, `reserves`.`p_ID` AS `p_ID`, `reserves`.`date` AS `date`, `reserves`.`time` AS `time`, `room`.`type` AS `type` FROM (`reserves` join `room` on(`room`.`room_num` = `reserves`.`room_num`)) ;

-- --------------------------------------------------------

--
-- Structure for view `nurse_appts_view`
--
DROP TABLE IF EXISTS `nurse_appts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nurse_appts_view`  AS SELECT `patient`.`firstname` AS `firstname`, `patient`.`middlename` AS `middlename`, `patient`.`lastname` AS `lastname`, `attends`.`date` AS `date`, `attends`.`time` AS `time`, `reserves`.`room_num` AS `room_num`, `users`.`ID` AS `ID`, `appointment`.`d_ID` AS `d_ID`, `nurse`.`n_ID` AS `n_ID` FROM (((((`appointment` join `nurse` on(`appointment`.`d_ID` = `nurse`.`d_ID`)) join `patient` on(`appointment`.`p_ID` = `patient`.`p_ID`)) join `users` on(`patient`.`p_ID` = `users`.`ID`)) join `attends` on(`appointment`.`p_ID` = `attends`.`p_ID`)) join `reserves` on(`reserves`.`p_ID` = `patient`.`p_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `patient_appts_view`
--
DROP TABLE IF EXISTS `patient_appts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `patient_appts_view`  AS SELECT `patient`.`p_ID` AS `p_ID`, `patient`.`firstname` AS `firstname`, `patient`.`middlename` AS `middlename`, `patient`.`lastname` AS `lastname`, `patient`.`insurance` AS `insurance`, `patient`.`date_admitted` AS `date_admitted`, `patient`.`date_checkout` AS `date_checkout`, `attends`.`date` AS `date`, `attends`.`time` AS `time`, `reserves`.`room_num` AS `room_num`, `users`.`ID` AS `ID`, `doctor`.`firstname` AS `doctor.firstname`, `doctor`.`lastname` AS `doctor.lastname` FROM (((((`appointment` join `patient` on(`appointment`.`p_ID` = `patient`.`p_ID`)) join `users` on(`patient`.`p_ID` = `users`.`ID`)) join `attends` on(`appointment`.`p_ID` = `attends`.`p_ID`)) join `reserves` on(`reserves`.`p_ID` = `patient`.`p_ID`)) join `doctor` on(`doctor`.`d_ID` = `appointment`.`d_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `patient_info_view`
--
DROP TABLE IF EXISTS `patient_info_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `patient_info_view`  AS SELECT `patient`.`p_ID` AS `p_ID`, `patient`.`firstname` AS `firstname`, `patient`.`middlename` AS `middlename`, `patient`.`lastname` AS `lastname`, `patient`.`insurance` AS `insurance`, `patient`.`date_admitted` AS `date_admitted`, `patient`.`date_checkout` AS `date_checkout`, `users`.`ID` AS `ID`, `users`.`pass` AS `pass`, `users`.`role` AS `role` FROM (`patient` join `users` on(`patient`.`p_ID` = `users`.`ID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appt_ID`),
  ADD KEY `d_ID` (`d_ID`),
  ADD KEY `p_ID` (`p_ID`);

--
-- Indexes for table `attends`
--
ALTER TABLE `attends`
  ADD PRIMARY KEY (`p_ID`,`appt_ID`);

--
-- Indexes for table `consults`
--
ALTER TABLE `consults`
  ADD PRIMARY KEY (`d1_ID`,`d2_ID`),
  ADD KEY `d2_ID` (`d2_ID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`d_ID`);

--
-- Indexes for table `nurse`
--
ALTER TABLE `nurse`
  ADD PRIMARY KEY (`n_ID`),
  ADD KEY `d_ID` (`d_ID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`p_ID`);

--
-- Indexes for table `patient_doc`
--
ALTER TABLE `patient_doc`
  ADD PRIMARY KEY (`p_ID`,`d_ID`),
  ADD KEY `d_ID` (`d_ID`);

--
-- Indexes for table `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`room_num`,`d_ID`),
  ADD KEY `p_ID` (`p_ID`),
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
  ADD PRIMARY KEY (`ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`d_ID`) REFERENCES `doctor` (`d_ID`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`p_ID`) REFERENCES `patient` (`p_ID`);

--
-- Constraints for table `attends`
--
ALTER TABLE `attends`
  ADD CONSTRAINT `attends_ibfk_1` FOREIGN KEY (`p_ID`) REFERENCES `patient` (`p_ID`);

--
-- Constraints for table `consults`
--
ALTER TABLE `consults`
  ADD CONSTRAINT `consults_ibfk_1` FOREIGN KEY (`d1_ID`) REFERENCES `doctor` (`d_ID`),
  ADD CONSTRAINT `consults_ibfk_2` FOREIGN KEY (`d2_ID`) REFERENCES `doctor` (`d_ID`);

--
-- Constraints for table `nurse`
--
ALTER TABLE `nurse`
  ADD CONSTRAINT `nurse_ibfk_1` FOREIGN KEY (`d_ID`) REFERENCES `doctor` (`d_ID`);

--
-- Constraints for table `patient_doc`
--
ALTER TABLE `patient_doc`
  ADD CONSTRAINT `patient_doc_ibfk_1` FOREIGN KEY (`d_ID`) REFERENCES `doctor` (`d_ID`),
  ADD CONSTRAINT `patient_doc_ibfk_2` FOREIGN KEY (`p_ID`) REFERENCES `patient` (`p_ID`);

--
-- Constraints for table `reserves`
--
ALTER TABLE `reserves`
  ADD CONSTRAINT `reserves_ibfk_1` FOREIGN KEY (`p_ID`) REFERENCES `patient` (`p_ID`),
  ADD CONSTRAINT `reserves_ibfk_2` FOREIGN KEY (`d_ID`) REFERENCES `doctor` (`d_ID`),
  ADD CONSTRAINT `reserves_ibfk_3` FOREIGN KEY (`room_num`) REFERENCES `room` (`room_num`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
