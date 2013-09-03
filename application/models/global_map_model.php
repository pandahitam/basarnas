<?php
class Global_Map_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_byLoc($loc)
	{
		$this->load->database();
		$sql = 'SELECT asset_type as `Asset`, nama as `Criteria`, jumlah FROM tview_asset_rekap_lv1 WHERE kode="'. $loc .'" ORDER BY asset_type, nama';
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		return $result;
	}

}
?>