<?php
class Pemeliharaan_Part_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pemeliharaan_part';
                $this->table = 'pemeliharaan_part';
//                $this->countTable = 'pemeliharaan_part';
                
                $this->selectColumn = "SELECT t.id, t.id_pemeliharaan, t.id_penyimpanan, t.qty_pemeliharaan,
                            c.part_number,c.nama";
	}
	
	function get_AllData($start=null, $limit=null){
////		$query = "$this->selectColumn FROM $this->viewTable
////                        where kd_brg NOT LIKE '4%'
////                        AND kd_brg NOT LIKE '2%'
////                        AND kd_brg NOT LIKE '30205%'
////                        AND kd_brg NOT LIKE '30203%' AND kd_brg NOT LIKE '30204%'
////                        AND kd_brg NOT LIKE '30201%' AND kd_brg NOT LIKE '30202%'";
//            
//            if($start !=null && $limit != null)
//            {
//                  $query = "$this->selectColumn FROM view_pemeliharaan_lainnya LIMIT $start, $limit";
//            }
//            else
//            {
//                 $query = "$this->selectColumn FROM view_pemeliharaan_lainnya";
//            }
//            
//		return $this->Get_By_Query($query);	
	}
	
	function get_PemeliharaanPart($id_pemeliharaan)
	{
//		$query = "$this->selectColumn FROM $this->table as t 
//                            LEFT JOIN inventory_penyimpanan as a on a.id = t.id_penyimpanan
//                            LEFT JOIN inventory_penyimpanan_data_perlengkapan as b on a.id = b.id_source
//                            LEFT JOIN ref_perlengkapan as c on c.part_number = b.part_number
//                            where t.id_pemeliharaan = '$id_pemeliharaan'";
//		
//                return $this->Get_By_Query($query);
	}
	
}
?>
