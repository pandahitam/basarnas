DELIMITER $$

USE `db_asset_basarnas`$$

DROP VIEW IF EXISTS `view_mutasi`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_mutasi` AS 
SELECT
  ''                AS `ur_baru`,
  MIN(`u`.`no_aset`) AS `no_awal`,
  MAX(`u`.`no_aset`) AS `no_akhir`,
  `c`.`ur_trn`      AS `jenis_transaksi`,
  `u`.`thn_ang`     AS `thn_ang`,
  `u`.`periode`     AS `periode`,
  `u`.`kd_lokasi`   AS `kd_lokasi`,
  `u`.`no_sppa`     AS `no_sppa`,
  `u`.`kd_brg`      AS `kd_brg`,
  `u`.`no_aset`     AS `no_aset`,
  `u`.`tgl_perlh`   AS `tgl_perlh`,
  `u`.`tercatat`    AS `tercatat`,
  `u`.`kondisi`     AS `kondisi`,
  `u`.`tgl_buku`    AS `tgl_buku`,
  `u`.`jns_trn`     AS `jns_trn`,
  `u`.`dsr_hrg`     AS `dsr_hrg`,
  `u`.`kd_data`     AS `kd_data`,
  `u`.`flag_sap`    AS `flag_sap`,
  `u`.`kuantitas`   AS `kuantitas`,
  `u`.`rph_sat`     AS `rph_sat`,
  `u`.`rph_aset`    AS `rph_aset`,
  `u`.`flag_kor`    AS `flag_kor`,
  `u`.`keterangan`  AS `keterangan`,
  `u`.`merk_type`   AS `merk_type`,
  `u`.`asal_perlh`  AS `asal_perlh`,
  `u`.`no_bukti`    AS `no_bukti`,
  `u`.`no_dsr_mts`  AS `no_dsr_mts`,
  `u`.`tgl_dsr_mts` AS `tgl_dsr_mts`,
  `u`.`flag_ttp`    AS `flag_ttp`,
  `u`.`flag_krm`    AS `flag_krm`,
  `u`.`kdblu`       AS `kdblu`,
  `u`.`setatus`     AS `setatus`,
  `u`.`noreg`       AS `noreg`,
  `u`.`kdbapel`     AS `kdbapel`,
  `u`.`kdkpknl`     AS `kdkpknl`,
  `u`.`umeko`       AS `umeko`,
  `u`.`rph_res`     AS `rph_res`,
  `u`.`kdkppn`      AS `kdkppn`
FROM (`t_masteru` `u`
   LEFT JOIN `t_croleh` `c`
     ON ((`u`.`jns_trn` = `c`.`jns_trn`)))
GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
HAVING (`u`.`jns_trn` IN('102','302','506','507','392'))$$

DELIMITER ;