<?php
class Kd_Brg_SubKelompok_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'ref_subkel';  
            $this->viewTable = 'view_referensi_kd_brg_sub_kelompok';
            $this->selectColumn = "SELECT kd_gol, ur_gol, kd_bid, ur_bid, kd_kel, ur_kel, kd_skel, ur_skel";
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
                                ur_bid like '%$searchByField%' OR
                                ur_kel like '%$searchByField%' OR
                                ur_skel like '%$searchByField%'
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                ur_gol like '%$searchByField%' OR
                                ur_bid like '%$searchByField%' OR
                                ur_kel like '%$searchByField%' OR
                                ur_skel like '%$searchByField%'
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
                                ur_bid like '%$searchByField%' OR
                                ur_kel like '%$searchByField%' OR
                                ur_skel like '%$searchByField%'             
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                ur_gol like '%$searchByField%' OR
                                ur_bid like '%$searchByField%' OR
                                ur_kel like '%$searchByField%' OR
                                ur_skel like '%$searchByField%' 
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