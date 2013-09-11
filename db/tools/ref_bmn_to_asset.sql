-- `dbbmn`.`t_gol` -> `db_asset_basarnas`.`ref_golongan`, identik
DROP TABLE IF EXISTS `db_asset_basarnas`.`ref_golongan`;
CREATE TABLE `db_asset_basarnas`.`ref_golongan` (
  `kd_gol` VARCHAR(3) NOT NULL,
  `ur_gol` VARCHAR(90) NOT NULL,
  PRIMARY KEY (`kd_gol`)
) ENGINE=INNODB;
INSERT INTO `db_asset_basarnas`.`ref_golongan`
SELECT * FROM `dbbmn`.`t_gol`;

-- `dbbmn`.`t_bid` -> `db_asset_basarnas`.`ref_bidang`, identik
DROP TABLE IF EXISTS `db_asset_basarnas`.`ref_bidang`;
CREATE TABLE `db_asset_basarnas`.`ref_bidang` (
  `kd_gol` VARCHAR(3) NOT NULL,
  `kd_bid` VARCHAR(2) NOT NULL,
  `ur_bid` VARCHAR(195) NOT NULL,
  `kd_bidbrg` VARCHAR(9) NOT NULL,
  PRIMARY KEY (`kd_gol`,`kd_bid`),
  UNIQUE KEY `U_kd_bidbrg` (`kd_bidbrg`)
) ENGINE=INNODB;
INSERT INTO `db_asset_basarnas`.`ref_bidang`
SELECT * FROM `dbbmn`.`t_bid`;

-- `dbbmn`.`t_kel` -> `db_asset_basarnas`.`ref_kel`, identik
DROP TABLE IF EXISTS `db_asset_basarnas`.`ref_kel`;
CREATE TABLE `db_asset_basarnas`.`ref_kel` (
  `kd_gol` VARCHAR(3) NOT NULL,
  `kd_bid` VARCHAR(2) NOT NULL,
  `kd_kel` VARCHAR(2) NOT NULL,
  `ur_kel` VARCHAR(65) NOT NULL,
  `kd_kelbrg` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`kd_gol`,`kd_bid`,`kd_kel`),
  UNIQUE KEY `U_kd_kelbrg` (`kd_kelbrg`)
) ENGINE=INNODB;
INSERT INTO `db_asset_basarnas`.`ref_kel`
SELECT * FROM `dbbmn`.`t_kel`;

-- `dbbmn`.`t_skel` -> `db_asset_basarnas`.`ref_subkel`, identik
DROP TABLE IF EXISTS `db_asset_basarnas`.`ref_subkel`;
CREATE TABLE `db_asset_basarnas`.`ref_subkel` (
  `kd_gol` VARCHAR(3) NOT NULL,
  `kd_bid` VARCHAR(2) NOT NULL,
  `kd_kel` VARCHAR(2) NOT NULL,
  `kd_skel` VARCHAR(2) NOT NULL,
  `ur_skel` VARCHAR(65) NOT NULL,
  `kd_skelbrg` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`kd_gol`,`kd_bid`,`kd_kel`,`kd_skel`),
  UNIQUE KEY `U_kd_skelbrg` (`kd_skelbrg`)
) ENGINE=INNODB;  
INSERT INTO `db_asset_basarnas`.`ref_subkel`
SELECT * FROM `dbbmn`.`t_skel`;

-- `dbbmn`.`t_sskel` -> `db_asset_basarnas`.`ref_subsubkel`, identik
DROP TABLE IF EXISTS `db_asset_basarnas`.`ref_subsubkel`;
CREATE TABLE `db_asset_basarnas`.`ref_subsubkel` (
  `kd_gol` VARCHAR(3) NOT NULL,
  `kd_bid` VARCHAR(2) NOT NULL,
  `kd_kel` VARCHAR(2) NOT NULL,
  `kd_skel` VARCHAR(2) NOT NULL,
  `kd_sskel` VARCHAR(3) NOT NULL,
  `satuan` VARCHAR(10) DEFAULT NULL,
  `ur_sskel` VARCHAR(65) NOT NULL,
  `kd_perk` VARCHAR(6) DEFAULT NULL,
  `kd_brg` VARCHAR(10) NOT NULL,
  `dasar` VARCHAR(30) DEFAULT NULL,
  `kdperkbr` VARCHAR(6) DEFAULT NULL,
  PRIMARY KEY (`kd_gol`,`kd_bid`,`kd_kel`,`kd_skel`,`kd_sskel`),
  UNIQUE KEY `U_kd_brg` (`kd_brg`)
) ENGINE=INNODB;
INSERT INTO `db_asset_basarnas`.`ref_subsubkel`
SELECT * FROM `dbbmn`.`t_sskel`;

-- `dbbmn`.`t_croleh` -> `db_asset_basarnas`.`ref_trans`, identik
DROP TABLE IF EXISTS `db_asset_basarnas`.`ref_trans`;
CREATE TABLE `db_asset_basarnas`.`ref_trans` (
  `jns_trn` VARCHAR(3) NOT NULL,
  `ur_trn` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`jns_trn`)
) ENGINE=INNODB;
INSERT INTO `db_asset_basarnas`.`ref_trans`
SELECT * FROM `dbbmn`.`t_croleh`;