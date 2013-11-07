<?php
class KabKota_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'tref_kabkota';    
            $this->selectColumn = "SELECT ID_KK, tref_kabkota.kode_prov,kode_kabkota, nama_kabkota, nama_prov";
	}
	
        function get_AllData($start=null, $limit=null){
            if($start !=null && $limit !=null)
            {
                $query = "$this->selectColumn 
                        FROM $this->table 
                        LEFT JOIN tref_provinsi ON tref_provinsi.kode_prov = tref_kabkota.kode_prov
                        ORDER BY nama_prov, nama_kabkota
                        LIMIT $start, $limit";
            }
            else
            {
                $query = "$this->selectColumn 
                        FROM $this->table
                        LEFT JOIN tref_provinsi ON tref_provinsi.kode_prov = tref_kabkota.kode_prov
                        ORDER BY nama_prov, nama_kabkota
                        ";
            }
            

            return $this->Get_By_Query($query);	
	}
}
?>