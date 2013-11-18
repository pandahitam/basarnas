<?php
class Kelompok_Part_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'ref_kelompok_part';    
            $this->selectColumn = "SELECT id, nama_kelompok";
	}
	
        function get_AllData($start=null, $limit=null){
            if($start !=null && $limit !=null)
            {
                $query = "$this->selectColumn 
                        FROM $this->table 
                        LIMIT $start, $limit";
            }
            else
            {
                $query = "$this->selectColumn 
                        FROM $this->table
                        ";
            }
            

            return $this->Get_By_Query($query);	
	}
	
}
?>