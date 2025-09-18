-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2023 at 04:36 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sisp`
--

-- --------------------------------------------------------

--
-- Table structure for table `frm_approval`
--

CREATE TABLE `frm_approval` (
  `UnitCode` varchar(4) NOT NULL,
  `FormTypes` varchar(40) NOT NULL,
  `OnePerson` varchar(40) NOT NULL,
  `TwoPerson` varchar(40) NOT NULL,
  `ThreePerson` varchar(40) NOT NULL,
  `FourPerson` varchar(40) NOT NULL,
  `OnePost` varchar(40) NOT NULL,
  `TwoPost` varchar(40) NOT NULL,
  `ThreePost` varchar(40) NOT NULL,
  `FourPost` varchar(40) NOT NULL,
  `CreatedOn` datetime NOT NULL,
  `CreatedBy` varchar(10) NOT NULL,
  `ChangedOn` datetime NOT NULL,
  `ChangedBy` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `frm_approval`
--

INSERT INTO `frm_approval` (`UnitCode`, `FormTypes`, `OnePerson`, `TwoPerson`, `ThreePerson`, `FourPerson`, `OnePost`, `TwoPost`, `ThreePost`, `FourPost`, `CreatedOn`, `CreatedBy`, `ChangedOn`, `ChangedBy`) VALUES
('S001', 'preparehoper', 'Melviya', 'T Maya H', 'Ernawati', 'Wahyu Widayani', 'Pengawas Produksi', 'Ka Unit Produksi', 'Man. Pengawasan Mutu', 'Man. Pemastian Mutu', '2023-05-29 03:38:42', 'SM000', '2023-05-29 03:38:42', ''),
('S001', 'preparepillow', 'Melviya', 'T Maya H', 'Ernawati', 'Wahyu Widayani', 'Pengawas Produksi', 'Ka Unit Produksi', 'Man. Pengawasan Mutu', 'Man. Pemastian Mutu', '2023-05-29 03:38:42', 'SM000', '2023-05-29 03:38:42', ''),
('S001', 'preparetopack', 'Melviya', 'T Maya H', 'Ernawati', 'Wahyu Widayani', 'Pengawas Produksi', 'Ka Unit Produksi', 'Man. Pengawasan Mutu', 'Man. Pemastian Mutu', '2023-05-29 03:38:42', 'SM000', '2023-05-29 03:38:42', ''),
('S001', 'proseshoper', 'Melviya', 'T Maya H', 'Ernawati', 'Wahyu Widayani', 'Pengawas Produksi', 'Ka Unit Produksi', 'Man. Pengawasan Mutu', 'Man. Pemastian Mutu', '2023-05-29 03:38:42', 'SM000', '2023-05-29 03:38:42', ''),
('S001', 'prosestopack', 'Melviya', 'T Maya H', 'Ernawati', 'Wahyu Widayani', 'Pengawas Produksi', 'Ka Unit Produksi', 'Man. Pengawasan Mutu', 'Man. Pemastian Mutu', '2023-05-29 03:38:42', 'SM000', '2023-05-29 03:38:42', ''),
('S001', 'rekontopack', 'Melviya', 'T Maya H', 'Ernawati', 'Wahyu Widayani', 'Pengawas Produksi', 'Ka Unit Produksi', 'Man. Pengawasan Mutu', 'Man. Pemastian Mutu', '2023-05-29 03:38:42', 'SM000', '2023-05-29 03:38:42', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `frm_approval`
--
ALTER TABLE `frm_approval`
  ADD PRIMARY KEY (`UnitCode`,`FormTypes`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
