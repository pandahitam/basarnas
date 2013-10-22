<?php
class Asset_Angkutan_Udara_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'asset_angkutan';
                $this->extTable = 'ext_asset_angkutan';
                $this->countTable = 'view_asset_angkutan_udara';
                $this->viewTable = 'view_asset_angkutan_udara';
//                $this->selectColumn = "SELECT t.kd_lokasi, t.kd_brg, t.no_aset, kuantitas, no_kib, merk, type, pabrik, thn_rakit, thn_buat, negara, muat, bobot, daya, 
//                            msn_gerak, jml_msn, bhn_bakar, no_mesin, no_rangka, no_polisi, no_bpkb, lengkap1, lengkap2, lengkap3, jns_trn, dari, tgl_prl, rph_aset, 
//                            dasar_hrg, sumber, no_dana, tgl_dana, unit_pmk, alm_pmk, catatan, kondisi, tgl_buku, rphwajar, status,
//                            b.id, b.kode_unor, b.image_url, b.document_url, 
//                            c.ur_upb as nama_unker, d.nama_unor,
//                            e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel
//                            ,f.nama as nama_klasifikasi_aset, b.kd_klasifikasi_aset,
//                            f.kd_lvl1,f.kd_lvl2,f.kd_lvl3,
//                            b.udara_surat_bukti_kepemilikan_no,b.udara_surat_bukti_kepemilikan_keterangan,b.udara_surat_bukti_kepemilikan_file,
//                            b.udara_sertifikat_pendaftaran_pesawat_udara_no,b.udara_sertifikat_pendaftaran_pesawat_udara_keterangan,b.udara_sertifikat_pendaftaran_pesawat_udara_masa_berlaku,b.udara_sertifikat_pendaftaran_pesawat_udara_file,
//                            b.udara_sertifikat_kelaikan_udara_no,b.udara_sertifikat_kelaikan_udara_keterangan,b.udara_sertifikat_kelaikan_udara_masa_berlaku,b.udara_sertifikat_kelaikan_udara_file
//                            ";
                
                 $this->selectColumn = "SELECT kd_lokasi, kd_brg, no_aset, kuantitas, no_kib, merk, type, pabrik, thn_rakit, thn_buat, negara, muat, bobot, daya, 
                            msn_gerak, jml_msn, bhn_bakar, no_mesin, no_rangka, no_polisi, no_bpkb, lengkap1, lengkap2, lengkap3, jns_trn, dari, tgl_prl, rph_aset, 
                            dasar_hrg, sumber, no_dana, tgl_dana, unit_pmk, alm_pmk, catatan, kondisi, tgl_buku, rphwajar, status,
                            id, kode_unor, image_url, document_url, 
                            nama_unker, nama_unor,
                            kd_gol,kd_bid,kd_kelompok,kd_skel, kd_sskel, ur_sskel
                            ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                            kd_lvl1,kd_lvl2,kd_lvl3,
                            udara_surat_bukti_kepemilikan_no,udara_surat_bukti_kepemilikan_keterangan,udara_surat_bukti_kepemilikan_file,
                            udara_sertifikat_pendaftaran_pesawat_udara_no,udara_sertifikat_pendaftaran_pesawat_udara_keterangan,udara_sertifikat_pendaftaran_pesawat_udara_masa_berlaku,udara_sertifikat_pendaftaran_pesawat_udara_file,
                            udara_sertifikat_kelaikan_udara_no,udara_sertifikat_kelaikan_udara_keterangan,udara_sertifikat_kelaikan_udara_masa_berlaku,udara_sertifikat_kelaikan_udara_file
                            ";
	}
	
	function get_AllData($start=null, $limit=null, $searchByBarcode=null, $gridFilter = null, $searchByField = null){
                
//            if($start != null && $limit != null)
//            {
//                $query = "$this->selectColumn FROM view_asset_angkutan_udara LIMIT $start,$limit";
//                if($searchByBarcode != null)
//                {
//                    $query = "$this->selectColumn FROM view_asset_angkutan_udara 
//                               where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode' 
//                                LIMIT $start,$limit";
//                }
////                $query = "$this->selectColumn
////                            FROM $this->table AS t
////                            LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
////                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
////                            LEFT JOIN ref_unor AS d ON b.kode_unor = d.kode_unor
////                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
////                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
////                            where t.kd_brg like '30205%'
////                            LIMIT $start,$limit";
//                
//		
//            }
//            else
//            {
//                $query = "$this->selectColumn FROM view_asset_angkutan_udara";
////                $query = "$this->selectColumn
////                            FROM $this->table AS t
////                            LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
////                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
////                            LEFT JOIN ref_unor AS d ON b.kode_unor = d.kode_unor
////                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
////                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
////                            where t.kd_brg like '30205%'
////                            ";
//                if($searchByBarcode != null)
//                {
//                    $query = "$this->selectColumn FROM view_asset_angkutan_udara 
//                               where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode' 
//                               ";
//                }
//            }
//            
//            return $this->Get_By_Query($query);
            
            $isGridFilter = false;
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn
                                FROM $this->viewTable
                                LIMIT $start, $limit";
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
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                nama_klasifikasi_aset like '%$searchByField%' OR
                                merk like '%$searchByField%' OR
                                type like '%$searchByField%'
                                LIMIT $start, $limit
                                ";
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
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                nama_klasifikasi_aset like '%$searchByField%' OR
                                merk like '%$searchByField%' OR
                                type like '%$searchByField%'
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
                return $this->Get_By_Query($query,false,'view_asset_angkutan_udara');	
            }
            else
            {
                return $this->Get_By_Query($query);	
            }	
			
	}
        
        function getSpecificPerlengkapanAngkutanUdara($id_ext_asset)
        {
            if($_POST['open'] == 1)
            {
                $query = "select id,id_ext_asset,id_asset_perlengkapan,jenis_perlengkapan,no,nama,keterangan
                        FROM ext_asset_angkutan_udara_perlengkapan WHERE id_ext_asset = $id_ext_asset";
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
	
   function getPerlengkapan_for_print($id_ext_asset) {
                $query = "select id,id_ext_asset,jenis_perlengkapan,no,nama,keterangan 
                        FROM ext_asset_angkutan_udara_perlengkapan WHERE id_ext_asset = $id_ext_asset";
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
//                return $this->Get_By_Query($query);
        }
	
   function getPenggunaan_for_print($id_ext_asset) {
                $query = "SELECT * FROM ext_asset_angkutan_detail_penggunaan WHERE id_ext_asset = $id_ext_asset";
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
//                return $this->Get_By_Query($query);
        }
   
	function get_SelectedDataPrint($ids){
		$dataasset = array();
		$idx = array();
		$idx = explode("||", urldecode($ids));
		$q = "$this->selectColumn from $this->viewTable as t WHERE t.kd_lokasi = '".$idx[0]."' and t.kd_brg = '".$idx[1]."' and t.no_aset = '".$idx[2]."'";
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