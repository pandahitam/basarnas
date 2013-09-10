<?php

class Unit_Organisasi_Model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'ref_unor';
        $this->selectColumn = "SELECT t.kd_lokasi, t.kode_unor, t.nama_unor, t.jabatan_unor, b.ur_upb";
    }

    function get_AllData($start = null, $limit = null) {
        $result = array();
        
        if ($start != null && $limit != null) {
            $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS b ON t.kd_lokasi = b.kdlok
                            LIMIT $start,$limit";
        } else {
            $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS b ON t.kd_lokasi = b.kdlok";
        }
        
        $result["results"] = $this->Get_By_Query($query);
        $result["total"] = count($result["results"]);
        
        return $result;
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