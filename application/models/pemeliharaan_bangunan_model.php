<?php
class Pemeliharaan_Bangunan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pemeliharaan_bangunan';
                $this->viewTable = 'view_pemeliharaanBangunan';
                
                $this->selectColumn = "SELECT id, nama_unker, nama_unor,kd_brg, kd_lokasi, no_aset,
                            kode_unor, jenis, subjenis, pelaksana_nama, pelaksana_startdate, 
                            pelaksana_endate, deskripsi, biaya, image_url, document_url";
	}
	
	
	function get_AllData(){
		$query = "$this->selectColumn FROM $this->viewTable";

		return $this->Get_By_Query($query);	
	}
	
	function get_Pemeliharaan($kd_lokasi, $kd_brg, $no_aset)
	{
		$query = "$this->selectColumn FROM $this->viewTable
                            where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_brg' and no_aset = '$no_aset'";

		return $this->Get_By_Query($query);	
	}
}
?>