-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2013 at 09:21 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_simpeg_basarnas`
--

-- --------------------------------------------------------

--
-- Structure for view `view_noasetgenerator`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_noasetgenerator` AS select `asset_alatbesar`.`kd_lokasi` AS `kd_lokasi`,`asset_alatbesar`.`kd_brg` AS `kd_brg`,`asset_alatbesar`.`no_aset` AS `no_aset` from `asset_alatbesar` union select `asset_angkutan`.`kd_lokasi` AS `kd_lokasi`,`asset_angkutan`.`kd_brg` AS `kd_brg`,`asset_angkutan`.`no_aset` AS `no_aset` from `asset_angkutan` union select `asset_bangunan`.`kd_lokasi` AS `kd_lokasi`,`asset_bangunan`.`kd_brg` AS `kd_brg`,`asset_bangunan`.`no_aset` AS `no_aset` from `asset_bangunan` union select `asset_perairan`.`kd_lokasi` AS `kd_lokasi`,`asset_perairan`.`kd_brg` AS `kd_brg`,`asset_perairan`.`no_aset` AS `no_aset` from `asset_perairan` union select `asset_senjata`.`kd_lokasi` AS `kd_lokasi`,`asset_senjata`.`kd_brg` AS `kd_brg`,`asset_senjata`.`no_aset` AS `no_aset` from `asset_senjata` union select `asset_tanah`.`kd_lokasi` AS `kd_lokasi`,`asset_tanah`.`kd_brg` AS `kd_brg`,`asset_tanah`.`no_aset` AS `no_aset` from `asset_tanah` union select `asset_dil`.`kd_lokasi` AS `kd_lokasi`,`asset_dil`.`kd_brg` AS `kd_brg`,`asset_dil`.`no_aset` AS `no_aset` from `asset_dil` union select `asset_perlengkapan`.`kd_lokasi` AS `kd_lokasi`,`asset_perlengkapan`.`kd_brg` AS `kd_brg`,`asset_perlengkapan`.`no_aset` AS `no_aset` from `asset_perlengkapan` union select `asset_ruang`.`kd_lokasi` AS `kd_lokasi`,`asset_ruang`.`kd_brg` AS `kd_brg`,`asset_ruang`.`no_aset` AS `no_aset` from `asset_ruang`;

--
-- VIEW  `view_noasetgenerator`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
