<?php
class Kd_Brg_SubSubKelompok_Model extends MY_Model {
	function __construct(){
		parent::__construct();
            $this->table = 'ref_subsubkel';    
            $this->selectColumn = "SELECT t.kd_gol, ur_gol, t.kd_bid, ur_bid, t.kd_kel, ur_kel, t.kd_skel, ur_skel, t.kd_sskel, ur_sskel";
	}
	
        function get_AllData($start=null, $limit=null){
            if($start !=null && $limit !=null)
            {
                $query = "$this->selectColumn 
                        FROM $this->table as t
                        LEFT JOIN ref_golongan as a ON a.kd_gol = t.kd_gol
                        LEFT JOIN ref_bidang as b ON b.kd_bid = t.kd_bid and b.kd_gol = t.kd_gol
                        LEFT JOIN ref_kel as c ON c.kd_bid = t.kd_bid and c.kd_gol = t.kd_gol and c.kd_kel = t.kd_kel
                        LEFT JOIN ref_subkel as d ON d.kd_bid = t.kd_bid and d.kd_gol = t.kd_gol and d.kd_kel = t.kd_kel and d.kd_skel = t.kd_skel
                        ORDER BY ur_gol,kd_bid,kd_kel,kd_skel, kd_sskel
                        LIMIT $start, $limit";
            }
            else
            {
                $query = "$this->selectColumn 
                        FROM $this->table as t
                        LEFT JOIN ref_golongan as a ON a.kd_gol = t.kd_gol
                        LEFT JOIN ref_bidang as b ON b.kd_bid = t.kd_bid and b.kd_gol = t.kd_gol
                        LEFT JOIN ref_kel as c ON c.kd_bid = t.kd_bid and c.kd_gol = t.kd_gol and c.kd_kel = t.kd_kel
                        LEFT JOIN ref_subkel as d ON d.kd_bid = t.kd_bid and d.kd_gol = t.kd_gol and d.kd_kel = t.kd_kel and d.kd_skel = t.kd_skel
                        ORDER BY ur_gol,kd_bid,kd_kel,kd_skel, kd_sskel
                        ";
            }
            

            return $this->Get_By_Query($query);	
	}
}
?>