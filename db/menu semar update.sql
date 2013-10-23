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

/*Table structure for table `tuser_semar_menu` */

DROP TABLE IF EXISTS `tuser_semar_menu`;

CREATE TABLE `tuser_semar_menu` (
  `idmenu` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_idmenu` bigint(20) NOT NULL DEFAULT '0',
  `general_text` varchar(50) NOT NULL,
  `general_iconclass` varchar(50) NOT NULL,
  `general_idbutton` varchar(50) NOT NULL,
  `general_idnewtab_popup` varchar(50) NOT NULL,
  `general_url` varchar(50) NOT NULL,
  `general_type` varchar(50) NOT NULL,
  `general_bottombreak` int(11) NOT NULL DEFAULT '0',
  `general_status` varchar(50) NOT NULL,
  `general_variableprefix` varchar(50) NOT NULL,
  `general_ismenu` int(10) NOT NULL DEFAULT '0',
  `process_view` int(11) NOT NULL DEFAULT '0',
  `process_tambah` int(11) NOT NULL DEFAULT '0',
  `process_ubah` int(11) NOT NULL DEFAULT '0',
  `process_hapus` int(11) NOT NULL DEFAULT '0',
  `process_proses` int(11) NOT NULL DEFAULT '0',
  `process_cetak` int(11) NOT NULL DEFAULT '0',
  `process_cetaksk` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Data for the table `tuser_semar_menu` */

insert  into `tuser_semar_menu`(`idmenu`,`parent_idmenu`,`general_text`,`general_iconclass`,`general_idbutton`,`general_idnewtab_popup`,`general_url`,`general_type`,`general_bottombreak`,`general_status`,`general_variableprefix`,`general_ismenu`,`process_view`,`process_tambah`,`process_ubah`,`process_hapus`,`process_proses`,`process_cetak`,`process_cetaksk`) values (1,0,'UTAMA','icon-menu_utama','m_utama','','','MainMenu',0,'Active','',1,1,1,1,1,1,1,1),(2,1,'Pengguna Login','icon-user','m_pengguna_login','pengguna_login','pengguna_login','Page',0,'Active','pl',1,1,1,1,1,1,1,1),(3,1,'Referensi','icon-gears','m_referensi','master_data','master_data','TabPage',0,'Active','referensi',1,1,1,1,1,1,1,1),(4,1,'Log Pengguna','icon-menu_log_pengguna','m_log','logs_user','utility_simpeg/logs_user','TabPage',0,'Active','log',1,1,1,1,1,1,1,1),(5,1,'Database Tools','icon-menu_db_tools','m_db_tool','db_tool','utility_simpeg/database_tools','TabPage',0,'Active','db_tool',1,1,1,1,1,1,1,1),(6,0,'PENGELOLAAN ASSET','icon-menu_layanan','m_pengelolaan_asset','','','MainMenu',0,'Active','',1,1,1,1,1,1,1,1),(7,6,'Inventaris Asset','icon-menu_impasing','m_inasset','pengelolaan_asset','pengelolaan_asset','TabPage',0,'Active','inasset',1,1,1,1,1,1,1,1),(8,6,'Perencanaan','icon-menu_impasing','m_perencanaan','perencanaan_asset','perencanaan','TabPage',0,'Active','perencanaan',1,1,1,1,1,1,1,1),(9,6,'Pengadaan','icon-menu_impasing','m_pengadaan','pengadaan_asset','pengadaan','TabPage',0,'Active','pengadaan',1,1,1,1,1,1,1,1),(10,6,'Pemeliharaan','icon-menu_impasing','m_pemeliharaan','pemeliharaan','#','MainMenu',0,'Active','pemeliharaan',1,1,1,1,1,1,1,1),(11,10,'Pemeliharaan Umum','icon-menu_impasing','m_pemeliharaan_umum','pemeliharaan_umum','#','MainMenu',0,'Active','pemeliharaan_umum',1,1,1,1,1,1,1,1),(12,11,'Pemeliharaan Kendaraan Darat','icon-menu_impasing','m_pemeliharaan_umum_kendaraan_darat','pemeliharaan_asset_kendaraan_darat','pemeliharaan_darat','TabPage',0,'Active','pemeliharaan_umum_kendaraan_darat',1,1,1,1,1,1,1,1),(13,11,'Pemeliharaan Kendaraan Udara','icon-menu_impasing','m_pemeliharaan_umum_kendaraan_udara','pemeliharaan_asset_kendaraan_udara','pemeliharaan_udara','TabPage',0,'Active','pemeliharaan_umum_kendaraan_udara',1,1,1,1,1,1,1,1),(14,11,'Pemeliharaan Kendaraan Laut','icon-menu_impasing','m_pemeliharaan_umum_kendaraan_laut','pemeliharaan_asset_kendaraan_laut','pemeliharaan_laut','TabPage',0,'Active','pemeliharaan_umum_kendaraan_laut',1,1,1,1,1,1,1,1),(15,11,'Pemeliharaan Peralatan Lainnya','icon-menu_impasing','m_pemeliharaan_umum_peralatan_lainnya','pemeliharaan_asset','pemeliharaan','TabPage',0,'Active','pemeliharaan_umum_peralatan_lainnya',1,1,1,1,1,1,1,1),(16,10,'Pemeliharaan Bangunan','icon-menu_impasing','m_pemeliharaan_bangunan','pemeliharaan_asset_bangunan','pemeliharaan_bangunan','TabPage',0,'Active','pemeliharaan_bangunan',1,1,1,1,1,1,1,1),(17,6,'Pendayagunaan','icon-menu_impasing','m_pendayagunaan','pendayagunaan_asset','pendayagunaan','TabPage',0,'Active','pendayagunaan_asset',1,1,1,1,1,1,1,1),(18,6,'Mutasi','icon-menu_impasing','m_mutasi','mutasi_asset','mutasi','TabPage',0,'Active','mutasi_asset',1,1,1,1,1,1,1,1),(19,6,'Penghapusan','icon-menu_impasing','m_penghapusan','penghapusan_asset','penghapusan','TabPage',0,'Active','penghapusan_asset',1,1,1,1,1,1,1,1),(20,6,'Peraturan','icon-menu_impasing','m_peraturan','peraturan','peraturan','TabPage',0,'Active','peraturan',1,1,1,1,1,1,1,1),(21,6,'Pengelolaan','icon-menu_impasing','m_pengelolaan','pengelolaan','pengelolaan','TabPage',0,'Active','pengelolaan',1,1,1,1,1,1,1,1),(22,6,'Inventory','icon-menu_impasing','m_inventory','inventory','#','MainMenu',0,'Active','inventory',1,1,1,1,1,1,1,1),(23,22,'Penerimaan/Pemeriksaan','icon-menu_impasing','m_inventory_penerimaan_pemeriksaan','inventory_penerimaan_pemeriksaan_panel','inventory_penerimaan_pemeriksaan','TabPage',0,'Active','inventory_penerimaan_pemeriksaan',1,1,1,1,1,1,1,1),(25,22,'Penyimpanan','icon-menu_impasing','m_inventory_penyimpanan','inventory_penyimpanan_panel','inventory_penyimpanan','TabPage',0,'Active','inventory_penyimpanan',1,1,1,1,1,1,1,1),(26,22,'Pengeluaran','icon-menu_impasing','m_inventory_pengeluaran','inventory_pengeluaran_panel','inventory_pengeluaran','TabPage',0,'Active','inventory_pengeluaran',1,1,1,1,1,1,1,1),(27,0,'MAP','icon-map1','m_global_map','map_asset','global_map','TabPage',0,'Active','map_asset',1,1,1,1,1,1,1,1),(28,0,'LAPORAN','icon-menu_laporan','m_laporan','','','MainMenu',0,'Active','',1,1,1,1,1,1,1,1),(29,28,'Aset/Unit Kerja','icon-menu_impasing','m_laporan_aset_unker','laporan_aset_unitkerja_panel','laporan_aset_unitkerja','TabPage',0,'Active','laporan_aset_unitkerja',1,1,1,1,1,1,1,1),(30,28,'Aset/ Kategori Barang','icon-menu_impasing','m_laporan_aset_kategoribarang','laporan_aset_kategoribarang_panel','laporan_aset_kategoribarang','TabPage',0,'Active','laporan_aset_kategoribarang',1,1,1,1,1,1,1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
