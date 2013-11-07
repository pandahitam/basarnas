<?php
class Kd_Brg_Golongan_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'ref_golongan';    
            $this->selectColumn = "SELECT kd_gol, ur_gol";
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