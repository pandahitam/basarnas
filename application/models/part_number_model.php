<?php
class Part_Number_Model extends MY_Model{
	
	function __construct(){
            parent::__construct();
            $this->table = 'ref_perlengkapan';
            $this->viewTable = 'view_referensi_part_number';
            $this->selectColumn = "SELECT id, vendor_id, part_number, kd_brg, merek, jenis, nama, part_number_substitusi, umur_maks, nama_kelompok, jenis_asset";
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
                                part_number like '%$searchByField%' OR
                                kd_brg like '%$searchByField%' OR
                                jenis_asset like '%$searchByField%' OR
                                jenis like '%$searchByField%' OR
                                nama like '%$searchByField%' OR
                                nama_kelompok like '%$searchByField%'
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                part_number like '%$searchByField%' OR
                                kd_brg like '%$searchByField%' OR
                                jenis_asset like '%$searchByField%' OR
                                jenis like '%$searchByField%' OR
                                nama like '%$searchByField%' OR
                                nama_kelompok like '%$searchByField%'
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
                                part_number like '%$searchByField%' OR
                                kd_brg like '%$searchByField%' OR
                                jenis_asset like '%$searchByField%' OR
                                jenis like '%$searchByField%' OR
                                nama like '%$searchByField%' OR
                                nama_kelompok like '%$searchByField%'             
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                part_number like '%$searchByField%' OR
                                kd_brg like '%$searchByField%' OR
                                jenis_asset like '%$searchByField%' OR
                                jenis like '%$searchByField%' OR
                                nama like '%$searchByField%' OR
                                nama_kelompok like '%$searchByField%' 
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