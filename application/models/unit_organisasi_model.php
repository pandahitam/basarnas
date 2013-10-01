<?php

class Unit_Organisasi_Model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'ref_unor';
        $this->selectColumn = "SELECT ID_Unor, b.ur_upb as nama_unker, kode_unor,kd_lokasi,kode_jab,kode_eselon,kode_parent,nama_unor,jabatan_unor,urut_unor,status_data";
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
        
        return $this->Get_By_Query($query);
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