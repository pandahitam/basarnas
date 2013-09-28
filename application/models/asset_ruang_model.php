<?php
class Asset_Ruang_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'asset_ruang';
                $this->extTable = 'ext_asset_ruang';
                $this->viewTable = 'view_asset_ruang';
                
//                $this->selectColumn = "SELECT t.kd_lokasi, t.kd_brg, t.no_aset, t.kd_pemilik, t.kd_ruang, a.id, a.kode_unor, a.image_url, a.document_url,
//                                        b.ur_upb as nama_unker, c.nama_unor, d.ur_ruang as ruang, d.pj_ruang as pejabat_ruang, d.nip_pjrug, e.ur_sskel,
//                                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel
//                                        ,f.nama as nama_klasifikasi_aset, a.kd_klasifikasi_aset,
//                                        f.kd_lvl1,f.kd_lvl2,f.kd_lvl3";
                
                $this->selectColumn = "SELECT kd_lokasi, kd_brg, no_aset, kd_pemilik, kd_ruang, id, kode_unor, image_url, document_url,
                        nama_unker, nama_unor, ruang, pejabat_ruang, nip_pjrug, ur_sskel,
                        kd_gol,kd_bid,kd_kelompok,kd_skel, kd_sskel
                        ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                        kd_lvl1,kd_lvl2,kd_lvl3";
	}
	
	function get_AllData($start=null,$limit=null, $searchTextFilter = null, $gridFilter=null){
            
//                if($start !=null && $limit != null)
//                {
//                    $query = "$this->selectColumn
//                        FROM $this->table as t 
//                        LEFT JOIN $this->extTable as a ON t.kd_lokasi = a.kd_lokasi AND t.kd_brg = a.kd_brg AND t.no_aset = a.no_aset
//                        LEFT JOIN ref_unker AS b ON t.kd_lokasi = b.kdlok
//                        LEFT JOIN ref_unor AS c ON a.kode_unor = c.kode_unor
//                        LEFT JOIN ref_ruang as d ON t.kd_lokasi = d.kd_lokasi AND t.kd_ruang = d.kd_ruang
//                        LEFT JOIN ref_subsubkel as e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON a.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        LIMIT $start,$limit";
//                    
//                    if($searchTextFilter != null)
//                    {
//                        $query = "$this->selectColumn
//                        FROM $this->table as t 
//                        LEFT JOIN $this->extTable as a ON t.kd_lokasi = a.kd_lokasi AND t.kd_brg = a.kd_brg AND t.no_aset = a.no_aset
//                        LEFT JOIN ref_unker AS b ON t.kd_lokasi = b.kdlok
//                        LEFT JOIN ref_unor AS c ON a.kode_unor = c.kode_unor
//                        LEFT JOIN ref_ruang as d ON t.kd_lokasi = d.kd_lokasi AND t.kd_ruang = d.kd_ruang
//                        LEFT JOIN ref_subsubkel as e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON a.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                         where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
//                        LIMIT $start,$limit";
//                    }
//                }
//                else
//                {
//                    $query = "$this->selectColumn
//                        FROM $this->table as t 
//                        LEFT JOIN $this->extTable as a ON t.kd_lokasi = a.kd_lokasi AND t.kd_brg = a.kd_brg AND t.no_aset = a.no_aset
//                        LEFT JOIN ref_unker AS b ON t.kd_lokasi = b.kdlok
//                        LEFT JOIN ref_unor AS c ON a.kode_unor = c.kode_unor
//                        LEFT JOIN ref_ruang as d ON t.kd_lokasi = d.kd_lokasi AND t.kd_ruang = d.kd_ruang
//                        LEFT JOIN ref_subsubkel as e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON a.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        ";
//                    
//                    if($searchTextFilter != null)
//                    {
//                        $query = "$this->selectColumn
//                        FROM $this->table as t 
//                        LEFT JOIN $this->extTable as a ON t.kd_lokasi = a.kd_lokasi AND t.kd_brg = a.kd_brg AND t.no_aset = a.no_aset
//                        LEFT JOIN ref_unker AS b ON t.kd_lokasi = b.kdlok
//                        LEFT JOIN ref_unor AS c ON a.kode_unor = c.kode_unor
//                        LEFT JOIN ref_ruang as d ON t.kd_lokasi = d.kd_lokasi AND t.kd_ruang = d.kd_ruang
//                        LEFT JOIN ref_subsubkel as e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON a.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                         where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
//                        ";
//                    }
//                }
//		
//                
//                return $this->Get_By_Query($query);	
            
            $isGridFilter = false;
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn
                                FROM $this->viewTable
                                LIMIT $start, $limit";
                if($searchTextFilter != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->viewTable
                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchTextFilter'
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

                if($searchTextFilter != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->viewTable
                               where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchTextFilter'
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
            else
            {
                return $this->Get_By_Query($query);	
            }
	}
        
        function get_ExtAllData($kd_lokasi,$kd_brg,$no_aset){

        }
	
	function get_byIDs($ids)
	{		
		
	}
	
	function get_SelectedDataPrint($ids){
		$dataasset = array();
		$idx = array();
		$idx = explode("||", urldecode($ids));
		
		$q = "$this->selectColumn
                        FROM $this->table as t 
                        LEFT JOIN $this->extTable as a ON t.kd_lokasi = a.kd_lokasi AND t.kd_brg = a.kd_brg AND t.no_aset = a.no_aset
                        LEFT JOIN ref_unker AS b ON t.kd_lokasi = b.kdlok
                        LEFT JOIN ref_unor AS c ON a.kode_unor = c.kode_unor
                        LEFT JOIN ref_ruang as d ON t.kd_lokasi = d.kd_lokasi AND t.kd_ruang = d.kd_ruang
                        LEFT JOIN ref_subsubkel as e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON a.kd_klasifikasi_aset = f.kd_klasifikasi_aset
								
								WHERE t.kd_lokasi = '".$idx[0]."' and t.kd_brg = '".$idx[1]."' and t.no_aset = '".$idx[2]."'
                        ";
		$query = $this->db->query($q);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$dataasset[] = $row;
			}
		}
		return $dataasset;
	}
}
?>