<?php
class Inventory_Penerimaan_Pemeriksaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'inventory_penerimaan_pemeriksaan';
                $this->extTable = 'inventory_penerimaan_pemeriksaan';
                $this->selectColumn = "SELECT t.id,t.tgl_berita_acara,t.nomor_berita_acara,t.kd_lokasi,t.id_pengadaan,t.nama_org,
                                        t.no_aset,t.date_created,
                                        t.keterangan, t.status_barang,t.qty,t.tgl_penerimaan,
                                        c.ur_upb as nama_unker,
                                        d.nama_unor, t.kode_unor";
                                        }
	
	function get_AllData($start=null, $limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){
                
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
                            nama_org like '%$searchByField%' OR
                            kd_lokasi like '%$searchByField%' OR
                            pic like '%$searchByField%' OR
                            nama_operasi like '%$searchByField%' OR
                            nama like '%$searchByField%' OR
                            deskripsi like '%$searchByField%'
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
                                    kd_brg like '%$searchByField%' OR
                                    kd_lokasi like '%$searchByField%' OR
                                    pic like '%$searchByField%' OR
                                    nama_operasi like '%$searchByField%' OR
                                    nama like '%$searchByField%' OR
                                    deskripsi like '%$searchByField%'
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
                    return $this->Get_By_Query($query,false,'inventory_penerimaan_pemeriksaan');	
                }
                else
                {
                    return $this->Get_By_Query($query);	
                }	
			
	}
	
	function get_InventoryPenerimaanPemeriksaan($id)
	{		
            $this->db->from($this->table);
            $this->db->where('id',$id);
            $query = $this->db->get();
            return $query->row();
	}
}
?>