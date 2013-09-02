<?php
class Klasifikasi_Aset_Lvl3_Model extends MY_Model{
	
	function __construct(){
            parent::__construct();
            $this->table = 'ref_klasifikasiaset_lvl3';
            
            $this->selectColumn = "SELECT t.kd_lvl1, t.kd_lvl2, t.kd_lvl3, t.nama, t.kd_klasifikasi_aset";
	}
	
	function get_AllData($start=null, $limit=null){
            
            if($start !=null && $limit !=null)
            {
                $query = "$this->selectColumn 
                        FROM $this->table AS t 
                        LIMIT $start, $limit";
            }
            else
            {
                $query = "$this->selectColumn 
                        FROM $this->table AS t 
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