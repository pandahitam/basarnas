<?php

class Unit_Kerja_Model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'ref_unker';
        $this->selectColumn = "SELECT kdlok, ur_upb, kd_pebin,kd_pbi,kd_ppbi,kd_upb,kd_subupb,kd_jk";
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
                                kdlok like '%$searchByField%' OR
                                ur_upb like '%$searchByField%'
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where 
                                kdlok like '%$searchByField%' OR
                                ur_upb like '%$searchByField%'
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
                                kdlok like '%$searchByField%' OR
                                ur_upb like '%$searchByField%'             
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where 
                                kdlok like '%$searchByField%' OR
                                ur_upb like '%$searchByField%' 
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

    function get_CountData() {
        
    }

    function get_Count_UKI() {

    }

    function getData_ID() {

    }

    function getLast_kode_unker() {

    }

    function Insert_Data() {

    }

    function Delete_Data() {

    }

    function get_AllPrint() {

    }

    function get_SelectedPrint() {

    }

    function get_ByRowsPrint() {

    }

}

?>