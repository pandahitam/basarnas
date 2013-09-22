<?php
class Asset_Perlengkapan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'asset_perlengkapan';
//                $this->extTable = "ext_asset_perlengkapan";
                
                $this->selectColumn = "SELECT t.id,t.warehouse_id,t.ruang_id,t.rak_id,
                            t.serial_number, t.part_number,t.kd_brg,t.kd_lokasi,
                            t.no_aset,t.kondisi, t.kuantitas, t.dari,
                            t.tanggal_perolehan,t.no_dana,t.penggunaan_waktu,
                            t.penggunaan_freq,t.unit_waktu,t.unit_freq,t.disimpan, 
                            t.dihapus,t.image_url,t.document_url,t.kode_unor
                            ,f.nama as nama_klasifikasi_aset, t.kd_klasifikasi_aset,
                            f.kd_lvl1,f.kd_lvl2,f.kd_lvl3";
                            }
	
	function get_AllData($start=null,$limit=null, $searchTextFilter = null){
//		$query = "$this->selectColumn
//                            FROM $this->table AS t
//                            LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
//                            LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                            LIMIT 0,$this->limit";
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn
                            FROM $this->table as t
                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                            LIMIT $start,$limit";
                
                if($searchTextFilter != null)
                {
                    $query = "$this->selectColumn
                            FROM $this->table as t
                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                             where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
                            LIMIT $start,$limit";
                }
            }
            else
            {
                $query = "$this->selectColumn
                            FROM $this->table as t
                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                            ";
                
                if($searchTextFilter != null)
                {
                    $query = "$this->selectColumn
                            FROM $this->table as t
                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                             where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
                            ";
                }
                
            }
            

		return $this->Get_By_Query($query);	
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
		$q = "$this->selectColumn
                         FROM $this->table as t
                            LEFT JOIN ref_unker c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
								
								WHERE t.kd_lokasi = '".$idx[0]."' and t.kd_brg = '".$idx[1]."' and t.no_aset = '".$idx[2]."'
                        ";
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