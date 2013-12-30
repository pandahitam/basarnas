<?php
class KabKota_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'tref_kabkota'; 
            $this->viewTable = 'view_referensi_kabkota';
            $this->selectColumn = "SELECT ID_KK, kode_prov,kode_kabkota, nama_kabkota, nama_prov";
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
                                nama_prov like '%$searchByField%' OR
                                nama_kabkota like '%$searchByField%' OR
                                kode_kabkota like '%$searchByField%'                      
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                nama_prov like '%$searchByField%' OR
                                nama_kabkota like '%$searchByField%' OR
                                kode_kabkota like '%$searchByField%'                      
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
                                nama_prov like '%$searchByField%' OR
                                nama_kabkota like '%$searchByField%' OR
                                kode_kabkota like '%$searchByField%'                                               
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                nama_prov like '%$searchByField%' OR
                                nama_kabkota like '%$searchByField%' OR
                                kode_kabkota like '%$searchByField%'                         
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