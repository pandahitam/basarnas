<?php

class Unit_Kerja_Model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'ref_unker';
        $this->selectColumn = "SELECT kdlok, ur_upb";
    }

    function get_AllData($start = null, $limit = null) {
        $result = array();
        
        if ($start != null && $limit != null) {
            $query = "$this->selectColumn
                            FROM $this->table AS t
                            LIMIT $start,$limit";
        } else {
            $query = "$this->selectColumn
                            FROM $this->table AS t
                            ";
        }
        
        $returnedResult = $this->Get_By_Query($query);

        $result["results"] = $returnedResult['data'];
        $result["total"] = $returnedResult['count'];
        
        return $result;
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