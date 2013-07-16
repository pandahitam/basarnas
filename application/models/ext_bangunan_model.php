<?php
class Ext_Bangunan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'ext_asset_bangunan';
	}
	
	function get_AllData(){
		$query = 'SELECT kd_lokasi, kd_brg, no_aset, kode_unker, kode_unor, imageurl FROM '. $this->table . ' LIMIT 0, '. $this->limit;
                
		return $this->Get_By_Query($query);	
	}
	
	function get_byIDs($ids)
	{		
		$query = 'SELECT kd_lokasi, kd_brg, no_aset, kode_unker, kode_unor, imageurl FROM ' . $this->table . ' WHERE id IN ('.$this->prepare_Query($ids).')ORDER BY id ASC';
                
		return $this->Get_By_Query($query);
	}
	
	
	function ConstructKode($kode_golongan = NULL,$kode_asset = NULL){
		$kode = NULL;
		if ($kode_golongan != NULL && $kode_asset != NULL)
		{
			$kode = '2' . $kode_golongan . $kode_asset;
		}	
		return $kode;
	}
}
?>