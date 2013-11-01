<?php
class Penghapusan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
                $this->table = 'view_penghapusan';
                $this->countTable = 'view_penghapusan';
                /*$this->selectColumn = "select ur_baru, no_awal, no_akhir, jenis_transaksi, 
                        thn_ang,periode,kd_lokasi,no_sppa,kd_brg,no_aset,
                        tgl_perlh,tercatat,kondisi,tgl_buku,jns_trn,dsr_hrg,kd_data,flag_sap,kuantitas,
                        rph_sat,rph_aset,flag_kor,keterangan,merk_type,asal_perlh,no_bukti,no_dsr_mts,
                        tgl_dsr_mts,flag_ttp,flag_krm,kdblu,setatus,noreg,kdbapel,kdkpknl,umeko,rph_res,kdkppn";*/
//		$this->extTable = 'pemeliharaan';
//                $this->viewTable = 'view_pemeliharaan';
	}
	
	function get_AllData($start=null, $limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){
            $countQuery = "";
            if($start != null && $limit != null)
            {
//		$query = "
//                        select b.ur_baru, min(no_aset) as no_awal, max(no_aset) as no_akhir, c.ur_trn as jenis_transaksi, 
//                        u.thn_ang,u.periode,u.kd_lokasi,u.no_sppa,u.kd_brg,u.no_aset,
//                        u.tgl_perlh,u.tercatat,u.kondisi,u.tgl_buku,u.jns_trn,u.dsr_hrg,u.kd_data,u.flag_sap,u.kuantitas,
//                        u.rph_sat,u.rph_aset,u.flag_kor,u.keterangan,u.merk_type,u.asal_perlh,u.no_bukti,u.no_dsr_mts,
//                        u.tgl_dsr_mts,u.flag_ttp,u.flag_krm,u.kdblu,u.setatus,u.noreg,u.kdbapel,u.kdkpknl,u.umeko,u.rph_res,u.kdkppn 
//                        from t_masteru u
//                        left join t_mapbrg b
//                        on u.kd_brg = b.kd_brgbaru
//                        left join t_croleh c
//                        on u.jns_trn = c.jns_trn
//                        where u.jns_trn IN ('301','391')
//                        group by b.ur_baru
//                        LIMIT $start, $limit";
                
//                $query = " $this->selectColumn
//                        from view_penghapusan
//                        LIMIT $start, $limit";
                $query = "
                                                SELECT `y`.`ur_baru` AS `ur_baru`, z.ur_upb AS ur_upb, `x`.*
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                        LIMIT $start, $limit";
                if($searchByBarcode != null)
                {
                    $query = "
                                                SELECT `y`.`ur_baru` AS `ur_baru`, z.ur_upb AS ur_upb, `x`.*
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
                                                        AND 
                                                        CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                        LIMIT $start, $limit";
                    
                    $countQuery = "SELECT count(*) as total
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
                                                        AND 
                                                        CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok";
                }
                else if($searchByField != null)
                {
                    $query = "
						SELECT `y`.`ur_baru` AS `ur_baru`, z.ur_upb AS ur_upb, `x`.*
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                                                WHERE
                                                (jenis_transaksi like '%$searchByField%' OR
                                                kd_brg like '%$searchByField%' OR
                                                no_sppa like '%$searchByField%' OR
                                                ur_upb like '%$searchByField%' OR
                                                ur_baru like '%$searchByField%' OR
                                                merk_type like'%$searchByField%')
                        LIMIT $start, $limit";
                    
                    $countQuery = "SELECT count(*) as total
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                                                WHERE
                                                (jenis_transaksi like '%$searchByField%' OR
                                                kd_brg like '%$searchByField%' OR
                                                no_sppa like '%$searchByField%' OR
                                                ur_upb like '%$searchByField%' OR
                                                ur_baru like '%$searchByField%' OR
                                                merk_type like'%$searchByField%')";
                }
                else if($gridFilter != null)
                {
                    $query = "
						SELECT `y`.`ur_baru` AS `ur_baru`, z.ur_upb AS ur_upb, `x`.*
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                                                WHERE
                                                $gridFilter
                        LIMIT $start, $limit";
                    
                    $countQuery = "SELECT count(*) as total
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                                                WHERE
                                                $gridFilter";
                }
            }
            else
            {
//                $query = "
//                        select b.ur_baru, min(no_aset) as no_awal, max(no_aset) as no_akhir, c.ur_trn as jenis_transaksi, 
//                        u.thn_ang,u.periode,u.kd_lokasi,u.no_sppa,u.kd_brg,u.no_aset,
//                        u.tgl_perlh,u.tercatat,u.kondisi,u.tgl_buku,u.jns_trn,u.dsr_hrg,u.kd_data,u.flag_sap,u.kuantitas,
//                        u.rph_sat,u.rph_aset,u.flag_kor,u.keterangan,u.merk_type,u.asal_perlh,u.no_bukti,u.no_dsr_mts,
//                        u.tgl_dsr_mts,u.flag_ttp,u.flag_krm,u.kdblu,u.setatus,u.noreg,u.kdbapel,u.kdkpknl,u.umeko,u.rph_res,u.kdkppn 
//                        from t_masteru u
//                        left join t_mapbrg b
//                        on u.kd_brg = b.kd_brgbaru
//                        left join t_croleh c
//                        on u.jns_trn = c.jns_trn
//                        where u.jns_trn IN ('301','391')
//                        group by b.ur_baru
//                        ";
//                $query = "$this->selectColumn
//                        from view_penghapusan";
                $query = "
						 SELECT `y`.`ur_baru` AS `ur_baru`, z.ur_upb AS ur_upb, `x`.*
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok";
                
                if($searchByBarcode != null)
                {
                     $query = "
                                                SELECT `y`.`ur_baru` AS `ur_baru`, z.ur_upb AS ur_upb, `x`.*
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
                                                        AND 
                                                        CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                        ";
                    
                    $countQuery = "SELECT count(*) as total
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
                                                        AND 
                                                        CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok";
                }
                 else if($searchByField != null)
                {
                     $query = "
						SELECT `y`.`ur_baru` AS `ur_baru`, z.ur_upb AS ur_upb, `x`.*
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                                                WHERE
                                                (jenis_transaksi like '%$searchByField%' OR
                                                kd_brg like '%$searchByField%' OR
                                                no_sppa like '%$searchByField%' OR
                                                ur_upb like '%$searchByField%' OR
                                                ur_baru like '%$searchByField%' OR
                                                merk_type like'%$searchByField%')
                     ";
                    
                    $countQuery = "SELECT count(*) as total
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                                                WHERE
                                                (jenis_transaksi like '%$searchByField%' OR
                                                kd_brg like '%$searchByField%' OR
                                                no_sppa like '%$searchByField%' OR
                                                ur_upb like '%$searchByField%' OR
                                                ur_baru like '%$searchByField%' OR
                                                merk_type like'%$searchByField%')";
                }
                else if($gridFilter != null)
                {
                    $query = "
						SELECT `y`.`ur_baru` AS `ur_baru`, z.ur_upb AS ur_upb, `x`.*
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                                                WHERE
                                                $gridFilter
                        ";
                    
                    $countQuery = "SELECT count(*) as total
						FROM
						(
							SELECT
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
							ABS(`u`.`rph_sat`)     AS `rph_sat`,
							ABS(`u`.`rph_aset`)    AS `rph_aset`,
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
							FROM `t_masteru` `u` LEFT JOIN `t_croleh` `c` ON `u`.`jns_trn` = `c`.`jns_trn`
							GROUP BY `u`.`kd_brg`,`u`.`kd_lokasi`,`u`.`no_sppa`
							HAVING `u`.`jns_trn` IN('301','391')
						) AS `x` LEFT JOIN
						(
							SELECT `z`.kd_brgbaru, `z`.ur_baru
							FROM t_mapbrg AS `z`
							GROUP BY `z`.kd_brgbaru
							ORDER BY `z`.kd_brgbaru, `z`.ur_baru
						) AS `y` ON `x`.`kd_brg` = `y`.`kd_brgbaru`
                                                LEFT JOIN
                                                (
                                                    SELECT ur_upb, kdlok FROM ref_unker
                                                )AS z ON x.kd_lokasi = z.kdlok
                                                WHERE
                                                $gridFilter";
                }
            }
                if($countQuery == '')
                {
                    return $this->Get_By_Query($query);
                }
                else
                {
                    return $this->Get_By_Query_New($query,$countQuery);
                }
			
	}
	
	function get_Penghapusan($kd_lokasi, $kd_barang, $no_aset)
	{
//		$query = "$this->selectColumn from view_penghapusan where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
                $query = "SELECT 
                        u.thn_ang,u.periode,u.kd_lokasi,u.no_sppa,u.kd_brg,u.no_aset,
                        u.tgl_perlh,u.tercatat,u.kondisi,u.tgl_buku,u.jns_trn,u.dsr_hrg,u.kd_data,u.flag_sap,u.kuantitas,
                        u.rph_sat,u.rph_aset,u.flag_kor,u.keterangan,u.merk_type,u.asal_perlh,u.no_bukti,u.no_dsr_mts,
                        u.tgl_dsr_mts,u.flag_ttp,u.flag_krm,u.kdblu,u.setatus,u.noreg,u.kdbapel,u.kdkpknl,u.umeko,u.rph_res,u.kdkppn 
                        FROM t_masteru u
                        WHERE jns_trn IN ('301','391')
                        AND kd_lokasi = '$kd_lokasi' AND kd_brg = '$kd_barang' AND no_aset = '$no_aset' ";
		return $this->Get_By_Query($query);
	}
	
	function get_PenghapusanForPrint($kd_lokasi, $kd_barang, $no_aset)
	{
//		$query = "$this->selectColumn from view_penghapusan where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
                $query = "SELECT 
                        u.thn_ang,u.periode,u.kd_lokasi,u.no_sppa,u.kd_brg,u.no_aset,
                        u.tgl_perlh,u.tercatat,u.kondisi,u.tgl_buku,u.jns_trn,u.dsr_hrg,u.kd_data,u.flag_sap,u.kuantitas,
                        u.rph_sat,u.rph_aset,u.flag_kor,u.keterangan,u.merk_type,u.asal_perlh,u.no_bukti,u.no_dsr_mts,
                        u.tgl_dsr_mts,u.flag_ttp,u.flag_krm,u.kdblu,u.setatus,u.noreg,u.kdbapel,u.kdkpknl,u.umeko,u.rph_res,u.kdkppn 
                        FROM t_masteru u
                        WHERE u.jns_trn IN ('301','391')
                        AND kd_lokasi = '$kd_lokasi' AND kd_brg = '$kd_barang' AND no_aset = '$no_aset' ";
		$this->load->database();
		$result = $this->db->query($query)->result_array();
		$this->db->close();				  
		return $result;
	}
}
?>
