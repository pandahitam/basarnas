<?php
class Asset_Angkutan_Laut_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'asset_angkutan';
                $this->extTable = 'ext_asset_angkutan';
                $this->countTable = 'view_asset_angkutan_laut';
                $this->viewTable = 'view_asset_angkutan_laut';
//                $this->selectColumn = "SELECT t.kd_lokasi, t.kd_brg, t.no_aset, kuantitas, no_kib, merk, type, pabrik, thn_rakit, thn_buat, negara, muat, bobot, daya, 
//                            msn_gerak, jml_msn, bhn_bakar, no_mesin, no_rangka, no_polisi, no_bpkb, lengkap1, lengkap2, lengkap3, jns_trn, dari, tgl_prl, rph_aset, 
//                            dasar_hrg, sumber, no_dana, tgl_dana, unit_pmk, alm_pmk, catatan, kondisi, tgl_buku, rphwajar, status,
//                            b.id, b.kode_unor, b.image_url, b.document_url, 
//                            c.ur_upb as nama_unker, d.nama_unor,
//                            e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel
//                            ,f.nama as nama_klasifikasi_aset, b.kd_klasifikasi_aset,
//                            f.kd_lvl1,f.kd_lvl2,f.kd_lvl3,
//                            b.laut_stkk_no,b.laut_stkk_keterangan,b.laut_stkk_masa_berlaku,b.laut_stkk_file,
//                            b.laut_surat_ukur_no,b.laut_surat_ukur_keterangan,b.laut_surat_ukur_masa_berlaku,
//                            b.laut_sertifikasi_keselamatan_no,b.laut_sertifikasi_keselamatan_keterangan,b.laut_sertifikasi_keselamatan_masa_berlaku,b.laut_sertifikasi_keselamatan_file,
//                            b.laut_sertifikasi_radio_no,b.laut_sertifikasi_radio_keterangan,b.laut_sertifikasi_radio_masa_berlaku,b.laut_sertifikasi_radio_file,
//                            b.laut_surat_ijin_berlayar_no,b.laut_surat_ijin_berlayar_keterangan,b.laut_surat_ijin_berlayar_masa_berlaku,b.laut_surat_ijin_berlayar_file
//                            ";
                
                  $this->selectColumn = "SELECT kd_lokasi, kd_brg, no_aset, kuantitas, no_kib, merk, type, pabrik, thn_rakit, thn_buat, negara, muat, bobot, daya, 
                            msn_gerak, jml_msn, bhn_bakar, no_mesin, no_rangka, no_polisi, no_bpkb, lengkap1, lengkap2, lengkap3, jns_trn, dari, tgl_prl, rph_aset, 
                            dasar_hrg, sumber, no_dana, tgl_dana, unit_pmk, alm_pmk, catatan, kondisi, tgl_buku, rphwajar, status,
                            id, kode_unor, image_url, document_url, 
                            nama_unker, nama_unor,
                            kd_gol,kd_bid,kd_kelompok,kd_skel, kd_sskel
                            ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                            kd_lvl1,kd_lvl2,kd_lvl3,
                            laut_stkk_no,laut_stkk_keterangan,laut_stkk_masa_berlaku,laut_stkk_file,
                            laut_surat_ukur_no,laut_surat_ukur_keterangan,laut_surat_ukur_masa_berlaku,
                            laut_sertifikasi_keselamatan_no,laut_sertifikasi_keselamatan_keterangan,laut_sertifikasi_keselamatan_masa_berlaku,laut_sertifikasi_keselamatan_file,
                            laut_sertifikasi_radio_no,laut_sertifikasi_radio_keterangan,laut_sertifikasi_radio_masa_berlaku,laut_sertifikasi_radio_file,
                            laut_surat_ijin_berlayar_no,laut_surat_ijin_berlayar_keterangan,laut_surat_ijin_berlayar_masa_berlaku,laut_surat_ijin_berlayar_file
                            ";
	}
	
	function get_AllData($start=null, $limit=null, $searchTextFilter = null, $gridFilter = null){
                
//            if($start != null && $limit != null)
//            {
//                  $query = "$this->selectColumn from view_asset_angkutan_laut LIMIT $start, $limit";
//                  if($searchTextFilter != null)
//                  {
//                      $query = "$this->selectColumn from view_asset_angkutan_laut 
//                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchTextFilter'
//                                LIMIT $start, $limit";
//                  }
////                $query = "$this->selectColumn
////                            FROM $this->table AS t
////                            LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
////                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
////                            LEFT JOIN ref_unor AS d ON b.kode_unor = d.kode_unor
////                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
////                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
////                            where t.kd_brg like '30203%' or t.kd_brg like '30204%'
////                            LIMIT $start,$limit";
//		
//            }
//            else
//            {
//                  $query = "$this->selectColumn from view_asset_angkutan_laut";
//                  if($searchTextFilter != null)
//                  {
//                      $query = "$this->selectColumn from view_asset_angkutan_laut 
//                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchTextFilter'
//                                ";
//                  }
////                $query = "$this->selectColumn
////                            FROM $this->table AS t
////                            LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
////                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
////                            LEFT JOIN ref_unor AS d ON b.kode_unor = d.kode_unor
////                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
////                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
////                            where t.kd_brg like '30203%' or t.kd_brg like '30204%'
////                            ";
//            }
//            
//            return $this->Get_By_Query($query);
            
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
        
        function getSpecificPerlengkapanAngkutanLaut($id_ext_asset)
        {
            if($_POST['open'] == 1)
            {
                $query = "select id,id_ext_asset,jenis_perlengkapan,no,nama,keterangan 
                        FROM ext_asset_angkutan_laut_perlengkapan WHERE id_ext_asset = $id_ext_asset";
//                return $this->Get_By_Query($query);
                $r = $this->db->query($query);
                 $data = array();
                if ($r->num_rows() > 0)
		{
		    foreach ($r->result() as $obj)
		    {
			$data[] = $obj;
		    }  
		}
                return $data;
            }
        }
	
	function get_byIDs($ids)
	{		
		$query = 'SELECT id, kd_lokasi, kd_brg, no_aset, kuantitas, no_kib, merk, type, pabrik, thn_rakit, thn_buat, negara, muat, bobot, daya, 
						msn_gerak, jml_msn, bhn_bakar, no_mesin, no_rangka, no_polisi, no_bpkb, lengkap1, lengkap2, lengkap3, jns_trn, dari, tgl_prl, rph_aset, 
						dasar_hrg, sumber, no_dana, tgl_dana, unit_pmk, alm_pmk, catatan, kondisi, tgl_buku, rphwajar, status, cad1
				  FROM '.$this->table.'
				  WHERE id IN ('.$this->prepare_Query($ids).')
				  ORDER BY kd_lokasi ASC';
		return $this->Get_By_Query($query);
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
                        FROM $this->table AS t
                            LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor AS d ON b.kode_unor = d.kode_unor
                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                            LEFT JOIN ext_asset_angkutan_laut AS g ON b.id = g.id_ext_angkutan
                            
									 
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