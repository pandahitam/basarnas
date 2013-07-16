<?php
class Mutasi_Model extends MY_Model{
	
	/*function __construct(){
		parent::__construct();
		$this->extTable = 'pemeliharaan';
                $this->viewTable = 'view_pemeliharaan';
	}
	
	function get_AllData(){
		$query = 'SELECT id, kd_brg, kd_lokasi, no_aset,
                            kode_unker, kode_unor, nama_unker, nama_unor,jenis, nama, 
                            tahun_angaran, pelaksana_tgl, pelaksana_nama, 
                            kondisi, deskripsi, harga, kode_angaran, 
                            freq_waktu, freq_pengunaan, status, durasi, 
                            rencana_waktu, rencana_pengunaan, rencana_keterangan, image_url,document_url, alert FROM ' . $this->viewTable;

		return $this->Get_By_Query($query);	
	}
	
	function get_Pemeliharaan($kd_lokasi, $kd_barang, $no_aset)
	{
		$query = "Select * from Pemeliharaan where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
		return $this->Get_By_Query($query);
	}*/
	
}
?>
