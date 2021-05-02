-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2021 at 11:14 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_patient` (IN `p_id` VARCHAR(255), IN `f` VARCHAR(225), IN `m` VARCHAR(225), IN `l` VARCHAR(225), IN `insur` VARCHAR(225), IN `dadm` VARCHAR(225), IN `dch` VARCHAR(225), IN `doc_id` VARCHAR(255), IN `pass` VARCHAR(255), IN `role` VARCHAR(255))  BEGIN
	START TRANSACTION;
	INSERT INTO patient (p_ID, firstname, middlename, lastname, insurance, date_admitted, date_checkout)
	VALUES (p_id, f, m, l, insur, dadm, dch);

	INSERT INTO patient_doc (p_ID, d_ID) 
                    VALUES(p_id, doc_id);

	INSERT INTO users (ID, pass, role) 
                    VALUES(p_id, pass, role);
	COMMIT;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_appt` (IN `p_id` VARCHAR(255), IN `appointmentid` VARCHAR(225))  BEGIN
	START TRANSACTION;
		DELETE FROM appointment WHERE appt_id=appointmentid AND appointment.p_ID=p_id;
		DELETE FROM attends WHERE attends.p_ID=p_id AND appt_id=appointmentid;
	COMMIT;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_patient_info` (IN `p_id` VARCHAR(255), IN `f` VARCHAR(225), IN `m` VARCHAR(225), IN `l` VARCHAR(225), IN `insur` VARCHAR(225))  BEGIN
	START TRANSACTION;
		UPDATE patient 
		SET firstname=f, middlename=m, lastname=l, insurance=insur
		WHERE patient.p_ID=p_id;
	COMMIT;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appt_ID` varchar(255) NOT NULL,
  `p_ID` varchar(255) NOT NULL,
  `d_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appt_ID`, `p_ID`, `d_ID`) VALUES
('1', 'aabranch', '1001'),
('2', 'hhbranch', '1001');

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

--
-- Dumping data for table `attends`
--

