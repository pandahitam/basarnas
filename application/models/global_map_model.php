<?php
class Global_Map_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_byLoc($loc)
	{
		$names = Array('Tanah', 'Bangunan', 'Alat Besar', 'Angkutan', 'Perairan', 'Senjata', 'Ruang', 'Luar');
		$tables = Array('ext_asset_tanah', 'ext_asset_bangunan', 'ext_asset_alatbesar', 'ext_asset_angkutan', 'ext_asset_perairan', 'ext_asset_senjata', 'ext_asset_ruang', 'ext_asset_dil');
		$sql = '';
		for($i=0; $i<8; $i++)
		{
			$sql .= ' SELECT "'.$names[$i].'" AS `asset`, `b`.`nama` AS `criteria`, MID(`a`.`kd_lokasi`, 6, 10) AS `kode_lokasi`, COUNT(*) AS `count`';
			$sql .= ' FROM '.$tables[$i].' AS `a` INNER JOIN ref_klasifikasiaset_lvl1 AS `b` ON  MID(`a`.`kd_klasifikasi_aset`, 1, 2) = `b`.kd_lvl1';
			$sql .= ' GROUP BY `kode_lokasi`, `criteria`';
			$sql .= ' HAVING `kode_lokasi` LIKE "%'. $loc .'%"';
			if($i<7) $sql .= ' UNION'; else $sql .= ' ORDER BY `asset`, `criteria`';
		}
		$this->load->database();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		return $result;
	}

	function get_sarpras_data_byLoc($loc)
	{
		$images = Array('sp_rescueboat', 'sp_rigidinflatableboat', 'sp_rubberboat', 'sp_rescuecartype1', 'sp_rescuecartype2', 'sp_truckpersonil', 'sp_rescuetruck', 'sp_ambulance', 'sp_atv', 'sp_sepedamotor');		
		$saranas = Array('Rescue Boat Kl. II/III/IV', 'Rigid Inflatable Boat', 'Rubber Boat', 'Rescue car Tipe 1', 'Rescue car Tipe 2', 'Truck Personil', 'Rescue Truck', 'Ambulance', 'ATV', 'Sepeda Motor');
		$standars = Array('Dermaga kantor SAR <br />dan Pos SAR', '- 1 Unit di Kantor SAR <br />- 1 Unit di Pos SAR', '4 unit Kantor SAR <br />dan 3 Unit diPos SAR', '1 Unit di Kantor SAR <br />dan Tiap Pos SAR', '2 Unit tiap Kantor SAR <br />dan Pos SAR', '2 Unit Kantor SAR <br />dan 1 Unit di Pos SAR', '1 Unit di Kantor SAR', '- 1 Unit di Kantor SAR <br />- 1 Unit di Pos SAR', 'Kantor SAR', '- 5 Unit Kantor SAR <br />- 3 Unit di Pos SAR');
		$kodes = Array('020200', '020400', '020500', '010201', '010202', '010204', '010100', '010205', '010204', '010206');
		$sql = '';
		for($i=0; $i<10; $i++)
		{
			$sql .= ' SELECT '.($i+1).' AS `nomor`, "'.$images[$i].'" AS `image`, "'.$saranas[$i].'" AS `sarana`, COUNT(*) AS `jumlah`, "'.$standars[$i].'" AS `standar`';
			$sql .= ' FROM ext_asset_angkutan';
			$sql .= ' WHERE kd_lokasi LIKE "%'.$loc.'%" AND kd_klasifikasi_aset = "'.$kodes[$i].'"';
			if($i<9) $sql .= ' UNION'; else $sql .= ' ORDER BY `nomor`';
		}
		$this->load->database();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		return $result;
	}
}
?>