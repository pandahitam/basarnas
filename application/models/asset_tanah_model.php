<?php
class Asset_Tanah_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'asset_tanah';
                $this->extTable = 'ext_asset_tanah';
                $this->viewTable = "view_asset_tanah";
                $this->countTable = 'ext_asset_tanah';
                
//                $this->selectColumn = "SELECT t.kd_lokasi, t.kd_brg, t.no_aset, 
//                        kuantitas, rph_aset, no_kib, luas_tnhs, 
//                        luas_tnhb, luas_tnhl, luas_tnhk, kd_prov, 
//                        kd_kab, kd_kec, t.kd_kel, kd_rtrw, 
//                        alamat, batas_u, batas_s, batas_t, 
//                        batas_b, jns_trn, sumber, dari, 
//                        dasar_hrg, no_dana, tgl_dana, surat1, 
//                        surat2, surat3, rph_m2, unit_pmk, 
//                        alm_pmk, catatan, tgl_prl, tgl_buku, 
//                        rphwajar, rphnjop, status, smilik,
//                        b.id, b.kode_unor, b.image_url, b.document_url,
//                        b.nop, b.njkp, b.waktu_pembayaran, b.setoran_pajak, b.keterangan,
//                        c.ur_upb as nama_unker, d.nama_unor,
//                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel
//                        ,f.nama as nama_klasifikasi_aset, b.kd_klasifikasi_aset,
//                        f.kd_lvl1,f.kd_lvl2,f.kd_lvl3";
                $this->selectColumn = "SELECT kd_lokasi, kd_brg, no_aset, 
                        kuantitas, rph_aset, no_kib, luas_tnhs, 
                        luas_tnhb, luas_tnhl, luas_tnhk, kd_prov, 
                        kd_kab, kd_kec, kd_kel, kd_rtrw, 
                        alamat, batas_u, batas_s, batas_t, 
                        batas_b, jns_trn, sumber, dari, 
                        dasar_hrg, no_dana, tgl_dana, surat1, 
                        surat2, surat3, rph_m2, unit_pmk, 
                        alm_pmk, catatan, tgl_prl, tgl_buku, 
                        rphwajar, rphnjop, status, smilik,
                        id, kode_unor, image_url, document_url,
                        nop, njkp, waktu_pembayaran, setoran_pajak, keterangan,
                        nama_unker, nama_unor,
                        kd_gol,kd_bid,kd_kelompok,kd_skel, kd_sskel,ur_sskel
                        ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                        kd_lvl1,kd_lvl2,kd_lvl3";
	}
	
	function get_AllData($start=null, $limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){
//                if($start != null && $limit !=null)
//                {
//                    $query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        LIMIT $start, $limit";
//                    
//                    if($searchByBarcode != null)
//                    {
//                        $query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                         where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchByBarcode'
//                        LIMIT $start, $limit";
//                    }
//                    
//                    
//                }
//                else
//                {
//                    $query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        ";
//                    
//                    if($searchByBarcode != null)
//                    {
//                        $query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                         where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchByBarcode'
//                        ";
//                    }
//                }
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
//                                nama_unor like '%$searchByField%'                                   
//                                LIMIT $start, $limit";
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
//                                nama_unor like '%$searchByField%'                                   
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
//                return $this->Get_By_Query($query,false,'view_asset_tanah');	
//            }
//            else
//            {
//                return $this->Get_By_Query($query);	
//            }	
            
            $countQuery = "select count(*) as total
                                FROM $this->table";
            $nilaiAssetQuery = "select sum(abs(rph_aset)) as nilai_asset
                              FROM $this->table";
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
                                nama_unor like '%$searchByField%'                                   
                                LIMIT $start, $limit";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                kd_brg like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%'";
                    $nilaiAssetQuery = "select sum(abs(rph_aset)) as nilai_asset
                                    FROM $this->viewTable
                                    where 
                                    kd_brg like '%$searchByField%' OR
                                    kd_lokasi like '%$searchByField%' OR
                                    nama_unker like '%$searchByField%' OR
                                    nama_unor like '%$searchByField%'";
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
                                ";
          
                
                if($searchByBarcode != null)
                {
                    $query = "$this->selectColumn
                                FROM $this->viewTable
                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
                                ";
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
                                nama_unor like '%$searchByField%'                                   
                                ";
                     $countQuery = "select count(*) as total
                                FROM $this->viewTable
                                where 
                                kd_brg like '%$searchByField%' OR
                                kd_lokasi like '%$searchByField%' OR
                                nama_unker like '%$searchByField%' OR
                                nama_unor like '%$searchByField%'";
                    $nilaiAssetQuery = "select sum(abs(rph_aset)) as nilai_asset
                                    FROM $this->viewTable
                                    where 
                                    kd_brg like '%$searchByField%' OR
                                    kd_lokasi like '%$searchByField%' OR
                                    nama_unker like '%$searchByField%' OR
                                    nama_unor like '%$searchByField%'";
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
        
        function get_filteredData($dataArray)
        {
//            $query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset";
//            
//            foreach($dataArray as $key=>$value)
//            {
//                $this->db->like($value->field,$value->value);
//            }
//            $this->db->select('t.kd_lokasi, t.kd_brg, t.no_aset, 
//                        kuantitas, rph_aset, no_kib, luas_tnhs, 
//                        luas_tnhb, luas_tnhl, luas_tnhk, kd_prov, 
//                        kd_kab, kd_kec, t.kd_kel, kd_rtrw, 
//                        alamat, batas_u, batas_s, batas_t, 
//                        batas_b, jns_trn, sumber, dari, 
//                        dasar_hrg, no_dana, tgl_dana, surat1, 
//                        surat2, surat3, rph_m2, unit_pmk, 
//                        alm_pmk, catatan, tgl_prl, tgl_buku, 
//                        rphwajar, rphnjop, status, smilik,
//                        b.id, b.kode_unor, b.image_url, b.document_url,
//                        b.nop, b.njkp, b.waktu_pembayaran, b.setoran_pajak, b.keterangan,
//                        c.ur_upb as nama_unker, d.nama_unor,
//                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel
//                        ,f.nama as nama_klasifikasi_aset, b.kd_klasifikasi_aset,
//                        f.kd_lvl1,f.kd_lvl2,f.kd_lvl3');
//            $this->db->from('asset_tanah');
//            
//            $result = $this->db->get();
//            var_dump($result);
//            die;
        }
	
	function get_byIDs($ids)
	{		
		$query = 'SELECT id, kd_lokasi, kd_brg, no_aset, 
                        kuantitas, rph_aset, no_kib, luas_tnhs, 
                        luas_tnhb, luas_tnhl, luas_tnhk, kd_prov, 
                        kd_kab, kd_kec, kd_kel, kd_rtrw, 
                        alamat, batas_u, batas_s, batas_t, 
                        batas_b, jns_trn, sumber, dari, 
                        dasar_hrg, no_dana, tgl_dana, surat1, 
                        surat2, surat3, rph_m2, unit_pmk, 
                        alm_pmk, catatan, tgl_prl, tgl_buku, 
                        rphwajar, rphnjop, status, smilik
                        FROM '.$this->table.'
                        WHERE id IN ('.$this->prepare_Query($ids).')
                        ORDER BY kd_lokasi ASC';
		return $this->Get_By_Query($query);
	}
        
        function get_Tanah($kd_lokasi,$kd_brg,$no_aset)
        {
            $query = "$this->selectColumn 
                      FROM
                      $this->viewTable
                      where kd_lokasi = '$kd_lokasi' AND kd_brg = '$kd_brg' AND no_aset = '$no_aset'";
            $result = $this->db->query($query);
            return $result->row();
        }
        
        
        function getSpecificRiwayatPajak($id_ext_asset)
        {
            if($_POST['open'] == 1)
            {
                $query = "select id,id_ext_asset,tahun_pajak,tanggal_pembayaran,jumlah_setoran,file_setoran,keterangan 
                        FROM ext_asset_tanah_riwayat_pajak WHERE id_ext_asset = $id_ext_asset";
                $countQuery = "select count(*) as total FROM ext_asset_tanah_riwayat_pajak WHERE id_ext_asset = $id_ext_asset";
		$countResult = $this->db->query($countQuery);
                
                $r = $this->db->query($query);
                $data = array();
                if ($r->num_rows() > 0)
                {
                    foreach ($r->result() as $obj)
                    {
                        $data[] = $obj;
                    }  
                }
                $returnData['data'] = $data;
                $returnData['count'] = $countResult->row()->total;
//                return $this->Get_By_Query($query);
                return $returnData;
            }
        }
	
	
	function ConstructKode($kode_golongan = NULL,$kode_asset = NULL){
		$kode = NULL;
		if ($kode_golongan != NULL && $kode_asset != NULL)
		{
			$kode = '2' . $kode_golongan . $kode_asset;
		}	
		return $kode;
	}
	
	function getRiwayatPajak($id_ext_asset)
	{
		$query = "select id,id_ext_asset,tahun_pajak,tanggal_pembayaran,jumlah_setoran,file_setoran,keterangan 
				  FROM ext_asset_tanah_riwayat_pajak WHERE id_ext_asset = $id_ext_asset";
                
                return $this->Get_By_Query($query);
	}
	
	function getRiwayatPajakForPrint($id_ext_asset)
	{
		$query = "select id,id_ext_asset,tahun_pajak,tanggal_pembayaran,jumlah_setoran,file_setoran,keterangan 
				  FROM ext_asset_tanah_riwayat_pajak WHERE id_ext_asset = $id_ext_asset";
		$this->load->database();
		$result = $this->db->query($query)->result_array();
		$this->db->close();				  
		return $result;
	}

	function get_SelectedDataPrint($ids){
		$dataasset = array();
		$idx = array();
		$idx = explode("||", urldecode($ids));
		
		$q = "$this->selectColumn 
                        FROM $this->viewTable AS t WHERE t.kd_lokasi = '".$idx[0]."' and t.kd_brg = '".$idx[1]."' and t.no_aset = '".$idx[2]."'
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