INSERT INTO `attends` (`p_ID`, `appt_ID`, `date`, `time`) VALUES
('aabranch', '1', '2021-05-12', '07:38:00'),
('hhbranch', '2', '2021-05-29', '24:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `consults`
--

CREATE TABLE `consults` (
  `d1_ID` varchar(255) NOT NULL,
  `d2_ID` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL
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

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`d_ID`, `firstname`, `middlename`, `lastname`, `phone_num`, `office`) VALUES
('1001', 'Bob', 'the', 'Doctor', 123456789, 'West Office');

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
,`p_ID` varchar(255)
,`d_ID` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `doc_consults_view`
-- (See below for the actual view)
--
CREATE TABLE `doc_consults_view` (
`d1_ID` varchar(255)
,`d2_ID` varchar(255)
,`date` date
,`description` text
,`d_ID` varchar(255)
,`firstname` varchar(255)
,`middlename` varchar(255)
,`lastname` varchar(255)
,`phone_num` int(10)
,`office` varchar(255)
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
,`n_ID` varchar(255)
,`type` varchar(255)
,`firstname` varchar(255)
,`middlename` varchar(255)
,`lastname` varchar(255)
,`nursefirst` varchar(255)
,`nurselast` varchar(255)
,`date_admitted` date
,`date_checkout` date
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

--
-- Dumping data for table `nurse`
--

INSERT INTO `nurse` (`n_ID`, `firstname`, `middlename`, `lastname`, `phone_num`, `department`, `d_ID`) VALUES
('nurse1', 'Emily', 'Marie', 'Strauss', 1234567890, 'ER', '1001');

-- --------------------------------------------------------

--
-- Stand-in structure for view `nurse_reserves_view`
-- (See below for the actual view)
--
CREATE TABLE `nurse_reserves_view` (
`firstname` varchar(255)
,`middlename` varchar(255)
,`lastname` varchar(255)
,`date_admitted` date
,`date_checkout` date
,`room_num` varchar(255)
,`p_ID` varchar(255)
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

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`p_ID`, `firstname`, `middlename`, `lastname`, `insurance`, `date_admitted`, `date_checkout`) VALUES
('aabranch', 'ally', NULL, 'branch', 'cigna', '2021-05-11', '2021-05-20'),
('hana', 'hana', 'sdf', 'sdfsd', 'sdfsd', '2021-04-28', '2021-04-28'),
('hhbranch', 'heidi', 's', 'branch', 'aetna', '2021-05-08', '2021-06-04'),
('leighstrif', 'lisa', 's', 'striffler', 'cigna', '2021-12-13', '2021-12-14'),
('marissam', 'marissa', 'n', 'nardf', 'uva', '2021-04-28', '2021-04-28'),
('nbBranch', 'Noell', 'Elise', 'Branch', 'Aetna', '2021-05-05', '2021-06-03'),
('sStein', 'Shay', 'Nicole', 'Steinkirchner', 'Aetna', '2021-05-14', '2021-06-03');

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
,`appt_ID` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `patient_doc`
--

CREATE TABLE `patient_doc` (
  `p_ID` varchar(255) NOT NULL,
  `d_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_doc`
--

INSERT INTO `patient_doc` (`p_ID`, `d_ID`) VALUES
('aabranch', '1001'),
('hana', '1001'),
('hhbranch', '1001'),
('leighstrif', '1001'),
('marissam', '1001'),
('nbBranch', '1001'),
('sStein', '1001');

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
  `n_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reserves`
--

INSERT INTO `reserves` (`d_ID`, `room_num`, `p_ID`, `n_ID`) VALUES
('1001', '100', 'aabranch', 'nurse1');

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
('100', 'patient'),
('200', 'patient'),
('300', 'patient'),
('400', 'patient');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `pass`, `role`) VALUES
('1001', 'password', 'doctor'),
('aabranch', 'password', 'patient'),
('hana', 'sdf', 'patient'),
('hhbranch', 'password', 'patient'),
('leighstrif', 'password', 'patient'),
('marissam', 'password', 'patient'),
('nbBranch', 'password', 'patient'),
('nurse1', 'password', 'nurse'),
('sStein', 'password', 'patient');

-- --------------------------------------------------------

--
-- Structure for view `doc_appts_view`
--
DROP TABLE IF EXISTS `doc_appts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `doc_appts_view`  AS SELECT `patient`.`firstname` AS `firstname`, `patient`.`middlename` AS `middlename`, `patient`.`lastname` AS `lastname`, `attends`.`date` AS `date`, `attends`.`time` AS `time`, `users`.`ID` AS `p_ID`, `appointment`.`d_ID` AS `d_ID` FROM (((`appointment` join `patient` on(`appointment`.`p_ID` = `patient`.`p_ID`)) join `users` on(`patient`.`p_ID` = `users`.`ID`)) join `attends` on(`appointment`.`p_ID` = `attends`.`p_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `doc_consults_view`
--
DROP TABLE IF EXISTS `doc_consults_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `doc_consults_view`  AS SELECT `consults`.`d1_ID` AS `d1_ID`, `consults`.`d2_ID` AS `d2_ID`, `consults`.`date` AS `date`, `consults`.`description` AS `description`, `doctor`.`d_ID` AS `d_ID`, `doctor`.`firstname` AS `firstname`, `doctor`.`middlename` AS `middlename`, `doctor`.`lastname` AS `lastname`, `doctor`.`phone_num` AS `phone_num`, `doctor`.`office` AS `office` FROM (`consults` join `doctor` on(`consults`.`d2_ID` = `doctor`.`d_ID`)) ;

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `doc_reserve_view`  AS SELECT `reserves`.`d_ID` AS `d_ID`, `reserves`.`room_num` AS `room_num`, `reserves`.`p_ID` AS `p_ID`, `reserves`.`n_ID` AS `n_ID`, `room`.`type` AS `type`, `patient`.`firstname` AS `firstname`, `patient`.`middlename` AS `middlename`, `patient`.`lastname` AS `lastname`, `nurse`.`firstname` AS `nursefirst`, `nurse`.`lastname` AS `nurselast`, `patient`.`date_admitted` AS `date_admitted`, `patient`.`date_checkout` AS `date_checkout` FROM (((`reserves` join `room` on(`room`.`room_num` = `reserves`.`room_num`)) join `patient` on(`reserves`.`p_ID` = `patient`.`p_ID`)) join `nurse` on(`nurse`.`n_ID` = `reserves`.`n_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `nurse_reserves_view`
--
DROP TABLE IF EXISTS `nurse_reserves_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nurse_reserves_view`  AS SELECT `patient`.`firstname` AS `firstname`, `patient`.`middlename` AS `middlename`, `patient`.`lastname` AS `lastname`, `patient`.`date_admitted` AS `date_admitted`, `patient`.`date_checkout` AS `date_checkout`, `reserves`.`room_num` AS `room_num`, `users`.`ID` AS `p_ID`, `appointment`.`d_ID` AS `d_ID`, `nurse`.`n_ID` AS `n_ID` FROM ((((`appointment` join `nurse` on(`appointment`.`d_ID` = `nurse`.`d_ID`)) join `patient` on(`appointment`.`p_ID` = `patient`.`p_ID`)) join `users` on(`patient`.`p_ID` = `users`.`ID`)) join `reserves` on(`reserves`.`p_ID` = `patient`.`p_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `patient_appts_view`
--
DROP TABLE IF EXISTS `patient_appts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `patient_appts_view`  AS SELECT `patient`.`p_ID` AS `p_ID`, `patient`.`firstname` AS `firstname`, `patient`.`middlename` AS `middlename`, `patient`.`lastname` AS `lastname`, `patient`.`insurance` AS `insurance`, `patient`.`date_admitted` AS `date_admitted`, `patient`.`date_checkout` AS `date_checkout`, `attends`.`date` AS `date`, `attends`.`time` AS `time`, `reserves`.`room_num` AS `room_num`, `users`.`ID` AS `ID`, `doctor`.`firstname` AS `doctor.firstname`, `doctor`.`lastname` AS `doctor.lastname`, `appointment`.`appt_ID` AS `appt_ID` FROM (((((`appointment` join `patient` on(`appointment`.`p_ID` = `patient`.`p_ID`)) join `users` on(`patient`.`p_ID` = `users`.`ID`)) join `attends` on(`appointment`.`p_ID` = `attends`.`p_ID`)) join `reserves` on(`reserves`.`p_ID` = `patient`.`p_ID`)) join `doctor` on(`doctor`.`d_ID` = `appointment`.`d_ID`)) ;

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
  ADD PRIMARY KEY (`room_num`,`p_ID`),
  ADD UNIQUE KEY `room_num` (`room_num`),
  ADD KEY `p_ID` (`p_ID`),
  ADD KEY `d_ID` (`d_ID`),
  ADD KEY `n_ID` (`n_ID`);

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
  ADD CONSTRAINT `reserves_ibfk_3` FOREIGN KEY (`room_num`) REFERENCES `room` (`room_num`),
  ADD CONSTRAINT `reserves_ibfk_4` FOREIGN KEY (`n_ID`) REFERENCES `nurse` (`n_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
