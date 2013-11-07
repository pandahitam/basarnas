<?php
class Kd_Brg_Kelompok_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'ref_kel';    
            $this->selectColumn = "SELECT t.kd_gol, ur_gol, t.kd_bid, ur_bid, kd_kel, ur_kel ";
	}
	
        function get_AllData($start=null, $limit=null){
            if($start !=null && $limit !=null)
            {
                $query = "$this->selectColumn 
                        FROM $this->table as t
                        LEFT JOIN ref_golongan as a ON a.kd_gol = t.kd_gol
                        LEFT JOIN ref_bidang as b ON b.kd_bid = t.kd_bid and b.kd_gol = t.kd_gol
                        LIMIT $start, $limit";
            }
            else
            {
                $query = "$this->selectColumn 
                        FROM $this->table as t
                        LEFT JOIN ref_golongan as a ON a.kd_gol = t.kd_gol
                        LEFT JOIN ref_bidang as b ON b.kd_bid = t.kd_bid and b.kd_gol = t.kd_gol
                        ";
            }
            

            return $this->Get_By_Query($query);	
	}
}
?>