<?php
class Asset_Angkutan_Darat_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'asset_angkutan';
                $this->extTable = 'ext_asset_angkutan';
                $this->countTable = 'view_asset_angkutan_darat';
                $this->viewTable = 'view_asset_angkutan_darat';
//                $this->selectColumn = "SELECT t.kd_lokasi, t.kd_brg, t.no_aset, kuantitas, no_kib, merk, type, pabrik, thn_rakit, thn_buat, negara, muat, bobot, daya, 
//                            msn_gerak, jml_msn, bhn_bakar, no_mesin, no_rangka, no_polisi, no_bpkb, lengkap1, lengkap2, lengkap3, jns_trn, dari, tgl_prl, rph_aset, 
//                            dasar_hrg, sumber, no_dana, tgl_dana, unit_pmk, alm_pmk, catatan, kondisi, tgl_buku, rphwajar, status,
//                            b.id, b.kode_unor, b.image_url, b.document_url, 
//                            c.ur_upb as nama_unker, d.nama_unor,
//                            e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel
//                            ,f.nama as nama_klasifikasi_aset, b.kd_klasifikasi_aset,
//                            f.kd_lvl1,f.kd_lvl2,f.kd_lvl3,
//                            b.darat_no_stnk,b.darat_masa_berlaku_stnk,b.darat_masa_berlaku_pajak,
//                            b.darat_jumlah_pajak, b.darat_keterangan_lainnya";
                
                  $this->selectColumn = "SELECT kd_lokasi, kd_brg, no_aset, kuantitas, no_kib, merk, type, pabrik, thn_rakit, thn_buat, negara, muat, bobot, daya, 
                            msn_gerak, jml_msn, bhn_bakar, no_mesin, no_rangka, no_polisi, no_bpkb, lengkap1, lengkap2, lengkap3, jns_trn, dari, tgl_prl, rph_aset, 
                            dasar_hrg, sumber, no_dana, tgl_dana, unit_pmk, alm_pmk, catatan, kondisi, tgl_buku, rphwajar, status,
                            id, kode_unor, image_url, document_url, 
                            nama_unker, nama_unor,
                            kd_gol,kd_bid,kd_kelompok,kd_skel, kd_sskel,ur_sskel
                            ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                            kd_lvl1,kd_lvl2,kd_lvl3,
                            darat_no_stnk,darat_masa_berlaku_stnk,darat_masa_berlaku_pajak,
                            darat_jumlah_pajak, darat_keterangan_lainnya";
	}
	
	function get_AllData($start=null, $limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){
                
//            if($start != null && $limit != null)
//            {
//                $query = "$this->selectColumn from view_asset_angkutan_darat LIMIT $start,$limit";
//                if($searchByBarcode != null)
//                {
//                    $query = "$this->selectColumn from view_asset_angkutan_darat
//                            where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
//                            LIMIT $start,$limit";
//                }
////                $query = "$this->selectColumn
////                            FROM $this->table AS t
////                            LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
////                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
////                            LEFT JOIN ref_unor AS d ON b.kode_unor = d.kode_unor
////                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
////                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
////                            where t.kd_brg like '30201%' or t.kd_brg like '30202%'
////                            LIMIT $start,$limit";
//		
//            }
//            else
//            {
//                  $query = "$this->selectColumn from view_asset_angkutan_darat";
//                  if($searchByBarcode != null)
//                  {
//                        $query = "$this->selectColumn from view_asset_angkutan_darat
//                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
//                                ";
//                  }
////                $query = "$this->selectColumn
////                            FROM $this->table AS t
////                            LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
////                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
////                            LEFT JOIN ref_unor AS d ON b.kode_unor = d.kode_unor
////                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
////                            LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
////                            where t.kd_brg like '30201%' or t.kd_brg like '30202%'
////                            ";
//            }
//            
//            return $this->Get_By_Query($query);
            
            
            
//            $isGridFilter = false;
//            if($start != null && $limit != null)
//            {
//                $query = "$this->selectColumn
//                                FROM $this->viewTable
//                                LIMIT $start, $limit";
//                if($searchByBarcode != null)
//                {
//                    $query = "$this->selectColumn
//                                FROM $this->viewTable
//                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
//                                LIMIT $start, $limit";
//                }
//                else if($searchByField != null)
//                {
//                    $query = "$this->selectColumn
//                                FROM $this->viewTable
//                                where
//                                kd_brg like '%$searchByField%' OR
//                                kd_lokasi like '%$searchByField%' OR
//                                nama_unker like '%$searchByField%' OR
//                                nama_unor like '%$searchByField%' OR
//                                nama_klasifikasi_aset like '%$searchByField%' OR
//                                merk like '%$searchByField%' OR
//                                type like '%$searchByField%'
//                                LIMIT $start, $limit
//                                ";
//                }
//                else if($gridFilter != null)
//                {
//                    $query = "$this->selectColumn
//                               FROM $this->viewTable
//                               where $gridFilter
//                               LIMIT $start, $limit
//                                ";
//                    $isGridFilter = true;
//                }
//            }
//            else
//            {
//                $query = "$this->selectColumn
//                                 FROM $this->viewTable
//                                ";
//
//                if($searchByBarcode != null)
//                {
//                    $query = "$this->selectColumn
//                                FROM $this->viewTable
//                               where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
//                                ";
//                }
//                else if($searchByField != null)
//                {
//                    $query = "$this->selectColumn
//                                FROM $this->viewTable
//                                where
//                                kd_brg like '%$searchByField%' OR
//                                kd_lokasi like '%$searchByField%' OR
//                                nama_unker like '%$searchByField%' OR
//                                nama_unor like '%$searchByField%' OR
//                                nama_klasifikasi_aset like '%$searchByField%' OR
//                                merk like '%$searchByField%' OR
//                                type like '%$searchByField%'
//                                ";
//                }
//                else if($gridFilter != null)
//                {
//                    $query = "$this->selectColumn
//                                FROM $this->viewTable
//                               where $gridFilter
//                                ";
//                    $isGridFilter = true;
//                }
//            }
//
//            if($isGridFilter == true)
//            {
//                return $this->Get_By_Query($query,true);	
//            }
//            else if($searchByField != null)
//            {
//                return $this->Get_By_Query($query,false,'view_asset_angkutan_darat');	
//            }
//            else
//            {
//                return $this->Get_By_Query($query);	
//            }	
	
             $countQuery = "select count(*) as total
                                 FROM $this->table
                              WHERE kd_brg LIKE '30201%'OR kd_brg LIKE '30202%'";
            $nilaiAssetQuery = "select sum(abs(rph_aset)) as nilai_asset
                              FROM $this->table
                              WHERE kd_brg LIKE '30201%'OR kd_brg LIKE '30202%'";
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
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'";
                     $nilaiAssetQuery = "select sum(abs(rph_aset)) as nilai_asset
                                    FROM $this->table
                                    where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'";
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
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                kd_brg like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                nama_klasifikasi_aset like '%$searchByField%' OR
                                merk like '%$searchByField%' OR
                                type like '%$searchByField%'";
                    $nilaiAssetQuery = "select sum(abs(rph_aset)) as nilai_asset
                                    FROM $this->viewTable
                                    where 
                                    kd_brg like '%$searchByField%' OR
                                    kd_lokasi like '%$searchByField%' OR
                                    nama_unker like '%$searchByField%' OR
                                    nama_unor like '%$searchByField%' OR
                                    nama_klasifikasi_aset like '%$searchByField%' OR
                                    merk like '%$searchByField%' OR
                                    type like '%$searchByField%'";
                }
                else if($gridFilter != null)
                {
                    $query = "$this->selectColumn
                               FROM $this->viewTable
                               where $gridFilter
                               LIMIT $start, $limit
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where $gridFilter";
                     $nilaiAssetQuery = "select sum(abs(rph_aset)) as nilai_asset
                                    FROM $this->viewTable
                                    where $gridFilter";
                }
            }
            else
            {
                $query = "$this->selectColumn
                                FROM $this->viewTable
                                LIMIT $start, $limit";
          
                
                if($searchByBarcode != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->table
                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->table
                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'";
                     $nilaiAssetQuery = "select sum(abs(rph_aset)) as nilai_asset
                                    FROM $this->viewTable
                                    where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'";
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
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                kd_brg like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                nama_klasifikasi_aset like '%$searchByField%' OR
                                merk like '%$searchByField%' OR
                                type like '%$searchByField%'";
                    $nilaiAssetQuery = "select sum(abs(rph_aset)) as nilai_asset
                                    FROM $this->viewTable
                                    where 
                                kd_brg like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%' OR
                                nama_klasifikasi_aset like '%$searchByField%' OR
                                merk like '%$searchByField%' OR
                                type like '%$searchByField%'";
                }
                else if($gridFilter != null)
                {
                    $query = "$this->selectColumn
                               FROM $this->viewTable
                               where $gridFilter
                               
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where $gridFilter";
                     $nilaiAssetQuery = "select sum(abs(rph_aset)) as nilai_asset
                                    FROM $this->viewTable
                                    where $gridFilter";
                }
            }
            
            $accessControl = array(
                'unker'=>true,
                'unor'=>true
            );
            return $this->Get_By_Query_New($query, $countQuery, $accessControl, $nilaiAssetQuery);
            
	}
        
        function getSpecificPerlengkapanAngkutanDarat($id_ext_asset)
        {
            
                $query = "select t.id,t.id_ext_asset,a.kd_brg,a.part_number,a.serial_number,t.jenis_perlengkapan,t.no,t.nama,t.keterangan , t.id_asset_perlengkapan
                        FROM ext_asset_angkutan_darat_perlengkapan as t
                        LEFT JOIN asset_perlengkapan as a on t.id_asset_perlengkapan = a.id
                        WHERE t.id_ext_asset = $id_ext_asset";
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
        
        function get_AngkutanDarat($kd_lokasi,$kd_brg,$no_aset)
        {
            $query = "$this->selectColumn 
                      FROM
                      $this->viewTable
                      where kd_lokasi = '$kd_lokasi' AND kd_brg = '$kd_brg' AND no_aset = '$no_aset'";
            $result = $this->db->query($query);
            return $result->row();
        }
       
	
   function getPerlengkapan_for_print($id_ext_asset) {
                $query = "select id,id_ext_asset,jenis_perlengkapan,no,nama,keterangan 
                        FROM ext_asset_angkutan_darat_perlengkapan WHERE id_ext_asset = $id_ext_asset";
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