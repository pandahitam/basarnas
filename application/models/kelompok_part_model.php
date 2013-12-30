<?php
class Kelompok_Part_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'ref_kelompok_part';    
            $this->selectColumn = "SELECT id, nama_kelompok, jenis_asset";
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
                                nama_kelompok like '%$searchByField%' OR
                                jenis_asset like '%$searchByField%'
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where 
                                nama_kelompok like '%$searchByField%' OR
                                jenis_asset like '%$searchByField%'
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
                                nama_kelompok like '%$searchByField%' OR
                                jenis_asset like '%$searchByField%'             
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where 
                                nama_kelompok like '%$searchByField%' OR
                                jenis_asset like '%$searchByField%' 
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
        }
	
}
?>