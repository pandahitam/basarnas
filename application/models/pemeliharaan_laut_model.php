<?php
class Pemeliharaan_Laut_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pemeliharaan';
                $this->viewTable = 'view_pemeliharaan';
                $this->countTable = 'view_pemeliharaan_laut';
                
                $this->selectColumn = "SELECT id, kd_brg, kd_lokasi, no_aset,
                            kode_unker, kode_unor, nama_unker, nama_unor,jenis, nama, 
                            tahun_angaran, pelaksana_tgl, pelaksana_nama, 
                            kondisi, deskripsi, harga, kode_angaran,
                            unit_waktu, unit_pengunaan,
                            freq_waktu, freq_pengunaan, status, durasi, 
                            rencana_waktu, rencana_pengunaan, rencana_keterangan, image_url,document_url, alert";
	}
	
	function get_AllData($start=null, $limit=null){
//		$query = "$this->selectColumn FROM $this->viewTable
//                where kd_brg like '30203%' or kd_brg like '30204%'";
            
            if($start !=null && $limit != null)
            {
                 $query = "$this->selectColumn FROM view_pemeliharaan_laut LIMIT $start, $limit";
            }
            else
            {
                 $query = "$this->selectColumn FROM view_pemeliharaan_laut";
            }

		return $this->Get_By_Query($query);	
	}
	
	function get_Pemeliharaan($kd_lokasi, $kd_barang, $no_aset)
	{
		$query = "$this->selectColumn FROM $this->viewTable where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
		
                return $this->Get_By_Query($query);
	}
	
}
?>
