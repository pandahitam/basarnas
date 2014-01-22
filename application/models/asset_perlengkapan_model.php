<?php
class Asset_Perlengkapan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'asset_perlengkapan';
//                $this->extTable = "ext_asset_perlengkapan";
                $this->viewTable = 'view_asset_perlengkapan';
                
//                $this->selectColumn = "SELECT t.id,t.warehouse_id,t.ruang_id,t.rak_id,
//                            t.serial_number, t.part_number,t.kd_brg,t.kd_lokasi,
//                            t.no_aset,t.kondisi, t.kuantitas, t.dari,
//                            t.tanggal_perolehan,t.no_dana,t.penggunaan_waktu,
//                            t.penggunaan_freq,t.unit_waktu,t.unit_freq,t.disimpan, 
//                            t.dihapus,t.image_url,t.document_url,t.kode_unor
//                            ,f.nama as nama_klasifikasi_aset, t.kd_klasifikasi_aset,
//                            f.kd_lvl1,f.kd_lvl2,f.kd_lvl3";
//                
//                $this->selectColumn = "SELECT id,warehouse_id,ruang_id,rak_id,nama_warehouse,nama_rak,nama_ruang,no_induk_asset,
//                            serial_number, part_number,kd_brg,kd_lokasi,nama_unker,nama_unor,
//                            no_aset,kondisi, kuantitas, dari,
//                            tanggal_perolehan,no_dana,penggunaan_waktu,
//                            penggunaan_freq,unit_waktu,unit_freq,disimpan, 
//                            dihapus,image_url,document_url,kode_unor
//                            ,nama_klasifikasi_aset, kd_klasifikasi_aset,
//                            kd_lvl1,kd_lvl2,kd_lvl3,id_pengadaan,nama_part,umur,jenis_asset,nama_kelompok,alert";
                
                $this->selectColumn = "Select *";
        }
                
	
	function get_AllData($start=null,$limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){
//		$query = "$this->selectColumn
//                            FROM $this->table AS t
//                            LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
//                            LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                            LIMIT 0,$this->limit";
//            if($start != null && $limit != null)
//            {
//                $query = "$this->selectColumn
//                            FROM $this->table as t
//                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
//                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                            LIMIT $start,$limit";
//                
//                if($searchByBarcode != null)
//                {
//                    $query = "$this->selectColumn
//                            FROM $this->table as t
//                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
//                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                             where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchByBarcode'
//                            LIMIT $start,$limit";
//                }
//            }
//            else
//            {
//                $query = "$this->selectColumn
//                            FROM $this->table as t
//                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
//                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                            ";
//                
//                if($searchByBarcode != null)
//                {
//                    $query = "$this->selectColumn
//                            FROM $this->table as t
//                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
//                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                             where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchByBarcode'
//                            ";
//                }
//                
//            }
            $isGridFilter = false;
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn
                            FROM $this->viewTable 
                            LIMIT $start,$limit";
                
                if($searchByBarcode != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->viewTable
                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
                                LIMIT $start, $limit";
                }
                else if($searchByField != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->viewTable
                                where
                                kd_brg like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
                                serial_number like '%$searchByField%' OR
                                part_number like '%$searchByField%' OR
                                nama_klasifikasi_aset like '%$searchByField%'
                                LIMIT $start, $limit";
                }
                else if($gridFilter != null)
                {
                    $query = "$this->selectColumn
                               FROM $this->viewTable
                               where $gridFilter
                               LIMIT $start, $limit
                                ";
                    $isGridFilter = true;
                }
            }
            else
            {
                $query = "$this->selectColumn
                            FROM $this->viewTable
                            ";
                
               if($searchByBarcode != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->viewTable
                               where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
                                ";
                }
                else if($searchByField != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->viewTable
                                where
                                kd_brg like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
                                serial_number like '%$searchByField%' OR
                                part_number like '%$searchByField%' OR
                                nama_klasifikasi_aset like '%$searchByField%'
                                ";
                }
                else if($gridFilter != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->viewTable
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
                return $this->Get_By_Query($query,false,'view_asset_perlengkapan');	
            }
            else
            {
                return $this->Get_By_Query($query);	
            }
	}
	
        function deleteData($id)
        {
                $this->db->where('id', $id);
		$this->db->delete($this->table);
                return true;
        }
        
        function get_Perlengkapan($id)
	{		
            $this->db->from($this->table);
            $this->db->where('id',$id);
            $query = $this->db->get();
            return $query->row();
	}
	
        function get_partNumberDetails($part_number)
        {
            $this->db->where('part_number',"$part_number");
            $query = $this->db->get('ref_perlengkapan');
            return $query->row();
        }
	
	function ConstructKode($kode_golongan = NULL,$kode_asset = NULL){
		$kode = NULL;
		if ($kode_golongan != NULL && $kode_asset != NULL)
		{
			$kode = '2' . $kode_golongan . $kode_asset;
		}	
		return $kode;
	}
	
	function get_SelectedDataPrint($ids){
		$dataasset = array();
		$idx = array();
		$idx = explode("||", urldecode($ids));
		$q = "$this->selectColumn FROM $this->viewTable as t WHERE t.kd_lokasi = '".$idx[0]."' and t.kd_brg = '".$idx[1]."' and t.no_aset = '".$idx[2]."'";
		$query = $this->db->query($q);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$dataasset[] = $row;
			}
		}
	
		$data = array('dataasset' => $dataasset );
		return $data;
	}
}
?>