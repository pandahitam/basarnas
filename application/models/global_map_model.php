<?php
class Global_Map_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_byLoc($loc)
	{
		$this->load->database();
		// Development Version :-), Create permanent View will be better.
		$sql =  'SELECT "Tanah" AS `asset`, `b`.`nama` AS `criteria`, MID(`a`.`kd_lokasi`, 6, 10) AS `kode_lokasi`, COUNT(*) AS `count`';
		$sql .= ' FROM ext_asset_tanah AS `a` INNER JOIN ref_klasifikasiaset_lvl1 AS `b` ON  MID(`a`.`kd_klasifikasi_aset`, 1, 2) = `b`.kd_lvl1';
		$sql .= ' GROUP BY `kode_lokasi`, `criteria`';
		$sql .= ' HAVING `kode_lokasi` LIKE "%'. $loc .'%"';
		$sql .= ' UNION ';
		$sql .= 'SELECT "Bangunan" AS `asset`, `b`.`nama` AS `criteria`, MID(`a`.`kd_lokasi`, 6, 10) AS `kode_lokasi`, COUNT(*) AS `count`';
		$sql .= ' FROM ext_asset_bangunan AS `a` INNER JOIN ref_klasifikasiaset_lvl1 AS `b` ON  MID(`a`.`kd_klasifikasi_aset`, 1, 2) = `b`.kd_lvl1';
		$sql .= ' GROUP BY `kode_lokasi`, `criteria`';
		$sql .= ' HAVING `kode_lokasi` LIKE "%'. $loc .'%"';
		$sql .= ' UNION ';
		$sql .= 'SELECT "Alat Besar" AS `asset`, `b`.`nama` AS `criteria`, MID(`a`.`kd_lokasi`, 6, 10) AS `kode_lokasi`, COUNT(*) AS `count`';
		$sql .= ' FROM ext_asset_alatbesar AS `a` INNER JOIN ref_klasifikasiaset_lvl1 AS `b` ON  MID(`a`.`kd_klasifikasi_aset`, 1, 2) = `b`.kd_lvl1';
		$sql .= ' GROUP BY `kode_lokasi`, `criteria`';
		$sql .= ' HAVING `kode_lokasi` LIKE "%'. $loc .'%"';
		$sql .= ' UNION ';
		$sql .= 'SELECT "Angkutan" AS `asset`, `b`.`nama` AS `criteria`, MID(`a`.`kd_lokasi`, 6, 10) AS `kode_lokasi`, COUNT(*) AS `count`';
		$sql .= ' FROM ext_asset_angkutan AS `a` INNER JOIN ref_klasifikasiaset_lvl1 AS `b` ON  MID(`a`.`kd_klasifikasi_aset`, 1, 2) = `b`.kd_lvl1';
		$sql .= ' GROUP BY `kode_lokasi`, `criteria`';
		$sql .= ' HAVING `kode_lokasi` LIKE "%'. $loc .'%"';
		$sql .= ' UNION ';
		$sql .= 'SELECT "Perairan" AS `asset`, `b`.`nama` AS `criteria`, MID(`a`.`kd_lokasi`, 6, 10) AS `kode_lokasi`, COUNT(*) AS `count`';
		$sql .= ' FROM ext_asset_perairan AS `a` INNER JOIN ref_klasifikasiaset_lvl1 AS `b` ON  MID(`a`.`kd_klasifikasi_aset`, 1, 2) = `b`.kd_lvl1';
		$sql .= ' GROUP BY `kode_lokasi`, `criteria`';
		$sql .= ' HAVING `kode_lokasi` LIKE "%'. $loc .'%"';
		$sql .= ' UNION ';
		$sql .= 'SELECT "Senjata" AS `asset`, `b`.`nama` AS `criteria`, MID(`a`.`kd_lokasi`, 6, 10) AS `kode_lokasi`, COUNT(*) AS `count`';
		$sql .= ' FROM ext_asset_senjata AS `a` INNER JOIN ref_klasifikasiaset_lvl1 AS `b` ON  MID(`a`.`kd_klasifikasi_aset`, 1, 2) = `b`.kd_lvl1';
		$sql .= ' GROUP BY `kode_lokasi`, `criteria`';
		$sql .= ' HAVING `kode_lokasi` LIKE "%'. $loc .'%"';
		$sql .= ' UNION ';
		$sql .= 'SELECT "Ruang" AS `asset`, `b`.`nama` AS `criteria`, MID(`a`.`kd_lokasi`, 6, 10) AS `kode_lokasi`, COUNT(*) AS `count`';
		$sql .= ' FROM ext_asset_ruang AS `a` INNER JOIN ref_klasifikasiaset_lvl1 AS `b` ON  MID(`a`.`kd_klasifikasi_aset`, 1, 2) = `b`.kd_lvl1';
		$sql .= ' GROUP BY `kode_lokasi`, `criteria`';
		$sql .= ' HAVING `kode_lokasi` LIKE "%'. $loc .'%"';
		$sql .= ' UNION ';
		$sql .= 'SELECT "Luar" AS `asset`, `b`.`nama` AS `criteria`, MID(`a`.`kd_lokasi`, 6, 10) AS `kode_lokasi`, COUNT(*) AS `count`';
		$sql .= ' FROM ext_asset_dil AS `a` INNER JOIN ref_klasifikasiaset_lvl1 AS `b` ON  MID(`a`.`kd_klasifikasi_aset`, 1, 2) = `b`.kd_lvl1';
		$sql .= ' GROUP BY `kode_lokasi`, `criteria`';
		$sql .= ' HAVING `kode_lokasi` LIKE "%'. $loc .'%"';
		$sql .= ' ORDER BY `asset`, `criteria`';

		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		return $result;
	}

}
?>