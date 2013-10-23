<?php
class Inventory_Pengeluaran_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'inventory_pengeluaran';
                $this->selectColumn = "SELECT t.id,t.tgl_berita_acara,t.nomor_berita_acara,t.kd_lokasi,
                                        t.date_created,t.nama_org,
                                        t.keterangan,t.tgl_pengeluaran,
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
                    return $this->Get_By_Query($query,false,'inventory_pengeluaran');	
                }
                else
                {
                    return $this->Get_By_Query($query);	
                }	
        }
	
	function get_byIDs($ids)
	{		
//		$query = 'SELECT id, kd_lokasi, kd_brg, no_aset, kuantitas, no_kib, merk, type, pabrik, thn_rakit, thn_buat, negara, muat, bobot, daya, 
//						msn_gerak, jml_msn, bhn_bakar, no_mesin, no_rangka, no_polisi, no_bpkb, lengkap1, lengkap2, lengkap3, jns_trn, dari, tgl_prl, rph_aset, 
//						dasar_hrg, sumber, no_dana, tgl_dana, unit_pmk, alm_pmk, catatan, kondisi, tgl_buku, rphwajar, status, cad1
//				  FROM '.$this->table.'
//				  WHERE id IN ('.$this->prepare_Query($ids).')
//				  ORDER BY kd_lokasi ASC';
//		return $this->Get_By_Query($query);
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