<?php
class Prov_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'tref_provinsi';    
            $this->selectColumn = "SELECT ID_Prov,kode_prov, nama_prov";
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
                                nama_prov like '%$searchByField%' OR
                                kode_prov like '%$searchByField%'                          
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where 
                                nama_prov like '%$searchByField%' OR
                                kode_prov like '%$searchByField%' 
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
                        FROM $this->table
                        ";
                
                if($searchByField != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->table
                                where 
                                nama_prov like '%$searchByField%' OR
                                kode_prov like '%$searchByField%' 
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where 
                                nama_prov like '%$searchByField%' OR
                                kode_prov like '%$searchByField%' 
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