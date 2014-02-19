/*
SQLyog Ultimate v9.20 
MySQL - 5.5.27 : Database - db_asset_basarnas
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_asset_basarnas` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_asset_basarnas`;

/*Table structure for table `view_asset_perlengkapan` */

DROP TABLE IF EXISTS `view_asset_perlengkapan`;

/*!50001 DROP VIEW IF EXISTS `view_asset_perlengkapan` */;
/*!50001 DROP TABLE IF EXISTS `view_asset_perlengkapan` */;

/*!50001 CREATE TABLE  `view_asset_perlengkapan`(
 `tipe` varchar(12) ,
 `id_part` varchar(11) ,
 `id_sub_part` varchar(11) ,
 `id` int(11) unsigned ,
 `alert` int(11) ,
 `id_pengadaan` int(11) ,
 `warehouse_id` int(11) unsigned ,
 `ruang_id` int(11) unsigned ,
 `rak_id` int(11) unsigned ,
 `serial_number` varchar(50) ,
 `part_number` varchar(50) ,
 `kd_brg` varchar(30) ,
 `kd_lokasi` varchar(60) ,
 `no_aset` decimal(11,0) ,
 `kondisi` varchar(20) ,
 `kuantitas` int(11) ,
 `dari` varchar(120) ,
 `tanggal_perolehan` date ,
 `no_dana` varchar(90) ,
 `image_url` varchar(255) ,
 `document_url` varchar(255) ,
 `kode_unor` int(11) ,
 `installation_date` date ,
 `installation_ac_tsn` decimal(18,2) ,
 `installation_comp_tsn` decimal(18,2) ,
 `task` varchar(5) ,
 `is_oc` int(11) ,
 `is_engine` int(11) ,
 `umur_maks` decimal(18,2) ,
 `cycle` decimal(18,2) ,
 `cycle_maks` decimal(18,2) ,
 `is_cycle` int(11) ,
 `eng_tso` varchar(100) ,
 `eng_type` varchar(100) ,
 `nama_klasifikasi_aset` varchar(100) ,
 `kd_klasifikasi_aset` varchar(10) ,
 `kd_lvl1` varchar(10) ,
 `kd_lvl2` varchar(10) ,
 `kd_lvl3` varchar(10) ,
 `nama_warehouse` varchar(60) ,
 `nama_ruang` varchar(60) ,
 `nama_rak` varchar(60) ,
 `no_induk_asset` varchar(255) ,
 `umur` decimal(18,2) ,
 `nama_part` varchar(255) ,
 `jenis_asset` varchar(20) ,
 `nama_kelompok` varchar(100) ,
 `nama_unker` varchar(300) ,
 `nama_unor` varchar(120) 
)*/;

/*View structure for view view_asset_perlengkapan */

/*!50001 DROP TABLE IF EXISTS `view_asset_perlengkapan` */;
/*!50001 DROP VIEW IF EXISTS `view_asset_perlengkapan` */;

