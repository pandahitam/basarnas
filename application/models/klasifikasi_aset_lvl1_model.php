<?php
class Klasifikasi_Aset_Lvl1_Model extends MY_Model{
	
	function __construct(){
            parent::__construct();
            $this->table = 'ref_klasifikasiaset_lvl1';
            
            $this->selectColumn = "SELECT kd_lvl1, nama";
	}
	
function get_AllData($start=null, $limit=null,$gridFilter = null, $searchByField = null){
            $countQuery = "select count(*) as total
                                FROM $this->table";
            if($start !=null && $limit !=null)
            {
                $query = "$this->selectColumn 
                        FROM $this->table
                        LIMIT $start, $limit";
                
                if($searchByField != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->table
                                where 
                                kd_lvl1 like '%$searchByField%' OR
                                nama like '%$searchByField%'                     
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where 
                                kd_lvl1 like '%$searchByField%' OR
                                nama like '%$searchByField%' 
                             ";
                }
                else if($gridFilter != null)
                {
                    $query = "$this->selectColumn
                               FROM $this->table
                               where $gridFilter
                               LIMIT $start, $limit
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->table
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
                                FROM $this->table
                                where 
                                kd_lvl1 like '%$searchByField%' OR
                                nama like '%$searchByField%'                         
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where 
                                kd_lvl1 like '%$searchByField%' OR
                                nama like '%$searchByField%' 
                             ";
                }
                else if($gridFilter != null)
                {
                    $query = "$this->selectColumn
                               FROM $this->table
                               where $gridFilter
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where $gridFilter";
                }
            }
            
            return $this->Get_By_Query_New($query,$countQuery);
//            return $this->Get_By_Query($query);	
	}
        
}
?>