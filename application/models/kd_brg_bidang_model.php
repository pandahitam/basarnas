<?php
class Kd_Brg_Bidang_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'ref_bidang';    
            $this->viewTable = 'view_referensi_kd_brg_bidang';
            $this->selectColumn = "SELECT kd_gol, ur_gol, kd_bid, ur_bid ";
	}
	
         function get_AllData($start=null, $limit=null,$gridFilter = null, $searchByField = null){
            $countQuery = "select count(*) as total
                                FROM $this->viewTable";
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
                                ur_gol like '%$searchByField%' OR
                                ur_bid like '%$searchByField%'
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                ur_gol like '%$searchByField%' OR
                                ur_bid like '%$searchByField%'  
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
                                ur_gol like '%$searchByField%' OR
                                ur_bid like '%$searchByField%'              
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                ur_gol like '%$searchByField%' OR
                                ur_bid like '%$searchByField%'  
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