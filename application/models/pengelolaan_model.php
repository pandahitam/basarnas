<?php
class Pengelolaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pengelolaan';
                $this->table = 'pengelolaan';
                
                $this->selectColumn = "SELECT t.id, t.nama_operasi, t.pic,t.tanggal_mulai,t.tanggal_selesai,t.deskripsi, t.image_url, t.document_url, t.kd_lokasi, t.kode_unor, t.kd_brg, t.no_aset, t.nama";
	}
	
	function get_AllData(){
		$query = "$this->selectColumn FROM $this->extTable as t";

		return $this->Get_By_Query($query);	
	}
        
        function get_Pengelolaan($kd_lokasi, $kd_barang, $no_aset)
	{
		$query = "$this->selectColumn
                        FROM $this->table AS t
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        where t.kd_lokasi = '$kd_lokasi' and t.kd_brg = '$kd_barang' and t.no_aset = '$no_aset'";
		
                return $this->Get_By_Query($query);
	}
	
	
}
?>
