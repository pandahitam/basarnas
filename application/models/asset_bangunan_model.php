<?php
class Asset_Bangunan_Model extends MY_Model{
	
	function __construct(){
            parent::__construct();
            $this->table = 'asset_bangunan';
            $this->extTable = 'ext_asset_bangunan';
            $this->viewTable = 'view_asset_bangunan';
//            $this->selectColumn = "SELECT t.kd_lokasi,t.kd_brg,t.no_aset,kuantitas, rph_aset, 
//                        no_kib, type, thn_sls, thn_pakai, no_imb, tgl_imb, 
//                        kd_prov, kd_kab, kd_kec, t.kd_kel, alamat, 
//                        kd_rtrw, no_kibtnh, jns_trn, dari, tgl_prl, 
//                        kondisi, rph, dasar_hrg, sumber, no_dana, 
//                        tgl_dana, unit_pmk, alm_pmk, catatan, tgl_buku, 
//                        rphwajar, rphnjop, status, cad1, luas_dsr, 
//                        luas_bdg, jml_lt, 
//                        b.id, b.kode_unor, b.image_url, b.document_url,
//                        b.nop, b.njkp, b.waktu_pembayaran, b.setoran_pajak, b.keterangan,
//                        c.ur_upb as nama_unker, d.nama_unor,
//                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel
//                        ,f.nama as nama_klasifikasi_aset, b.kd_klasifikasi_aset,
//                        f.kd_lvl1,f.kd_lvl2,f.kd_lvl3";
            $this->selectColumn = "SELECT kd_lokasi,kd_brg,no_aset,kuantitas, rph_aset, 
                        no_kib, type, thn_sls, thn_pakai, no_imb, tgl_imb, 
                        kd_prov, kd_kab, kd_kec, kd_kel, alamat, 
                        kd_rtrw, no_kibtnh, jns_trn, dari, tgl_prl, 
                        kondisi, rph, dasar_hrg, sumber, no_dana, 
                        tgl_dana, unit_pmk, alm_pmk, catatan, tgl_buku, 
                        rphwajar, rphnjop, status, cad1, luas_dsr, 
                        luas_bdg, jml_lt, 
                        id, kode_unor, image_url, document_url,
                        nop, njkp, waktu_pembayaran, setoran_pajak, keterangan,
                        nama_unker, nama_unor,
                        kd_gol,kd_bid,kd_kelompok,kd_skel, kd_sskel
                        ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                        kd_lvl1,kd_lvl2,kd_lvl3";
	}
	
	function get_AllData($start=null, $limit=null, $searchTextFilter = null, $gridFilter = null){
            
//            if($start !=null && $limit !=null)
//            {
//                $query = "$this->selectColumn 
//                        FROM $this->table AS t 
//                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        LIMIT $start, $limit";
//                
//                if($searchTextFilter != null)
//                {
//                    $query = "$this->selectColumn 
//                        FROM $this->table AS t 
//                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                         where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
//                        LIMIT $start, $limit";
//                }
//            }
//            else
//            {
//                $query = "$this->selectColumn 
//                        FROM $this->table AS t 
//                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        ";
//                
//                if($searchTextFilter != null)
//                {
//                    $query = "$this->selectColumn 
//                        FROM $this->table AS t 
//                        LEFT JOIN $this->extTable AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_unor d ON b.kode_unor = d.kode_unor
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON b.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                         where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
//                        ";
//                }
//            }
//            
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
        
        function get_ExtAllData($kd_lokasi,$kd_brg,$no_aset){
            $query = "SELECT t.nop, t.njkp, t.waktu_pembayaran, t.setoran_pajak, t.keterangan 
                FROM $this.extTable as t WHERE t.kd_lokasi = $kd_lokasi AND t.kd_brg = $kd_brg AND t.no_aset = $no_aset";
            
            return $this->Get_By_Query($query);
        }
	
	function get_byIDs($ids)
	{		
            $query = 'SELECT id, kd_lokasi, kd_brg, no_aset, kuantitas, rph_aset, 
                        no_kib, type, thn_sls, thn_pakai, no_imb, tgl_imb, 
                        kd_prov, kd_kab, kd_kec, kd_kel, alamat, 
                        kd_rtrw, no_kibtnh, jns_trn, dari, tgl_prl, 
                        kondisi, rph, dasar_hrg, sumber, no_dana, 
                        tgl_dana, unit_pmk, alm_pmk, catatan, tgl_buku, 
                        rphwajar, rphnjop, status, cad1, luas_dsr, 
                        luas_bdg, jml_lt FROM ' . $this->table . ' WHERE id IN ('.$this->prepare_Query($ids).')ORDER BY id ASC';

            return $this->Get_By_Query($query);
	}
        
        function getSpecificRiwayatPajak($id_ext_asset)
        {
            if($_POST['open'] == 1)
            {
                $query = "select id,id_ext_asset,tahun_pajak,tanggal_pembayaran,jumlah_setoran,file_setoran,keterangan 
                        FROM ext_asset_bangunan_riwayat_pajak WHERE id_ext_asset = $id_ext_asset";
                return $this->Get_By_Query($query);
            }
        }
	
	function getRiwayatPajak($id_ext_asset)
	{
			$query = "select id,id_ext_asset,tahun_pajak,tanggal_pembayaran,jumlah_setoran,file_setoran,keterangan 
					FROM ext_asset_bangunan_riwayat_pajak WHERE id_ext_asset = $id_ext_asset";
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