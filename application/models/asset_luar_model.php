<?php
class Asset_Luar_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'asset_dil';
                $this->extTable = 'ext_asset_dil';
                
                $this->selectColumn = "SELECT t.kd_lokasi, t.kd_brg, t.no_aset, t.lok_fisik, a.id, a.kode_unor, a.image_url, a.document_url,
                                        b.ur_upb as nama_unker, c.nama_unor, e.ur_sskel as nama,
                                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel,
                                            f.nama as nama_klasifikasi_aset, a.kd_klasifikasi_aset,
                            f.kd_lvl1,f.kd_lvl2,f.kd_lvl3
                                        ";
	}
	
	function get_AllData($start,$limit){
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn
                        FROM $this->table as t 
                        LEFT JOIN $this->extTable as a ON t.kd_lokasi = a.kd_lokasi AND t.kd_brg = a.kd_brg AND t.no_aset = a.no_aset
                        LEFT JOIN ref_unker AS b ON t.kd_lokasi = b.kdlok
                        LEFT JOIN ref_unor AS c ON a.kode_unor = c.kode_unor
                        LEFT JOIN ref_subsubkel as e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON a.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                        LIMIT $start, $limit";
            }
            else
            {
                $query = "$this->selectColumn
                        FROM $this->table as t 
                        LEFT JOIN $this->extTable as a ON t.kd_lokasi = a.kd_lokasi AND t.kd_brg = a.kd_brg AND t.no_aset = a.no_aset
                        LEFT JOIN ref_unker AS b ON t.kd_lokasi = b.kdlok
                        LEFT JOIN ref_unor AS c ON a.kode_unor = c.kode_unor
                        LEFT JOIN ref_subsubkel as d ON t.kd_brg = d.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON a.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                        ";
            }
                
                return $this->Get_By_Query($query);	
	}
        
        function get_ExtAllData($kd_lokasi,$kd_brg,$no_aset){

        }
	
	function get_byIDs($ids)
	{		
		
	}
	
	
}
?>