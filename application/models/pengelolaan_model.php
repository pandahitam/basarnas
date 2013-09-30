<?php
class Pengelolaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pengelolaan';
                $this->table = 'pengelolaan';
                
                $this->selectColumn = "SELECT id, nama_operasi, pic,tanggal_mulai,tanggal_selesai,deskripsi, image_url, document_url, kd_lokasi, kode_unor, kd_brg, no_aset, nama";
	}
	
	function get_AllData(){
		$query = "$this->selectColumn FROM $this->extTable";

		return $this->Get_By_Query($query);	
	}
	
	
}
?>
