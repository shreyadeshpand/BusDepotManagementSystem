-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Aug 06, 2023 at 06:28 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bss`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignedemp`
--
-- Creation: Apr 18, 2023 at 04:53 PM
-- Last update: Aug 06, 2023 at 02:59 PM
--

CREATE TABLE `assignedemp` (
  `date` date NOT NULL,
  `eid` varchar(5) NOT NULL,
  `ejob` int(1) NOT NULL,
  `busNo` varchar(5) NOT NULL,
  `shiftno` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `assignedemp`:
--   `eid`
--       `emp` -> `eid`
--

-- --------------------------------------------------------

--
-- Table structure for table `busdata`
--
-- Creation: Aug 06, 2023 at 02:22 PM
-- Last update: Aug 06, 2023 at 03:03 PM
--

CREATE TABLE `busdata` (
  `busNo` varchar(5) NOT NULL ,
  `vehicleNo` varchar(10) NOT NULL,
  `chasis` varchar(17) NOT NULL,
  `bType` varchar(11) NOT NULL,
  `bdepot` varchar(10) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `busdata`:
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `completeschedule`
-- (See below for the actual view)
--
CREATE TABLE `completeschedule` (
`date` date
,`eid` varchar(5)
,`ejob` int(1)
,`busNo` varchar(5)
,`shiftno` int(2)
,`rid` varchar(5)
,`shiftstart` time
,`shiftend` time
);

-- --------------------------------------------------------

--
-- Table structure for table `conductor_login`
--
-- Creation: May 06, 2023 at 01:26 AM
-- Last update: Aug 06, 2023 at 03:24 PM
--

CREATE TABLE `conductor_login` (
  `id` int(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `password` varchar(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `eid` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `conductor_login`:
--

--
-- Dumping data for table `conductor_login`
--

INSERT INTO `conductor_login` (`id`, `username`, `password`, `createdAt`, `eid`) VALUES
(11, 'b8091', '*9578471FDD', '2023-08-06 20:53:40', 'e686'),
(13, 'b9415', '*79098C9B27', '2023-08-06 20:54:32', 'e383');

-- --------------------------------------------------------

--
-- Stand-in structure for view `conductor_view`
-- (See below for the actual view)
--
CREATE TABLE `conductor_view` (
`eid` varchar(8)
,`ename` varchar(47)
,`etype` varchar(10)
,`ejob` int(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `controller_view`
-- (See below for the actual view)
--
CREATE TABLE `controller_view` (
`eid` varchar(8)
,`ename` varchar(47)
,`etype` varchar(10)
,`ejob` int(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `deletedbus`
-- (See below for the actual view)
--
CREATE TABLE `deletedbus` (
`busNo` varchar(5)
,`vehicleNo` varchar(10)
,`chasis` varchar(17)
,`bType` varchar(11)
,`bdepot` varchar(10)
,`timestamp` datetime
,`deleted` int(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `driver_view`
-- (See below for the actual view)
--
CREATE TABLE `driver_view` (
`eid` varchar(8)
,`ename` varchar(47)
,`etype` varchar(10)
,`ejob` int(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `emobile`
--
-- Creation: Jun 23, 2023 at 07:34 AM
-- Last update: Aug 06, 2023 at 03:03 PM
--

CREATE TABLE `emobile` (
  `eid` varchar(5) NOT NULL,
  `emob` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `emobile`:
--

-- --------------------------------------------------------

--
-- Table structure for table `emp`
--
-- Creation: May 12, 2023 at 01:19 PM
-- Last update: Aug 06, 2023 at 03:46 PM
--

CREATE TABLE `emp` (
  `eid` varchar(8) NOT NULL,
  `efname` varchar(15) NOT NULL,
  `emname` varchar(15) NOT NULL,
  `elname` varchar(15) NOT NULL,
  `eage` int(2) NOT NULL,
  `egender` varchar(8) NOT NULL,
  `esalary` int(6) NOT NULL,
  `etype` varchar(10) NOT NULL,
  `edob` date NOT NULL,
  `ejob` int(1) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `emp`:
--

--
-- Dumping data for table `emp`
--

INSERT INTO `emp` (`eid`, `efname`, `emname`, `elname`, `eage`, `egender`, `esalary`, `etype`, `edob`, `ejob`, `timestamp`, `deleted`) VALUES
('E1', 'a', 'a', 'a', 22, 'male', 50000, 'Permanent', '2002-06-19', 1, '2023-08-06 20:41:18', 1),
('e383', 'bb', 'bb', 'bb', 22, 'male', 50000, 'fulltime', '2000-08-12', 3, '2023-08-06 20:54:32', 0),
('e686', 'bb', 'bb', 'bb', 22, 'male', 50000, 'fulltime', '2000-08-12', 3, '2023-08-06 20:53:40', 0);

--
-- Triggers `emp`
--
DELIMITER $$
CREATE TRIGGER `generate_conductor_login` BEFORE INSERT ON `emp` FOR EACH ROW BEGIN
  IF NEW.eJob = 3 THEN
    SET @efname = NEW.efname;
    SET @username = CONCAT(LOWER(LEFT(@efname, 1)), FLOOR(RAND() * 8999) + 1000);
    SET @password = SUBSTRING(MD5(RAND()), FLOOR(RAND() * 22) + 1, 8);
    SET @eid = NEW.eid;
    SET @hashed_password = PASSWORD(@password);
    INSERT INTO conductor_login (username, password, eid) VALUES (@username, @hashed_password, @eid);
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `generate_login` AFTER INSERT ON `emp` FOR EACH ROW BEGIN
  IF NEW.eJob = 1 THEN
    SET @efname = NEW.efname;
    SET @username = CONCAT('co', FLOOR(RAND() * 8999) + 1000);
    SET @password = LPAD(FLOOR(RAND() * 99999999), 8, '0');
    SET @eid = NEW.eid;
    SET @hashed_password = PASSWORD(@password);
    INSERT INTO logins (username, password, eid) VALUES (@username, @hashed_password, @eid);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `failure`
--
-- Creation: Jun 23, 2023 at 02:40 PM
-- Last update: Aug 06, 2023 at 03:02 PM
--

CREATE TABLE `failure` (
  `date` date NOT NULL,
  `time` time NOT NULL,
  `busNo` varchar(5) NOT NULL,
  `location` varchar(20) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `round` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `failure`:
--

--
-- Triggers `failure`
--
DELIMITER $$
CREATE TRIGGER `failurebuses` AFTER INSERT ON `failure` FOR EACH ROW BEGIN
  DECLARE next_bus varchar(5);
  SELECT busNo INTO next_bus FROM busdata
  WHERE busNo NOT IN (SELECT busNo FROM schedule)
  AND busNo NOT IN (SELECT busNo FROM failure) AND busNo NOT IN (SELECT busNo from reassignedbus) AND deleted=0
  LIMIT 1;
  IF next_bus IS NOT NULL THEN
    UPDATE schedule SET busNo = next_bus WHERE date = CURRENT_DATE() AND busNo = NEW.busNo;
    INSERT into reassignedbus(oldBus,busNo) values (new.busNo,next_bus);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `katrajfare`
--
-- Creation: Jun 23, 2023 at 02:53 PM
--

CREATE TABLE `katrajfare` (
  `stopno` int(11) NOT NULL,
  `stopname` varchar(30) NOT NULL,
  `fare` int(11) NOT NULL,
  `fare2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `katrajfare`:
--

--
-- Dumping data for table `katrajfare`
--

INSERT INTO `katrajfare` (`stopno`, `stopname`, `fare`, `fare2`) VALUES
(0, 'Bharati Vidyapeeth Gate (Brts)', 5, 20),
(1, 'Padmavati (Brts)', 5, 15),
(2, 'Bhapkar Petrol Pump (Brts)', 10, 15),
(3, 'Swargate', 10, 15),
(4, 'SPCollege', 10, 15),
(5, 'Deccan Corner (To Paud Road)', 15, 10),
(6, 'Garware College', 15, 10),
(7, 'AnandNagar Kothrud', 15, 10),
(8, 'Vanaz Corner', 15, 5),
(10, 'Kothrud Depot', 20, 5);

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--
-- Creation: Apr 27, 2023 at 02:34 PM
-- Last update: Aug 06, 2023 at 03:11 PM
--

CREATE TABLE `logins` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `eid` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `logins`:
--   `eid`
--       `emp` -> `eid`
--

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`id`, `username`, `password`, `eid`) VALUES
(5, 'a7960', '*358962111C9EA45A875F7E8653E8F501ADAE08FE', 'E1');

-- --------------------------------------------------------

--
-- Stand-in structure for view `notdeletedbus`
-- (See below for the actual view)
--
CREATE TABLE `notdeletedbus` (
`busNo` varchar(5)
,`vehicleNo` varchar(10)
,`chasis` varchar(17)
,`bType` varchar(11)
,`bdepot` varchar(10)
,`timestamp` datetime
,`deleted` int(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--
-- Creation: Jun 23, 2023 at 06:53 AM
-- Last update: Aug 06, 2023 at 03:02 PM
--

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `notif_msg` text NOT NULL,
  `notif_time` datetime NOT NULL,
  `notif_repeat` int(11) NOT NULL DEFAULT 1,
  `notif_loop` int(11) NOT NULL DEFAULT 1,
  `publish_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `notif`:
--

-- --------------------------------------------------------

--
-- Table structure for table `reassignedbus`
--
-- Creation: Aug 06, 2023 at 10:26 AM
-- Last update: Aug 06, 2023 at 03:02 PM
--

CREATE TABLE `reassignedbus` (
  `oldBus` varchar(5) NOT NULL,
  `busNo` varchar(5) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `reassignedbus`:
--

-- --------------------------------------------------------

--
-- Table structure for table `routedata`
--
-- Creation: May 06, 2023 at 03:32 AM
-- Last update: Aug 06, 2023 at 03:01 PM
--

CREATE TABLE `routedata` (
  `id` int(11) NOT NULL,
  `rid` varchar(5) NOT NULL,
  `source` varchar(20) NOT NULL,
  `destination` varchar(20) NOT NULL,
  `tripstart` time NOT NULL,
  `tripend` time NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `routedata`:
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `routestops`
-- (See below for the actual view)
--
CREATE TABLE `routestops` (
`rid` varchar(5)
,`source_destination` varchar(43)
,`stops` mediumtext
);

-- --------------------------------------------------------

--
-- Table structure for table `route_stops_data`
--
-- Creation: May 07, 2023 at 09:41 AM
--

CREATE TABLE `route_stops_data` (
  `rid` varchar(5) DEFAULT NULL,
  `source_destination` varchar(43) DEFAULT NULL,
  `stop0` varchar(20) DEFAULT NULL,
  `stop1` varchar(20) DEFAULT NULL,
  `stop2` varchar(20) DEFAULT NULL,
  `stop3` varchar(20) DEFAULT NULL,
  `stop4` varchar(20) DEFAULT NULL,
  `stop5` varchar(20) DEFAULT NULL,
  `stop6` varchar(20) DEFAULT NULL,
  `stop7` varchar(20) DEFAULT NULL,
  `stop8` varchar(20) DEFAULT NULL,
  `stop9` varchar(20) DEFAULT NULL,
  `stop10` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `route_stops_data`:
--

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--
-- Creation: May 06, 2023 at 03:33 AM
-- Last update: Aug 06, 2023 at 03:01 PM
--

CREATE TABLE `schedule` (
  `date` date NOT NULL,
  `busNo` varchar(5) NOT NULL,
  `rid` varchar(5) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `schedule`:
--   `rid`
--       `routedata` -> `rid`
--   `busNo`
--       `busdata` -> `busNo`
--

--
-- Triggers `schedule`
--
DELIMITER $$
CREATE TRIGGER `setticket` AFTER INSERT ON `schedule` FOR EACH ROW BEGIN
    INSERT INTO tickets (date, busNo, amtcollected, nooftickets)
    VALUES (CURDATE(), NEW.busNo, 0, 0);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--
-- Creation: Apr 09, 2023 at 04:42 PM
-- Last update: Aug 06, 2023 at 03:00 PM
--

CREATE TABLE `shifts` (
  `rid` varchar(5) NOT NULL,
  `shiftno` int(2) NOT NULL,
  `shiftstart` time NOT NULL,
  `shiftend` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `shifts`:
--   `rid`
--       `routedata` -> `rid`
--

-- --------------------------------------------------------

--
-- Table structure for table `stops`
--
-- Creation: Apr 03, 2023 at 03:57 PM
-- Last update: Aug 06, 2023 at 03:01 PM
--

CREATE TABLE `stops` (
  `rid` varchar(5) NOT NULL,
  `stopname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `stops`:
--   `rid`
--       `routedata` -> `rid`
--

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--
-- Creation: Jun 21, 2023 at 06:29 AM
-- Last update: Aug 06, 2023 at 03:01 PM
--

CREATE TABLE `tickets` (
  `date` date NOT NULL DEFAULT current_timestamp(),
  `busNo` varchar(5) NOT NULL DEFAULT 'NULL',
  `amtcollected` int(5) NOT NULL,
  `nooftickets` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `tickets`:
--

-- --------------------------------------------------------

--
-- Table structure for table `upperfare`
--
-- Creation: Jun 23, 2023 at 02:54 PM
--

CREATE TABLE `upperfare` (
  `stopno` int(11) NOT NULL,
  `stopname` varchar(30) NOT NULL,
  `fare` int(11) NOT NULL,
  `fare2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `upperfare`:
--

--
-- Dumping data for table `upperfare`
--

INSERT INTO `upperfare` (`stopno`, `stopname`, `fare`, `fare2`) VALUES
(0, 'Vanaz Corner', 5, 20),
(1, 'Anandnagar Kothrud', 5, 15),
(2, 'Garware College', 10, 15),
(3, 'Deccan Corner', 10, 15),
(4, 'SPCollege', 10, 15),
(5, 'Swargate', 15, 10),
(6, 'Bhapkar Petrol Pump (Brts)', 15, 10),
(7, 'Padmavati (Brts)', 15, 10),
(8, 'Bharati Vidyapeeth Gate (Brts)', 15, 5),
(9, 'Katraj Depot', 20, 5);

-- --------------------------------------------------------

--
-- Structure for view `completeschedule` exported as a table
--
DROP TABLE IF EXISTS `completeschedule`;
CREATE TABLE`completeschedule`(
    `date` date NOT NULL,
    `eid` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
    `ejob` int(1) NOT NULL,
    `busNo` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
    `shiftno` int(2) NOT NULL,
    `rid` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `shiftstart` time DEFAULT NULL,
    `shiftend` time DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Structure for view `conductor_view` exported as a table
--
DROP TABLE IF EXISTS `conductor_view`;
CREATE TABLE`conductor_view`(
    `eid` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
    `ename` varchar(47) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    `etype` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
    `ejob` int(1) NOT NULL
);

-- --------------------------------------------------------

--
-- Structure for view `controller_view` exported as a table
--
DROP TABLE IF EXISTS `controller_view`;
CREATE TABLE`controller_view`(
    `eid` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
    `ename` varchar(47) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    `etype` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
    `ejob` int(1) NOT NULL
);

-- --------------------------------------------------------

--
-- Structure for view `deletedbus` exported as a table
--
DROP TABLE IF EXISTS `deletedbus`;
CREATE TABLE`deletedbus`(
    `busNo` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
    `vehicleNo` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
    `chasis` varchar(17) COLLATE utf8mb4_general_ci NOT NULL,
    `bType` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
    `bdepot` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
    `timestamp` datetime NOT NULL DEFAULT 'current_timestamp()',
    `deleted` int(1) NOT NULL DEFAULT '0'
);

-- --------------------------------------------------------

--
-- Structure for view `driver_view` exported as a table
--
DROP TABLE IF EXISTS `driver_view`;
CREATE TABLE`driver_view`(
    `eid` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
    `ename` varchar(47) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    `etype` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
    `ejob` int(1) NOT NULL
);

-- --------------------------------------------------------

--
-- Structure for view `notdeletedbus` exported as a table
--
DROP TABLE IF EXISTS `notdeletedbus`;
CREATE TABLE`notdeletedbus`(
    `busNo` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
    `vehicleNo` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
    `chasis` varchar(17) COLLATE utf8mb4_general_ci NOT NULL,
    `bType` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
    `bdepot` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
    `timestamp` datetime NOT NULL DEFAULT 'current_timestamp()',
    `deleted` int(1) NOT NULL DEFAULT '0'
);

-- --------------------------------------------------------

--
-- Structure for view `routestops` exported as a table
--
DROP TABLE IF EXISTS `routestops`;
CREATE TABLE`routestops`(
    `rid` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
    `source_destination` varchar(43) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    `stops` mediumtext COLLATE utf8mb4_general_ci DEFAULT NULL
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignedemp`
--
ALTER TABLE `assignedemp`
  ADD PRIMARY KEY (`date`,`shiftno`,`ejob`,`eid`) USING BTREE,
  ADD UNIQUE KEY `uniqueschedule` (`date`,`shiftno`,`ejob`,`busNo`) USING BTREE,
  ADD KEY `assignedemp_ibfk_1` (`eid`);

--
-- Indexes for table `busdata`
--
ALTER TABLE `busdata`
  ADD PRIMARY KEY (`busNo`),
  ADD UNIQUE KEY `vehicleNo` (`vehicleNo`),
  ADD UNIQUE KEY `chasis` (`chasis`);

--
-- Indexes for table `conductor_login`
--
ALTER TABLE `conductor_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emobile`
--
ALTER TABLE `emobile`
  ADD PRIMARY KEY (`eid`,`emob`);

--
-- Indexes for table `emp`
--
ALTER TABLE `emp`
  ADD PRIMARY KEY (`eid`),
  ADD UNIQUE KEY `deleted` (`eid`);

--
-- Indexes for table `failure`
--
ALTER TABLE `failure`
  ADD PRIMARY KEY (`date`,`busNo`) USING BTREE;

--
-- Indexes for table `katrajfare`
--
ALTER TABLE `katrajfare`
  ADD PRIMARY KEY (`stopno`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eid` (`eid`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reassignedbus`
--
ALTER TABLE `reassignedbus`
  ADD PRIMARY KEY (`busNo`);

--
-- Indexes for table `routedata`
--
ALTER TABLE `routedata`
  ADD PRIMARY KEY (`rid`),
  ADD UNIQUE KEY `unique` (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`date`,`busNo`),
  ADD KEY `rid` (`rid`),
  ADD KEY `schedule_ibfk_2` (`busNo`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`rid`,`shiftno`);

--
-- Indexes for table `stops`
--
ALTER TABLE `stops`
  ADD PRIMARY KEY (`rid`,`stopname`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`date`,`busNo`) USING BTREE,
  ADD KEY `busNo` (`busNo`);

--
-- Indexes for table `upperfare`
--
ALTER TABLE `upperfare`
  ADD PRIMARY KEY (`stopno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conductor_login`
--
ALTER TABLE `conductor_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notif`
--
ALTER TABLE `notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `routedata`
--
ALTER TABLE `routedata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignedemp`
--
ALTER TABLE `assignedemp`
  ADD CONSTRAINT `assignedemp_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `emp` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `logins_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `emp` (`eid`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `routedata` (`rid`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`busNo`) REFERENCES `busdata` (`busNo`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `routedata` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stops`
--
ALTER TABLE `stops`
  ADD CONSTRAINT `stops_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `routedata` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Metadata
--
USE `phpmyadmin`;

--
-- Metadata for table assignedemp
--

--
-- Metadata for table busdata
--

--
-- Metadata for table completeschedule
--

--
-- Metadata for table conductor_login
--

--
-- Metadata for table conductor_view
--

--
-- Metadata for table controller_view
--

--
-- Metadata for table deletedbus
--

--
-- Metadata for table driver_view
--

--
-- Metadata for table emobile
--

--
-- Metadata for table emp
--

--
-- Metadata for table failure
--

--
-- Metadata for table katrajfare
--

--
-- Metadata for table logins
--

--
-- Metadata for table notdeletedbus
--

--
-- Metadata for table notif
--

--
-- Metadata for table reassignedbus
--

--
-- Metadata for table routedata
--

--
-- Metadata for table routestops
--

--
-- Metadata for table route_stops_data
--

--
-- Metadata for table schedule
--

--
-- Metadata for table shifts
--

--
-- Metadata for table stops
--

--
-- Metadata for table tickets
--

--
-- Metadata for table upperfare
--

--
-- Metadata for database bss
--
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
