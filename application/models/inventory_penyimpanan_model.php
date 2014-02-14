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
	
	function get_AllData($start=null, $limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){
            
            $isGridFilter = false;
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            LIMIT $start,$limit";
                
                if($searchByBarcode != null)
                {
                    $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchByBarcode'
                            LIMIT $start,$limit";
                }
                else if($searchByField != null)
                {
                    $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor AS d ON t.kode_unor = d.kode_unor
                            where
                            t.nama_org like '%$searchByField%' OR
                            t.kd_lokasi like '%$searchByField%' OR
                            t.pic like '%$searchByField%' OR
                            t.keterangan like '%$searchByField%' OR
                            t.asal_barang like '%$searchByField%'
                            LIMIT $start, $limit";
                }
                 else if($gridFilter != null)
                {
                    $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor AS d ON t.kode_unor = d.kode_unor
                               where $gridFilter
                               LIMIT $start, $limit
                                ";
                    $isGridFilter = true;
                }
              
		
            }
            else
            {
                $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor AS d ON t.kode_unor = d.kode_unor
                            ";
                
                if($searchByBarcode != null)
                {
                    $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchByBarcode'
                            ";
                }
                 else if($searchByField != null)
                    {
                        $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor AS d ON t.kode_unor = d.kode_unor
                            where
                            t.nama_org like '%$searchByField%' OR
                            t.kd_lokasi like '%$searchByField%' OR
                            t.pic like '%$searchByField%' OR
                            t.keterangan like '%$searchByField%' OR
                            t.asal_barang like '%$searchByField%'
                                    ";
                    }
                    else if($gridFilter != null)
                    {
                        $query = "$this->selectColumn FROM $this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor AS d ON t.kode_unor = d.kode_unor
                                   where $gridFilter
                                    ";
                        $isGridFilter = true;
                    }
            
               
			
	}
        
             if($isGridFilter == true)
                {
                    return $this->Get_By_Query($query,true);	
                }
                else if($searchByField != null)
                {
                     
                    return $this->Get_By_Query($query,false,'inventory_penyimpanan');	
                }
                else
                {
                    
                    return $this->Get_By_Query($query);	
                }	
        }
	
        function get_InventoryPenyimpanan($id)
	{		
            $this->db->from('inventory_penyimpanan_data_perlengkapan');
            $this->db->where('id',$id);
            $query = $this->db->get();
            return $query->row();
	}
        
        function get_InventoryPenyimpananSubPart($id)
	{
            $query = $this->db->query("select t.*, b.id_part
                     FROM inventory_penyimpanan_data_perlengkapan_sub_part as t
                     LEFT JOIN ref_sub_part as b on t.part_number = b.part_number
                     where t.id=$id");
//            $this->db->from('inventory_penyimpanan_data_perlengkapan_sub_part');
//            $this->db->where('id',$id);
//            $query = $this->db->get();
            return $query->row();
	}
        
        function get_InventoryPenyimpananSubSubPart($id)
	{		
            $query = $this->db->query("select t.*, b.id_part, c.id_sub_part
                     FROM inventory_penyimpanan_data_perlengkapan_sub_sub_part as t
                     LEFT JOIN ref_sub_sub_part as c on t.part_number = c.part_number
                     LEFT JOIN ref_sub_part as b on c.id_sub_part = b.id
                     where t.id = $id");
//            $this->db->from('inventory_penyimpanan_data_perlengkapan_sub_sub_part');
//            $this->db->where('id',$id);
//            $query = $this->db->get();
            return $query->row();
	}
        
        function checkServerQuantity($id_penyimpanan_perlengkapan, $qty_keluar, $id_penyimpanan)
        {
            $this->db->where('id',$id_penyimpanan_perlengkapan);
            $query_perlengkapan = $this->db->get('inventory_penyimpanan_data_perlengkapan');
            if($query_perlengkapan->num_rows == 1)
            {
                $result_perlengkapan = $query_perlengkapan->row();
                if(($result_perlengkapan->qty - $qty_keluar) >= 0 )
                {
                    return true;
                }
                else
                {
                    
                    $this->db->where('id',$id_penyimpanan);
                    $query_penyimpanan = $this->db->get('inventory_penyimpanan');
                    if($query_penyimpanan->num_rows == 1)
                    {
                        
                        $result_penyimpanan = $query_penyimpanan->row();
                        $data_failed = array(
                            'nomor_berita_acara'=>$result_penyimpanan->nomor_berita_acara,
                            'part_number'=>$result_perlengkapan->part_number
                        );
                        
                        return $data_failed;
                    }
                    else
                    {
                        return false;
                    }
                    
                    
                }
            }
            else
            {
                return false;
            }
            
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