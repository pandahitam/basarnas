<?php
class Inventory_Pengeluaran_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'inventory_pengeluaran';
                $this->selectColumn = "SELECT t.id,t.id_perlengkapan,t.tgl_berita_acara,t.nomor_berita_acara,t.kd_brg,t.kd_lokasi,
                                        t.no_aset, t.part_number,t.serial_number,t.date_created,t.nama_org,
                                        t.keterangan, t.status_barang,t.qty,t.tgl_pengeluaran,t.asal_barang,t.qty_barang_keluar,
                                        c.ur_upb as nama_unker,
                                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel,
                                        d.nama_unor, t.kode_unor";
                                        }
	
	function get_AllData($start=null, $limit=null){
                
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                            LIMIT $start,$limit";
		
            }
            else
            {
                $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor AS d ON b.kode_unor = d.kode_unor
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                            ";
            }
            
            return $this->Get_By_Query($query);
			
	}
	
	function get_byIDs($ids)
	{		
//		$query = 'SELECT id, kd_lokasi, kd_brg, no_aset, kuantitas, no_kib, merk, type, pabrik, thn_rakit, thn_buat, negara, muat, bobot, daya, 
//						msn_gerak, jml_msn, bhn_bakar, no_mesin, no_rangka, no_polisi, no_bpkb, lengkap1, lengkap2, lengkap3, jns_trn, dari, tgl_prl, rph_aset, 
//						dasar_hrg, sumber, no_dana, tgl_dana, unit_pmk, alm_pmk, catatan, kondisi, tgl_buku, rphwajar, status, cad1
//				  FROM '.$this->table.'
//				  WHERE id IN ('.$this->prepare_Query($ids).')
//				  ORDER BY kd_lokasi ASC';
//		return $this->Get_By_Query($query);
	}
	
	
//	function ConstructKode($kode_golongan = NULL,$kode_asset = NULL){
//		$kode = NULL;
//		if ($kode_golongan != NULL && $kode_asset != NULL)
//		{
//			$kode = '2' . $kode_golongan . $kode_asset;
//		}	
//		return $kode;
//	}
}
?>