<?php
class Kd_Brg_Bidang_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'ref_bidang';    
            $this->selectColumn = "SELECT t.kd_gol, ur_gol, kd_bid, ur_bid ";
	}
	
        function get_AllData($start=null, $limit=null){
            if($start !=null && $limit !=null)
            {
                $query = "$this->selectColumn 
                        FROM $this->table as t
                        LEFT JOIN ref_golongan as a ON a.kd_gol = t.kd_gol
                        ORDER BY ur_gol, kd_bid
                        LIMIT $start, $limit";
            }
            else
            {
                $query = "$this->selectColumn 
                        FROM $this->table as t
                        LEFT JOIN ref_golongan as a ON a.kd_gol = t.kd_gol
                        ORDER BY ur_gol, kd_bid
                        ";
            }
            

            return $this->Get_By_Query($query);	
	}
}
?>