<?php
class Inventory_Penyimpanan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'inventory_penyimpanan';
                $this->extTable = 'inventory_penyimpanan';
                $this->selectColumn = "SELECT t.id,t.tgl_berita_acara,t.nomor_berita_acara,t.kd_lokasi,t.nama_org,t.id_penerimaan_pemeriksaan,
                                        t.date_created,
                                        t.keterangan,t.tgl_penyimpanan,
                                        c.ur_upb as nama_unker,
                                        d.nama_unor, t.kode_unor";
                                        }
	
	function get_AllData($start=null, $limit=null, $searchTextFilter = null){
                
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            LIMIT $start,$limit";
                
                if($searchTextFilter != null)
                {
                    $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
                            LIMIT $start,$limit";
                }
		
            }
            else
            {
                $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            ";
                
                if($searchTextFilter != null)
                {
                    $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
                            ";
                }
            }
            
            return $this->Get_By_Query($query);
			
	}
	
        function get_InventoryPenyimpanan($id)
	{		
            $this->db->from($this->table);
            $this->db->where('id',$id);
            $query = $this->db->get();
            return $query->row();
	}
	
	
//	function ConstructKode($kode_golongan = NULL,$kode_asset = NULL){
//		$kode = NULL;
//		if ($kode_golongan != NULL && $kode_asset != NULL)
//		{
//			$kode = '2' . $kode_golongan . $kode_asset;
//		}	
//		return $kode;
//	}
}
?>