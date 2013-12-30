<?php
class Klasifikasi_Aset_Lvl3_Model extends MY_Model{
	
	function __construct(){
            parent::__construct();
            $this->table = 'ref_klasifikasiaset_lvl3';
            $this->viewTable = 'view_referensi_klasifikasiaset_lvl3';
            $this->selectColumn = "SELECT kd_lvl1, kd_lvl2, kd_lvl3, nama, kd_klasifikasi_aset, nama_lvl2";
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
                                nama_lvl2 like '%$searchByField%' OR
                                kd_lvl3 like '%$searchByField%' OR
                                nama like '%$searchByField%'                 
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                nama_lvl2 like '%$searchByField%' OR
                                kd_lvl3 like '%$searchByField%' OR
                                nama like '%$searchByField%'     
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
                                nama_lvl2 like '%$searchByField%' OR
                                kd_lvl3 like '%$searchByField%' OR
                                nama like '%$searchByField%'                           
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                nama_lvl2 like '%$searchByField%' OR
                                kd_lvl3 like '%$searchByField%' OR
                                nama like '%$searchByField%'   
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
        }
}
?>