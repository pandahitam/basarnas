<?php
class Ref_Sub_Part_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'ref_sub_part';    
            $this->viewTable = 'view_referensi_sub_part';
            $this->selectColumn = "SELECT * ";
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
                                part_induk like '%$searchByField%' OR
                                nama like '%$searchByField%' OR
                                part_number like '%$searchByField%' OR
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                part_induk like '%$searchByField%' OR
                                nama like '%$searchByField%' OR
                                part_number like '%$searchByField%' OR
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
                                part_induk like '%$searchByField%' OR
                                nama like '%$searchByField%' OR
                                part_number like '%$searchByField%' OR             
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                part_induk like '%$searchByField%' OR
                                nama like '%$searchByField%' OR
                                part_number like '%$searchByField%' OR
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