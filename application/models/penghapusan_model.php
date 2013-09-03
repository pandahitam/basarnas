<?php
class Penghapusan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
//		$this->extTable = 'pemeliharaan';
//                $this->viewTable = 'view_pemeliharaan';
	}
	
	function get_AllData($start=null, $limit=null){
            if($start != null && $limit != null)
            {
		$query = "
                        select b.ur_baru, min(no_aset) as no_awal, max(no_aset) as no_akhir, c.ur_trn as jenis_transaksi, 
                        u.thn_ang,u.periode,u.kd_lokasi,u.no_sppa,u.kd_brg,u.no_aset,
                        u.tgl_perlh,u.tercatat,u.kondisi,u.tgl_buku,u.jns_trn,u.dsr_hrg,u.kd_data,u.flag_sap,u.kuantitas,
                        u.rph_sat,u.rph_aset,u.flag_kor,u.keterangan,u.merk_type,u.asal_perlh,u.no_bukti,u.no_dsr_mts,
                        u.tgl_dsr_mts,u.flag_ttp,u.flag_krm,u.kdblu,u.setatus,u.noreg,u.kdbapel,u.kdkpknl,u.umeko,u.rph_res,u.kdkppn 
                        from t_masteru u
                        left join t_mapbrg b
                        on u.kd_brg = b.kd_brgbaru
                        left join t_croleh c
                        on u.jns_trn = c.jns_trn
                        where u.jns_trn IN ('301','391')
                        group by b.ur_baru
                        LIMIT $start, $limit";
            }
            else
            {
                $query = "
                        select b.ur_baru, min(no_aset) as no_awal, max(no_aset) as no_akhir, c.ur_trn as jenis_transaksi, 
                        u.thn_ang,u.periode,u.kd_lokasi,u.no_sppa,u.kd_brg,u.no_aset,
                        u.tgl_perlh,u.tercatat,u.kondisi,u.tgl_buku,u.jns_trn,u.dsr_hrg,u.kd_data,u.flag_sap,u.kuantitas,
                        u.rph_sat,u.rph_aset,u.flag_kor,u.keterangan,u.merk_type,u.asal_perlh,u.no_bukti,u.no_dsr_mts,
                        u.tgl_dsr_mts,u.flag_ttp,u.flag_krm,u.kdblu,u.setatus,u.noreg,u.kdbapel,u.kdkpknl,u.umeko,u.rph_res,u.kdkppn 
                        from t_masteru u
                        left join t_mapbrg b
                        on u.kd_brg = b.kd_brgbaru
                        left join t_croleh c
                        on u.jns_trn = c.jns_trn
                        where u.jns_trn IN ('301','391')
                        group by b.ur_baru
                        ";
            }
		return $this->Get_By_Query($query);	
	}
	
//	function get_Pemeliharaan($kd_lokasi, $kd_barang, $no_aset)
//	{
//		$query = "Select * from Pemeliharaan where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
//		return $this->Get_By_Query($query);
//	}
	
}
?>
