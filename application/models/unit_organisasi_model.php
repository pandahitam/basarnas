<?php

class Unit_Organisasi_Model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'ref_unor';
        $this->viewTable = 'view_referensi_unit_organisasi';
        $this->selectColumn = "SELECT ID_Unor, nama_unker, kode_unor,kd_lokasi,kode_jab,kode_eselon,kode_parent,nama_unor,jabatan_unor,urut_unor,status_data";
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
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
                                kode_unor like '%$searchByField%'
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
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
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
                                kode_unor like '%$searchByField%'             
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
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
        }

    function getLast_kode_unor() {
        
    }

    function Insert_Data() {
        
    }

    function Delete_Data() {
        
    }

    function get_AllPrint() {
        
    }

    function get_SelectedPrint() {
        
    }

    function get_ByRowsPrint($dari = null, $sampai = null) {
        
    }

}

?>