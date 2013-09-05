<?php
class Mutasi_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
                $this->table = 'view_mutasi';
//		$this->extTable = 'pemeliharaan';
//                $this->viewTable = 'view_pemeliharaan';
	}
	
	function get_AllData($start=null, $limit=null){
            if($start != null && $limit != null)
            {
//		$query = "select b.ur_baru, min(no_aset) as no_awal, max(no_aset) as no_akhir, c.ur_trn as jenis_transaksi, 
//                        u.thn_ang,u.periode,u.kd_lokasi,u.no_sppa,u.kd_brg,u.no_aset,
//                        u.tgl_perlh,u.tercatat,u.kondisi,u.tgl_buku,u.jns_trn,u.dsr_hrg,u.kd_data,u.flag_sap,u.kuantitas,
//                        u.rph_sat,u.rph_aset,u.flag_kor,u.keterangan,u.merk_type,u.asal_perlh,u.no_bukti,u.no_dsr_mts,
//                        u.tgl_dsr_mts,u.flag_ttp,u.flag_krm,u.kdblu,u.setatus,u.noreg,u.kdbapel,u.kdkpknl,u.umeko,u.rph_res,u.kdkppn 
//                        from t_masteru u
//                        left join t_mapbrg b
//                        on u.kd_brg = b.kd_brgbaru
//                        left join t_croleh c
//                        on u.jns_trn = c.jns_trn
//                        where u.jns_trn IN ('102','302','506','507','392') and thn_ang=2011
//                        group by b.ur_baru
//                        LIMIT $start, $limit";
                $query = "select ur_baru, no_awal, no_akhir, jenis_transaksi, 
                        thn_ang,periode,kd_lokasi,no_sppa,kd_brg,no_aset,
                        tgl_perlh,tercatat,kondisi,tgl_buku,jns_trn,dsr_hrg,kd_data,flag_sap,kuantitas,
                        rph_sat,rph_aset,flag_kor,keterangan,merk_type,asal_perlh,no_bukti,no_dsr_mts,
                        tgl_dsr_mts,flag_ttp,flag_krm,kdblu,setatus,noreg,kdbapel,kdkpknl,umeko,rph_res,kdkppn 
                        from view_mutasi
                        LIMIT $start, $limit";
            }
            else
            {
//                $query = "select b.ur_baru, min(no_aset) as no_awal, max(no_aset) as no_akhir, c.ur_trn as jenis_transaksi, 
//                        select b.ur_baru, min(no_aset) as no_awal, max(no_aset) as no_akhir, c.ur_trn as jenis_transaksi, 
//                        u.thn_ang,u.periode,u.kd_lokasi,u.no_sppa,u.kd_brg,u.no_aset,
//                        u.tgl_perlh,u.tercatat,u.kondisi,u.tgl_buku,u.jns_trn,u.dsr_hrg,u.kd_data,u.flag_sap,u.kuantitas,
//                        u.rph_sat,u.rph_aset,u.flag_kor,u.keterangan,u.merk_type,u.asal_perlh,u.no_bukti,u.no_dsr_mts,
//                        u.tgl_dsr_mts,u.flag_ttp,u.flag_krm,u.kdblu,u.setatus,u.noreg,u.kdbapel,u.kdkpknl,u.umeko,u.rph_res,u.kdkppn 
//                        from t_masteru u
//                        left join t_mapbrg b
//                        on u.kd_brg = b.kd_brgbaru
//                        left join t_croleh c
//                        on u.jns_trn = c.jns_trn
//                        where u.jns_trn IN ('102','302','506','507','392')and thn_ang=2011
//                        group by b.ur_baru
//                        ";
                
                $query = "select ur_baru, no_awal, no_akhir, jenis_transaksi, 
                        thn_ang,periode,kd_lokasi,no_sppa,kd_brg,no_aset,
                        tgl_perlh,tercatat,kondisi,tgl_buku,jns_trn,dsr_hrg,kd_data,flag_sap,kuantitas,
                        rph_sat,rph_aset,flag_kor,keterangan,merk_type,asal_perlh,no_bukti,no_dsr_mts,
                        tgl_dsr_mts,flag_ttp,flag_krm,kdblu,setatus,noreg,kdbapel,kdkpknl,umeko,rph_res,kdkppn 
                        from view_mutasi";
            }
		return $this->Get_By_Query($query);	
	}
	
	function get_Mutasi($kd_lokasi, $kd_barang, $no_aset)
	{
		$query = "SELECT 
                        u.thn_ang,u.periode,u.kd_lokasi,u.no_sppa,u.kd_brg,u.no_aset,
                        u.tgl_perlh,u.tercatat,u.kondisi,u.tgl_buku,u.jns_trn,u.dsr_hrg,u.kd_data,u.flag_sap,u.kuantitas,
                        u.rph_sat,u.rph_aset,u.flag_kor,u.keterangan,u.merk_type,u.asal_perlh,u.no_bukti,u.no_dsr_mts,
                        u.tgl_dsr_mts,u.flag_ttp,u.flag_krm,u.kdblu,u.setatus,u.noreg,u.kdbapel,u.kdkpknl,u.umeko,u.rph_res,u.kdkppn 
                        FROM t_masteru u
                        WHERE u.jns_trn IN ('102','302','506','507','392')
                        AND kd_lokasi = '$kd_lokasi' AND kd_brg = '$kd_barang' AND no_aset = '$no_aset' ";
		
                return $this->Get_By_Query($query);
	}
	
}
?>
