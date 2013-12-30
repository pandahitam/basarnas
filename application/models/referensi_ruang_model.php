<?php
class Referensi_Ruang_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'ref_ruang';
            $this->viewTable = 'view_referensi_ruang';
//            $this->selectColumn = "SELECT t.kd_lokasi, t.kd_ruang, t.ur_ruang, t.kode_unor, a.ur_upb as nama_unker, b.nama_unor ";
            $this->selectColumn = "SELECT kd_lokasi, kd_ruang, ur_ruang, kode_unor, nama_unker, nama_unor ";
	}
	
        function get_AllData($start=null, $limit=null,$gridFilter = null, $searchByField = null){
            $countQuery = "select count(*) as total
                                FROM $this->table";
            if($start !=null && $limit !=null)
            {
                $query = "$this->selectColumn 
                        FROM $this->viewTable
                        LIMIT $start, $limit";
                
                if($searchByField != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->viewTable
                                where 
                                kd_lokasi like '%$searchByField%' OR
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                ur_ruang like '%$searchByField%' OR
                                kd_ruang like '%$searchByField%' OR
                                kode_unor like '%$searchByField%'                         
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                kd_lokasi like '%$searchByField%' OR
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                ur_ruang like '%$searchByField%' OR
                                kd_ruang like '%$searchByField%' OR
                                kode_unor like '%$searchByField%'   
                             ";
                }
                else if($gridFilter != null)
                {
                    $query = "$this->selectColumn
                               FROM $this->viewTable
                               where $gridFilter
                               LIMIT $start, $limit
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where $gridFilter";
                }
            }
            else
            {
                $query = "$this->selectColumn 
                        FROM $this->viewTable
                        ";
                
                if($searchByField != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->viewTable
                                where 
                                kd_lokasi like '%$searchByField%' OR
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                ur_ruang like '%$searchByField%' OR
                                kd_ruang like '%$searchByField%' OR
                                kode_unor like '%$searchByField%'                         
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                kd_lokasi like '%$searchByField%' OR
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                ur_ruang like '%$searchByField%' OR
                                kd_ruang like '%$searchByField%' OR
                                kode_unor like '%$searchByField%'   
                             ";
                }
                else if($gridFilter != null)
                {
                    $query = "$this->selectColumn
                               FROM $this->viewTable
                               where $gridFilter
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where $gridFilter";
                }
            }
            
            return $this->Get_By_Query_New($query,$countQuery);
//            return $this->Get_By_Query($query);	
	}
}
?>