<?php
class Asset_Tanah_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'asset_tanah';
                $this->extTable = 'ext_asset_tanah';
                
                $this->selectColumn = "SELECT t.kd_lokasi, t.kd_brg, t.no_aset, 
                        kuantitas, rph_aset, no_kib, luas_tnhs, 
                        luas_tnhb, luas_tnhl, luas_tnhk, kd_prov, 
                        kd_kab, kd_kec, t.kd_kel, kd_rtrw, 
                        alamat, batas_u, batas_s, batas_t, 
                        batas_b, jns_trn, sumber, dari, 
                        dasar_hrg, no_dana, tgl_dana, surat1, 
                        surat2, surat3, rph_m2, unit_pmk, 
                        alm_pmk, catatan, tgl_prl, tgl_buku, 
                        rphwajar, rphnjop, status, smilik,
                        b.id, b.kode_unor, b.image_url, b.document_url,
                        b.nop, b.njkp, b.waktu_pembayaran, b.setoran_pajak, b.keterangan,
                        c.ur_upb as nama_unker, d.nama_unor,
                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel
                        ,f.nama as nama_klasifikasi_aset, b.kd_klasifikasi_aset,
                        f.kd_lvl1,f.kd_lvl2,f.kd_lvl3";
	}
	
	function get_AllData($start=null, $limit=null, $searchTextFilter = null){
                if($start != null && $limit !=null)
                {
                    $query = "$this->selectColumn
                        FROM $this->table AS t
                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                        LIMIT $start, $limit";
                    
                    if($searchTextFilter != null)
                    {
                        $query = "$this->selectColumn
                        FROM $this->table AS t
                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                         where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
                        LIMIT $start, $limit";
                    }
                    
                    
                }
                else
                {
                    $query = "$this->selectColumn
                        FROM $this->table AS t
                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                        ";
                    
                    if($searchTextFilter != null)
                    {
                        $query = "$this->selectColumn
                        FROM $this->table AS t
                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                         where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
                        ";
                    }
                }
		
                    
                
		return $this->Get_By_Query($query);	
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
        
        function getSpecificRiwayatPajak($id_ext_asset)
        {
            if($_POST['open'] == 1)
            {
                $query = "select id,id_ext_asset,tahun_pajak,tanggal_pembayaran,jumlah_setoran,file_setoran,keterangan 
                        FROM ext_asset_tanah_riwayat_pajak WHERE id_ext_asset = $id_ext_asset";
                return $this->Get_By_Query($query);
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
	
	function get_SelectedDataPrint($ids){
		$dataasset = array();
		$idx = array();
		$idx = explode("||", urldecode($ids));
		
		$q = "$this->selectColumn 
                        FROM $this->table AS t
                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
								
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