/*!50001 CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_asset_perlengkapan` AS select 'Part' AS `tipe`,'-' AS `id_part`,'-' AS `id_sub_part`,`t`.`id` AS `id`,`t`.`alert` AS `alert`,`t`.`id_pengadaan` AS `id_pengadaan`,`t`.`warehouse_id` AS `warehouse_id`,`t`.`ruang_id` AS `ruang_id`,`t`.`rak_id` AS `rak_id`,`t`.`serial_number` AS `serial_number`,`t`.`part_number` AS `part_number`,`t`.`kd_brg` AS `kd_brg`,`t`.`kd_lokasi` AS `kd_lokasi`,`t`.`no_aset` AS `no_aset`,`t`.`kondisi` AS `kondisi`,`t`.`kuantitas` AS `kuantitas`,`t`.`dari` AS `dari`,`t`.`tanggal_perolehan` AS `tanggal_perolehan`,`t`.`no_dana` AS `no_dana`,`t`.`image_url` AS `image_url`,`t`.`document_url` AS `document_url`,`t`.`kode_unor` AS `kode_unor`,`t`.`installation_date` AS `installation_date`,`t`.`installation_ac_tsn` AS `installation_ac_tsn`,`t`.`installation_comp_tsn` AS `installation_comp_tsn`,`t`.`task` AS `task`,`t`.`is_oc` AS `is_oc`,`t`.`is_engine` AS `is_engine`,`t`.`umur_maks` AS `umur_maks`,`t`.`cycle` AS `cycle`,`t`.`cycle_maks` AS `cycle_maks`,`t`.`is_cycle` AS `is_cycle`,`t`.`eng_tso` AS `eng_tso`,`t`.`eng_type` AS `eng_type`,`f`.`nama` AS `nama_klasifikasi_aset`,`t`.`kd_klasifikasi_aset` AS `kd_klasifikasi_aset`,`f`.`kd_lvl1` AS `kd_lvl1`,`f`.`kd_lvl2` AS `kd_lvl2`,`f`.`kd_lvl3` AS `kd_lvl3`,`g`.`nama` AS `nama_warehouse`,`h`.`nama` AS `nama_ruang`,`i`.`nama` AS `nama_rak`,`z`.`merk` AS `no_induk_asset`,`t`.`umur` AS `umur`,`j`.`nama` AS `nama_part`,`j`.`jenis_asset` AS `jenis_asset`,`k`.`nama_kelompok` AS `nama_kelompok`,`c`.`ur_upb` AS `nama_unker`,`d`.`nama_unor` AS `nama_unor` from (((((((((`asset_perlengkapan` `t` left join `ref_unker` `c` on((`t`.`kd_lokasi` = `c`.`kdlok`))) left join `ref_warehouse` `g` on((`t`.`warehouse_id` = `g`.`id`))) left join `ref_warehouseruang` `h` on((`t`.`ruang_id` = `h`.`id`))) left join `ref_warehouserak` `i` on((`t`.`rak_id` = `i`.`id`))) left join `ref_klasifikasiaset_lvl3` `f` on((`t`.`kd_klasifikasi_aset` = `f`.`kd_klasifikasi_aset`))) left join `ref_perlengkapan` `j` on((`t`.`part_number` = `j`.`part_number`))) left join `ref_kelompok_part` `k` on((`j`.`id_kelompok_part` = `k`.`id`))) left join `ref_unor` `d` on((`t`.`kode_unor` = `d`.`kode_unor`))) left join `asset_angkutan` `z` on((`t`.`no_induk_asset` = concat(`z`.`kd_brg`,`z`.`kd_lokasi`,`z`.`no_aset`)))) union all select 'Sub Part' AS `tipe`,`t`.`id_part` AS `id_part`,'-' AS `id_sub_part`,`t`.`id` AS `id`,`t`.`alert` AS `alert`,`t`.`id_pengadaan` AS `id_pengadaan`,`t`.`warehouse_id` AS `warehouse_id`,`t`.`ruang_id` AS `ruang_id`,`t`.`rak_id` AS `rak_id`,`t`.`serial_number` AS `serial_number`,`t`.`part_number` AS `part_number`,`t`.`kd_brg` AS `kd_brg`,`t`.`kd_lokasi` AS `kd_lokasi`,`t`.`no_aset` AS `no_aset`,`t`.`kondisi` AS `kondisi`,`t`.`kuantitas` AS `kuantitas`,`t`.`dari` AS `dari`,`t`.`tanggal_perolehan` AS `tanggal_perolehan`,`t`.`no_dana` AS `no_dana`,`t`.`image_url` AS `image_url`,`t`.`document_url` AS `document_url`,`t`.`kode_unor` AS `kode_unor`,`t`.`installation_date` AS `installation_date`,`t`.`installation_ac_tsn` AS `installation_ac_tsn`,`t`.`installation_comp_tsn` AS `installation_comp_tsn`,`t`.`task` AS `task`,`t`.`is_oc` AS `is_oc`,`t`.`is_engine` AS `is_engine`,`t`.`umur_maks` AS `umur_maks`,`t`.`cycle` AS `cycle`,`t`.`cycle_maks` AS `cycle_maks`,`t`.`is_cycle` AS `is_cycle`,'-' AS `eng_tso`,'-' AS `eng_type`,`f`.`nama` AS `nama_klasifikasi_aset`,`t`.`kd_klasifikasi_aset` AS `kd_klasifikasi_aset`,`f`.`kd_lvl1` AS `kd_lvl1`,`f`.`kd_lvl2` AS `kd_lvl2`,`f`.`kd_lvl3` AS `kd_lvl3`,`g`.`nama` AS `nama_warehouse`,`h`.`nama` AS `nama_ruang`,`i`.`nama` AS `nama_rak`,`j`.`nama` AS `no_induk_asset`,`t`.`umur` AS `umur`,`t`.`nama` AS `nama_part`,`t`.`jenis_asset` AS `jenis_asset`,`k`.`nama_kelompok` AS `nama_kelompok`,`c`.`ur_upb` AS `nama_unker`,`d`.`nama_unor` AS `nama_unor` from (((((((((`view_asset_perlengkapan_sub_part` `t` left join `ref_unker` `c` on((`t`.`kd_lokasi` = `c`.`kdlok`))) left join `ref_warehouse` `g` on((`t`.`warehouse_id` = `g`.`id`))) left join `ref_warehouseruang` `h` on((`t`.`ruang_id` = `h`.`id`))) left join `ref_warehouserak` `i` on((`t`.`rak_id` = `i`.`id`))) left join `ref_klasifikasiaset_lvl3` `f` on((`t`.`kd_klasifikasi_aset` = `f`.`kd_klasifikasi_aset`))) left join `asset_perlengkapan` `x` on((`t`.`id_part` = `x`.`id`))) left join `ref_perlengkapan` `j` on((`x`.`part_number` = `j`.`part_number`))) left join `ref_kelompok_part` `k` on((`j`.`id_kelompok_part` = `k`.`id`))) left join `ref_unor` `d` on((`t`.`kode_unor` = `d`.`kode_unor`))) union all select 'Sub Sub Part' AS `tipe`,'-' AS `id_part`,`t`.`id_sub_part` AS `id_sub_part`,`t`.`id` AS `id`,`t`.`alert` AS `alert`,`t`.`id_pengadaan` AS `id_pengadaan`,`t`.`warehouse_id` AS `warehouse_id`,`t`.`ruang_id` AS `ruang_id`,`t`.`rak_id` AS `rak_id`,`t`.`serial_number` AS `serial_number`,`t`.`part_number` AS `part_number`,`t`.`kd_brg` AS `kd_brg`,`t`.`kd_lokasi` AS `kd_lokasi`,`t`.`no_aset` AS `no_aset`,`t`.`kondisi` AS `kondisi`,`t`.`kuantitas` AS `kuantitas`,`t`.`dari` AS `dari`,`t`.`tanggal_perolehan` AS `tanggal_perolehan`,`t`.`no_dana` AS `no_dana`,`t`.`image_url` AS `image_url`,`t`.`document_url` AS `document_url`,`t`.`kode_unor` AS `kode_unor`,`t`.`installation_date` AS `installation_date`,`t`.`installation_ac_tsn` AS `installation_ac_tsn`,`t`.`installation_comp_tsn` AS `installation_comp_tsn`,`t`.`task` AS `task`,`t`.`is_oc` AS `is_oc`,`t`.`is_engine` AS `is_engine`,`t`.`umur_maks` AS `umur_maks`,`t`.`cycle` AS `cycle`,`t`.`cycle_maks` AS `cycle_maks`,`t`.`is_cycle` AS `is_cycle`,'-' AS `eng_tso`,'-' AS `eng_type`,`f`.`nama` AS `nama_klasifikasi_aset`,`t`.`kd_klasifikasi_aset` AS `kd_klasifikasi_aset`,`f`.`kd_lvl1` AS `kd_lvl1`,`f`.`kd_lvl2` AS `kd_lvl2`,`f`.`kd_lvl3` AS `kd_lvl3`,`g`.`nama` AS `nama_warehouse`,`h`.`nama` AS `nama_ruang`,`i`.`nama` AS `nama_rak`,`y`.`nama` AS `no_induk_asset`,`t`.`umur` AS `umur`,`t`.`nama` AS `nama_part`,`t`.`jenis_asset` AS `jenis_asset`,`k`.`nama_kelompok` AS `nama_kelompok`,`c`.`ur_upb` AS `nama_unker`,`d`.`nama_unor` AS `nama_unor` from ((((((((((`view_asset_perlengkapan_sub_sub_part` `t` left join `ref_unker` `c` on((`t`.`kd_lokasi` = `c`.`kdlok`))) left join `ref_warehouse` `g` on((`t`.`warehouse_id` = `g`.`id`))) left join `ref_warehouseruang` `h` on((`t`.`ruang_id` = `h`.`id`))) left join `ref_warehouserak` `i` on((`t`.`rak_id` = `i`.`id`))) left join `ref_klasifikasiaset_lvl3` `f` on((`t`.`kd_klasifikasi_aset` = `f`.`kd_klasifikasi_aset`))) left join `asset_perlengkapan_sub_part` `y` on((`t`.`id_sub_part` = `y`.`id`))) left join `asset_perlengkapan` `x` on((`y`.`id_part` = `x`.`id`))) left join `ref_perlengkapan` `j` on((`x`.`part_number` = `j`.`part_number`))) left join `ref_kelompok_part` `k` on((`j`.`id_kelompok_part` = `k`.`id`))) left join `ref_unor` `d` on((`t`.`kode_unor` = `d`.`kode_unor`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
