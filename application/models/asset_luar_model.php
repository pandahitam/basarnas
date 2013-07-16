<?php
class Asset_Luar_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'asset_dil';
                $this->extTable = 'ext_asset_dil';
                
                $this->selectColumn = "SELECT t.kd_lokasi, t.kd_brg, t.no_aset, t.lok_fisik, a.id, a.kode_unor, a.image_url, a.document_url,
                                        b.ur_upb as nama_unker, c.nama_unor, d.ur_sskel as nama ";
	}
	
	function get_AllData(){
		$query = "$this->selectColumn
                        FROM $this->table as t 
                        LEFT JOIN $this->extTable as a ON t.kd_lokasi = a.kd_lokasi AND t.kd_brg = a.kd_brg AND t.no_aset = a.no_aset
                        LEFT JOIN ref_unker AS b ON t.kd_lokasi = e.kdlok
                        LEFT JOIN ref_unor AS c ON a.kode_unor = f.kode_unor
                        LEFT JOIN ref_subsubkel as d ON t.kd_brg = c.kd_brg
                        LIMIT 100, 500";
                
                return $this->Get_By_Query($query);	
	}
        
        function get_ExtAllData($kd_lokasi,$kd_brg,$no_aset){

        }
	
	function get_byIDs($ids)
	{		
		
	}
	
	
}
?>