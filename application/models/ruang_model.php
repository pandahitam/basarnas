<?php
//MODEL IN REFERENSI -> RUANG
class Ruang_Model extends MY_Model{
	
	function __construct(){
            parent::__construct();
            $this->table = 'ref_warehouseruang';
            
            $this->selectColumn = "SELECT t.id, t.warehouse_id, t.nama, a.nama as nama_warehouse, b.ur_upb as nama_unker, c.nama_unor";
	}
	
	function get_AllData($start=null, $limit=null){
            
            if($start !=null && $limit !=null)
            {
                $query = "$this->selectColumn 
                        FROM $this->table AS t 
                        LEFT JOIN ref_warehouse as a on t.warehouse_id = a.id
                        LEFT JOIN ref_unker as b on a.kd_lokasi = b.kdlok
                        LEFT JOIN ref_unor as c on a.kode_unor = c.kode_unor
                        LIMIT $start, $limit";
            }
            else
            {
                $query = "$this->selectColumn 
                        FROM $this->table AS t
                        LEFT JOIN ref_warehouse as a on t.warehouse_id = a.id
                        LEFT JOIN ref_unker as b on a.kd_lokasi = b.kdlok
                        LEFT JOIN ref_unor as c on a.kode_unor = c.kode_unor
                        ";
            }
            

            return $this->Get_By_Query($query);
	}
        
//        function get_ExtAllData($kd_lokasi,$kd_brg,$no_aset){
//            $query = "SELECT t.nop, t.njkp, t.waktu_pembayaran, t.setoran_pajak, t.keterangan 
//                FROM $this.extTable as t WHERE t.kd_lokasi = $kd_lokasi AND t.kd_brg = $kd_brg AND t.no_aset = $no_aset";
//            
//            return $this->Get_By_Query($query);
//        }
//	
//	function get_byIDs($ids)
//	{		
//            $query = 'SELECT id, kd_lokasi, kd_brg, no_aset, kuantitas, rph_aset, 
//                        no_kib, type, thn_sls, thn_pakai, no_imb, tgl_imb, 
//                        kd_prov, kd_kab, kd_kec, kd_kel, alamat, 
//                        kd_rtrw, no_kibtnh, jns_trn, dari, tgl_prl, 
//                        kondisi, rph, dasar_hrg, sumber, no_dana, 
//                        tgl_dana, unit_pmk, alm_pmk, catatan, tgl_buku, 
//                        rphwajar, rphnjop, status, cad1, luas_dsr, 
//                        luas_bdg, jml_lt FROM ' . $this->table . ' WHERE id IN ('.$this->prepare_Query($ids).')ORDER BY id ASC';
//
//            return $this->Get_By_Query($query);
//	}
//        
//        function getSpecificRiwayatPajak($id_ext_asset)
//        {
//            if($_POST['open'] == 1)
//            {
//                $query = "select id,id_ext_asset,tahun_pajak,tanggal_pembayaran,jumlah_setoran,file_setoran,keterangan 
//                        FROM ext_asset_bangunan_riwayat_pajak WHERE id_ext_asset = $id_ext_asset";
//                return $this->Get_By_Query($query);
//            }
//        }
}
?>