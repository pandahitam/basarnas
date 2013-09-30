<?php
class Pemeliharaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pemeliharaan';
                $this->viewTable = 'view_pemeliharaan';
                $this->countTable = 'view_pemeliharaan_lainnya';
                
                $this->selectColumn = "SELECT id, kd_brg, kd_lokasi, no_aset,
                            kode_unker, kode_unor, nama_unker, nama_unor,jenis, nama, 
                            tahun_angaran, pelaksana_tgl, pelaksana_nama, 
                            kondisi, deskripsi, harga, kode_angaran,
                            unit_waktu, unit_pengunaan,
                            freq_waktu, freq_pengunaan, status, durasi, 
                            rencana_waktu, rencana_pengunaan, rencana_keterangan, image_url,document_url, alert";
	}
	
	function get_AllData($start=null, $limit=null, $searchTextFilter = null){
//		$query = "$this->selectColumn FROM $this->viewTable
//                        where kd_brg NOT LIKE '4%'
//                        AND kd_brg NOT LIKE '2%'
//                        AND kd_brg NOT LIKE '30205%'
//                        AND kd_brg NOT LIKE '30203%' AND kd_brg NOT LIKE '30204%'
//                        AND kd_brg NOT LIKE '30201%' AND kd_brg NOT LIKE '30202%'";
            
            if($start !=null && $limit != null)
            {
                  $query = "$this->selectColumn FROM view_pemeliharaan_lainnya LIMIT $start, $limit";
                 if($searchTextFilter != null)
                 {
                     $query = "$this->selectColumn FROM view_pemeliharaan_lainnya
                     where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchTextFilter' 
                     LIMIT $start, $limit";
                 }
            }
            else
            {
                 $query = "$this->selectColumn FROM view_pemeliharaan_lainnya";
                  if($searchTextFilter != null)
                 {
                     $query = "$this->selectColumn FROM view_pemeliharaan_lainnya
                     where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchTextFilter' 
                     ";
                 }
            }
            
		return $this->Get_By_Query($query);	
	}
	
	function get_Pemeliharaan($kd_lokasi, $kd_barang, $no_aset)
	{
		$query = "$this->selectColumn FROM $this->viewTable where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
		
                return $this->Get_By_Query($query);
	}
	
	function get_PemeliharaanForPrint($kd_lokasi, $kd_barang, $no_aset)
	{
		$query = "$this->selectColumn FROM $this->viewTable where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
		$this->load->database();
		$result = $this->db->query($query)->result_array();
		$this->db->close();				  
		return $result;	
	}
}
?>
